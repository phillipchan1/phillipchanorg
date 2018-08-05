<?php
/**
 * Paradeigm Functions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package Hypha Theme
 * @since v1.0
 */


/*-----------------------------------------------------------------------------------*/
/*	Setup Theme Defaults
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'hypha_after_setup_theme' ) ):
function hypha_after_setup_theme() {
	
	// Make theme available for translation
	load_theme_textdomain( 'hyphatheme', get_template_directory() . '/includes/languages' );
	
	if( is_admin() ) {

		// Add Editor Styles
		add_editor_style( array( '/includes/css/editor-style.css', hypha_header_font_url() ) );
		
		// Add Custom Metabox
		require_once( get_template_directory() . '/includes/admin/metabox.php' );

	}

	// Add Theme Customizer
	require_once( get_template_directory() . '/includes/admin/customizer.php' );
	
	// Add Custom Header
	require_once ( get_template_directory() . '/includes/admin/custom-header.php' );
	
	// Add RSS feed links to <head> for posts and comments
	add_theme_support( 'automatic-feed-links' );
	
	// Enable Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Default Thumb
	add_image_size( 'block-thumb', 500, 9999, false ); // Block Thumb
	add_image_size( 'post-image', 1000, 600, true ); // Headline Thumb
	add_image_size( 'image-format', 9999, 9999, false ); // Image Post Format
	
	add_image_size( 'square-thumb', 500, 500, true ); // Square Thumb

	// Register Menus
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'hyphatheme' )
	) );
	
	// Enable Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'link', 'quote' ) );

	// Custom Background Support
	add_theme_support( 'custom-background' );
	
	// Hypha Extensions Plugin Support
	//add_theme_support( 'hypha_themes_portfolio_support' );

}
endif; // hypha_after_setup_theme
add_action( 'after_setup_theme', 'hypha_after_setup_theme' );




/*-----------------------------------------------------------------------------------*/
/*	Enqueue Scripts / Styles
/*-----------------------------------------------------------------------------------*/

function hypha_enqueue_scripts() {
	
	$version = wp_get_theme()->Version;
	
	// Main Stylesheet
	wp_enqueue_style( 'hypha-style', get_stylesheet_uri() );
	
	// IE < 10 Stylesheet
	wp_enqueue_style( 'hypha-style-ie', get_stylesheet_directory_uri() . '/includes/css/ie.css', array( 'hypha-style' ) );
	wp_style_add_data( 'hypha-style-ie', 'conditional', 'lte IE 9' );
	
	// Google Fonts
	wp_enqueue_style( 'hypha-google-font-header', hypha_header_font_url(), array(), null );
	wp_enqueue_style( 'hypha-google-font-body', hypha_body_font_url(), array(), null );
	
	// Font Awesome
	if ( ! wp_style_is( 'hyphaext-fontawesome-css', 'enqueued' ) ) {
		wp_enqueue_style( 'hypha-fontawesome-css', get_template_directory_uri() . '/includes/fonts/fontawesome/font-awesome.min.css', array( 'hypha-style' ), '4.0.3' );
	}
	
	// Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	//Enqueue Masonry
	wp_enqueue_script( 'jquery-masonry' );

	// Custom Scripts
	wp_enqueue_script( 'hypha-scripts-js', get_template_directory_uri() . '/includes/js/custom.js', array(), $version, true );
	
	// Flexslider
	wp_enqueue_style( 'hypha-flexslider-css', get_template_directory_uri() . '/includes/css/flexslider.css', array( 'hypha-style' ), '2.2' );
	wp_enqueue_script( 'hypha-flexslider-js', get_template_directory_uri() . '/includes/js/jquery.flexslider.js', array(), '2.2', true );
	
	// Fitvids
	wp_enqueue_script( 'hypha-fitvids-js', get_template_directory_uri() . '/includes/js/jquery.fitvids.js', array( 'jquery' ), '1.0.3', true );

	// Small Menu
	wp_enqueue_script( 'hypha-small-menu-js', get_template_directory_uri() . '/includes/js/small-menu.js', array(), $version, true );

	// HTML5 IE Shiv
	wp_enqueue_script( 'hypha-htmlshiv-js', get_template_directory_uri() . '/includes/js/html5shiv.js', array(), '3.6.2', true );
		
	// Keyboard Image Navigation
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'hypha-keyboard-image-navigation-js', get_template_directory_uri() . '/includes/js/keyboard-image-navigation.js', array( 'jquery' ), $version );
	}
	
	// Threaded Comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Localize Scripts
	wp_localize_script( 'hypha-scripts-js', 'hypha_scripts_js_vars', array(
		'post_tabs' => get_option( 'hypha_customizer_tabs_select' ),
		'load_masonry' => !is_singular()
	) );
	
}
add_action( 'wp_enqueue_scripts', 'hypha_enqueue_scripts' );




