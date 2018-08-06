<?php if ( ! defined( 'ABSPATH' ) ) {
	die();
} ?>

<div class="themepile__section">
	<h2><?php _e( 'Styling Options', THEMEPILE_LANGUAGE ); ?></h2>
</div>

<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'cover-left' ); ?>">
				<?php _e( 'Layout', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>
		<p class="themepile__section__description">
			<?php _e( 'Layout settings', THEMEPILE_LANGUAGE ); ?>
		</p>
	</div>
	<div class="themepile__section__field ">
		<input type="hidden" name="<?php echo ThemePileTheme::get_theme_option_name( 'cover-left' ); ?>" value="0">
		<input
			type="checkbox"
			id="<?php echo ThemePileTheme::get_theme_option_name( 'cover-left' ); ?>"
			name="<?php echo ThemePileTheme::get_theme_option_name( 'cover-left' ); ?>"
			value="1"
			<?php checked( ThemePileTheme::get_theme_option( 'cover-left' ), '1' ); ?>
			>
		<label for="<?php echo ThemePileTheme::get_theme_option_name( 'cover-left' ); ?>"><?php _e('Set Cover Position to Left', THEMEPILE_LANGUAGE ); ?></label>
	</div>
	<div class="themepile__section__field ">
		<input type="hidden" name="<?php echo ThemePileTheme::get_theme_option_name( 'sidebar-right' ); ?>" value="0">
		<input
			type="checkbox"
			id="<?php echo ThemePileTheme::get_theme_option_name( 'sidebar-right' ); ?>"
			name="<?php echo ThemePileTheme::get_theme_option_name( 'sidebar-right' ); ?>"
			value="1"
			<?php checked( ThemePileTheme::get_theme_option( 'sidebar-right' ), '1' ); ?>
			>
		<label for="<?php echo ThemePileTheme::get_theme_option_name( 'sidebar-right' ); ?>"><?php _e('Set Sidebar Position to Right', THEMEPILE_LANGUAGE ); ?></label>
	</div>
	<div class="themepile__section__field ">
		<input type="hidden" name="<?php echo ThemePileTheme::get_theme_option_name( 'post-two-column' ); ?>" value="0">
		<input
			type="checkbox"
			id="<?php echo ThemePileTheme::get_theme_option_name( 'post-two-column' ); ?>"
			name="<?php echo ThemePileTheme::get_theme_option_name( 'post-two-column' ); ?>"
			value="1"
			<?php checked( ThemePileTheme::get_theme_option( 'post-two-column' ), '1' ); ?>
			>
		<label for="<?php echo ThemePileTheme::get_theme_option_name( 'post-two-column' ); ?>"><?php _e('Set two column layout for post content', THEMEPILE_LANGUAGE ); ?></label>
	</div>
	<div class="themepile__section__field ">
		<input type="hidden" name="<?php echo ThemePileTheme::get_theme_option_name( 'sidebar-none' ); ?>" value="0">
		<input
			type="checkbox"
			id="<?php echo ThemePileTheme::get_theme_option_name( 'sidebar-none' ); ?>"
			name="<?php echo ThemePileTheme::get_theme_option_name( 'sidebar-none' ); ?>"
			value="1"
			<?php checked( ThemePileTheme::get_theme_option( 'sidebar-none' ), '1' ); ?>
			>
		<label for="<?php echo ThemePileTheme::get_theme_option_name( 'sidebar-none' ); ?>"><?php _e('Hide Sidebar', THEMEPILE_LANGUAGE ); ?></label>
	</div>
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'cover_image' ); ?>">
				<?php _e( 'Cover Image', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>

		<p class="themepile__section__description">
			<?php _e( 'Upload a cover image.', THEMEPILE_LANGUAGE ); ?>
		</p>
	</div>
	<div class="themepile__section__field themepile__section__field_type_file"
		 data-themepile-plugin="themepile-wp-uploader">
		<div data-themepile-wp-uploader-container class="themepile-wp-uploader__image">
			<?php
			$cover_image = ThemePileTheme::get_theme_option( 'cover_image' );
			if ( $cover_image ) {
				echo "<img src='" . $cover_image . "'>";
			}
			?>
		</div>
		<input class="regular-text"
			   placeholder="<?php _e(
				   'Upload image, or specify the image address of your image',
				   THEMEPILE_LANGUAGE
			   ); ?>"
			   data-themepile-wp-uploader-input type="text"
			   id="<?php echo ThemePileTheme::get_theme_option_name( 'cover_image' ); ?>"
			   name="<?php echo ThemePileTheme::get_theme_option_name( 'cover_image' ); ?>"
			   value="<?php echo $cover_image; ?>">

		<p class="description"><?php printf( __( 'Recommended size: %s', THEMEPILE_LANGUAGE ), '1600x800' ); ?></p>
		<a data-themepile-wp-uploader-button class="button themepile-upload-button"
		   href="#"><?php _e( 'Add Image', THEMEPILE_LANGUAGE ); ?></a>
		<a data-themepile-wp-uploader-remove class="button" href="#"><?php _e( 'Remove', THEMEPILE_LANGUAGE ); ?></a>
	</div>
	<!-- .themepile__section__field -->
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title">
			<label for="<?php echo ThemePileTheme::get_theme_option_name( 'error_image' ); ?>">
				<?php _e( 'Image for Error 404', THEMEPILE_LANGUAGE ); ?>
			</label>
		</h3>
		<p class="themepile__section__description">
			<?php _e( 'Upload a image for error 404 page.', THEMEPILE_LANGUAGE ); ?>
		</p>
	</div>
	<div class="themepile__section__field themepile__section__field_type_file"
		 data-themepile-plugin="themepile-wp-uploader">
		<div data-themepile-wp-uploader-container class="themepile-wp-uploader__image">
			<?php
			$error_image = ThemePileTheme::get_theme_option( 'error_image' );
			if ( $error_image ) {
				echo "<img src='" . $error_image . "'>";
			}
			?>
		</div>
		<input class="regular-text"
			   placeholder="<?php _e(
				   'Upload image, or specify the image address of your image',
				   THEMEPILE_LANGUAGE
			   ); ?>"
			   data-themepile-wp-uploader-input type="text"
			   id="<?php echo ThemePileTheme::get_theme_option_name( 'error_image' ); ?>"
			   name="<?php echo ThemePileTheme::get_theme_option_name( 'error_image' ); ?>"
			   value="<?php echo $error_image; ?>">

		<p class="description"><?php printf( __( 'Recommended size: %s', THEMEPILE_LANGUAGE ), '1600x800' ); ?></p>
		<a data-themepile-wp-uploader-button class="button themepile-upload-button"
		   href="#"><?php _e( 'Add Image', THEMEPILE_LANGUAGE ); ?></a>
		<a data-themepile-wp-uploader-remove class="button" href="#"><?php _e( 'Remove', THEMEPILE_LANGUAGE ); ?></a>
	</div>
	<!-- .themepile__section__field -->
</div>
<div class="themepile__section">
	<div class="themepile__section__left">
		<h3 class="themepile__section__title"><label
				for="<?php echo ThemePileTheme::get_theme_option_name( 'custom_css' ); ?>">Custom CSS</label>
		</h3>

		<p class="themepile__section__description"><?php _e(
				'Quickly add some CSS to your theme by adding it to this block.',
				THEMEPILE_LANGUAGE
			); ?></p>
	</div>
	<div class="themepile__section__field ">
		<textarea class="large-text code" rows="10"
				  id="<?php echo ThemePileTheme::get_theme_option_name( 'custom_css' ); ?>"
				  name="<?php echo ThemePileTheme::get_theme_option_name(
					  'custom_css',
					  true
				  ); ?>"><?php echo ThemePileTheme::get_theme_option( 'custom_css' ); ?></textarea>
	</div>
</div>


