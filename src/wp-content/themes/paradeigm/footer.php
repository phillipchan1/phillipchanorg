<?php
/**
 * The Footer
 *
 * Contains footer content and the closing of the #page div elements.
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>
		
	</div><!-- .main-wrapper -->

	<footer id="colophon" class="site-footer clearfix">
		
		<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
			<div class="site-footer-inside clearfix">
				<?php get_sidebar( 'footer' ); ?>
			</div><!-- .site-footer-inside -->
		<?php endif; ?>
				
		<div class="footnote">
			<div class="footnote-inside clearfix">
			
				<div id="scroll-to-top">
					<div class="scroll-to-top-wrap">
						<a href="#"><i class="fa fa-angle-up"></i></a>
					</div>
				</div><!-- .scroll-to-top -->
				
				<div class="footnote-right">
					<?php if ( hypha_get_social_icons() ) { ?>
						<!-- Grab footer icons -->
						<div class="social-icons">
							<div class="icons-widget">
								<div class="fa fa-links">
									<?php echo hypha_get_social_icons(); ?>
								</div><!-- .fa fa-links -->
							</div><!-- .icons-widget -->
						</div><!-- .icons -->
					<?php }	?>
				</div><!-- .footnote-right -->
				
				<div class="footnote-left">
					<div class="site-info">
						<?php if ( get_option( 'hypha_customizer_footnote_text' ) ) { ?>
							<?php echo get_option( 'hypha_customizer_footnote_text' ) ?>
						<?php } else { ?>
							<span class="copyright">&copy;</span>
							<?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url() ); ?>" rel="bookmark"><?php bloginfo( 'name' ); ?></a>
							<span class="sep"> | </span>
							<?php bloginfo( 'description' ); ?>
						<?php } ?>
					</div><!-- .site-info -->
				</div><!-- .footnote-left -->
			
			</div><!-- .footnote-inside -->
		</div><!-- .footnote -->
		
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<div id="media-query"></div>

<?php wp_footer(); ?>

</body>
</html>