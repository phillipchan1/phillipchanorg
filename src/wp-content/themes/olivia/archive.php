<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Olivia
 */
get_header();
?>

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php
				// Grab author profile box
				if ( is_author() ) {
					at_olivia_author_box();
			} ?>

			<div class="row">
				<div class="col col--3-of-12">
					<?php
					if ( ! is_author() ) { ?>
						<header class="entry-header archive-header">
						<?php the_archive_title( '<h3 class="archive-title">', '</h3>' ); ?>
						</header><!-- .entry-header -->
					<?php } ?>
				</div><!-- .col -->


				<div id="articles-list" class="col col--9-of-12">

					<?php
						$description = get_the_archive_description();
						if ( $description ) {
							the_archive_description( '<div class="entry-content"><div class="taxonomy-description">', '</div></div>' );
						}
    				?>

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