/*-----------------------------------------------------------------------------------*/
/*	Content Width
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 770; /* pixels */




/*-----------------------------------------------------------------------------------*/
/*	Register Widget Areas / Widgets
/*-----------------------------------------------------------------------------------*/

/* Widget Areas */
function hypha_widgets_init() {	
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'hyphatheme' ),
		'id'            => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
		
	register_sidebar( array(
		'name' 			=> __( 'Footer', 'hyphatheme' ),
		'id' 			=> 'sidebar-footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h2 class="widget-title">',
		'after_title' 	=> '</h2>',
	) );
}
add_action( 'widgets_init', 'hypha_widgets_init' );




/*-----------------------------------------------------------------------------------*/
/*	Register Fonts
/*-----------------------------------------------------------------------------------*/

/* Register Google Font For Hypha Theme */
if ( ! function_exists( 'hypha_header_font_url' ) ):
function hypha_header_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by this font, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Google font: on or off', 'hyphatheme' ) ) {
		$font_url = add_query_arg( 'family', 'Josefin+Sans:600,700', "http://fonts.googleapis.com/css" );
	}

	return $font_url;
}
endif; // hypha_header_font_url


/* Register Google Font For Hypha Theme */
if ( ! function_exists( 'hypha_body_font_url' ) ):
function hypha_body_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by this font, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Google font: on or off', 'hyphatheme' ) ) {
		$font_url = add_query_arg( 'family', 'Merriweather:300italic,400,400italic,700', "http://fonts.googleapis.com/css" );
	}

	return $font_url;
}
endif; // hypha_body_font_url


