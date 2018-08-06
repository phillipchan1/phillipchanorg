<?php
/**
 * The template for displaying featured posts on the front page
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('featured-article'); ?>>

	<div class="row">

		<div class="col col--3-of-12">
			<header class="entry-header">

				<div class="byline">
					<span class="meta-by">
						<?php esc_html_e( 'by', 'olivia' ); ?>
					</span>

					<span class="meta-author">
						<?php the_author_posts_link(); ?>
					</span>

					<span class="meta-date">
						<?php echo get_the_date(); ?>
					</span>
				</div>

				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php the_title(); ?>
					</a>
				</h2>

				<?php
				if ( function_exists( 'get_the_subtitle' ) ) {
				    the_subtitle( '<p class="entry-subtitle">', '</p>' );
				}
				?>

			</header><!-- .entry-header -->
		</div><!-- .col -->

		<div class="col col--9-of-12">
			<div class="entry-featured-image">
				<span class="featured-sign">
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php
							//get tag name from Featured Content Jetpack customizer
							$featured_options = get_option( 'featured-content' );
							$featured_name = $featured_options[ 'tag-name' ];

							if ( ! $featured_name ) {
								$featured_name = esc_html_e( 'featured', 'olivia' );
							}

							echo $featured_name;
						 ?>
					</a>
				</span>

				<a class="featured-image" href="<?php the_permalink(); ?>" rel="bookmark">
				<?php
					// Output the featured image.
					if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'olivia-full-width' );
					endif;
				?>
				</a>

			</div><!-- .entry-featured-image -->
		</div><!-- .col -->

	</div><!-- .row -->

</article><!-- #post-## -->
