<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Olivia
 */

// Get the sidebar widgets
?>

<div id="sidebar" class="widget-area">
		<?php do_action( 'at_olivia_above_sidebar' );

		dynamic_sidebar( 'drawer-widget' );

		do_action( 'at_olivia_below_sidebar' ); ?>
	</div><!-- #secondary .widget-area -->