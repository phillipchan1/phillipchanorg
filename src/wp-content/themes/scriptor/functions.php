<?php
/**
 * ThemePile functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 * Set up the content width value based on the theme's design.
 */
if ( ! isset( $content_width ) )
	$content_width = 960;

/*
 * Init ThemePile Framework
 *
 * @since Scriptor
 *
 * @return void
 */
require_once( 'framework/framework.php' );
$theme = ThemePileTheme::getInstance();

if ( ! function_exists( 'themepile_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers the various WordPress features that
	 * ThemePile supports.
	 *
	 * @uses  load_theme_textdomain() For translation/localization support.
	 * @uses  add_editor_style() To add Visual Editor stylesheets.
	 * @uses  add_theme_support() To add support for automatic feed links, post
	 *        formats, and post thumbnails.
	 * @uses  register_nav_menu() To add support for a navigation menu.
	 * @uses  set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_theme_setup() {
		/*
		 * Makes ThemePile available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Twenty Thirteen, use a find and
		 * replace to change THEMEPILE_LANGUAGE to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( THEMEPILE_LANGUAGE, get_template_directory() . '/languages' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( 'css/editor-style.css' );

		// Switches default core markup for search form, comment form, and comments
		// to output valid HTML5.
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * This theme uses a custom image size for featured images, displayed on
		 * "standard" posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );

		/*
		 * This theme supports all available post formats by default.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' )
		);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary-menu', __( 'Primary Navigation', THEMEPILE_LANGUAGE ) );
		register_nav_menu( 'cover-menu', __( 'Cover Navigation', THEMEPILE_LANGUAGE ) );

		add_theme_support( 'post-thumbnails' );

		add_image_size('themepile-post-grid-size-x1', 140, 140, true);
		add_image_size('themepile-post-grid-size-x2', 300, 200, true);
		add_image_size('themepile-post-grid-size-x3', 460, 300, true);

		// Body class modificators
		$is_themepile_sidebar_right   = ThemePileTheme::get_theme_option( 'sidebar-right' );
		$is_themepile_cover_left      = ThemePileTheme::get_theme_option( 'cover-left' );
		$is_themepile_post_two_column = ThemePileTheme::get_theme_option( 'post-two-column' );
		$is_themepile_sidebar_none = ThemePileTheme::get_theme_option( 'sidebar-none' );

		if ( $is_themepile_sidebar_right == '1' ) add_filter( 'body_class', 'themepile_filter_add_sidebar_right_class' );
		if ( $is_themepile_cover_left == '1' ) add_filter( 'body_class', 'themepile_filter_add_cover_left_class' );
		if ( $is_themepile_post_two_column == '1' ) add_filter( 'body_class', 'themepile_filter_add_two_columns_for_single_content' );
		if ( $is_themepile_sidebar_none == '1' ) add_filter( 'body_class', 'themepile_filter_add_sidebar_none_class' );
	}
	add_action( 'after_setup_theme', 'themepile_theme_setup' );
endif;
if ( ! function_exists( 'themepile_scripts_styles' ) ) :
	/**
	 * Enqueues scripts and styles for front end.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_scripts_styles() {

		// Adds JavaScript to pages with the comment form to support sites with
		// threaded comments (when in use).
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_register_style( 'scriptor-style', get_template_directory_uri() . '/style.css', array(), false );
		wp_register_style( 'scriptor-responsive', get_template_directory_uri() . '/css/responsive.css', array(), false );

		wp_enqueue_style( 'scriptor-style' );

		if ( ThemePileTheme::get_theme_option( 'responsive', true ) != 1 ) {
			wp_enqueue_style( 'scriptor-responsive' );
		}

		wp_register_script( 'maps.googleapis', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), false, true );
		wp_register_script( 'jquery.masonry', get_template_directory_uri() . '/js/jquery/plugins/jquery.masonry.min.js', array(), false, true );
		wp_register_script( 'jquery.validate', get_template_directory_uri() . '/js/jquery/plugins/jquery.validate.min.js', array(), false, true );
		wp_register_script( 'jquery.easing', get_template_directory_uri() . '/js/jquery/plugins/jquery.easing.js', array(), false, true );
		wp_register_script( 'app', get_template_directory_uri() . '/js/app.js', array(), false, true );

		if ( is_page_template( 'template-contact.php' ) ) {
			wp_enqueue_script( 'maps.googleapis' );
		}

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery.easing' );
		wp_enqueue_script( 'jquery.masonry' );
		wp_enqueue_script( 'jquery.validate' );
		wp_enqueue_script( 'wp-mediaelement' );
		wp_enqueue_script( 'app' );

	}
	add_action( 'wp_enqueue_scripts', 'themepile_scripts_styles' );
endif;
if ( ! function_exists( 'themepile_widgets_init' ) ) :
	/**
	 * Registers three widget areas.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_widgets_init() {
		register_sidebar(
			array(
				'name'          => __( 'Blog', THEMEPILE_LANGUAGE ),
				'id'            => 'blog',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => "</aside>\n",
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => "</h3>\n",
			)
		);
	}
	add_action( 'widgets_init', 'themepile_widgets_init' );
endif;
if ( ! function_exists( 'themepile_get_wp_title' ) ) :
	/**
	 * Creates a nicely formatted and more specific title element text for output
	 * in head of document, based on current view.
	 *
	 * @since Scriptor
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep   Optional separator.
	 *
	 * @return string The filtered title.
	 */
	function themepile_get_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ) {
			return $title;
		}

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ) {
			$title = "$title $sep " . sprintf(
				__( 'Page %s', THEMEPILE_LANGUAGE ),
				max( $paged, $page )
			);
		}

		return $title;
	}
	add_filter( 'wp_title', 'themepile_get_wp_title', 10, 2 );
