<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Olivia
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

	<div class="row">

		<div class="col col--push-3-of-12 col--9-of-12">

			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

		</div><!-- .col -->

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

		<!-- Grab the featured image -->
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="featured-image"><?php the_post_thumbnail( 'olivia-full-width' ); ?></div>
		<?php } ?>

			<div class="entry-content">
				<?php the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'olivia' ),
					'after'  => '</div>',
				) ); ?>
			</div><!-- .entry-content -->

		</div><!-- .col -->

	</div><!-- .row -->

</article><!-- #post-## -->
