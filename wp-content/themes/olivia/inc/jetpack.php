<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Olivia
 */

/**
 * Add theme support for
 * - Infinite Scroll / see http://jetpack.me/support/infinite-scroll/
 * - Featured Content / see https://jetpack.me/support/featured-content/
 * See: http://jetpack.me/support/infinite-scroll/
 */
function at_olivia_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'articles-list',
		'wrapper'   => 'new-infinite-posts',
		'footer'    => 'page',
		'render'    => 'at_olivia_render_infinite_posts',
		'type'      => 'click',
	) );

	add_theme_support( 'featured-content', array(
	    'filter'     => 'olivia_get_featured_posts',
	    'max_posts'  => 1,
	    'post_types' => array( 'post' ),
	) );
}
add_action( 'after_setup_theme', 'at_olivia_jetpack_setup' );

/** Render infinite posts by using template parts */
function at_olivia_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'template-parts/content-list' );
	}
}

/**
 * Add infinite-scroll class if active
 */
function at_olivia_is_class( $classes ) {
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		$classes[] = 'infinite-scroll';
	}

	return $classes;
}
add_filter( 'body_class', 'at_olivia_is_class' );


/**
 * Changes the text of the "Older posts" button in infinite scroll
 * for portfolio related views.
 */
function at_olivia_infinite_scroll_button_text( $js_settings ) {

	$js_settings['text'] = esc_html__( 'Load more', 'olivia' );

	return $js_settings;
}
add_filter( 'infinite_scroll_js_settings', 'at_olivia_infinite_scroll_button_text' );


/**
 * Getter function for Featured Content Plugin.
 *
 * @return array An array of WP_Post objects.
 */
function at_olivia_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Olivia.
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'olivia_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether there are featured posts.
 */
function at_olivia_has_featured_posts() {
	return ! is_paged() && (bool) at_olivia_get_featured_posts();
}


