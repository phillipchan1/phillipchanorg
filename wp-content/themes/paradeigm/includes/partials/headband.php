<?php
/**
 * Display Headband
 *
 * Shows the post and page titles
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */

if ( is_front_page() && get_theme_mod( 'hypha_customizer_homepage_logo' ) ) { ?>

	<div class="headband">
		<div class="hero-header<?php if ( ! get_theme_mod( 'hypha_customizer_hide_tagline' ) ) { ?> show-description<?php } ?>">
			<h1 class="logo-image">
				<?php
				$hero_logo_url = get_theme_mod( 'hypha_customizer_homepage_retina_logo' ) ? get_theme_mod( 'hypha_customizer_homepage_retina_logo' ) : get_theme_mod( 'hypha_customizer_homepage_logo' );
				$hero_logo_id = hypha_get_attachment_id_from_url( get_theme_mod( 'hypha_customizer_homepage_logo' ) );
				$hero_logo_attributes = wp_get_attachment_image_src( $hero_logo_id, 'full' );
				
				printf( '<img class="hero-site-logo" src="%1$s" width="%2$s" height="%3$s" alt="%4$s" />',
					esc_url( $hero_logo_url ),
					$hero_logo_attributes[1],
					$hero_logo_attributes[2],
					get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' )
				);
				?>
				<?php if ( ! get_theme_mod( 'hypha_customizer_hide_tagline' ) ) { ?>
					<span class="hero-site-description"><?php bloginfo( 'description' ); ?></span>
				<?php } ?>
			</h1>
		</div>
	</div>

<?php } else { ?>

	<div class="headband">
	
		<div class="hero-header">
			<?php
			// Hero Header
			if ( is_category() ) :
				printf( '<span class="hero-span">%s</span>', __( 'Category', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', single_cat_title('', false) );
					
			elseif ( is_tag() ) :
				printf( '<span class="hero-span">%s</span>', __( 'Tag', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', single_tag_title('', false) );
	
			elseif ( is_author() ) :
				/* Queue the first post to know what author we're dealing with.
				 * After printing the information, we need to rewind the loop back to the
				 * beginning, so we can run the full loop properly.
				 */
				the_post();
				printf( '<span class="hero-span">%1$s</span>', __( 'Author', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', get_the_author() );
				rewind_posts();
	
			elseif ( is_day() ) :
				printf( '<span class="hero-span">%1$s</span>', __( 'Day', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', get_the_date() );
	
			elseif ( is_month() ) :
				printf( '<span class="hero-span">%1$s</span>', __( 'Month', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', get_the_date( 'F Y' ) );
	
			elseif ( is_year() ) :
				printf( '<span class="hero-span">%1$s</span>', __( 'Year', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', get_the_date( 'Y' ) );
	
			elseif ( is_404() ) :
				printf( '<span class="hero-span">%1$s</span>', __( '404', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', __( 'Page Not Found', 'hyphatheme' ) );
	
			elseif ( is_search() ) :
				printf( '<span class="hero-span">%1$s</span>', __( 'Search Results', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', get_search_query() );

			elseif ( is_archive() ) :
				printf( '<span class="hero-span">%1$s</span>', __( 'Archive', 'hyphatheme' ) );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', single_cat_title('', false) );

			elseif ( is_single() ) :
				printf( '<span class="hero-span">%1$s</span>', hypha_get_time_stamp() );
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', single_post_title('', false) );
					
			else :
				printf( '<h1 class="hero-title">%s</h1><!-- .hero-title -->', single_post_title('', false) );
	
			endif;
	
	
			// Subtitle Header
			if ( is_single() || is_page() || is_home() && !is_page_template( 'template-homepage.php' ) ) :
				$get_post_id = is_home() ? get_option( 'page_for_posts' ) : $post->ID;
				$page_subtitle = get_post_meta( $get_post_id, 'hypha_page_subtitles_meta', true );
				if ( ! empty( $page_subtitle ) ) { 
					printf( '<h3 class="hero-subtitle"><span>%s</span></h3><!-- .hero-subtitle -->', $page_subtitle );
				};
				
			elseif ( is_category() ) :
				$page_subtitle = category_description();
				if ( ! empty( $page_subtitle ) ) {
					printf( '<h3 class="hero-subtitle"><span>%s</span></h3><!-- .hero-subtitle -->', $page_subtitle );
				};
				printf( '<ul class="sub-categories-nav">%s</ul>',
					wp_list_categories('
						orderby=name&depth=1&title_li=&show_option_none=&child_of=' . get_category( $cat )->cat_ID . "&echo=0"
					)
				);
					
			elseif ( is_tag() ) :
				$page_subtitle = tag_description();
				if ( ! empty( $page_subtitle ) ) {
					printf( '<h3 class="hero-subtitle"><span>%s</span></h3><!-- .hero-subtitle -->', $page_subtitle );
				};
			
			endif;
			
			
			// Post Meta
			if ( is_single() ) : ?>
				<ul class="hero-meta byline">
					<li class="avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email', $post->post_author ), apply_filters( 'hypha_author_bio_avatar_size', 100 ) ); ?>
					</li>
					<li class="author">
						<?php
						printf( __( 'By <a href="%1$s">%2$s</a>', 'hyphatheme' ),
							get_author_posts_url( $post->post_author ),
							get_the_author_meta( 'display_name', $post->post_author )
						); ?>
					</li>
					<?php if ( get_comments_number() ) { ?>
						<li class="comments">
							<a href="<?php comments_link(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'hyphatheme' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number( __( 'No Comments', 'hyphatheme' ), __( '1 Comment', 'hyphatheme' ), __( '% Comments', 'hyphatheme') );?></a>
						</li>
					<?php } ?>
				</ul><!-- .hero-meta -->
			<?php endif; ?>
			
		</div><!-- .hero-header -->
	
	</div><!-- .headband -->

<?php } ?>