/* Enqueue Google Fonts For Admin - Custom Header */
function hypha_admin_enqueue_scripts( $hook_suffix ) {
	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	wp_enqueue_style( 'hypha-google-font', hypha_header_font_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'hypha_admin_enqueue_scripts' );




/*-----------------------------------------------------------------------------------*/
/*	Register Plugins
/*-----------------------------------------------------------------------------------*/

/* Jetpack */
if ( class_exists( 'Jetpack' ) )
	require( get_template_directory() . '/includes/plugins/jetpack/jetpack.php' );




/*-----------------------------------------------------------------------------------*/
/*	Filter Functions
/*-----------------------------------------------------------------------------------*/

/* Author Contact Methods */
function hypha_user_contactmethods( $contactmethods ) {
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['instagram'] = 'Instagram';
	$contactmethods['tumblr'] = 'Tumblr';
	$contactmethods['dribbble'] = 'Dribbble';
	$contactmethods['flickr'] = 'Flickr';
	$contactmethods['pinterest'] = 'Pinterest';
	$contactmethods['googleplus'] = 'Google+';
	$contactmethods['vimeo'] = 'Vimeo';
	$contactmethods['youtube'] = 'YouTube';
	$contactmethods['linkedin'] = 'LinkedIn';
	$contactmethods['github'] = 'GitHub';
	$contactmethods['rss'] = 'RSS';
	$contactmethods['public_email'] = 'Public Email';
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'hypha_user_contactmethods', 10, 1 );


/* Add Next Page Button to Editor */
function add_nextpage_button($buttons) {
    // Insert the new item without overwriting an existing button
    array_splice( $buttons, 15, 0, 'wp_page' );
    return $buttons;
}
add_filter( 'mce_buttons', 'add_nextpage_button' );


/* Filter TinyMCE Buttons */
function hypha_mce_buttons_2( $buttons ) {
  	array_unshift( $buttons, 'styleselect' );
  	return $buttons;
}
add_filter( 'mce_buttons_2', 'hypha_mce_buttons_2' );


/* Add Style Options */
function hypha_tiny_mce_before_init( $settings ){
	$settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';

	$style_formats = array(
		array(
			'title'		=> 'Introduction',
			'block'   	=> 'h3',  
			'classes' 	=> 'h4 intro'
		),
		array(
			'title' 	=> 'Highlight',
			'inline'   	=> 'span',
			'classes' 	=> 'highlight'
		),
		array(
			'title' 	=> 'Dropcaps',
			'inline'   	=> 'span',
			'classes' 	=> 'dropcap'
		)
	);

	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'hypha_tiny_mce_before_init' );


/* Print Title Tag Based on Current View */
function hypha_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'hyphatheme' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'hypha_wp_title', 10, 2 );


/* Extend the Default WordPress Post Classes */
function hypha_post_class( $classes ) {
	if ( is_home() || is_archive() || is_search() ) {
		$classes[] = 'post-entry';
	}
	return $classes;
}
add_filter( 'post_class', 'hypha_post_class' );


/* Extend the Default WordPress Body Classes */
function hypha_body_class( $classes ) {
	global $wp_query;
	if ( is_home() || is_archive() || ( is_search() && 0 !== $wp_query->found_posts ) ) {
		$classes[] = 'posts-index masonry-index';
	}
	return $classes;
}
add_filter( 'body_class', 'hypha_body_class' );


/* Modify Read More Link */
function hypha_the_content_more_link( $more_link, $more_link_text ) {
	return str_replace( $more_link_text, __( 'Read More', 'hyphatheme'), $more_link );
}
add_filter( 'the_content_more_link', 'hypha_the_content_more_link', 10, 2 );




/*-----------------------------------------------------------------------------------*/
/*	Action Functions
/*-----------------------------------------------------------------------------------*/

/* Extend Init */
function hypha_extend_init() {
	
	/** 
	 * Add Taxonomy to Attachments
	 * Sets archive page header image to display the attachments
	 * tagged in the same category
	 */
	register_taxonomy_for_object_type( 'category', 'attachment' );
	register_taxonomy_for_object_type( 'post_tag', 'attachment' );
	
	// Add Excerpt to Pages
	add_post_type_support( 'page', 'excerpt' );
	
}  
add_action( 'init' , 'hypha_extend_init' );


/* Extend WP Head */
function hypha_show_custom_favicon() {
	
	// Add JS Class to HTML
	echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
	
	// Custom Favicon
	$favicon_custom = get_theme_mod( 'hypha_customizer_favicon' );
	$favicon = $favicon_custom ? esc_url( $favicon_custom ) : get_template_directory_uri() . '/includes/images/favicon.png';
	echo '<link rel="shortcut icon" href="' . $favicon . '" />'. "\n";
	
}
add_action( 'wp_head', 'hypha_show_custom_favicon' );


