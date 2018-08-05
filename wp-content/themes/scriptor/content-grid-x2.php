<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-grid-x2'); ?>>
	<?php if ( has_post_thumbnail() && ! post_password_required() && !is_single() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail('full'); ?>
		</div>
	<?php endif; ?>
	<header class="entry-header">
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
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
</article><!-- #post -->
