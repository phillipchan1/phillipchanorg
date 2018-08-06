<?php
/**
 * The template for displaying Search results.
 *
 * @package Olivia
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<div class="row">
				<div class="col col--3-of-12">
					<h1 class="archive-title">
						<?php printf( esc_html__( 'Results for: %s', 'olivia' ), '<span>' . get_search_query() . '</span>' ); ?>
					</h1>
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
