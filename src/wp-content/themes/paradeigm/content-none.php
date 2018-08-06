<?php
/**
 * The default template for no content found
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

<div class="entry-container none">
	<div class="entry-header">	
		<h1 class="entry-title"><?php _e( 'Nothing Found', 'hyphatheme' ); ?></h1>
	</div><!-- .entry-header -->
	
	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'hyphatheme' ), admin_url( 'post-new.php' ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hyphatheme' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It looks like nothing was found at this location. Try using the navigation menu or the search box to find what you were looking for.', 'hyphatheme' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
		
	</div><!-- .entry-content -->
</div><!-- .entry-container -->