endif;
if ( ! function_exists( 'themepile_get_logo' ) ) :
	/**
	 * Get Uploaded logo
	 *
	 * @since Scriptor
	 *
	 * @return string The filtered title.
	 */
	function themepile_get_logo() {
		$image_upload_logo = ThemePileTheme::get_theme_option( 'custom_logo' );
		$get_logo_image    = null;
		if ( ! empty( $image_upload_logo ) ) {
			$get_logo_image = $image_upload_logo;
		}
		return $get_logo_image;
	}
endif;
if ( ! function_exists( 'themepile_get_cover_image' ) ) :
	/**
	 * Get Cover Image
	 *
	 * @since Scriptor
	 *
	 * @return string A link of image.
	 */
	function themepile_get_cover_image() {
		$cover_image     = ThemePileTheme::get_theme_option( 'cover_image' );
		$get_cover_image = null;
		if ( ! empty( $cover_image ) ) {
			$get_cover_image = $cover_image;
		}
		return $get_cover_image;
	}
endif;
if ( ! function_exists( 'themepile_get_error_image' ) ) :
	/**
	 * Get Error Image
	 *
	 * @since Scriptor
	 *
	 * @return string A link of image.
	 */
	function themepile_get_error_image() {
		$error_image     = ThemePileTheme::get_theme_option( 'error_image' );
		$get_error_image = null;
		if ( ! empty( $error_image ) ) {
			$get_error_image = $error_image;
		}
		return $get_error_image;
	}
endif;
if ( ! function_exists( 'themepile_filter_add_sidebar_right_class' ) ) :
	/**
	 * Add Class for Sidebar
	 *
	 * @since Scriptor
	 *
	 * @return string A body class.
	 */
	function themepile_filter_add_sidebar_right_class( $classes ) {
		$classes[] = 'scriptor--sidebar--right';
		return $classes;
	}
endif;

if ( ! function_exists( 'themepile_filter_add_sidebar_none_class' ) ) :
	/**
	 * Add Class for hide Sidebar
	 *
	 * @since Scriptor
	 *
	 * @return string A body class.
	 */
	function themepile_filter_add_sidebar_none_class( $classes ) {
		$classes[] = 'scriptor--sidebar--hidden';
		return $classes;
	}
endif;



