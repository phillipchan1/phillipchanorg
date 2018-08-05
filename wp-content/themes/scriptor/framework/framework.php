<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 * Framework Constants
 */

if ( ! defined( 'THEMEPILE_LANGUAGE' ) ) {
	define( 'THEMEPILE_LANGUAGE', 'themepile' );
}

define( 'THEMEPILE_LOGGING', false ); // write errors into core/log/system.log
define( 'THEMEPILE_DEVELOPER_MODE', false ); // show exception on frontend

define( 'THEMEPILE_FRAMEWORK_VERSION', '1.0.2' );
define( 'THEMEPILE_FRAMEWORK_UPDATE_URL', 'http://updates.themepile.co.uk/framework/' );

define( 'THEMEPILE_FRAMEWORK_PATH', get_template_directory() . '/framework' );
define( 'THEMEPILE_FRAMEWORK_PATH_URI', get_template_directory_uri() . '/framework' );

define( 'THEMEPILE_FRAMEWORK_CORE_PATH', THEMEPILE_FRAMEWORK_PATH . '/core' );
define( 'THEMEPILE_FRAMEWORK_CORE_PATH_URI', THEMEPILE_FRAMEWORK_PATH_URI . '/core' );

define( 'THEMEPILE_FRAMEWORK_MODULE_PATH', THEMEPILE_FRAMEWORK_PATH . '/modules' );
define( 'THEMEPILE_FRAMEWORK_MODULE_PATH_URI', THEMEPILE_FRAMEWORK_PATH_URI . '/modules' );

/*
 * Load Framework Components
 */
foreach ( glob( THEMEPILE_FRAMEWORK_CORE_PATH . "/{*.inc.php,*/*.inc.php}", GLOB_BRACE ) as $inc ) {
	require_once( $inc );
}

/*
 * Load Framework Modules
 */
require_once( THEMEPILE_FRAMEWORK_MODULE_PATH . '/modules.inc.php' );

?>