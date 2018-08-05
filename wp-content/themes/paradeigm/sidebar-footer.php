<?php
/**
 * The Footer Sidebar
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

<div id="footer-widgets" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar_footer' ); ?>
	<?php dynamic_sidebar( 'sidebar-footer' ); ?>
</div><!-- #footer-widgets -->