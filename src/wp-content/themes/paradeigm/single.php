<?php
/**
 * The template for displaying all single posts.
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
						
							/*
							 * Include the post format-specific template for the content. If you want to
							 * use this in a child theme, then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
	
						endwhile;
						?>
					
						<div class="main-content-inside clearfix">
							
							<div id="post-tabs" class="clearfix">
								<ul class="post-tab-nav">
									<?php if ( comments_open() || get_comments_number() ) { ?>
										<li><a href="#tab-1"><i class="fa fa-comment"></i> <span><?php comments_number( __( 'Comments', 'hyphatheme' ), __( 'Comments (1)', 'hyphatheme' ), __( 'Comments (%)', 'hyphatheme') );?></span></a></li>
								<?php } ?>
									<li><a href="#tab-2"><i class="fa fa-user"></i> <span><?php _e( 'Author', 'hyphatheme' ); ?></span></a></li>
									<li><a href="#tab-3"><i class="fa fa-list-ul"></i> <span><?php _e( 'Details', 'hyphatheme' ); ?></span></a></li>
								</ul><!-- .post-tab-nav -->
								
								<?php if ( comments_open() || get_comments_number() ) { ?>
									<div id="tab-1" class="comments-section post-tab clearfix">
										<?php comments_template(); ?>
									</div><!-- comments-section -->
								<?php } ?>

								<div id="tab-2" class="author-section post-tab clearfix">
									<?php get_template_part( 'includes/partials/author-card' ); ?>
								</div><!-- author-section -->
								
								<div id="tab-3" class="meta-section post-tab clearfix">
									<div id="meta-info">
										<ul class="meta-list">
											<li class="author"><?php the_author_posts_link(); ?></li>
											<li class="time"><?php echo hypha_get_time_stamp(); ?></li>
											<li class="category"><?php the_category(', '); ?></li>
											<?php if( has_tag() ) { ?>
												<li class="tag"><?php the_tags('', ', ', ''); ?></li>
											<?php  } ?>
										</ul>
									</div><!-- #meta-info -->
								</div><!-- meta-section-->
							</div><!-- #post-tabs -->
							
						</div><!-- .main-content-inside -->
					
					</div><!-- #main-content -->
					
					<?php hypha_get_pagination( 'entry-pagination' ); // Show Pagination  ?>
					
				</div><!-- #content  -->
			</div><!-- #primary -->
			
			<?php echo hypha_get_related_posts( 'category', __( 'You Might Also Like', 'hyphatheme' ) ); ?>
			
		</div><!-- #main -->

<?php get_footer(); ?>