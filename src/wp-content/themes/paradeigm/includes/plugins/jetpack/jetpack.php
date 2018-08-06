<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Hypha Theme
 */


/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function hypha_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'type'		=> 'click',
		'container' => 'main-content',
		'footer'    => 'colophon',
		'wrapper'   => false,
		'render'    => 'hypha_render_infinite_posts',
	) );
}
add_action( 'after_setup_theme', 'hypha_jetpack_setup' );


/* Render infinite posts by using the standard template */
if ( ! function_exists( 'hypha_render_infinite_posts' ) ):
function hypha_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'content', get_post_format() );
	}
}
endif; // hypha_render_infinite_posts


/* Change Click Button Text */
function filter_jetpack_infinite_scroll_js_settings( $settings ) {
	$settings['text'] = __( 'Load More', 'hyphatheme' );
 
	return $settings;
}
add_filter( 'infinite_scroll_js_settings', 'filter_jetpack_infinite_scroll_js_settings' );