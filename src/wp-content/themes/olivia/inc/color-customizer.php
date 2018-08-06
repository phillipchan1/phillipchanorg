<?php
/**
 * Olivia Customizer functionality
 *
 * @package WordPress
 * @subpackage Olivia
 * @since Olivia 1.0
 *
 */



/**
 * Registers additional customizer controls
 */
function array_register_customizer_options( $wp_customize ) {

	// Body Background Color
	$wp_customize->add_setting( 'at_olivia_body_bg_color', array(
		'default'           => '#fff',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'at_olivia_body_bg_color', array(
		'label'    => esc_html__( 'Body Background Color', 'olivia' ),
		'section'  => 'colors',
		'settings' => 'at_olivia_body_bg_color',
		'priority' => 15
	) ) );

	// Drawer Background Color
	$wp_customize->add_setting( 'at_olivia_drawer_bg_color', array(
		'default'           => '#141618',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'at_olivia_drawer_bg_color', array(
		'label'    => esc_html__( 'Drawer Background Color', 'olivia' ),
		'section'  => 'colors',
		'settings' => 'at_olivia_drawer_bg_color',
		'priority' => 16
	) ) );


	// Border Color
	$wp_customize->add_setting( 'at_olivia_west_border_color', array(
		'default'           => '#ddd',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'at_olivia_west_border_color', array(
		'label'    => esc_html__( 'Border Color', 'olivia' ),
		'section'  => 'colors',
		'settings' => 'at_olivia_west_border_color',
		'priority' => 17
	) ) );


	// Body Text Color
	$wp_customize->add_setting( 'at_olivia_body_text', array(
		'default'           => '#343c40',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'at_olivia_body_text', array(
		'label'    => esc_html__( 'Body Text Color', 'olivia' ),
		'section'  => 'colors',
		'settings' => 'at_olivia_body_text',
		'priority' => 18
	) ) );


	// Subtitle Color
	$wp_customize->add_setting( 'at_olivia_subtitle_text', array(
		'default'           => '#aaa',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'at_olivia_subtitle_text', array(
		'label'    => esc_html__( 'Secondary Body Text Color', 'olivia' ),
		'description' => esc_html__( 'Change the color of subtitle post.', 'olivia' ),
		'section'  => 'colors',
		'settings' => 'at_olivia_subtitle_text',
		'priority' => 19
	) ) );


	// Accent Color
	$wp_customize->add_setting( 'at_olivia_accent_color', array(
		'default'           => '#E0B853',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'at_olivia_accent_color', array(
		'label'    => esc_html__( 'Accent Color', 'olivia' ),
		'section'  => 'colors',
		'settings' => 'at_olivia_accent_color',
		'priority' => 20
	) ) );


	// Element Color
	$wp_customize->add_setting( 'at_olivia_element_color', array(
		'default'           => '#000',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'at_olivia_element_color', array(
		'label'    => esc_html__( 'Element Color', 'olivia' ),
		'description' => esc_html__( 'Change the color of Site Title, Menu, Widgets, Navigation Buttons.', 'olivia' ),
		'section'  => 'colors',
		'settings' => 'at_olivia_element_color',
		'priority' => 21
	) ) );

}
add_action( 'customize_register', 'array_register_customizer_options' );



/**
 * Add Customizer CSS To Header
 */
function at_olivia_customizer_css() {
	?>
	<style type="text/css">

		body {
			background: <?php echo get_theme_mod( 'at_olivia_body_bg_color', '#FFF' ); ?>;
			color: <?php echo get_theme_mod( 'at_olivia_body_text', '#343E47' ); ?>;
		}

		#fullscreen-menu {
			background: <?php echo get_theme_mod( 'at_olivia_drawer_bg_color', '#000' ); ?>;
		}

		.v-line {
			background: <?php echo get_theme_mod( 'at_olivia_west_border_color', '#DDD' ); ?>;
		}
		
		.entry-subtitle {
			color: <?php echo get_theme_mod( 'at_olivia_subtitle_text', '#aaa' ); ?>;
		}

		a,
		.site-title a:hover,
		.post.is-hovered a,
		.main-navigation a,
		.entry-title a:hover,
		.list-post .entry-title a:hover,
		#wp-calendar a:hover {
			color: <?php echo get_theme_mod( 'at_olivia_accent_color', '#DAA520' ); ?>;
		}

		.featured-sign a,
		button:hover,
		input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.button:hover,
		.comment-navigation a:hover,
		.drawer .tax-widget a:hover {
			background: <?php echo get_theme_mod( 'at_olivia_accent_color', '#DAA520' ); ?>;
		}

		.blog-title, 
		.author-profile-title, 
		.archive-title,
		.fs-title,
		h3.comments-title,
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="password"]:focus,
		input[type="search"]:focus,
		textarea:focus,
		#page #infinite-handle button,
		#page #infinite-handle button:hover {
			border-color: <?php echo get_theme_mod( 'at_olivia_accent_color', '#DAA520' ); ?>;
		}

		.nav-icon, 
		.nav-icon:before, 
		.nav-icon:after, 
		.widget-icon, 
		.widget-icon:before, 
		.widget-icon:after,
		.panel-widget-open .side-widget .widget-icon,
		.panel-widget-open .side-widget .widget-icon:after,
		.panel-menu-open .side-menu:hover .nav-icon:before,
		.panel-menu-open .side-menu:hover .nav-icon:after {
			background: <?php echo get_theme_mod( 'at_olivia_element_color', '#000' ); ?>;
		}

		.navigation a,
		.site-title a,
		.navigation a:hover,
		.post-navigation a {
			color: <?php echo get_theme_mod( 'at_olivia_element_color', '#000' ); ?>;
		}

	</style>
<?php
}
add_action( 'wp_head', 'at_olivia_customizer_css' );


