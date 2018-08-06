<?php
/**
 * The template for displaying Author bios.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */
?>

<div class="entry-author-card">
	<div class="entry-author-card-avatar">
		<a class="entry-author-card-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 64 ); ?>
		</a><!-- .entry-author-card-link -->
	</div><!-- .entry-author-card-avatar -->
	<div class="entry-author-card-text">
		<h4 class="entry-author-card-heading">
			<?php _e( 'Written by', THEMEPILE_LANGUAGE ) ?>
		</h4><!-- .entry-author-card-heading -->
		<h3 class="entry-author-card-name">
			<a class="entry-author-info-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php the_author(); ?>
			</a>
		</h3><!-- .entry-author-card-name -->
		<p class="entry-author-card-description">
			<?php the_author_meta( 'description' ); ?>
		</p>
		<div class="entry-author-card-additional">
			<time class="entry-author-card-additional-published"><?php echo get_the_date() ?></time>
		</div><!-- .entry-author-card-additional -->
		<?php themepile_entry_tags();  ?>
	</div><!-- .entry-author-card-text -->
</div><!-- .entry-author-card -->