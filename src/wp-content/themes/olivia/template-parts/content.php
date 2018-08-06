<?php
/**
 * @package Olivia
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post full-post' ); ?>>

	<div class="row">

		<div class="col col--push-3-of-12 col--9-of-12">

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

			<?php if ( is_single() ) { ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php } else { ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php } ?>

		</div>

		<div class="col col--3-of-12">

			<?php 
			if ( function_exists( 'the_subtitle' ) ) {
				$subtitle = get_the_subtitle();
			}

			if ( ! empty( $subtitle ) ) {
			?>
			
			<header class="entry-header">
				<?php the_subtitle( '<p class="entry-subtitle">', '</p>' ); ?>
			</header><!-- .entry-header -->

			<?php } ?>

		</div>

		<div class="col col--9-of-12">

			<?php if ( has_post_thumbnail() ) : ?>

				<?php if ( is_single() ) { ?>
					<div class="featured-image"><?php the_post_thumbnail( 'olivia-full-width' ); ?></div>
				<?php } else { ?>
					<div class="entry-featured-image">
						<a class="featured-image" href="<?php the_permalink(); ?>" rel="bookmark">
							<?php the_post_thumbnail( 'olivia-full-width' ); ?>
						</a>
					</div><!-- .entry-featured-image -->
				<?php } ?>

			<?php endif; ?>

			<?php if ( is_single() ) { ?>

				<div class="entry-content">

					<?php

						the_content( esc_html__( 'Read More', 'olivia' ) );

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'olivia' ),
							'after'  => '</div>',
						) );

					?>

				</div><!-- .entry-content -->

			<?php get_template_part( 'template-parts/content-meta' ); ?>

			<?php } ?>

		</div><!-- .col -->

	</div><!-- .row -->

</article><!-- #post-## -->