/* Ignore Featured Posts */
function hypha_ignore_featured_posts( $query ) {

	if ( is_home() && $query -> is_main_query() ) {
		// Featured Content Query
        $args = array(
			'posts_per_page' => get_option( 'hypha_customizer_featured_content_items' ),
			'meta_key' => '_thumbnail_id', // only if have thumbnail
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array(
						'post-format-aside',
						'post-format-audio',
						//'post-format-gallery',
						'post-format-image',
						'post-format-link',
						'post-format-quote',
						'post-format-video'
						),
					'operator' => 'NOT IN'
					)
			)
		);
		
		// Select either Sticky Posts or Categories
		if ( get_theme_mod('hypha_customizer_category_select') == 'sticky' ) {
			$args['post__in'] = get_option( 'sticky_posts' );
			$query->set('ignore_sticky_posts', true);
		} else {
			$args['category'] = get_theme_mod('hypha_customizer_category_select');
		}
						
		$featured_list_posts = get_posts($args);
		
		$count_posts = count( $featured_list_posts );
		
		if ( $featured_list_posts && $count_posts > 2 ) :			
			// Grab post IDs
			$slider_post_ids = array();
			foreach ( $featured_list_posts as $featured_list_post ) {
				$featured_post_ids[] = $featured_list_post->ID;
			}
			// Remove Featured Posts From Main Query
        	$query->set( 'post__not_in', $featured_post_ids );
		endif;
	}
	
}
add_action( 'pre_get_posts', 'hypha_ignore_featured_posts' );


/* Custom CSS Output */
function hypha_customizer_css() {
	$output = '';
	$accent = get_theme_mod( 'hypha_customizer_color_accent', '#dcbc83' );
	
	if ( $accent ) {
		$output .= 'a, blockquote:before, #commentform .required, #sidebar-widgets .widget ul li:hover:before, #footer-widgets .widget ul li:hover:before, #footer-widgets a:hover, #footer-widgets .widget ul li:before, #content .post-entry .entry-title a:hover {';
		$output .= 'color: ' . $accent . ';';
		$output .= '}';
		
		$output .= 'button, input[type="submit"], input[type="button"], input[type="reset"], pre:before, #read-progress, .page-links a, #comment-nav-below a, .post-format-icon a, .entry-meta .post-categories a, .tagcloud a, #wp-calendar tr th {';
		$output .= 'background: ' . $accent . ';';
		$output .= '}';
		
		$output .= '#main, .main-navigation ul ul, .main-small-navigation .sub-menu, .site-footer-inside, #content .post-entry, .menu-search, #sidebar-widgets {';
		$output .= 'border-top-color: ' . $accent . ';';
		$output .= '}';
		
		$output .= '.main-navigation ul ul:before {';
		$output .= 'border-bottom-color: ' . $accent . ';';
		$output .= '}';
		
		$output .= '.entry-meta ul li a {';
		$output .= 'border-color: ' . $accent . ';';
		$output .= '}';
	}
	
	/*
	if ( get_option( 'hypha_customizer_custom_header_disable' ) == 'enable' && is_single() ) {
		$output .= 'body.single .format-standard .entry-content::first-letter, body.page .entry-content::first-letter {';
		$output .= 'float: left; font-size: 4.500em; margin-right: .06em; line-height: 1em; }';
		$output .= '}';
	}
	*/
	
	// Display Customizer CSS
	if ( ! empty( $output ) ) {
		$output = '<style type="text/css">' . $output . '</style>';
		echo stripslashes( $output );
	}
	
}
add_action( 'wp_head', 'hypha_customizer_css' );




/*-----------------------------------------------------------------------------------*/
/*	Theme Functions
/*-----------------------------------------------------------------------------------*/

