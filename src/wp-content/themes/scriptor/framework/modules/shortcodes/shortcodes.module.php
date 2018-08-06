<?php

class ThemePileShortcodes {

	function __construct() {
		require_once( 'shortcodes.php' );
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
	}

	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return    void
	 */
	function init() {
		if ( ! is_admin() ) {
			wp_enqueue_script( 'underscore');
			wp_enqueue_script(
				'jquery.modularis.alert',
					THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.alert.js',
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script(
				'jquery.modularis.tabs',
					THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.tabs.js',
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script(
				'jquery.modularis.toggle',
					THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.toggle.js',
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script(
				'jquery.modularis.imagepreloader',
				THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.imagepreloader.js',
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script(
				'jquery.modularis.gallery.popup',
				THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.gallery.popup.js',
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script(
				'jquery.modularis.slider',
				THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.slider.js',
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script(
				'jquery.modularis.share',
				THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.share.js',
				array( 'jquery' ),
				false,
				true
			);

		}

		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', array( &$this, 'add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'register_rich_buttons' ) );
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return    void
	 */
	function add_rich_plugins( $plugin_array ) {

		$plugin_array['ThemePileShortcodes'] = THEMEPILE_FRAMEWORK_MODULE_PATH_URI . '/shortcodes/tinymce/plugin.js';
		return $plugin_array;
	}

	// --------------------------------------------------------------------------

	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return    void
	 */
	function register_rich_buttons( $buttons ) {
		array_push( $buttons, "|", 'themepile_button' );
		return $buttons;
	}

	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return    void
	 */
	function admin_init() {
		// css
		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script(
			'jquery-livequery',
				THEMEPILE_FRAMEWORK_MODULE_PATH_URI . '/shortcodes/tinymce/js/jquery.livequery.js',
			false,
			'1.1.1',
			false
		);
		wp_enqueue_script(
			'jquery-appendo',
				THEMEPILE_FRAMEWORK_MODULE_PATH_URI . '/shortcodes/tinymce/js/jquery.appendo.js',
			false,
			'1.0',
			false
		);
		wp_enqueue_script(
			'base64',
				THEMEPILE_FRAMEWORK_MODULE_PATH_URI . '/shortcodes/tinymce/js/base64.js',
			false,
			'1.0',
			false
		);
		wp_enqueue_script(
			'themepile-popup',
				THEMEPILE_FRAMEWORK_MODULE_PATH_URI . '/shortcodes/tinymce/js/popup.js',
			false,
			'1.0',
			false
		);

		wp_localize_script(
			'jquery',
			'ThemePileShortcodes',
			array( 'plugin_folder' => THEMEPILE_FRAMEWORK_MODULE_PATH_URI . '/shortcodes' )
		);

	}

}

$themepile_shortcodes = new ThemePileShortcodes();

?>