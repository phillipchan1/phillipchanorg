<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new ThemePile_Shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="themepile-popup">

	<div id="themepile-shortcode-wrap">

		<div id="themepile-sc-form-wrap">

			<div id="themepile-sc-form-head">

				<?php echo $shortcode->popup_title; ?>

			</div>
			<!-- /#themepile-sc-form-head -->

			<form method="post" id="themepile-sc-form">

				<table id="themepile-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody>
					<tr class="form-row">
						<?php if ( ! $shortcode->has_child ) : ?>
							<td class="label">&nbsp;</td><?php endif; ?>
						<td class="field"><a href="#" class="button-primary themepile-insert">Insert Shortcode</a></td>
					</tr>
					</tbody>

				</table>
				<!-- /#themepile-sc-form-table -->

			</form>
			<!-- /#themepile-sc-form -->

		</div>
		<!-- /#themepile-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#themepile-shortcode-wrap -->

</div>
<!-- /#themepile-popup -->

</body>
</html>