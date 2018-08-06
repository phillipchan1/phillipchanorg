<?php
/**
 * Modules
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// autoload all exist modules
foreach ( glob( THEMEPILE_FRAMEWORK_MODULE_PATH . "{/*/*.module.php}", GLOB_BRACE ) as $inc ) {
	if ( apply_filters( 'themepile_include_module', true, basename( $inc ) ) ) {
		require_once( $inc );
	}
}