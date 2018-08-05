<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary" class="content-area clearfix">
				<div id="content" class="site-content clearfix" role="main">
					<div id="main-content" class="site-content-inside clearfix">
						
						<?php get_template_part( 'content', 'none' ); ?>
						
					</div><!-- #main-content -->
				</div><!-- #content -->
			</div><!-- #primary -->
		</div><!-- #main -->

<?php get_footer(); ?>