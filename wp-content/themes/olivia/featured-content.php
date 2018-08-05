<?php
/**
 * The template for displaying featured content
 */
?>

<div id="featured-content" class="featured-posts">
	<?php
		/**
		 * Fires before the Olivia featured content.
		 */
		do_action( 'olivia_featured_posts_before' );

		$featured_posts = at_olivia_get_featured_posts();
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );

			// Include the featured content template.
			get_template_part( 'template-parts/content', 'featured-post' );
		endforeach;

		/**
		 * Fires after the Olivia featured content.
		 */
		do_action( 'olivia_featured_posts_after' );

		wp_reset_postdata();
	?>
</div><!-- #featured-content .featured-posts -->