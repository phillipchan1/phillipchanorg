<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */

get_header(); ?>
	<section class="primary primary--error" <?php if ( themepile_get_cover_image()  ) : ?> style="background:url(<?php echo themepile_get_error_image() ?>);" <?php endif; ?>>
		<div class="content" role="main">
			<header class="page-header">
				<h1 class="site-title">
					<?php if ( themepile_get_logo()  ) : ?>
						<a href="<?php echo home_url(); ?>"><img src="<?php echo themepile_get_logo() ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
					<?php else : ?>
						<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
				</h1>
			</header>
			<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', THEMEPILE_LANGUAGE ); ?></h2>
			<p><?php printf('It looks like nothing was found at this location. <a href="%1$s">May be return on homepage?</a>', home_url()); ?></p>
		</div><!-- .wrapper-inner -->
	</section><!-- .content -->
<?php get_footer(); ?>