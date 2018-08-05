<?php
/**
 * Olivia Theme Customizer
 *
 * Customizer color options can be found in inc/color-customizer.php.
 *
 * @package Olivia
 */



if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;


/**
 * Sanitize range slider
 */
function at_olivia_sanitize_range( $input ) {
	filter_var( $input, FILTER_FLAG_ALLOW_FRACTION );
	return ( $input );
}


/**
 * Sanitize title select option
 */
function at_olivia_sanitize_opt_site_title( $title ) {

	if ( ! in_array( $title, array( 'circle', 'rectangle' ) ) ) {
		$title = 'square';
	}
	return $title;
}


/**
 * Sanitize text
 */
function at_olivia_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize textarea output
 */
function at_olivia_sanitize_textarea( $text ) {
    return esc_textarea( $text );
}


/**
 * Sanitize a checkbox to only allow 0 or 1
 */
function sanitize_checkbox( $input ) {
	return ( 1 === absint( $input ) ) ? 1 : 0;
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function at_olivia_customize_register( $wp_customize ) {

	// Options for site logo
	$wp_customize->add_setting( 'at_olivia_opt_site_logo', array(
		'default' => 0,
		'sanitize_callback' => 'sanitize_checkbox',
	));

	$wp_customize->add_control( 'at_olivia_opt_site_logo', array(
		'settings' => 'at_olivia_opt_site_logo',
		'label'    => esc_html__( 'Rounded Logo', 'olivia' ),
		'section'  => 'title_tagline',
		'type'     => 'checkbox',
		'priority' => 30
	) );

	// Logo and header text options - only show if Site Logos is not supported
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		$wp_customize->add_setting( 'at_olivia_customizer_logo', array(
			'transport'         => 'refresh',
			'sanitize_callback' => 'at_olivia_sanitize_text'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'at_olivia_customizer_logo', array(
			'label'    => esc_html__( 'Logo Upload', 'olivia' ),
			'section'  => 'title_tagline',
			'settings' => 'at_olivia_customizer_logo',
		) ) );

		$wp_customize->add_setting( 'at_olivia_hide_site_title', array(
			'transport'         => 'refresh',
			'default'			=> 0,
			'sanitize_callback' => 'sanitize_checkbox'
		) );

		$wp_customize->add_control( 'at_olivia_hide_site_title', array(
			'settings' => 'at_olivia_hide_site_title',
			'label'    => esc_html__( 'Hide Site Title', 'olivia' ),
			'section'  => 'title_tagline',
			'type'     => 'checkbox',
			'priority' => 31
		) );
	}

	// Theme Options - under Featured Content
	$wp_customize->add_section( 'at_olivia_customizer', array(
		'title'    => esc_html__( 'Theme Options', 'olivia' ),
		'priority' => 131
	) );

	// Articles Header Text
	$wp_customize->add_setting( 'at_olivia_article_header_text', array(
		'sanitize_callback' => 'at_olivia_sanitize_text',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'at_olivia_article_header_text', array(
			'label'    => esc_html__( 'Articles Header Text', 'olivia' ),
			'section'  => 'at_olivia_customizer',
			'settings' => 'at_olivia_article_header_text',
			'type'     => 'text',
			'priority' => 1
		)
	);

	// Menu Header Text
	$wp_customize->add_setting( 'at_olivia_menu_header_text', array(
		'sanitize_callback' => 'at_olivia_sanitize_text',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'at_olivia_menu_header_text', array(
			'label'    => esc_html__( 'Menu Header Text', 'olivia' ),
			'section'  => 'at_olivia_customizer',
			'settings' => 'at_olivia_menu_header_text',
			'type'     => 'text',
			'priority' => 2
		)
	);

	// Widget Header Text
	$wp_customize->add_setting( 'at_olivia_widget_header_text', array(
		'sanitize_callback' => 'at_olivia_sanitize_text',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'at_olivia_widget_header_text', array(
			'label'    => esc_html__( 'Widget Header Text', 'olivia' ),
			'section'  => 'at_olivia_customizer',
			'settings' => 'at_olivia_widget_header_text',
			'type'     => 'text',
			'priority' => 3
		)
	);

	// Footer tagline
	$wp_customize->add_setting( 'at_olivia_footer_text', array(
		'sanitize_callback' => 'at_olivia_sanitize_text',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'at_olivia_footer_text', array(
			'label'    => esc_html__( 'Footer Tagline', 'olivia' ),
			'section'  => 'at_olivia_customizer',
			'settings' => 'at_olivia_footer_text',
			'type'     => 'text',
			'priority' => 4
		)
	);

}
add_action( 'customize_register', 'at_olivia_customize_register' );


/**
 * Replaces the footer tagline text
 */
function at_olivia_filter_footer_text() {

	// Get the footer copyright text
	$footer_copy_text = get_theme_mod( 'at_olivia_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text
		$footer_text = '&copy; ' . date("Y") . sprintf( esc_html__( ' %1$s Theme', 'olivia' ), 'Olivia' );
	}

	return $footer_text;

}
add_filter( 'at_olivia_footer_text', 'at_olivia_filter_footer_text' );


/**
 * Replaces the articles header text
 */
function at_olivia_filter_article_header_text() {

	// Get the articles header text
	$article_header_text = get_theme_mod( 'at_olivia_article_header_text' );

	if ( $article_header_text ) {
		// If we have articles header text, use it
		$article_text = $article_header_text;
	} else {
		// Otherwise show the fallback theme text
		$article_text = _e( 'Articles', 'olivia' );
	}

	return $article_text;

}
add_filter( 'at_olivia_article_header_text', 'at_olivia_filter_article_header_text' );


/**
 * Replaces the menu header text
 */
function at_olivia_filter_menu_header_text() {

	// Get the menu header text
	$menu_header_text = get_theme_mod( 'at_olivia_menu_header_text' );

	if ( $menu_header_text ) {
		// If we have menu header text, use it
		$menu_text = $menu_header_text;
	} else {
		// Otherwise show the fallback theme text
		$menu_text = _e( 'Menu', 'olivia' );
	}

	return $menu_text;

}
add_filter( 'at_olivia_menu_header_text', 'at_olivia_filter_menu_header_text' );


/**
 * Replaces the widget header text
 */
function at_olivia_filter_widget_header_text() {

	// Get the widget header text
	$widget_header_text = get_theme_mod( 'at_olivia_widget_header_text' );

	if ( $widget_header_text ) {
		// If we have widget header text, use it
		$widget_text = $widget_header_text;
	} else {
		// Otherwise show the fallback theme text
		$widget_text = _e( 'Explore', 'olivia' );
	}

	return $widget_text;

}
add_filter( 'at_olivia_widget_header_text', 'at_olivia_filter_widget_header_text' );