if ( ! function_exists( 'themepile_filter_add_cover_left_class' ) ) :
	/**
	 * Add Class for Cover
	 *
	 * @since Scriptor
	 *
	 * @return string A body class.
	 */
	function themepile_filter_add_cover_left_class( $classes ) {
		$classes[] = 'scriptor--cover--left';
		return $classes;
	}
endif;
if ( ! function_exists( 'themepile_filter_add_two_columns_for_single_content' ) ) :
	/**
	 * Add Class for Post content
	 *
	 * @since Scriptor
	 *
	 * @return string A body class.
	 */
	function themepile_filter_add_two_columns_for_single_content( $classes ) {
		$classes[] = 'scriptor--single-content--two-columns';
		return $classes;
	}
endif;
if ( ! function_exists( 'themepile_the_attached_image' ) ) :
	/**
	 * Print the attached image with a link to the next attached image.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_the_attached_image() {
		/**
		 * Filter the image attachment size to use.
		 *
		 * @since Scriptor
		 *
		 * @param array $size {
		 *
		 * @type int The attachment height in pixels.
		 * @type int The attachment width in pixels.
		 * }
		 */
		$next_attachment_url = wp_get_attachment_url();
		$post                = get_post();

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => - 1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}

		printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url( $next_attachment_url ),
			the_title_attribute( array( 'echo' => false ) ),
			wp_get_attachment_image( $post->ID, 'full' )
		);
	}
endif;

if ( ! function_exists( 'themepile_pagination' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_pagination() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );



		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'total'    => $GLOBALS['wp_query']->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'twentyfourteen' ),
			'next_text' => __( 'Next &rarr;', 'twentyfourteen' ),
		) );

		if ( $links ) :

			?>
			<nav class="navigation paging-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentyfourteen' ); ?></h1>
				<div class="pagination loop-pagination">
					<?php echo $links; ?>
				</div><!-- .pagination -->
			</nav><!-- .navigation -->
		<?php
		endif;
	}