/* Get Header Background */
if ( ! function_exists( 'hypha_get_header_image' ) ):
function hypha_get_header_image() {
	global $post;
	
	if ( get_option( 'hypha_customizer_custom_header_disable' ) == 'disable' ) {
		$bg_image_url = get_header_image();
		return $bg_image_url;
	}
	
	if ( is_home() ) {
		// If it's the static blog page, use the custom header
		if ( ! defined( 'get_the_ID' ) ) {
			//$blog_id = get_the_id();
			$bg_image_url = get_header_image();
			return $bg_image_url;
		}
		$page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : $blog_id );
		
		$get_bg_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $page_id ), 'full', false, '');
		$bg_image_url = esc_url( $get_bg_image_url[0] );
		
		if ( empty( $bg_image_url ) ) {
			$bg_image_url = get_header_image();
		}
		
	} elseif ( is_author() || is_404() || is_search() ) {
		// Use the custom header if on Author, 404, or Search
		$bg_image_url = get_header_image();
	
	} elseif ( is_category() || is_tag() ) {
		// If in Archive, search for 1 random tagged image
		$query_slug = get_queried_object()->slug;
		$args = array(
			'post_type' => 'attachment',
			'post_status' => 'inherit',
			'orderby' => 'rand',
			'showposts' => 1
		);
		// Conditional Search
		if ( is_category() ) {
			$args['category_name'] = $query_slug;
		} elseif ( is_tag() ) {
			$args['tag'] = $query_slug;
		}
		$archive_media_query = new WP_Query( $args );
		
		if ( $archive_media_query->have_posts() ) {
			while ( $archive_media_query->have_posts() ) : $archive_media_query->the_post();
				$bg_image_url = wp_get_attachment_url( get_the_ID() );
			endwhile;
			wp_reset_postdata();
		} else {
			$bg_image_url = get_header_image();
		}
	
	} elseif ( '' != get_the_post_thumbnail() ) {
		// If there is a featured image, use it
		$get_bg_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', false, '');
		$bg_image_url = esc_url( $get_bg_image_url[0] );
		
	} else {
		// If there is no featured image, use the custom header
		$bg_image_url = get_header_image();
	}
	
	return $bg_image_url;
}
endif; // hypha_get_header_image


/* Get Attachment ID */
if ( ! function_exists( 'hypha_get_attachment_id_from_url' ) ):
function hypha_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}
endif; // hypha_get_attachment_id_from_url


/* Time Stamp */
if ( ! function_exists( 'hypha_get_time_stamp' ) ):
function hypha_get_time_stamp() {
	if ( get_option( 'hypha_customizer_time_stamp_select' ) == 'time' ) {
		// Time Ago
		return sprintf( __( '%s ago', 'hyphatheme' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
	} else {
		// Date
		return get_the_date();
	}
}
endif; // hypha_get_time_stamp


/* Read Time */
if ( ! function_exists( 'hypha_get_read_time' ) ):
function hypha_get_read_time() {
	global $post;
	// Get Word Count
    $content = get_post_field( 'post_content', $post->ID );
    $word_count = str_word_count( strip_tags( $content ) );
    $read_time = ceil( $word_count / 250 );
    
    return sprintf( __( '%s Min Read', 'hyphatheme' ), $read_time );
}
endif; // hypha_get_read_time


/* Grab First Image */
if ( ! function_exists( 'hypha_get_first_image' ) ):
function hypha_get_first_image() {
  global $post;
  $output = '';
  ob_start();
  ob_end_clean();
  preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
  $output = $matches[1][0];

  return $output;
}
endif; // hypha_get_first_image


/**
 * Pagination
 *
 * @param string $nav_id ID of navigation
 * @param string $pages Max number of pages in query
 * @param integer $range Number of links displayed before and after current page
 * @return string Pagination links
 */
if ( ! function_exists( 'hypha_get_pagination' ) ):
function hypha_get_pagination( $nav_id, $pages = '', $range = 2 ) {
	global $wp_query, $post, $paged;
	
	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}
				
	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;
		
	// Navigation Classes
	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() ) { 
		$nav_class = 'site-navigation post-navigation';
	}
	?>
	
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?> clearfix">
		<h1 class="assistive-text"><?php _e( 'Post Navigation', 'hyphatheme' ); ?></h1>

		<?php 
		// Navigation links for single posts
		if ( is_single() ) :
		
			previous_post_link(
				'<div class="nav-previous">%link</div>',
				'<span class="meta-nav"><i class="fa fa-caret-left"></i>' . __( 'Previous Post', 'hyphatheme' ) . '</span> %title'
			);
			next_post_link(
				'<div class="nav-next">%link</div>',
				'<span class="meta-nav">' . __( 'Next Post', 'hyphatheme' ) . '<i class="fa fa-caret-right"></i></span> %title'
			);
		
		// Navigation links for home, archive, and search pages
		elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) :
		
			if ( empty( $paged ) ) $paged = 1;
			$showitems = ( $range * 2 ) + 1;
			
			if ( $pages == '' ) {
				$pages = $wp_query->max_num_pages;
			};
			
			// Previous/Newer Post Links
			if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages)
				echo '<a href="' . get_pagenum_link(1) . '"><i class="fa fa-angle-double-left"></i></a>';
			if ( $paged > 1 && $showitems < $pages)
				previous_posts_link( '<i class="fa fa-angle-left"></i>' );
				
			// Pagination Numbers
			for ( $i = 1; $i <= $pages; $i++ ) {
				if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
					echo ($paged == $i) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '" class="numeric" >' . $i . '</a>';
				};
			};
			
			// Next/Older Posts Links
			if ( $paged < $pages && $showitems < $pages) {
				next_posts_link( '<i class="fa fa-angle-right"></i>' );
			};
			if ( $paged < $pages - 1 &&  $paged + $range - 1 < $pages && $showitems < $pages ) {
				echo '<a href="' . get_pagenum_link( $pages ) . '"><i class="fa fa-angle-double-right"></i></a>';
			};
			
		endif;
		?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
	
	// Jetpack Infinite Scroll Is Active
	/*
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		printf( '<div class="infinite-end-page">%s</div>',
			__( 'No More Posts', 'hyphatheme' )
		);
	}
	*/
	
}
endif; // hypha_get_pagination


