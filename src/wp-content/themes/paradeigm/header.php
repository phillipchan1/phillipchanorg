<?php
/**
 * The Header
 *
 * Displays all of the <head> section and opens up the page.
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page">

	<header id="masthead" class="site-header" role="banner">
	
		<div class="headcap clearfix">
			<div class="headcap-inside clearfix">
				<div class="navigation-wrap clearfix">
				
					<div class="hgroup">
						<?php if ( get_theme_mod( 'hypha_customizer_logo' ) ) { ?>
			   				<h1 class="logo-image">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<?php
									$logo_url = get_theme_mod( 'hypha_customizer_retina_logo' ) ? get_theme_mod( 'hypha_customizer_retina_logo' ) : get_theme_mod( 'hypha_customizer_logo' );
									$logo_id = hypha_get_attachment_id_from_url( get_theme_mod( 'hypha_customizer_logo' ) );
									$logo_attributes = wp_get_attachment_image_src( $logo_id, 'full' );
									
									printf( '<img class="site-logo" src="%1$s" width="%2$s" height="%3$s" alt="%4$s" />',
										esc_url( $logo_url ),
										$logo_attributes[1],
										$logo_attributes[2],
										get_bloginfo( 'name' )
									);
									?>
									<span class="site-title"><?php bloginfo( 'name' ); ?></span>
								</a>
							</h1>
						<?php } else { ?>
							<h1 class="site-title animated flipInY"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php } ?>
					</div><!-- .hgroup -->
		
					<nav role="navigation" class="site-navigation main-navigation clearfix">
						<h1 class="assistive-text"><i class="fa fa-bars"></i> <?php _e( 'Menu', 'hyphatheme' ); ?></h1>
						<div class="assistive-text skip-link"><a href="#content"><?php _e( 'Skip to content', 'hyphatheme' ); ?></a></div>
						<?php wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_class' => 'menu clearfix',
							'items_wrap' => '
								<ul id="%1$s" class="%2$s">%3$s
									<li class="main-menu-search">
										<a class="menu-search-toggle" href="#">
											<i class="fa fa-search"></i><i class="fa fa-times"></i>
										</a>
										<div class="menu-search">
											<form method="get" action="' . esc_url( home_url( '/' ) ) . '" role="search">
												<label class="assistive-text">' . __( 'Search', 'hyphatheme' ) . '</label>
												<input type="text" id="menu-search-input" class="field header-search-input" name="s" value="' . esc_attr( get_search_query() ) . '" placeholder="' . esc_attr( 'Type here and press enter', 'hyphatheme' ) . '" />
											</form>
										</div><!-- .menu-search -->
									</li>
								</ul>'
						) ); ?>
					</nav><!-- .site-navigation -->
					
				</div><!-- .navigation-wrap -->
			</div><!-- .headcap-inside -->
		</div><!-- .headcap -->
	
		<div class="site-header-inside">
			<?php get_template_part( 'includes/partials/headband' ); ?>
		</div><!-- .site-header-inside -->
		
		<div class="header-image animated fadeIn" <?php if ( '' != hypha_get_header_image() ) { ?>style="background-image: url('<?php echo hypha_get_header_image(); ?>');"<?php } ?>>
		</div><!-- .header-image -->
		
	</header><!-- #masthead .site-header -->
	
	<div class="main-wrapper">