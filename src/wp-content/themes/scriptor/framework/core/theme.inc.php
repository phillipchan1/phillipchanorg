<?php
/**
 * ThemePile Theme
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 *
 */
if ( class_exists( 'ThemePile_Core_Abstract' ) ) {

	final class ThemePileTheme extends ThemePile_Core_Abstract {

		/**
		 * @var string
		 */
		public static $_option_name = 'themepile_theme_options';

		/**
		 * @var
		 */
		public $_name;

		/**
		 * @var
		 */
		public $_version;


		/**
		 * PHP5 constructor
		 */
		public function __construct() {

			$this->setName( wp_get_theme()->Name );
			$this->setVersion( wp_get_theme()->Version );

			// apply hook before theme init
			do_action( 'themepile_before_init' );

			// RUN
			$this->add_action( 'admin_menu', 'themepile_admin_add_menu_page' );
			$this->add_action( 'admin_head', 'themepile_admin_enqueue_frontend' );
			$this->add_action( 'admin_init', 'themepile_theme_options_save' );
			$this->add_action( 'init', 'theme_init_settings' );
			$this->add_action( 'admin_bar_menu', 'themepile_admin_bar_customize_menu' );
			$this->add_action( 'template_redirect', 'themepile_coming_soon_redirect' );
			$this->add_action( 'wp_head', 'themepile_action_add_meta_framework' );
			$this->add_action( 'wp_head', 'themepile_action_add_meta_theme_name' );
			$this->add_action( 'wp_enqueue_scripts', 'themepile_action_enqueue_frontend' );
			$this->add_filter( 'themepile_filter_option_value', 'themepile_filter_option_value', 10, 2 );
			$this->add_filter( 'themepile_filter_admin_menu_sort', 'themepile_filter_admin_menu_sort' );
			$this->add_filter( 'the_excerpt', 'themepile_filter_highlight_search_results' );
			//$this->add_filter( 'image_size_names_choose', 'themepile_filter_additional_uploader_image_sizes' );
			$this->add_filter( 'body_class', 'themepile_filter_add_responsive_class' );
			$this->add_filter( 'body_class', 'themepile_filter_add_skin_class' );

			remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
			remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed

			// apply hook after theme init
			do_action( 'themepile_after_init' );

			// Redirect if theme has just been activated
			global $pagenow;
			if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == "themes.php" ) {
				wp_safe_redirect( admin_url( 'admin.php?page=themepile_theme_options' ), 302 );
			}
		}

		/**
		 * Init Main Theme Settings, Navigate Menu, Sidebars, etc...
		 */
		public function theme_init_settings() {
			do_action( 'themepile_register_post_types' );
		}

		/**
		 *
		 */
		public function themepile_action_enqueue_frontend() {
			$this->add_action( 'wp_head', 'themepile_add_html5_js' );
			$this->add_action( 'wp_head', 'themepile_add_system_js_vars' );
			$this->add_action( 'wp_head', 'themepile_add_custom_js' );
			$this->add_action( 'wp_head', 'themepile_add_custom_css' );
			$this->add_action( 'wp_head', 'themepile_add_custom_background' );
		}

		public function themepile_add_html5_js() {
			echo '<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' . PHP_EOL;
		}

		public function themepile_add_system_js_vars() {
			echo '<!-- ThemePile System JS Paths -->' . PHP_EOL;
			echo '<script>window.THEMEPILE_AJAX_PATH="' . get_site_url() . '/wp-admin/admin-ajax.php";</script>' . PHP_EOL;
			echo '<script>window.THEMEPILE_THEME_PATH="' . get_template_directory_uri() . '";</script>' . PHP_EOL;
		}

		public function themepile_add_custom_background() {
			$background_url = ThemePileTheme::get_theme_option( 'background_image_url', true );
			if ( ! empty( $background_url ) ) {
				echo '<!-- ThemePile Custom Background CSS -->' . PHP_EOL;
				echo '
                    <style>
                        BODY { background: transparent url(' . ThemePileTheme::get_theme_option(
					'background_image_url',
					true
				) . ') ' .
					ThemePileTheme::get_theme_option( 'background_image_repeat', true ) . ' ' .
					ThemePileTheme::get_theme_option( 'background_image_scroll', true ) . '
                    </style>' . PHP_EOL;
			}
		}

		public function themepile_add_custom_js() {
			$tracking_code = ThemePileTheme::get_theme_option( 'custom_js', true );
			if ( ! empty( $tracking_code ) ) {
				echo '<!-- ThemePile Custom JS -->' . PHP_EOL;
				echo $tracking_code . PHP_EOL;
			}
		}

		public function themepile_add_custom_css() {
			$custom_css = ThemePileTheme::get_theme_option( 'custom_css', true );
			if ( ! empty( $custom_css ) ) {
				echo '<!-- ThemePile Custom CSS -->' . PHP_EOL;
				echo $custom_css . PHP_EOL;
			}
		}

		public function themepile_admin_enqueue_frontend() {

			wp_register_script( 'google.map.js', 'http://maps.google.co.uk/maps/api/js?sensor=false&libraries=geometry', array(), false, true );
			wp_register_script( 'jquery.themepile.wp.uploader.js', THEMEPILE_FRAMEWORK_PATH_URI . '/' . 'assets/js/plugins/jquery.themepile.wp.uploader.js', array( 'jquery' ), '0.1', false );
			wp_register_script( 'jquery.themepile.google.get.location.js', THEMEPILE_FRAMEWORK_PATH_URI . '/' . 'assets/js/plugins/jquery.themepile.google.get.location.js', array( 'jquery' ), '0.1', false );
			wp_register_script( 'themepile.admin.js', THEMEPILE_FRAMEWORK_PATH_URI . '/' . 'assets/js/themepile.admin.js', array( 'jquery' ), '0.1', false );
			wp_register_script( 'themepile.metabox.slider.js', THEMEPILE_FRAMEWORK_PATH_URI . '/' . 'assets/js/metabox/themepile.metabox.slider.js', array( 'jquery' ), '0.1', false );
			wp_register_style( 'themepile.admin.css', THEMEPILE_FRAMEWORK_PATH_URI . '/' . 'assets/css/themepile.admin.css', array(), 'all' );

			wp_enqueue_media(); // wp media library
			wp_enqueue_script( 'underscore' ); // using js-template
			global $pagenow;
			if ( is_admin() ) {
				wp_enqueue_script( 'google.map.js' );
				wp_enqueue_script( 'jquery.themepile.google.get.location.js' );
				wp_enqueue_script( 'jquery.themepile.wp.uploader.js' );
				wp_enqueue_script( 'themepile.admin.js' );
				wp_enqueue_script( 'themepile.metabox.slider.js' );
			}
			wp_enqueue_style( 'themepile.admin.css' );
		}

		/**
		 * Add the Customize link to the admin menu
		 */
		public function themepile_admin_add_menu_page() {
			add_menu_page(
				$this->_name,
				$this->_name,
				'edit_theme_options',
				'themepile_theme_options',
				array( $this, 'themepile_option_page' ),
				THEMEPILE_FRAMEWORK_PATH_URI . '/assets/images/favicon.png'
			);

			add_submenu_page(
				THEMEPILE_LANGUAGE,
				__( 'Theme Options' ),
				__( 'Theme Options' ),
				'edit_theme_options',
				'themepile_theme_options',
				array( $this, 'themepile_option_page' )
			);
		}

		/**
		 * @param string $more
		 *
		 * @return string
		 */
		public function themepile_admin_bar_customize_menu() {
			global $wp_admin_bar;
			$wp_admin_bar->add_menu(
				array(
					'id'     => 'theme-settings',
					'parent' => 'top-secondary',
					'title'  => __( 'Theme Options', THEMEPILE_LANGUAGE ),
					'href'   => admin_url( 'admin.php?page=themepile_theme_options' )
				)
			);
		}

		/**
		 * @param $items
		 *
		 * @return array
		 */
		public function themepile_filter_admin_menu_sort( $items ) {
			$default = apply_filters(
				'default_themepile_filter_admin_menu_sort',
				array(
					'general' => 'general',
					'styling' => 'styling'
				)
			);

			$result = array_merge( $default, $items );
			return $result;
		}


		/**
		 *
		 */
		public function themepile_option_page() {
			if ( function_exists( 'themepile_option_page' ) ) {
				themepile_option_page();
			}
		}

		public function themepile_theme_options_reset() {

			$theme_options                                = get_option( self::$_option_name );
			$theme_options['responsive']                  = '0';
			$theme_options['custom_rss_url']              = '';
			$theme_options['custom_js']                   = esc_attr( '<script></script>' );
			$theme_options['custom_css']                  = esc_attr( '<style></style>' );

			update_option( 'themepile_theme_options', $theme_options );

		}

		/**
		 * Saving Theme options - Customize, Theme settings, Default WP Options
		 */
		public function themepile_theme_options_save() {
			if ( isset( $_POST['reset'] ) ) {
				if ( $_POST['reset'] ) {
					$this->themepile_theme_options_reset();
					return;
				}
			}
			if ( isset( $_POST['action'] ) ) {
				if ( $_POST['action'] === 'themepile_options_save' ) {
					if ( isset( $_POST[self::$_option_name] ) ) {
						$options = $_POST[self::$_option_name];
						$themepile_options = get_option( self::$_option_name );
						foreach ($options as $option_name => $new_option_value) {
							$themepile_options[$option_name] = $new_option_value;
						}
						update_option( self::$_option_name, $themepile_options );
					}
				}
			}
		}

		/**
		 * Get theme option name
		 * @static
		 *
		 * @param bool $option
		 *
		 * @return string
		 */
		public static function get_theme_option( $option = false ) {
			$themepile_options = get_option( self::$_option_name );
			if(isset($themepile_options[$option])) {
				return stripslashes($themepile_options[$option]);
			} else {
				return null;
			}
		}

		/**
		 * Get theme option name
		 * @static
		 *
		 * @param bool $option
		 *
		 * @return string
		 */
		public static function get_theme_option_name( $option = false ) {
			return (string) self::$_option_name . "[" . $option . "]";
		}


		/**
		 * Get theme customize option name
		 *
		 * @static
		 *
		 * @param $option
		 *
		 * @return string
		 */
		public static function get_customize_option_name( $option, $default = false ) {
			if ( $default == true ) {
				return 'default_' . self::$_option_name . '[' . $option . ']';
			}

			return (string) self::$_option_name . "[" . $option . "]";
		}

		public function themepile_filter_option_value( $value, $option ) {
			return stripslashes( $value );
		}

		/**
		 * The Excerpt
		 *
		 * @param string $excerpt
		 *
		 * @return mixed|string|void
		 */
		public function themepile_the_excerpt( $excerpt = '' ) {
			if ( ! (bool) ThemePileTheme::get_theme_option( 'post_content', true ) ) {
				return $excerpt;
			}

			return apply_filters( 'the_content', get_the_content() );
		}

		/**
		 * Highlight search results
		 * @return string
		 */
		public function themepile_filter_highlight_search_results( $text ) {
			if ( is_search() ) {
				$sr   = get_query_var( 's' );
				$keys = explode( " ", $sr );
				$text = preg_replace(
					'/(' . implode( '|', $keys ) . ')/iu',
					'<strong class="search-excerpt">' . $sr . '</strong>',
					$text
				);
			}
			return $text;
		}

		/**
		 * Add additional size for image uploader
		 *
		 * @param $sizes
		 *
		 * @return array
		 */
		public function themepile_filter_additional_uploader_image_sizes( $sizes ) {
			global $_wp_additional_image_sizes;
			foreach ( $_wp_additional_image_sizes as $name => $size ) {
				if ( isset( $sizes[$name] ) ) {
					continue;
				}
				$sizes[$name] = $name;
			}
			return $sizes;
		}

		public function themepile_filter_add_skin_class( $classes ) {
			if ( ThemePileTheme::get_theme_option( 'skin', true ) == 'default' ) {
				$classes[] = 'modularis-skin--default';
			}
			else {
				//$classes[] = 'modularis-skin--' . ThemePileTheme::get_theme_option( 'skin', true );
			}
			return $classes;
		}

		public function themepile_filter_add_responsive_class( $classes ) {

			if ( ThemePileTheme::get_theme_option( 'responsive', true ) != 1 ) {
				$classes[] = 'modularis-responsive--enable';
			}
			return $classes;
		}

		/**
		 * Redirect on coming soon page
		 */
		public function themepile_coming_soon_redirect() {
			$mm = ThemePileTheme::get_theme_option( 'mm', true ); // month
			$jj = ThemePileTheme::get_theme_option( 'jj', true ); // day
			$aa = ThemePileTheme::get_theme_option( 'aa', true ); // year
			$hh = ThemePileTheme::get_theme_option( 'hh', true ); // hours
			$mn = ThemePileTheme::get_theme_option( 'mn', true ); // minutes

			$date = compact( 'mm', 'hh', 'aa', 'jj', 'mn' );
			$date = array_map( create_function( '$d', 'if (empty($d)) {return 1;} return $d;' ), $date );
			extract( $date );
			$end_date             = mktime( $hh, $mn, 0, $mm, $jj, $aa );
			$coming_soon_template = get_template_directory() . '/template-coming-soon.php';
			if ( ( time() < $end_date && file_exists( $coming_soon_template ) ) && ! is_super_admin() ) {
				nocache_headers(); // disable HTTP cache
				include( $coming_soon_template );
				exit;
			}
		}

		public function themepile_action_add_meta_framework() {
			echo '<meta name="generator" content="ThemePile Framework ' . THEMEPILE_FRAMEWORK_VERSION . '" />' . PHP_EOL;
		}

		public function themepile_action_add_meta_theme_name() {
			echo '<meta name="generator" content="' . $this->getName() . ' ' . $this->getVersion() . ' " />' . PHP_EOL;
		}

		public static function themepile_action_add_favicon() {
			if ( self::get_theme_option( 'custom_favicon' ) ) {
				echo self::get_theme_option( 'custom_favicon' );
			}
			else {
				echo THEMEPILE_FRAMEWORK_PATH_URI . 'favicon.png';
			}
		}

		public static function themepile_action_add_rss() {
			if ( self::get_theme_option( 'custom_rss_url', true ) ) {
				echo self::get_theme_option( 'custom_rss_url', true );
			}
			else {
				bloginfo( 'rss2_url' );
			}
		}

		/**
		 * @static
		 * @return mixed|void
		 */
		public static function themepile_get_social_links() {
			// apply Hooking
			return apply_filters(
				'themepile_social_links',
				array(
					'facebook'    => __( 'Facebook', THEMEPILE_LANGUAGE ),
					'linkedin'    => __( 'LinkedIn', THEMEPILE_LANGUAGE ),
					'twitter'     => __( 'Twitter', THEMEPILE_LANGUAGE ),
					'google-plus' => __( 'Google Plus', THEMEPILE_LANGUAGE ),
					'pinterest'   => __( 'Pinterest', THEMEPILE_LANGUAGE )
				)
			);
		}


		/**
		 * @param $name
		 */
		public function setName( $name ) {
			$this->_name = $name;
		}


		/**
		 * @return mixed
		 */
		public function getName( $option = false ) {
			if ( $option ) {
				return strtolower( $this->_name );
			}
			return $this->_name;
		}

		/**
		 * @param $version
		 */
		public function setVersion( $version ) {
			$this->_version = $version;
		}

		/**
		 * @return mixed
		 */
		public function getVersion() {
			return $this->_version;
		}

		/**
		 * @return string
		 */
		public function getThemeModName() {
			return 'theme_mods_' . $this->getName( true );
		}


	}

} // class_exist