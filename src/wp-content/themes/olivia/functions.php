<?php
/**
 * Olivia functions and definitions
 *
 * @package Olivia
 */


if ( ! function_exists( 'at_olivia_setup' ) ) :
/**
 * Sets up Olivia's defaults and registers support for various WordPress features
 */
function at_olivia_setup() {

	/**
	 * Add styles to post editor (editor-style.css)
	 */
	add_editor_style();

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'olivia', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Post thumbnail support and image sizes
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Add title output
	 */
	add_theme_support( 'title-tag' );

	// Large post image
	add_image_size( 'olivia-full-width', 1200 );

	// Grid thumbnail
	add_image_size( 'olivia-list-thumb', 80, 80, true );

	// Logo size
	add_image_size( 'olivia-logo', 120, 120 );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'site-logo', array(
		'header-text' => array(
			'titles-wrap',
		),
		'size' => 'olivia-logo',
	) );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'olivia' )
	) );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );

	/**
	 * Remove subtitle plugins css
	 */
	if ( class_exists( 'Subtitles' ) &&  method_exists( 'Subtitles', 'subtitle_styling' ) ) {
	    remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
	}
}
endif; // at_olivia_setup
add_action( 'after_setup_theme', 'at_olivia_setup' );




/**
 * Set the content width based on the theme's design and stylesheet
 */
function at_olivia_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'at_olivia_content_width', 1275 );
}
add_action( 'after_setup_theme', 'at_olivia_content_width', 0 );


/**
 * Register widget area
 */
function at_olivia_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Drawer Widget Area', 'olivia' ),
		'id'            => 'drawer-widget',
		'description'   => esc_html__( 'Widgets added here will appear on the drawer.', 'olivia' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'at_olivia_widgets_init' );


if ( ! function_exists( 'at_olivia_fonts_url' ) ) :
	/**
	 * Register Google fonts for Olivia.
	 */
	function at_olivia_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Abril Fatface, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Abril Fatface font: on or off', 'olivia' ) ) {
			$fonts[] = 'Abril Fatface';
		}

		/* translators: If there are characters in your language that are not supported by Karla, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Karla font: on or off', 'olivia' ) ) {
			$fonts[] = 'Karla:400,400italic,700,700italic';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;


/**
 * Enqueue Google fonts style to admin for editor styles
 */
function at_olivia_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'olivia-fonts', at_olivia_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'at_olivia_admin_fonts' );
add_action( 'admin_print_styles-appearance_page_custom-header', 'at_olivia_admin_fonts' );


/**
 * Enqueue scripts and styles
 */
function at_olivia_scripts() {

	wp_enqueue_style( 'olivia-style', get_stylesheet_uri() );

	/**
	* Load Abril Fatface & Karla from Google
	*/
	wp_enqueue_style( 'olivia-fonts', at_olivia_fonts_url(), array(), null );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fonts/fontawesome/css/font-awesome.css", array(), '4.4.0', 'screen' );

	/**
	 * Simple-Line-Icons stylesheet - https://github.com/thesabbir/simple-line-icons
	 */
	wp_enqueue_style( 'font-sli', get_template_directory_uri() . "/inc/fonts/simple-line-icons/css/simple-line-icons.css", array(), '2.2.2', 'screen' );

	/**
	 * Load Olivia's javascript
	 */
	wp_enqueue_script( 'olivia-js', get_template_directory_uri() . '/js/olivia.js', array( 'jquery' ), '1.0', true );

	/**
	 * Localizes the olivia-js file
	 */
	wp_localize_script( 'olivia-js', 'at_olivia_js_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );

	/**
	 * Load fitvids
	 */
	wp_enqueue_script( 'fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), '1.6.6', true );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'at_olivia_scripts' );


/**
 * Custom template tags for Olivia
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates
 */
require get_template_directory() . '/inc/extras.php';


/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Color customizer theme options
 */
require get_template_directory() . '/inc/color-customizer.php';


/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Add button class to next/previous post links
 */
function at_olivia_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'at_olivia_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'at_olivia_posts_link_attributes' );


/**
 * Remove default ellipsis and add class to more link
 */
function at_olivia_custom_excerpt( $text ) {
   if ( strpos( $text, '[&hellip;]') ) {
      $excerpt = str_replace( '[&hellip;]', '<p><a class="more-link" href="' . get_permalink() . '">Read More</a></p><br>', $text );
   } else {
      $excerpt = $text . '<p><a class="more-link" href="' . get_permalink() . '">Read More</a></p>';
   }
   return $excerpt;
}
add_filter( 'the_excerpt', 'at_olivia_custom_excerpt' );


/**
 * Remove the 28px Push Down from the Admin Bar
 */
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');
