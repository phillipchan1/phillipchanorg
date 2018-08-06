<?php
/**
 * The Main Sidebar
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

<div id="sidebar-widgets" class="widget-area clearfix" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	
	<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
		
		<aside id="search" class="widget widget_search">
			<h1 class="widget-title"><?php _e( 'Search', 'hyphatheme' ); ?></h1>
			<?php get_search_form(); ?>
		</aside>
		
		<aside id="archives" class="widget">
			<h1 class="widget-title"><?php _e( 'Archives', 'hyphatheme' ); ?></h1>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside>

		<aside id="meta" class="widget">
			<h1 class="widget-title"><?php _e( 'Meta', 'hyphatheme' ); ?></h1>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>
		
	<?php endif; ?>
	
</div><!-- #sidebar-widgets -->