endif;
if ( ! function_exists( 'themepile_paging_nav' ) ) :
	/**
	 * Displays navigation to next/previous set of posts when applicable.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_paging_nav() {
		global $wp_query;
		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 )
			return;
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Posts navigation', THEMEPILE_LANGUAGE ); ?></h1>

			<div class="nav-links">

				<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', THEMEPILE_LANGUAGE ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', THEMEPILE_LANGUAGE ) ); ?></div>
				<?php endif; ?>

			</div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
endif;
if ( ! function_exists( 'themepile_post_nav' ) ) :
	/**
	 * Displays navigation to next/previous post when applicable.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_post_nav() {
		global $post;

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', THEMEPILE_LANGUAGE ); ?></h1>

			<div class="nav-links">

				<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', THEMEPILE_LANGUAGE ) ); ?>
				<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', THEMEPILE_LANGUAGE ) ); ?>

			</div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
endif;
if ( ! function_exists( 'themepile_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own themepile_entry_meta() to override in a child theme.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_entry_meta() {

		// Post author
		if ( 'post' == get_post_type() ) {
			printf(
				'<span class="entry-meta-item author vcard">
					<!--<span class="author-avatar">%4$s</span>-->
					<em class="entry-meta-item-label">%1$s</em>
					<a class="url fn n" href="%2$s" title="%3$s" rel="author">
						<span class="author-title">%5$s</span>
					</a>
				</span>',
				esc_attr( ( __( 'by', THEMEPILE_LANGUAGE ) ) ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', THEMEPILE_LANGUAGE ), get_the_author() ) ),
				get_avatar( get_the_author_meta( 'ID' ), 64 ),
				get_the_author()
			);
		}

		if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
			themepile_entry_date();

		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', THEMEPILE_LANGUAGE ) );
		if ( $categories_list ) {
			echo
				'<span class="entry-meta-item categories-links">' .
				'<em class="entry-meta-item-label">' . __( 'in' ) . '</em> ' .
				'<span class="categories-links-list">' . $categories_list . '</span>
				</span>';
		}


		edit_post_link( __( 'Edit Post', THEMEPILE_LANGUAGE ), '<span class="entry-meta-item edit-link"><em class="entry-meta-item-label"><span class="scriptor-icon--gears-setting"></span></em> ', '</span>' );


	}
endif;
if ( ! function_exists( 'themepile_entry_share' ) ) :
	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own themepile_entry_meta() to override in a child theme.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_entry_share() {
		?>

		<div class="entry-actions-share">
			<a class="entry-actions-share-link"
			   title="<?php _e( 'Share this post on Twitter', THEMEPILE_LANGUAGE ) ?>"
			   data-action="share-on-twitter"
			   data-action-value="<?php echo the_permalink(); ?>"
			   href="http://twitter.com/share?text=<?php echo wp_title( '/', false, 'right' ); ?>&amp;url=<?php echo the_permalink(); ?>">
				<span class="scriptor-icon--twitter">
					<span class="screen-reader-text"><?php _e( 'Twitter', THEMEPILE_LANGUAGE ) ?></span>
				</span>
			</a>
			<a class="entry-actions-share-link"
			   title="<?php _e( 'Share this post on Facebook', THEMEPILE_LANGUAGE ) ?>"
			   data-action="share-on-facebook"
			   data-action-value="<?php echo the_permalink(); ?>"
			   href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php echo wp_title( '/', false, 'right' ); ?>">
				<span class="scriptor-icon--facebook">
					<span class="screen-reader-text"><?php _e( 'Facebook', THEMEPILE_LANGUAGE ) ?></span>
				</span>
			</a>
			<a class="entry-actions-share-link"
			   title="<?php _e( 'Share this post on Google+', THEMEPILE_LANGUAGE ) ?>"
			   data-action="share-on-google"
			   data-action-value="<?php echo the_permalink(); ?>"
			   href="https://plus.google.com/share?url=<?php echo the_permalink(); ?>">
				<span class="scriptor-icon--google">
					<span class="screen-reader-text"><?php _e( 'Google+', THEMEPILE_LANGUAGE ) ?></span>
				</span>
			</a>
		</div>
	<?php
	}
endif;
if ( ! function_exists( 'themepile_entry_tags' ) ) :
	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own themepile_entry_meta() to override in a child theme.
	 *
	 * @since Scriptor
	 *
	 * @return void
	 */
	function themepile_entry_tags() {
		$tag_list = get_the_tag_list( '', __( ', ', THEMEPILE_LANGUAGE ) );
		if ( $tag_list ) {
			echo
				'<div class="entry-tags">' .
				'<span class="entry-meta-item tags-links">' .
				'<em class="entry-meta-item-label">' . __( 'Tags:' ) . '</em> ' .
				'<span class="tags-links__list">' . $tag_list . '</span>' .
				'</span>' .
				'</div>';
		}
	}
