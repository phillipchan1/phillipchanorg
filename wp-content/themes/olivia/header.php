<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Olivia
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- <body <?php body_class(); ?>> -->

<div class="v-line"></div>

<header id="masthead" class="wrap site-header" role="banner">

	<div class="west-side">

		<?php at_olivia_title_logo(); ?>

		<!-- menu -->
		<div id="panel-menu" class="side-menu" href="#">
			<span class="nav-icon"></span>
		</div>

		<!-- widget -->
		<div id="panel-widget" class="side-widget" href="#">
			<span class="widget-icon"></span>
		</div>

	</div>


</header><!-- .site-header -->


<div class="content-wrapper">

	<div id="fullscreen-menu" class="full-height">
		<div class="wrap-fs-menu pos-rel">
			<div class="row">

				<div class="col col--3-of-12">
					<h3 class="fs-title">
						<?php echo at_olivia_filter_menu_header_text(); ?>
					</h3>
				</div>

				<div class="col col--9-of-12">
					<div class="menu-inner">

						<nav id="site-navigation" class="main-navigation" role="navigation">
							<?php wp_nav_menu( array(
								'theme_location' => 'primary',
								'depth' => 2
							) );?>
						</nav><!-- #site-navigation -->

					</div>
				</div>

			</div>
		</div>

		<div class="wrap-fs-widgets pos-rel">
			<div class="row">

				<div class="col col--3-of-12">
					<h3 class="fs-title">
						<?php echo at_olivia_filter_widget_header_text(); ?>
					</h3>
				</div>

				<div class="col col--9-of-12">
					<div class="widgets-inner">

						<?php get_sidebar(); ?>

					</div>
				</div>

			</div>
		</div>

	</div>

	<div id="page" class="hfeed site">
		<div id="content" class="wrap site-content">
