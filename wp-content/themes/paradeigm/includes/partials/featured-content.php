<?php
/**
 * Display Featured Content
 *
 * Select parameters in the Theme Customizer
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

<?php if ( is_home() && !is_paged() ) { ?>

	<div class="featured-content">
		<div class="featured-content-inside">
		
			<div class="featured-content-slider flexslider">
				<ul class="featured-content-list slides">
						
					<?php
					$args = array(
						'posts_per_page' => get_option( 'hypha_customizer_featured_content_items' ),
						'meta_key' => '_thumbnail_id', // only if have thumbnail
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array(
									'post-format-aside',
									'post-format-audio',
									//'post-format-gallery',
									'post-format-image',
									'post-format-link',
									'post-format-quote',
									'post-format-video'
									),
								'operator' => 'NOT IN'
								)
						)
					);
						
					// Select either Sticky Posts or Categories
					if ( get_theme_mod('hypha_customizer_category_select') == 'sticky' ) {
						$args['post__in'] = get_option( 'sticky_posts' );
					} else {
						$args['category'] = get_theme_mod('hypha_customizer_category_select');
					}
						
					$featured_list_posts = get_posts($args);
						
					$count_posts = count( $featured_list_posts );
					$slide_nav = ( $count_posts > 3 ) ? 'show-nav' : 'hide-nav';
	
					// Display Featured Posts if found
					if ( $featured_list_posts && $count_posts > 2 ) :
						foreach ( $featured_list_posts as $post ) {
							setup_postdata( $post );
							printf(
								'<li id="post-%1$s"><figure class="featured-item">
									<a class="featured-image" href="%2$s" title="%3$s" rel="bookmark">
										<div class="featured-info">
											<div class="info-wrapper">
												<div class="time-stamp h5"><span>%4$s</span><span class="sep"></span><span class="time-read">%5$s</span></div>
												<h2 class="h4">%6$s</h2>
											</div>
										</div>
									%7$s
									</a>
								</figure></li>',
								get_the_ID(),
								get_the_permalink(),
								esc_attr( sprintf( __( 'Permalink to %s', 'hyphatheme' ), the_title_attribute( 'echo=0' ) ) ),
								hypha_get_time_stamp(),
								hypha_get_read_time(),
								get_the_title(),
								get_the_post_thumbnail( get_the_ID(), 'square-thumb' )
							);
						}
						wp_reset_postdata();
					endif;
					?>
					
				</ul><!-- .featured-content-list -->
			</div><!-- .featured-content-slider -->
		
		</div><!-- .featured-content-inside -->
	</div><!-- .featured-content -->

<?php } ?>