endif;
if ( ! function_exists( 'themepile_entry_date' ) ) :
	/**
	 * Prints HTML with date information for current post.
	 *
	 * Create your own themepile_entry_date() to override in a child theme.
	 *
	 * @since Scriptor
	 *
	 * @param boolean $echo Whether to echo the date. Default true.
	 *
	 * @return string The HTML-formatted post date.
	 */
	function themepile_entry_date( $echo = true ) {
		if ( has_post_format( array( 'chat', 'status' ) ) )
			$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', THEMEPILE_LANGUAGE );
		else
			$format_prefix = '%2$s';

		$date = sprintf(
			'<span class="entry-meta-item date">
				<em class="entry-meta-item-label">%1$s</em>
				<a href="%2$s" title="%3$s" rel="bookmark">
					<time class="entry-date" datetime="%4$s">%5$s</time>
				</a>
			</span>',
			esc_attr( ( __( 'on', THEMEPILE_LANGUAGE ) ) ),
			esc_url( get_permalink() ),
			esc_attr( sprintf( __( 'Permalink to %s', THEMEPILE_LANGUAGE ), the_title_attribute( 'echo=0' ) ) ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

		if ( $echo )
			echo $date;

		return $date;
	}
endif;
if ( ! function_exists( 'themepile_get_link_url' ) ) :
	/**
	 * Returns the URL from the post.
	 *
	 * @uses  get_url_in_content() to get the URL in the post meta (if it exists) or
	 *        the first link found in the post content.
	 *
	 * Falls back to the post permalink if no URL is found in the post.
	 *
	 * @since Scriptor
	 *
	 * @return string The Link format URL.
	 */
	function themepile_get_link_url() {
		$content = get_the_content();
		$has_url = get_url_in_content( $content );
		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
endif;
if ( ! function_exists( 'themepile_gallery_shortcode' ) ) :
	/**
	 * Override WordPress Gallery Shortcode
	 *
	 * @since Scriptor
	 *
	 * @return string Gallery Content
	 */
	function themepile_gallery_shortcode( $attr ) {
		$post = get_post();

		static $instance = 0;
		$instance ++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}

		// Allow plugins/themes to override the default gallery template.
		$output = apply_filters( 'post_gallery', '', $attr );
		if ( $output != '' )
			return $output;

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] )
				unset( $attr['orderby'] );
		}

		extract( shortcode_atts( array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => ''
		), $attr, 'gallery' ) );

		$id = intval( $id );
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( ! empty( $include ) ) {
			$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		}
		elseif ( ! empty( $exclude ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
		}
		else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
		}

		if ( empty( $attachments ) )
			return '';

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			}
			return $output;
		}

		$itemtag    = tag_escape( $itemtag );
		$captiontag = tag_escape( $captiontag );
		$icontag    = tag_escape( $icontag );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[$itemtag] ) )
			$itemtag = 'dl';
		if ( ! isset( $valid_tags[$captiontag] ) )
			$captiontag = 'dd';
		if ( ! isset( $valid_tags[$icontag] ) )
			$icontag = 'dt';

		$columns       = intval( $columns );
		$selector      = "gallery-{$instance}";
		$gallery_style = $gallery_div = '';
		$size_class    = sanitize_html_class( $size );
		$gallery_div   = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
		$output        = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
		$i             = 0;
		foreach ( $attachments as $id => $attachment ) {
			if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
				$image_output = wp_get_attachment_link( $id, $size, false, false );
			elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
				$image_output = wp_get_attachment_image( $id, $size, false );
			else
				$image_output = wp_get_attachment_link( $id, $size, true, false );

			$image_meta = wp_get_attachment_metadata( $id );

			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) )
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
				<{$icontag} class='gallery-icon {$orientation}'>
					$image_output
				</{$icontag}>";
			if ( $captiontag && trim( $attachment->post_excerpt ) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption'>
					" . wptexturize( $attachment->post_excerpt ) . "
					</{$captiontag}>";
			}
			$output .= "</{$itemtag}>";
		}
		$output .= "</div>";
		return $output;
	}

	remove_shortcode( 'gallery', 'gallery_shortcode' );
	add_shortcode( 'gallery', 'themepile_gallery_shortcode' );
endif;


function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function add_custom_meta_boxes() {
	$meta_box = array(
		'id'         => 'themepile_post_settings', // Meta box ID
		'title'      => __('ThemePIle Post Settings', THEMEPILE_LANGUAGE), // Meta box title
		'pages'      => array('post'), // Post types this meta box should be shown on
		'context'    => 'side', // Meta box context
		'priority'   => 'high', // Meta box priority
		'fields' => array(
			array(
				'id' => 'themepile-post-grid-size',
				'name' =>  __('Choose Post Size', THEMEPILE_LANGUAGE),
				'type' => 'select',
				'std' => 'themepile_post_grid_size_x1',
				'choices' => array(
					'themepile-post-grid-size-x1' => __('One Column', THEMEPILE_LANGUAGE),
					'themepile-post-grid-size-x2' => __('Two Column', THEMEPILE_LANGUAGE),
					'themepile-post-grid-size-x3' => __('Three Column', THEMEPILE_LANGUAGE)
				)
			)
		)
	);
	themepile_add_meta_box( $meta_box );
}
add_action( 'themepile_meta_boxes', 'add_custom_meta_boxes' );