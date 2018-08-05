<?php
/**
 * The template for displaying posts in the Quote post format.
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
	<?php if ( is_single() ) : ?>
		<div class="entry-footer">
			<div class="entry-actions">
				<?php themepile_entry_share(); ?>
			</div><!-- .entry-actions -->
			<?php get_template_part( 'templates/template', 'author-bio' ); ?>
		</div><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post -->
