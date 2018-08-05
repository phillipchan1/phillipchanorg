<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
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
									
						<?php if ( comments_open() || get_comments_number() ) { ?>
							<div class="main-content-inside clearfix">
								<div id="post-tabs" class="clearfix">
									<ul class="post-tab-nav">
										<li><a href="#tab-1"><i class="fa fa-comment"></i> <span><?php comments_number( __( 'Comments', 'hyphatheme' ), __( 'Comments (1)', 'hyphatheme' ), __( 'Comments (%)', 'hyphatheme') );?></span></a></li>
									</ul><!-- .post-tab-nav -->
								
									<div id="tab-1" class="comments-section post-tab clearfix">
										<?php comments_template(); ?>
									</div><!-- comments-section -->

								</div><!-- #post-tabs -->
							</div><!-- .main-content-inside -->
						<?php } ?>
						
					</div><!-- #main-content -->				
				</div><!-- #content -->				
			</div><!-- #primary -->
		</div><!-- #main -->

<?php get_footer(); ?>