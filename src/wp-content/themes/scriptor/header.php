<?php
/**
 * The Header of ThemePile.
 * Displays all of the <head> section and everything up till <body>
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" user-scalable="no">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php ThemePileTheme::themepile_action_add_rss(); ?>" />
	<link rel="shortcut icon" href="<?php ThemePileTheme::themepile_action_add_favicon(); ?>">
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic,700italic' rel='stylesheet' type='text/css'>

	<?php wp_head(); ?>
</head>
<!-- head -->
<body <?php body_class(); ?>>
	<nav class="site-nav" role="navigation">
		<div class="site-nav-buttons">
			<a href="#/action/scriptor--site-nav--open" title="<?php _e( 'Show Site Navigation', THEMEPILE_LANGUAGE ) ?>" class="site-nav-go-to-nav-link">
				<span class="scriptor-icon--menu">
					<span class="screen-reader-text"><?php _e( 'Search', THEMEPILE_LANGUAGE ) ?></span>
				</span>
			</a><!-- .site-nav-go-to-home-link -->
			<a href="#/action/scriptor--sidebar--open" class="ui-show-sidebar-toggle" title="<?php _e( 'Show Sidebar', THEMEPILE_LANGUAGE ) ?>" >
				<span class="scriptor-icon--thumb-view">
					<span class="screen-reader-text"><?php _e( 'Show Sidebar', THEMEPILE_LANGUAGE ) ?></span>
				</span>
			</a>
		</div><!--- site-nav-go-to-home -->
		<div class="site-nav-inner">
			<?php get_search_form(); ?>
			<div class="site-nav-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'site-nav-list' ) ); ?>
			</div>
		</div>
		<div class="site-nav-overlay"></div>
	</nav><!-- site-nav -->


	<div class="container">
		<aside class="cover">
			<div class="cover-inner">
				<div class="cover-body">
					<h1 class="site-title">
						<?php if ( themepile_get_logo()  ) : ?>
							<a href="<?php echo home_url(); ?>"><img src="<?php echo themepile_get_logo() ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
						<?php else : ?>
							<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
						<?php endif; ?>
					</h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
					<?php if ( is_page_template('template-contact.php') ) {
						$lat = ThemePileTheme::get_theme_option( 'contact_location_lat', true );
						$lng = ThemePileTheme::get_theme_option( 'contact_location_lng', true );
						if ( ! empty( $lat ) && ! empty( $lng ) ) : ?>
							<div class="google-map"
								 data-lat="<?php echo ThemePileTheme::get_theme_option(
									 'contact_location_lat',
									 true
								 ); ?>"
								 data-lng="<?php echo ThemePileTheme::get_theme_option(
									 'contact_location_lng',
									 true
								 ); ?>">
							</div>
						<?php endif; ?>
					<?php } else { ?>

					<div class="cover-nav">
						<?php //wp_nav_menu( array( 'theme_location' => 'cover-menu', 'menu_class' => 'cover-nav-list' ) ); ?>
					</div>


					<div class="cover-image">
						<?php if ( themepile_get_cover_image() && !is_single() && !is_page() ) : ?>
							<img src="<?php echo themepile_get_cover_image() ?>" alt="<?php bloginfo( 'name' ); ?>" />
						<?php else: ?>
							<?php if ( has_post_thumbnail() && !post_password_required() && (is_single() || is_page() )  ) : ?>
									<?php the_post_thumbnail('full'); ?>
								<?php else: ?>
									<img src="<?php echo themepile_get_cover_image() ?>" alt="<?php bloginfo( 'name' ); ?>" />
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<?php } ?>
			</div><!-- .cover-inner -->
		</aside><!-- .cover -->