/**
 * Related Posts
 *
 * @param string $type : Type of related post to search for
 * @param string $title_header : Text for header
 * @return string The related posts
 */
if ( ! function_exists( 'hypha_get_related_posts' ) ):
function hypha_get_related_posts( $type = null, $title_header = null ) {
	global $post, $authordata;
	
	// Get related posts type
	$related_posts_args = array(
		'numberposts' => 5,
		'meta_key' => '_thumbnail_id', // only if have thumbnail,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array(
					'post-format-aside',
					'post-format-audio',
					//'post-format-gallery',
					'post-format-image',
					'post-format-link',
					'post-format-quote',
					'post-format-video'
					),
				'operator' => 'NOT IN'
				)
		)
	);
	
	if ( is_search() || is_404() ) {} else {
		$related_posts_args['post__not_in'] = array( $post->ID );
	}
	
	switch ( $type ) {
    	case 'author':
        	$related_posts_args['author'] = $authordata->ID;
        	break;
        case 'tag':
        	$related_posts_args['tag__in'] = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
        	break;
        case 'popular':
        	$related_posts_args['orderby'] = 'comment_count';
        	break;
    	default:
        	$related_posts_args['category__in'] = wp_get_post_categories( $post->ID );
        	break;
	}
	
	$related_posts = get_posts( $related_posts_args );
	
	$count_posts = count( $related_posts );
	$slide_nav = ( $count_posts > 3 ) ? 'show-nav' : 'hide-nav';
	
	// Display related posts if found
	if ( $related_posts && $count_posts > 2 ) :
		$output = '';
		$output .= '<div id="related-posts" class="featured-content clearfix">';
			
			// Show Header
			if ( ! empty( $title_header ) ) {
				$output .= '<h3>' . $title_header . '</h3>';
			}
			
			$output .= '<div class="' . $type . '-related-posts-slider featured-content-slider ' . $slide_nav . ' flexslider">';
				// Output related posts list
				$output .= '<ul class="' . $type . '-related-posts-list featured-content-list slides">';
					foreach ( $related_posts as $post ) {
						setup_postdata( $post );
						$output .= '<li>';
						$output .= sprintf(
							'<figure>
								<a class="featured-image" href="%1$s" title="%2$s" rel="bookmark">
									<div class="featured-info">
										<div class="info-wrapper">
											<span class="time-stamp h5">%3$s<span class="sep"></span>%4$s</span>
											<h2 class="h4">%5$s</h2>
										</div>
									</div>
								%6$s
								</a>
							</figure>',
							get_the_permalink(),
							esc_attr( sprintf( __( 'Permalink to %s', 'hyphatheme' ), the_title_attribute( 'echo=0' ) ) ),
							hypha_get_time_stamp(),
							hypha_get_read_time(),
							get_the_title(),
							get_the_post_thumbnail( get_the_ID(), 'square-thumb' )
						);
						$output .= '</li>';
					}
					wp_reset_postdata();
				$output .= '</ul>';
			$output .= '</div><!-- .' . $type . '-related-posts-slider -->';
		$output .= '</div><!-- .related-posts -->';
		
		return $output;
	endif;
	
}
endif; // hypha_get_related_posts


