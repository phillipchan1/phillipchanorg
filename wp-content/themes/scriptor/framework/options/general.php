<?php if ( ! defined( 'ABSPATH' ) ) {
	die();
} ?>



<div class="themepile__section">
	<h2><?php _e( 'General Settings', THEMEPILE_LANGUAGE ); ?></h2>
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'custom_logo' ); ?>">
				<?php _e( 'Custom Logo Upload', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>

		<p class="themepile__section__description">
			<?php _e( 'Upload a logo for your theme.', THEMEPILE_LANGUAGE ); ?>
		</p>
	</div>
	<div class="themepile__section__field themepile__section__field_type_file"
		 data-themepile-plugin="themepile-wp-uploader">
		<div data-themepile-wp-uploader-container class="themepile-wp-uploader__image">
			<?php
			$image_logo = ThemePileTheme::get_theme_option( 'custom_logo' );
			if ( $image_logo ) {
				echo "<img src='" . $image_logo . "'>";
			}
			?>
		</div>
		<input class="regular-text"
			   placeholder="<?php _e(
				   'Upload image, or specify the image address of your image',
				   THEMEPILE_LANGUAGE
			   ); ?>"
			   data-themepile-wp-uploader-input type="text"
			   id="<?php echo ThemePileTheme::get_theme_option_name( 'custom_logo' ); ?>"
			   name="<?php echo ThemePileTheme::get_theme_option_name( 'custom_logo' ); ?>"
			   value="<?php echo $image_logo; ?>">

		<p class="description"><?php printf( __( 'Recommended size: %s', THEMEPILE_LANGUAGE ), '45x45' ); ?></p>
		<a data-themepile-wp-uploader-button class="button themepile-upload-button"
		   href="#"><?php _e( 'Add Image', THEMEPILE_LANGUAGE ); ?></a>
		<a data-themepile-wp-uploader-remove class="button" href="#"><?php _e( 'Remove', THEMEPILE_LANGUAGE ); ?></a>
	</div>
	<!-- .themepile__section__field -->
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'custom_favicon' ); ?>">
				<?php _e( 'Custom Favicon Upload', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>

		<p class="themepile__section__description">
			<?php _e(
				'Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.',
				THEMEPILE_LANGUAGE
			); ?>
		</p>
	</div>
	<div class="themepile__section__field themepile__section__field_type_file"
		 data-themepile-plugin="themepile-wp-uploader">
		<div data-themepile-wp-uploader-container class="themepile-wp-uploader__image">
			<?php
			$image_favicon = ThemePileTheme::get_theme_option( 'custom_favicon' );
			if ( $image_favicon ) {
				echo "<img src='" . $image_favicon . "'>";
			}
			?>
		</div>
		<input class="regular-text"
			   placeholder="<?php _e(
				   'Upload image, or specify the image address of your image',
				   THEMEPILE_LANGUAGE
			   ); ?>"
			   data-themepile-wp-uploader-input type="text"
			   id="<?php echo ThemePileTheme::get_theme_option_name( 'custom_favicon' ); ?>"
			   name="<?php echo ThemePileTheme::get_theme_option_name( 'custom_favicon' ); ?>"
			   value="<?php echo $image_favicon; ?>">

		<p class="description"><?php printf( __( 'Recommended size: %s', THEMEPILE_LANGUAGE ), '16x16' ); ?></p>
		<a data-themepile-wp-uploader-button class="button themepile-upload-button"
		   href="#"><?php _e( 'Add Image', THEMEPILE_LANGUAGE ); ?></a>
		<a data-themepile-wp-uploader-remove class="button" href="#"><?php _e( 'Remove', THEMEPILE_LANGUAGE ); ?></a>
	</div>
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'custom_rss_url', true ); ?>">
				<?php _e( 'FeedBurner URL', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>

		<p class="themepile__section__description">
			<?php _e(
				'Enter your full FeedBurner URL (or any other preferred feed URL) if you wish to use FeedBurner over the standard WordPress feed e.g. http://feeds.feedburner.com/yoururlhere',
				THEMEPILE_LANGUAGE
			); ?>
	</div>
	<div class="themepile__section__field ">
		<input type="text" class="regular-text"
			   value="<?php echo ThemePileTheme::get_theme_option( 'custom_rss_url' ); ?>"
			   id="<?php echo ThemePileTheme::get_theme_option_name( 'custom_rss_url' ); ?>"
			   name="<?php echo ThemePileTheme::get_theme_option_name( 'custom_rss_url' ); ?>">
	</div>
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'custom_js' ); ?>">
				<?php _e( 'Custom JS', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>

		<p class="themepile__section__description">
			<?php _e(
				'Paste your Google Analytics (or other) tracking code here. It will be inserted before the closing body tag of your theme. ',
				THEMEPILE_LANGUAGE
			); ?>
		</p>
	</div>
	<div class="themepile__section__field ">
		<textarea class="large-text code" rows="10"
				  id="<?php echo ThemePileTheme::get_theme_option_name( 'custom_js' ); ?>"
				  rows="10"
				  name="<?php echo ThemePileTheme::get_theme_option_name( 'custom_js' ); ?>"><?php echo ThemePileTheme::get_theme_option( 'custom_js' ); ?></textarea>
	</div>
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'responsive' ); ?>">
				<?php _e( 'Responsive Layout', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>
		<p class="themepile__section__description">
			<?php _e( 'Disable or enable responsive layout for current theme', THEMEPILE_LANGUAGE ); ?>
		</p>
	</div>
	<div class="themepile__section__field ">
		<input type="hidden" name="<?php echo ThemePileTheme::get_theme_option_name( 'responsive' ); ?>" value="0">
		<input
			type="checkbox"
			id="<?php echo ThemePileTheme::get_theme_option_name( 'responsive' ); ?>"
			name="<?php echo ThemePileTheme::get_theme_option_name( 'responsive' ); ?>"
			value="1"
			<?php checked( ThemePileTheme::get_theme_option( 'responsive' ), '1' ); ?>
			>
		<label for="<?php echo ThemePileTheme::get_theme_option_name( 'responsive' ); ?>"><?php _e('Disable Responsive Layout', THEMEPILE_LANGUAGE ); ?></label>
	</div>
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'contact_location_address' ); ?>">
				<?php _e( 'Contact Information', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>

		<p><?php _e( 'Enter your company\'s address', THEMEPILE_LANGUAGE ); ?></p>
	</div>
	<div class="themepile__section__field ">
		<div class="themepile-google-get-location" data-themepile-plugin="themepile-google-get-location">
			<div class="row">
				<input
					data-themepile-google-get-location-address
					placeholder="<?php _e( 'Enter your company\'s address', THEMEPILE_LANGUAGE ); ?>"
					type="text"
					size="40"
					class="regular-text"
					id="<?php echo ThemePileTheme::get_theme_option_name( 'contact_location_address' ); ?>"
					name="<?php echo ThemePileTheme::get_theme_option_name( 'contact_location_address' ); ?>"
					value="<?php echo ThemePileTheme::get_theme_option( 'contact_location_address' ); ?>">

				<div class="row__inner">
					<a
						data-themepile-google-get-location-search-submit href="#"
						data-themepile-lang-google-status="<?php _e( 'Google Maps Status:', THEMEPILE_LANGUAGE ); ?>"
						data-themepile-lang-loading="<?php _e(
							'Loading... Getting latitude and longitude',
							THEMEPILE_LANGUAGE
						); ?>"
						data-themepile-lang-success="<?php _e(
							'Ok. We have updated latitude and longitude below.<br>Not the address you need? Try again with more details.',
							THEMEPILE_LANGUAGE
						); ?>"
						data-themepile-lang-error="<?php _e(
							'Google Maps can\'t find this address.<br>Maybe other address?',
							THEMEPILE_LANGUAGE
						); ?>"
						class="themepile-google-get-location-search-submit">
						<?php _e( 'Get Lat and Lng by address?', THEMEPILE_LANGUAGE ); ?>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="themepile-google-get-location__map" data-themepile-google-get-location-map></div>
			</div>
			<div class="row">
				<input
					data-themepile-google-get-location-map-lat
					placeholder="<?php _e( 'Lat', THEMEPILE_LANGUAGE ); ?>"
					type="text"
					size="10"
					value="<?php echo ThemePileTheme::get_theme_option( 'contact_location_lat' ); ?>"
					name="<?php echo ThemePileTheme::get_theme_option_name( 'contact_location_lat' ); ?>"
					id="contact_location_lat"
					class="half">
				<input
					data-themepile-google-get-location-map-lng
					placeholder="<?php _e( 'Lng', THEMEPILE_LANGUAGE ); ?>"
					type="text"
					size="10"
					value="<?php echo ThemePileTheme::get_theme_option( 'contact_location_lng' ); ?>"
					name="<?php echo ThemePileTheme::get_theme_option_name( 'contact_location_lng' ); ?>"
					id="contact_location_lng"
					class="half">
			</div>
		</div>
	</div>
</div>

<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'pagination_type' ); ?>">
				<?php _e( 'Pagination Type', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>

		<p class="themepile__section__description">
			<?php _e( 'Choose type of pagination', THEMEPILE_LANGUAGE ); ?>
		</p>
	</div>
	<div class="themepile__section__field ">
		<?php $pagination_type = ThemePileTheme::get_theme_option( 'pagination_type' ); ?>
		<select name="<?php echo ThemePileTheme::get_theme_option_name( 'pagination_type' ); ?>"
				id="<?php echo ThemePileTheme::get_theme_option_name( 'pagination_type' ); ?>">
			<option <?php selected( 'standard', $pagination_type ); ?>
				value="standard"><?php _e( 'Standard', THEMEPILE_LANGUAGE ); ?></option>
			<option <?php selected( 'ajax', $pagination_type ); ?>
				value="ajax"><?php _e( 'Ajax', THEMEPILE_LANGUAGE ); ?></option>
		</select>
	</div>
</div>




