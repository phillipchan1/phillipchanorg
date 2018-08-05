<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Olivia
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post();

			// Move Jetpack share links below author box
			if ( function_exists( 'sharing_display' ) ) {
				remove_filter( 'the_excerpt', 'sharing_display', 19 );
				remove_filter( 'the_content', 'sharing_display', 19 );
			}

			get_template_part( 'template-parts/content' );

			at_olivia_author_box();

			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() ) {
				comments_template();
				//TODO
			}

		endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
