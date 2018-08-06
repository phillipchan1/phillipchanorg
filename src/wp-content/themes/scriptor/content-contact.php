<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', THEMEPILE_LANGUAGE ) ); ?>
			<?php
			if ( class_exists( 'ThemePile_ContactForm' ) ) {
				ThemePile_ContactForm::getInstance()->render();
			}
			?>
		</div><!-- .entry-content -->
	<?php endif; ?>
</article><!-- #post -->

