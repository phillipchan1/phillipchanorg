<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', THEMEPILE_LANGUAGE ); ?></h1>
		<div class="entry-meta">
			<?php themepile_entry_meta(); ?>
			<?php if ( comments_open() && ! is_single() ) : ?>
				<span class="entry-meta-item comments-link">
				<em class="entry-meta-item-label">
					<span class="scriptor-icon--bubbles-talk"></span>
					<?php comments_popup_link(
						'<span class="leave-reply">' . __( 'Leave a comment', THEMEPILE_LANGUAGE ) . '</span>',
						__( 'One comment so far', THEMEPILE_LANGUAGE ), __( 'View all % comments', THEMEPILE_LANGUAGE )
					);
					?>
				</em><!-- .entry-meta-item-label -->
			</span><!-- .comments-link -->
			<?php endif; // comments_open() ?>

		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', THEMEPILE_LANGUAGE ), admin_url( 'post-new.php' ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', THEMEPILE_LANGUAGE ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', THEMEPILE_LANGUAGE ); ?></p>
		<?php endif; ?>
	</div><!-- .entry-content -->
</article><!-- #post -->

