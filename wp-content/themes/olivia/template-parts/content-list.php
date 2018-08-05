<?php
/**
 * The template for displaying latest articles on the front page
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'list-post' ); ?>>

	<div class="row">

		<div class="col col--10-of-12 col--m-3-of-4">

			<header class="entry-header">
				<div class="byline">
					<span class="meta-date">
						<?php echo get_the_date(); ?>
					</span>
				</div>

				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php the_title(); ?>
					</a>
				</h2>
			</header><!-- .entry-header -->

		</div><!-- .col -->

		<div class="col col--2-of-12 col--m-1-of-4">

			<?php if ( has_post_thumbnail() ) : ?>

			<?php 
			$featured_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "olivia-list-thumb" );
			?>

			<div class="entry-featured-image">
				<a class="featured-image" href="<?php the_permalink(); ?>" rel="bookmark" style="background-image: url(<?php echo esc_url( $featured_image_src[0] ); ?>);">
				</a>
			</div><!-- .entry-featured-image -->
			<?php endif; ?>

		</div>

	</div><!-- .row -->

</article><!-- #post-## -->