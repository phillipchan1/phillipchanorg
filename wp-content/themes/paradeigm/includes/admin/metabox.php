<?php
/**
 * Metaboxes
 *
 * @package Hypha Theme
 * @since v1.0
 */

/*-----------------------------------------------------------------------------------*/
/*	Add Metaboxes
/*-----------------------------------------------------------------------------------*/

function hypha_add_meta_boxes() {

	// Featured Preview
	add_meta_box( 'hypha_featured_preview_meta', __( 'Featured Preview', 'hyphatheme' ), 'hypha_featured_preview_meta_box', 'post', 'normal', 'high' );

	// Page Subtitle
	add_meta_box( 'hypha_page_subtitles_meta', __( 'Page Subtitle', 'hyphatheme' ), 'hypha_page_subtitles_meta_box', 'post', 'normal', 'high' );
	add_meta_box( 'hypha_page_subtitles_meta', __( 'Page Subtitle', 'hyphatheme' ), 'hypha_page_subtitles_meta_box', 'page', 'normal', 'high' );
	
}
add_action( 'add_meta_boxes', 'hypha_add_meta_boxes' );




/*-----------------------------------------------------------------------------------*/
/*	Print Metaboxes
/*-----------------------------------------------------------------------------------*/

/* Featured Preview */
function hypha_featured_preview_meta_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'hypha_featured_preview_nonce' );
	
	// Get existing value
	$value = get_post_meta( $post->ID, 'hypha_featured_preview_meta', true );

	$output = '<input type="text" id="hypha_featured_preview_meta" name="hypha_featured_preview_meta" value="' . esc_attr( $value ) . '" size="30" style="width:100%;" />';
	$output .= '<p>' . sprintf( __( 'Embed videos, images, tweets, audio, and other content by entering its URL. <a class="thickbox" href="%1$s">More Info</a>', 'hyphatheme' ), esc_url( 'http://codex.wordpress.org/Embeds?TB_iframe=true&amp;width=900&amp;height=600' ) ) . '</p>';

	echo $output;
}


/* Page Subtitles */
function hypha_page_subtitles_meta_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'hypha_page_subtitles_nonce' );

	// Get existing value
	$value = get_post_meta( $post->ID, 'hypha_page_subtitles_meta', true );

	$output = '<input type="text" id="hypha_page_subtitles_meta" name="hypha_page_subtitles_meta" value="'.esc_attr( $value ).'" size="30" style="width:100%;" />';
	$output .= '<p>' . __( 'Add a subtitle for your page (optional).', 'hyphatheme' ) . '</p>';
	
	echo $output;
}




/*-----------------------------------------------------------------------------------*/
/*	Save Metaboxes
/*-----------------------------------------------------------------------------------*/

/* Sanitize Save Metabox */
function hypha_sanitize_save_meta_box( $post_id, $nonce_field ) {
	
	// Get the posted data and sanitize it
	$new_meta_value = ( isset( $_POST[$nonce_field] ) ? $_POST[$nonce_field] : '' );
	
	// Get the meta key
	$meta_key = $nonce_field;
	
	// Get the meta value of the custom field key
	$meta_value = get_post_meta( $post_id, $meta_key, true );
	
	// If a new meta value was added and there was no previous value, add it
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
		
	// If the new meta value does not match the old value, update it
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	
	// If there is no new meta value but an old value exists, delete it
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
		   
}


/* Save Post Featured Preview Metabox */
function hypha_save_featured_preview_meta_box( $post_id ) {
	global $post;

	// Return early if this is a newly created post that hasn't been saved yet.
	if ( 'auto-draft' == get_post_status( $post_id ) ) {
		return $post_id;
	}
	
	// Verify the nonce before proceeding
	if ( ! isset( $_POST["hypha_featured_preview_nonce"] ) || ! wp_verify_nonce( $_POST["hypha_featured_preview_nonce"], plugin_basename( __FILE__ ) ) )
		return $post_id;

	// Get post type object
	$post_type = get_post_type_object( $post->post_type );

	// Check if user has permission to edit the post
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}
	
	// Call function to santize save meta box
	hypha_sanitize_save_meta_box( $post_id, 'hypha_featured_preview_meta' );

}
add_action( 'save_post', 'hypha_save_featured_preview_meta_box' );


/* Save Post Page Subtitles Metabox */
function hypha_save_page_subtitles_meta_box( $post_id ) {
	global $post;

	// Return early if this is a newly created post that hasn't been saved yet.
	if ( 'auto-draft' == get_post_status( $post_id ) ) {
		return $post_id;
	}
	
	// Verify the nonce before proceeding
	if ( ! isset( $_POST["hypha_page_subtitles_nonce"] ) || ! wp_verify_nonce( $_POST["hypha_page_subtitles_nonce"], plugin_basename( __FILE__ ) ) )
		return $post_id;

	// Get post type object
	$post_type = get_post_type_object( $post->post_type );

	// Check if user has permission to edit the post
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}
	
	// Call function to santize save meta box
	hypha_sanitize_save_meta_box( $post_id, 'hypha_page_subtitles_meta' );

}
add_action( 'save_post', 'hypha_save_page_subtitles_meta_box' );