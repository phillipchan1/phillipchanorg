<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */

get_header(); ?>

	<section class="primary">
		<div class="content" role="main">
			<?php if ( have_posts() ) : ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php echo __( 'Last Posts', THEMEPILE_LANGUAGE ); ?></h1>
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
