<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */

get_header(); ?>
	<section class="primary">
		<div class="content" role="main">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php comments_template(); ?>
				<?php themepile_post_nav(); ?>
			<?php endwhile; ?>
		</div><!-- .wrapper-inner -->
	</section><!-- .content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>