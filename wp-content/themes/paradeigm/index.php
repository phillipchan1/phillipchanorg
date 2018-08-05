<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			
			<?php get_template_part( 'includes/partials/featured-content' ); ?>
			<?php get_template_part( 'includes/partials/necktie' ); ?>
			
			<div id="primary" class="content-area clearfix">
				<div id="content" class="site-content clearfix" role="main">
					
					<div id="main-content" class="site-content-inside clearfix">
						
						<?php get_sidebar(); ?>
						
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
							
								/*
								 * Include the post format-specific template for the content. If you want to
								 * use this in a child theme, then include a file called called content-___.php
								 * (where ___ is the post format) and that will be used instead.
								 */
								get_template_part( 'content', get_post_format() );
							
							endwhile;
						else :
						
							/*
							 * If no posts are found in the loop, include the "No Posts Found" template.
							 */
							get_template_part( 'content', 'none' );
							
						endif;
						?>
						
					</div><!-- #main-content -->
					
					<?php hypha_get_pagination( 'site-pagination' ); ?>
					
				</div><!-- #content -->
				
				
				
			</div><!-- #primary -->		
		</div><!-- #main -->

<?php get_footer(); ?>