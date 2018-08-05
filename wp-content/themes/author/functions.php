<?php

//-----------------------------------  // Load Scripts //-----------------------------------//

add_action('init', 'ok_theme_js');
function ok_theme_js() {
	if (is_admin()) return;
	
	//Register jQuery
	wp_enqueue_script('jquery');
	
	//Custom JS
	wp_enqueue_script('custom_js', get_template_directory_uri() . '/includes/js/custom/custom.js', false, false , true);
	
	//Mobile Menu
	wp_enqueue_script('mobile_js', get_template_directory_uri() . '/includes/js/menu/jquery.mobilemenu.js', false, false , false);
	
	//Fancybox Easing
	wp_enqueue_script('fancybox_js', get_template_directory_uri() . '/includes/js/fancybox/jquery.fancybox-1.3.4.pack.js', false, false);
	
	//FlexSlider
	wp_enqueue_script('flex_js', get_template_directory_uri() . '/includes/js/flex/jquery.flexslider.js', false, false);
	
	//FidVid
	wp_enqueue_script('fitvid_js', get_template_directory_uri() . '/includes/js/fitvid/jquery.fitvids.js', false, false);
	
	//Twitter
	wp_enqueue_script('twitter', 'http://widgets.twimg.com/j/2/widget.js', false, false);
	
}

//Add Fancybox CSS
wp_enqueue_style( 'fancybox_css', get_template_directory_uri() . "/includes/js/fancybox/jquery.fancybox-1.3.4.css", array(), '0.1', 'screen' );
wp_enqueue_style( 'flex_css', get_template_directory_uri() . "/includes/js/flex/flexslider.css", array(), '0.1', 'screen' );


//-----------------------------------  // Add Localization //-----------------------------------//

load_theme_textdomain( 'okay', get_template_directory() . '/includes/languages' );
		
		
//-----------------------------------  // Popular Posts Widget //-----------------------------------//

$popular_posts = $wpdb->get_results("SELECT id,post_title FROM {$wpdb->prefix}posts ORDER BY comment_count DESC LIMIT 0,5");
foreach($popular_posts as $post) {
	// Do something with the $post variable
}		


//-----------------------------------  // Editor Styles and Shortcodes //-----------------------------------//

require_once(dirname(__FILE__) . "/includes/editor/add-styles.php");


//-----------------------------------  // Auto Feed Links //-----------------------------------//

add_theme_support( 'automatic-feed-links' );


//-----------------------------------  // Load Widgets //-----------------------------------//

require_once(dirname(__FILE__) . "/includes/widgets/twitter.php");
require_once(dirname(__FILE__) . "/includes/widgets/dribbble.php");
require_once(dirname(__FILE__) . "/includes/widgets/social.php");
require_once(dirname(__FILE__) . "/includes/widgets/recent-widgets.php");


//-----------------------------------  // Custom Excerpt //-----------------------------------//

function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}


//-----------------------------------  // Add Lightbox to Attachments //-----------------------------------//

add_filter( 'wp_get_attachment_link', 'gallery_lightbox');
		
function gallery_lightbox ($content) {
	$galleryid = get_the_ID();
	$perma = get_attachment_link($attachment_id);
	
	// adds a lightbox to single page elements
	if(is_single() || is_page()) {
	 
	return str_replace("<a", "<a class='lightbox' rel='gallery-$galleryid' " , $content);
	
	} else {
	
	return str_replace("<a", "<a href='$perma' " , $content);
	
	}
}


//-----------------------------------  // Add Menus //-----------------------------------//

add_theme_support( 'menus' );
register_nav_menu('main', 'Main Menu');
register_nav_menu('secondary', 'Secondary Menu');
register_nav_menu('footer', 'Footer Menu');
register_nav_menu('custom', 'Custom Menu');


//-----------------------------------  // Thumbnail Sizes //-----------------------------------//

add_theme_support('post-thumbnails');
set_post_thumbnail_size( 150, 150, true ); // Default Thumb
add_image_size( 'large-image', 930, 9999, false ); // Large Post Image
add_image_size( 'small-image', 210, 9999, false ); // Large Post Image

if ( ! isset( $content_width ) ) $content_width = 690;


//-----------------------------------  // Custom Comments //-----------------------------------//

function okay_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">
		
		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
			<div class="comment-info">
				
				
				<div class="comment-author vcard clearfix">
					<?php echo get_avatar( $comment->comment_author_email, 35 ); ?>
					
					<div class="comment-meta commentmetadata">
						<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
						<div style="clear:both;"></div>
						<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?>
					</div>
				</div>
			<div style="clear:both;"></div>
			</div>
			
			<div class="comment-text">
				<?php comment_text() ?>
				<p class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</p>
			</div>
		
			<?php if ($comment->comment_approved == '0') : ?>
			<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
			<?php endif; ?>    
		</div>
		 
<?php
}

function custom_comment_reply($content) {
	$content = str_replace('Reply', '+  Reply', $content);
	return $content;
}
add_filter('comment_reply_link', 'custom_comment_reply');


//-----------------------------------  // Register Widget Areas //-----------------------------------//

if ( function_exists('register_sidebars') )

register_sidebar(array(
'name' => 'Sidebar',
'description' => 'Widgets in this area will be shown on the sidebar of all pages.',
'before_widget' => '<div class="widget">',
'after_widget' => '</div>'
));


//-----------------------------------  // Check for Options Framework - Only wizards beyond this point! //-----------------------------------//

okay_options_check();

function okay_options_check()
{
  if ( !function_exists('optionsframework_activation_hook') )
  {
    add_thickbox(); // Required for the plugin install dialog.
    add_action('admin_notices', 'okay_options_check_notice');
  }
}

// The Admin Notice
function okay_options_check_notice()
{
?>
  <div class='updated fade'>
    <p>The Options Framework plugin is required for this theme to function properly. <a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&plugin=options-framework&TB_iframe=true&width=640&height=589'); ?>" class="thickbox onclick">Install now</a>.</p>
  </div>
<?php
}

/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */

if ( !function_exists( 'of_get_option' ) ) {
function of_get_option($name, $default = false) {
	
	$optionsframework_settings = get_option('optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
	}
}
}


/*
* This is an example of how to override a default filter
* for 'textarea' sanitization and $allowedposttags + embed and script.
*/

add_action('admin_init','optionscheck_change_santiziation', 100);
function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'custom_sanitize_textarea' );
}
function custom_sanitize_textarea($input) {
    global $allowedposttags;
    $custom_allowedtags["embed"] = array(
      "src" => array(),
      "type" => array(),
      "allowfullscreen" => array(),
      "allowscriptaccess" => array(),
      "height" => array(),
          "width" => array()
      );
      $custom_allowedtags["script"] = array();
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}


//-----------------------------------  // Add Support Tab To Theme Options //-----------------------------------//

require_once(dirname(__FILE__) . "/includes/support/support.php");
