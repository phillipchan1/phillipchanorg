<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head> 
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" /> 
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	
	<title>
		<?php
			global $page, $paged;
	
			wp_title( '|', true, 'right' );
	
			bloginfo( 'name' );
	
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
	
			if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );
		?>
	</title>
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<!-- bookmark icon -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png" />
	
	<!-- main stylesheet -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	
	<!-- media queries -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/media-queries.css" type="text/css" media="screen" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />
	
	<!-- google font -->
	<link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,700,900' rel='stylesheet' type='text/css' />
	
	<!-- load scripts -->
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>

	<!-- conditional css -->
	<style type="text/css">
		a {
			color:<?php echo of_get_option('of_colorpicker', 'no entry' ); ?>;
		}
		.scroll .flex-control-nav li a.active {
			background:<?php echo of_get_option('of_colorpicker', 'no entry' ); ?>;
		}
		
		<?php if ( of_get_option('of_theme_css') ) { ?>
			<?php echo of_get_option('of_theme_css'); ?>
		<?php } ?>
	</style>
</head>

<body <?php body_class( $class ); ?>>
	
	<div id="wrapper" class="clearfix">
		
		<div id="main" class="clearfix">
			<div class="header-wrapper clearfix">
				<!-- grab the logo -->
				<?php if ( of_get_option('of_logo') ) { ?>
		        	<div class="logo-img">
						<a href="<?php echo home_url( '/' ); ?>"><img class="logo" src="<?php echo of_get_option('of_logo'); ?>" alt="<?php the_title(); ?>" /></a>
					</div>
				<!-- otherwise show the site title and description -->	
		        <?php } else { ?>
		        	
	            <div class="logo-default">
		            <div class="logo-text">
		            	<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name') ?></a>
		            	<br />
		            	<span><?php bloginfo('description') ?></span>
		            </div>
	            </div>
		        <?php } ?>    
				
				<div class="top-bar">			
		        	<div class="menu-wrap">
		            	<?php wp_nav_menu(array('theme_location' => 'main', 'menu_class' => 'nav')); ?>	
		            </div>
				</div><!-- top bar -->
			</div><!-- header wrapper -->
			
			<!-- secondary menu -->
			<?php if ( has_nav_menu( 'secondary' ) ) { ?>
				<div class="secondary-menu-wrap">
					<?php wp_nav_menu(array('theme_location' => 'secondary', 'menu_class' => 'secondary-menu')); ?>
				</div>
			<?php } ?>