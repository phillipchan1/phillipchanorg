<?php
/**
 * ThemePile Metaboxes
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}


add_action( 'add_meta_boxes', 'themepile_create_meta_boxes' );
add_action( 'save_post', 'themepile_save_meta_boxes', 10, 2 );

if ( ! function_exists( 'themepile_create_meta_boxes' ) ) {
	function themepile_create_meta_boxes() {
		global $post;
		do_action( 'themepile_add_meta_box_' . $post->post_type, $post );
	}
}
if ( ! function_exists( 'themepile_save_meta_boxes' ) && class_exists( 'ThemePile_Core_Abstract' ) ) {
	function themepile_save_meta_boxes( $postID, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return $post->ID;
		}
		if ( ThemePile_Core_Abstract::post( 'action' ) == 'inline-save' ) {
			return $post->ID;
		}
		do_action( 'themepile_save_meta_box_' . $post->post_type, $post );
	}
}

if( !class_exists( 'ThemePile_Meta_Box_Framework' ) ) {

	class ThemePile_Meta_Box_Framework {

		function __construct()
		{
			add_action( 'admin_init', array(&$this, 'admin_init') );
			add_action( 'add_meta_boxes', array(&$this, 'add_meta_boxes') );
			add_action( 'pre_post_update', array(&$this, 'meta_box_save') );
		}

		function admin_init() {
			do_action( 'themepile_meta_boxes' );
		}

		function add_meta_boxes() {
			global $themepile_meta_boxes;


			if( !is_array($themepile_meta_boxes) )
				return;

			foreach( $themepile_meta_boxes as $meta_box ){
				if( is_array($meta_box['pages']) ){
					foreach( $meta_box['pages'] as $page ){
						add_meta_box( $meta_box['id'], $meta_box['title'], array(&$this, 'meta_box_output'), $page, $meta_box['context'], $meta_box['priority'], array('themepile_meta_box' => $meta_box) );
					}
				} else {
					add_meta_box( $meta_box['id'], $meta_box['title'], array(&$this, 'meta_box_output'), $meta_box['pages'], $meta_box['context'], $meta_box['priority'], array('themepile_meta_box' => $meta_box) );
				}
			}
		}

		function meta_box_save( $post_id ) {
			if(isset($_REQUEST['post_type'])) {
				if ( 'page' == $_REQUEST['post_type'] ) {
					if ( !current_user_can( 'edit_page', $post_id ) )
						return;
				} else {
					if ( !current_user_can( 'edit_post', $post_id ) )
						return;
				}
			}


			if ( !isset( $_POST['themepile_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['themepile_meta_box_nonce'], plugin_basename( __FILE__ ) ) )
				return;

			global $themepile_meta_boxes;
			if( !is_array($themepile_meta_boxes) )
				return;

			foreach( $themepile_meta_boxes as $meta_box ){
				if( isset($meta_box['fields']) && is_array($meta_box['fields']) ){
					foreach( $meta_box['fields'] as $field ){
						if( isset($field['id']) ){
							if( $field['type'] == 'checkboxes' && isset($field['choices']) ){
								foreach( $field['choices'] as $ckey=>$cval ){
									if( isset($_POST[$field['id'] .'_'. $ckey]) ){
										update_post_meta( $post_id, $field['id'] .'_'. $ckey, $_POST[$field['id'] .'_'. $ckey] );
									}
								}
							} else {
								if( isset($_POST[$field['id']]) ){
									update_post_meta( $post_id, $field['id'], $_POST[$field['id']] );
								}
							}
						}
					}
				}
			}
		}

		function meta_box_output( $post, $args ) {
			global $themepile_meta_boxes;
			if( !is_array($themepile_meta_boxes) )
				return;

			wp_nonce_field( plugin_basename( __FILE__ ), 'themepile_meta_box_nonce' );

			foreach( $themepile_meta_boxes as $meta_box ){
				if( isset($args['args']['themepile_meta_box']['id']) && $args['args']['themepile_meta_box']['id'] == $meta_box['id'] ){
					if( isset($meta_box['fields']) && is_array($meta_box['fields']) ){
						foreach( $meta_box['fields'] as $field ){
							if( isset($field['id']) && isset($field['type']) ){
								$value = get_post_meta( $post->ID, $field['id'], true );
								if( $value === false && isset($field['std']) ) $value = $field['std'];

								if( $field['type'] == 'checkboxes' && isset($field['choices']) ){
									$value = array();
									foreach( $field['choices'] as $ckey=>$cval ){
										$value[$field['id'] .'_'. $ckey] = get_post_meta( $post->ID, $field['id'] .'_'. $ckey, true );
									}
								}

								echo '<div class="themepile-metabox--slider__item">';

								if( isset($field['name']) && $field['name'] ){
									echo '<label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong></label> ';
								}
								if( isset($field['desc']) && $field['desc'] ){
									echo '<span class="help">'. $field['desc'] .'</span>';
								}

								switch( $field['type'] ){
									case 'text':
										$value = esc_attr(stripslashes($value));
										echo '<input type="text" name="'. $field['id'] .'" id="'. $field['id'] .'" value="'. $value .'" style="width:100%" />';
										break;
									case 'textarea':
										$value = esc_html(stripslashes($value));
										echo '<textarea name="'. $field['id'] .'" id="'. $field['id'] .'" style="width:100%;height:150px;">'. $value .'</textarea>';
										break;
									case 'select':
										$value = esc_html(esc_attr($value));
										if( isset($field['choices']) ){
											echo '<select name="'. $field['id'] .'" id="'. $field['id'] .'">';
											foreach( $field['choices'] as $ckey=>$cval ){
												echo '<option value="'. $ckey .'"'. (($ckey == $value) ? ' selected="selected"' : '') .'>'. $cval .'</option>';
											}
											echo '</select>';
										}
										break;
									case 'radio':
										$value = esc_html(esc_attr($value));
										if( isset($field['choices']) ){
											foreach( $field['choices'] as $ckey=>$cval ){
												echo '<label><input type="radio" name="'. $field['id'] .'" id="'. $field['id'] .'_'. $ckey .'" value="'. $ckey .'"'. (($ckey == $value) ? ' checked="checked"' : '') .' /> '. $cval .'</label><br />';
											}
										}
										break;
									case 'checkbox':
										$value = esc_attr(stripslashes($value));
										echo '<input type="hidden" name="'. $field['id'] .'" value="0" />';
										echo '<label><input type="checkbox" name="'. $field['id'] .'" id="'. $field['id'] .'" value="1"'. (($value) ? ' checked="checked"' : '') .' /> '. $desc .'</label>';
										break;
									case 'checkboxes':
										if( isset($field['choices']) ){
											foreach( $field['choices'] as $ckey=>$cval ){
												$val = '';
												if(isset($value[$field['id'] .'_'. $ckey])) $val = $value[$field['id'] .'_'. $ckey];
												elseif(is_array($field['std']) && in_array($ckey, $field['std'])) $val = $ckey;
												$val = esc_html(esc_attr($val));
												echo '<input type="hidden" name="'. $field['id'] .'_'. $ckey .'" value="0" />';
												echo '<label><input type="checkbox" name="'. $field['id'] .'_'. $ckey .'" id="'. $field['id'] .'_'. $ckey .'" value="'. $ckey .'"'. (($ckey == $val) ? ' checked="checked"' : '') .' /> '. $cval .'</label><br />';
											}
										}
										break;
									default:
										break;
								}

								echo '</div>';
							}
						}
					}
				}
			}
		}

	}
	new ThemePile_Meta_Box_Framework();

}

if( !function_exists( 'themepile_add_meta_box' ) ) {

	function themepile_add_meta_box( $meta_box ) {
		global $themepile_meta_boxes;

		if( !is_array($themepile_meta_boxes) )
			$themepile_meta_boxes = array();

		$themepile_meta_boxes[] = $meta_box;
	}

}