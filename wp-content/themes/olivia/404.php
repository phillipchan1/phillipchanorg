<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Olivia
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<div class="row">
			<div class="col col--3-of-12">
				<h3 class="archive-title"><?php esc_html_e( 'Page Not Found', 'olivia' ); ?></h3>
			</div><!-- .col -->

			<div class="col col--9-of-12">

				<div class="entry-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Please use the search box or the navigation menu to locate the content you were looking for.', 'olivia' ); ?></p>

					<?php get_search_form(); ?>

			</div><!-- .col -->
		</div><!-- .row -->
	</main><!-- #main -->

<?php get_footer(); ?>
