<?php
/**
 *  Load a template part into a template
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

get_template_part( 'content', get_post_format() ); ?>