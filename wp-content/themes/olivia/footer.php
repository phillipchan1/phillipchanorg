<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Olivia
 */
?>

		</div><!-- #content -->
	</div><!-- #page -->

	<?php
		// Get the post navigations for single posts
		if ( is_single() ) {
			at_olivia_post_navigation();
		} ?>

	<footer id="colophon" class="wrap site-footer" role="contentinfo">

		<div class="row">
			<div class="col col--push-3-of-12 col--9-of-12">
				<div class="footer-bottom">
					<div class="row">
						<div class="col col--6-of-12 col--am">

							<div class="site-info">
									&copy; 2016 phillipchan.org
							</div>
						</div>

						<div class="col col--6-of-12 col--am">
							<?php at_olivia_site_desc(); ?>
						</div>

					</div>
				</div><!-- .footer-bottom -->
			</div><!-- .col -->
		</div><!-- .row -->

	</footer><!-- #colophon -->

</div><!-- .site-wrapper -->

<?php wp_footer(); ?>

</body>
</html>