/**
 * Social Icons
 *
 * @param string $type Use 'author' for profile contact info
 * @return string The social icons
 */
if ( ! function_exists( 'hypha_get_social_icons' ) ):
function hypha_get_social_icons( $type = null ) {	
	$output = '';
	$socials = array(
		'twitter' => 'fa-twitter',
		'facebook' => 'fa-facebook',
		'instagram' => 'fa-instagram',
		'tumblr' => 'fa-tumblr',
		'dribbble' => 'fa-dribbble',
		'flickr' => 'fa-flickr',
		'pinterest' => 'fa-pinterest',
		'googleplus' => 'fa-google-plus',
		'vimeo' => 'fa-play',
		'youtube' => 'fa-youtube',
		'linkedin' => 'fa-linkedin',
		'github' => 'fa-github',
		'rss' => 'fa-rss-square',
		'public_email' => 'fa-envelope'
	);
	
	// Display social links
	foreach ( $socials as $social => $class ) {
		switch ( $type ) {
    		case 'author':
    			$social_option = get_the_author_meta( $social );
        		break;
    		default:
        		$social_option = get_option( 'hypha_customizer_icon_' . $social );
        		break;
		}
		
		// Output social icons
		if ( $social_option ) {
			if ( $social == 'public_email' ) {
				$social_link = 'mailto:' . antispambot( $social_option );
			} else {
				$social_link = esc_url( $social_option );
			};
			$output .= '<a href="' . $social_link . '" class="' . $social . '-icon" title="' . esc_attr( ucfirst( $social ) ) . '">';
			$output .= '<i class="fa ' . $class . '"></i>';
			$output .= '</a>';
		};
	};
							
	return $output;
}
endif; // hypha_get_social_icons


/**
 * Comment Output
 *
 * Used as a callback by wp_list_comments() for displaying the comments
 */
if ( ! function_exists( 'hypha_get_comment' ) ):
function hypha_get_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

		<div class="comment-block clearfix" id="comment-<?php comment_ID(); ?>">

			<div class="comment-info clearfix">
				<div class="comment-author vcard">
					<div class="vcard-wrap">
						<?php echo get_avatar( $comment->comment_author_email, 100 ); ?>
					</div>
				</div>

				<div class="comment-content">
					<div class="comment-meta commentmetadata">
						<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>

						<div class="comment-time">
							<?php
								printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'hyphatheme' ), get_comment_date(), get_comment_time() )
								);
							?>
							<?php edit_comment_link('<i class="fa fa-edit"></i>', ''); ?>
						</div>
					</div>

					<?php comment_text(); ?>

					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'hyphatheme'); ?></em>
			<?php endif; ?>
		</div>
	<?php
	/* </li> closes in comments.php */
}
endif; // hypha_get_comment