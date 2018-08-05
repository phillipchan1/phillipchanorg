<?php
/**
 * ThemePile Helpers
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function the_blog_title() {
	$blogID = get_option( 'page_for_posts', false );
	if ( $blogID != false && ! empty( $blogID ) ) {
		echo get_the_title( $blogID );
	}
	else {
		_e( "Our Blog", THEMEPILE_LANGUAGE );
	}
}

function the_blog_permalink() {
	$blogID = get_option( 'page_for_posts', false );
	if ( $blogID != false && ! empty( $blogID ) ) {
		echo get_permalink( $blogID );
	}
	else {
		echo esc_url( home_url( '/' ) );
	}
}


if ( ! function_exists( 'themepile_get_posts_list' ) ) {
	function themepile_get_posts_list( $post_type = 'project', $posts_per_page = -1 ) {
		$args = array(
			'posts_per_page' => $posts_per_page,
			'post_type'      => $post_type,
			'order'          => apply_filters( 'themepile_' . $post_type . '_order', 'DESC' ),
			'orderby'        => apply_filters( 'themepile_' . $post_type . '_orderby', 'menu_order date' ),
		);

		$args = apply_filters( 'themepile_' . $post_type . '_list_agrs', $args );
		return new WP_Query( $args );
	}
}

if ( ! function_exists( 'themepile_dropdown_posts' ) ) {
	/**
	 *
	 * @param string $args
	 *
	 * @return mixed|string|void
	 */
	function themepile_dropdown_posts( $args = '' ) {
		$defaults = array(
			'selected'              => 0,
			'echo'                  => 1,
			'input_name'            => 'page_id',
			'input_id'              => '',
			'show_option_none'      => '',
			'show_option_no_change' => '',
			'option_none_value'     => '',
			'numberposts'           => - 1,
			'depth'                 => 0,
		);

		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		$pages  = get_posts( $r );
		$output = '';
		// Back-compat with old system where both id and name were based on $name argument
		if ( empty( $id ) ) {
			$input_id = $input_name;
		}

		if ( ! isset( $custom_attr ) ) {
			$custom_attr = "";
		}

		if ( ! isset( $label ) ) {
			$label = "";
		}

		if ( ! empty( $pages ) ) {
			$output = "<select $custom_attr name='" . esc_attr( $input_name ) . "' id='" . esc_attr(
				$input_id
			) . "'>\n";
			if ( $show_option_no_change ) {
				$output .= "\t<option value=\"-1\">$show_option_no_change</option>";
			}
			if ( $show_option_none ) {
				$output .= "\t<option value=\"" . esc_attr(
					$option_none_value
				) . "\">$show_option_none</option>\n";
			}
			$output .= walk_page_dropdown_tree( $pages, $depth, $r );
			$output .= "</select>\n" . $label;
		}

		if ( $echo ) {
			echo $output;
		}

		return $output;
	}
}

if ( ! function_exists( 'themepile_input_meta_box' ) ) {
	function themepile_input_meta_box( $post, $args = array() ) {
		$defaults = array(
			'input_name'  => 'name_' . $post->post_type,
			'echo'        => 1,
			'custom_attr' => '',
			'label'       => '',
			'value'       => ''
		);

		$args = isset( $args['args'] ) ? $args['args'] : array();
		$r    = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		if ( empty( $input_id ) ) {
			$input_id = $input_name;
		}


		$output = "<input $custom_attr type=\"text\" name=\"" . esc_attr( $input_name ) . "\" id=\"" . esc_attr(
			$input_id
		) . "\" value='" . esc_attr( $value ) . "'>" . $label;

		if ( $echo ) {
			echo $output;
		}

		return $output;
	}
}