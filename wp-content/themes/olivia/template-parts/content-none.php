<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Olivia
 */
?>

<article class="no-results not-found post">

	<div class="row">
		<div class="col col--3-of-12">
			<h1 class="archive-title"><?php esc_html_e( 'Nothing Found', 'olivia' ); ?></h1>
		</div><!-- .col -->


		<div class="col col--9-of-12">
			<div class="entry-content">
				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'olivia' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>


				<?php elseif ( is_search() ) : ?>

					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'olivia' ); ?></p>
					<?php get_search_form(); ?>

				<?php else : ?>

					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'olivia' ); ?></p>
					<?php get_search_form(); ?>

				<?php endif; ?>
			</div><!-- .entry-content -->
		</div><!-- .col -->
	</div><!-- .row -->

</article><!-- .no-results -->
