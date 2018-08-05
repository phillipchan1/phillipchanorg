<?php
/**
 * The template for displaying posts in the Status post format.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', THEMEPILE_LANGUAGE ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', THEMEPILE_LANGUAGE ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .entry-content -->
	<?php endif; ?>
	<?php if ( !is_single() ) : ?>
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
		</div>
		<!-- .entry-meta -->
	<?php endif; // is_single() ?>
	<?php if ( is_single() ) : ?>
		<div class="entry-footer">
			<div class="entry-actions">
				<?php themepile_entry_share(); ?>
			</div><!-- .entry-actions -->
			<?php get_template_part( 'templates/template', 'author-bio' ); ?>
		</div><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post -->