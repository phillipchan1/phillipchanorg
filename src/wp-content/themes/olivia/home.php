<?php
/**
 * This template displays posts in a gallery layout on the homepage
 *
 * @package Olivia
 */
get_header(); ?>

<?php
	if ( is_front_page() && at_olivia_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
			<div class="row">
				<div class="col col--3-of-12">
					<h3 class="blog-title fadeIn">
						<?php echo at_olivia_filter_article_header_text(); ?>
					</h3>
				</div><!-- .col -->

				<div id="articles-list" class="col col--9-of-12">

				<?php while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'list' );

				endwhile; ?>

				</div><!-- .col -->
			</div><!-- .row -->

			<?php at_olivia_page_navs(); ?>

		<?php else :

			get_template_part( 'template-parts/content-none' );

		endif; ?>

	</main><!-- #main -->

<?php get_footer(); ?>
