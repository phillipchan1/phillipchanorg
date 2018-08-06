<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */

get_header(); ?>
<section class="primary">
	<div class="content" role="main">

		<?php if ( have_posts() ) : ?>
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template(); ?>
				<?php themepile_post_nav(); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- .wrapper-inner -->
</section><!-- .content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
