<?php
/**
 * The sidebar containing the secondary widget area, displays on posts and pages.
 *
 * If no active widgets in this sidebar, it will be hidden completely.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */

if ( is_active_sidebar( 'blog' ) ) : ?>
	<div class="sidebar sidebar--blog" role="complementary">
		<?php dynamic_sidebar( 'blog' ); ?>
	</div><!-- .widget-area -->
<?php endif; ?>