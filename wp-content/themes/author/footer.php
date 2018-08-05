			<div id="footer" class="clearfix">
				<div class="footer-copy">
					<div class="menu-footer-wrapper">
						<?php wp_nav_menu(array('menu_id' => 'menu-footer', 'theme_location' => 'footer', 'menu_class' => 'footernav')); ?>
					</div>
					
					<div class="clear"></div>
	
					<p class="copyright">&copy; <?php echo date("Y"); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a> | <?php bloginfo('description'); ?></p>
				</div>
				
				<div class="social-icons">
					<?php if ( of_get_option('twitter_icon') ) { ?>
						<a href="<?php echo of_get_option('twitter_icon'); ?>" title="twitter"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-twitter.png" alt="twitter" /></a>
					<?php } ?>
					
					<?php if ( of_get_option('google_icon') ) { ?>
						<a href="<?php echo of_get_option('google_icon'); ?>" title="google"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-google.png" alt="google" /></a>
					<?php } ?>
					
					<?php if ( of_get_option('youtube_icon') ) { ?>
						<a href="<?php echo of_get_option('youtube_icon'); ?>" title="youtube"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-youtube.png" alt="google" /></a>
					<?php } ?>
					
					<?php if ( of_get_option('dribbble_icon') ) { ?>
						<a href="<?php echo of_get_option('dribbble_icon'); ?>" title="dribbble"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-dribbble.png" alt="dribbble" /></a>
					<?php } ?>
					
					<?php if ( of_get_option('facebook_icon') ) { ?>
						<a href="<?php echo of_get_option('facebook_icon'); ?>" title="facebook"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-facebook.png" alt="facebook" /></a>
					<?php } ?>
					
					<?php if ( of_get_option('vimeo_icon') ) { ?>
						<a href="<?php echo of_get_option('vimeo_icon'); ?>" title="vimeo"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-vimeo.png" alt="vimeo" /></a>
					<?php } ?>
					
					<?php if ( of_get_option('tumblr_icon') ) { ?>
						<a href="<?php echo of_get_option('tumblr_icon'); ?>" title="tumblr"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-tumblr.png" alt="tumblr" /></a>
					<?php } ?>
					
					<?php if ( of_get_option('linkedin_icon') ) { ?>
						<a href="<?php echo of_get_option('linkedin_icon'); ?>" title="linkedin"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-linkedin.png" alt="linkedin" /></a>
					<?php } ?>
					
					<?php if ( of_get_option('flickr_icon') ) { ?>
						<a href="<?php echo of_get_option('flickr_icon'); ?>" title="flickr"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-flickr.png" alt="flickr" /></a>
					<?php } ?>
				</div>
				
			</div><!--footer-->
		</div><!-- main -->
	</div><!-- wrapper -->

	<!-- google analytics code -->
	<?php if (of_get_option('of_tracking_code') == true) { ?>
		<?php echo of_get_option('of_tracking_code', 'no entry' ); ?>
	<?php } ?>
	
	<?php wp_footer(); ?>

</body>
</html>