<?php
/**
 * The template for displaying Tag pages.
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */

get_header(); ?>
	<section class="primary">
		<div class="content" role="main">
			<?php if ( have_posts() ) : ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', THEMEPILE_LANGUAGE ), single_tag_title( '', false ) ); ?></h1>
					<?php if ( tag_description() ) : // Show an optional tag description ?>
						<div class="archive-meta"><?php echo tag_description(); ?></div>
					<?php endif; ?>
				</header><!-- .archive-header -->
				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
				<?php echo ThemePile_Pagination() ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</div><!-- .wrapper-inner -->
	</section><!-- .content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>