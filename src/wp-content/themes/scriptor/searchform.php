<?php
/**
 * The template for displaying search forms in ThemePile
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
} ?>

<div class="site-search">
	<form class="site-search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="site-search-form-row">
			<input type="search" name="s" placeholder="<?php esc_attr_e( 'Enter Text Here…', THEMEPILE_LANGUAGE ); ?>" autocomplete="off">
			<button type="button" class="modularis-button modularis-button--link" data-action="search-remove-result">
				<span class="scriptor-icon--cross-mark">
					<span class="screen-reader-text"><?php _e( 'Close Results', THEMEPILE_LANGUAGE ); ?></span>
				</span>
			</button>
			<button type="submit" class="modularis-button modularis-button--link" data-action="search-query">
				<span class="scriptor-icon--search">
					<span class="screen-reader-text"><?php _e( 'Search', THEMEPILE_LANGUAGE ); ?></span>
				</span>
			</button>
		</div><!-- .site-search-form-row -->
	</form><!-- .site-search__form -->
</div><!-- .site-search -->