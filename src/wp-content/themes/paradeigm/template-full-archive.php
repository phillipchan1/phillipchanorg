<?php
/**
 * Template Name: Full Archive
 *
 * The template for displaying archives.
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary" class="content-area clearfix">
				<div id="content" class="site-content clearfix" role="main">
					
					<div id="main-content" class="site-content-inside clearfix">
							
						<?php
						while ( have_posts() ) : the_post();
						
							// Include the page content template
							get_template_part( 'content', 'page' );
					
						endwhile;
						?>
						
						<?php get_search_form(); ?>
						
						<div class="main-content-inside clearfix">
							<div class="archive-content">
								<h4><?php _e( 'Recent Posts', 'hyphatheme' ); ?></h4>
								<ul><?php wp_get_archives( 'type=postbypost&limit=20' ); ?></ul>
							</div><!-- .archive-content -->
							
							<div class="archive-content">
								<h4><?php _e( 'Pages', 'hyphatheme' ); ?></h4>
								<ul><?php wp_list_pages( 'sort_column=menu_order&title_li=' ); ?></ul>
							</div><!-- .archive-content -->
							
							<div class="archive-content">
								<h4><?php _e( 'Categories', 'hyphatheme' ); ?></h4>
								<ul><?php wp_list_categories( 'orderby=name&title_li=' ); ?></ul>
							</div><!-- .archive-content -->
							
							<div class="archive-content">
								<h4><?php _e( 'Contributors', 'hyphatheme' ); ?></h4>
								<ul><?php wp_list_authors( 'show_fullname=1&optioncount=1&orderby=post_count&order=DESC' ); ?></ul>
							</div><!-- .archive-content -->
							
							<div class="archive-content">
								<h4><?php _e( 'Archive By Day', 'hyphatheme' ); ?></h4>
								<ul><?php wp_get_archives( 'type=daily&limit=25' ); ?></ul>
							</div><!-- .archive-content -->
											
							<div class="archive-content">
								<h4><?php _e( 'Archive By Month', 'hyphatheme' ); ?></h4>
								<ul><?php wp_get_archives( 'type=monthly&limit=12' ); ?></ul>
							</div><!-- .archive-content -->
										
							<div class="archive-content">
								<h4><?php _e( 'Archive By Year', 'hyphatheme' ); ?></h4>
								<ul><?php wp_get_archives( 'type=yearly&limit=12' ); ?></ul>
							</div><!-- .archive-content -->	
						</div><!-- .main-content-inside -->
						
					</div><!-- #main-content -->
				
				</div><!-- #content -->						
			</div><!-- #primary -->
		</div><!-- #main -->

<?php get_footer(); ?>