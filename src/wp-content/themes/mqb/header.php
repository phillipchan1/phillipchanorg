<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>

<link rel="shortcut icon" href="http://www.phillipchan.org/images/favico.ico" />
<link rel="icon" href="http://www.phillipchan.org/images/favico.ico" />

<meta name="google-site-verification" content="xkLnSDyCzVOYooZ9yLisJoTR4GpRfvg6up68KQ-JK54" />


</head>
<body>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5233075-6']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<div id="wrap">
<div id="header">
<div id="headone">
<ul id="menu">
<li class="<?php if ( is_home() or is_archive() or is_single() or is_paged() or is_search() or (function_exists('is_tag') and is_tag()) ) { ?>current_page_link<?php } else { ?>page_link<?php } ?>"><a href="<?php echo get_settings('home'); ?>"><?php _e('Home'); ?></a></li>
<?php wp_list_pages('sort_column=id&depth=1&title_li='); ?>
</ul>
<h1><a href="<?php echo get_option('home'); ?>/"><img src="http://www.phillipchan.org/images/logo2.png" border="0" class="thumbnail" style="margin-bottom:20px;"></a></h1>
<h2><?php bloginfo('description'); ?></h2>
</div>
<div id="headtwo">
</div>
</div>
<div id="container" class="fix">