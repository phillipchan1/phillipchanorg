<?php
/**
 * ThemePile Options
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */

if ( ! function_exists( 'themepile_option_page' ) ) {
	function themepile_option_page() {
		?>
		<div class="themepile__wrapper">
			<form action="" data-action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
				<?php do_action( 'themepile_option_page_start' ); ?>
				<div class="themepile__primary">
					<div class="themepile__sidebar">
						<div class="themepile__header">
							<?php do_action( 'themepile_option_page_head' ); ?>
						</div>
						<?php do_action( 'themepile_option_page_navigation' ); ?>
					</div>
					<div class="themepile__content">
						<?php do_action( 'themepile_option_page_content' ); ?>
					</div>
				</div>
				<div class="themepile__footer">
					<input type="submit" value="<?php _e( 'Save Changes', THEMEPILE_LANGUAGE ); ?>"
								 class="button button-primary" id="submit" name="submit">
					<input type="submit"
								 data-themepile-lang-confirm="<?php _e(
									 'Click to reset. Any settings will be lost!',
									 THEMEPILE_LANGUAGE
								 ); ?>"
								 value="<?php _e( 'Reset Options', THEMEPILE_LANGUAGE ) ?>" class="button action reset"
								 name="reset">
				</div>
			</form>
		</div>
	<?php
	}
}

if ( ! function_exists( 'themepile_option_page_start' ) ) {
	function themepile_option_page_start() {
		?>
		<input type="hidden" name="action" value="themepile_options_save">
	<?php
	}

	add_action( 'themepile_option_page_start', 'themepile_option_page_start' );
}
if ( ! function_exists( 'themepile_option_page_head' ) ) {
	function themepile_option_page_head() {
		?>
		<h2 class="themepile__theme-title">
			<?php echo ThemePileTheme::getInstance()->getName(); ?>
			<em><?php _e( 'version', THEMEPILE_LANGUAGE ); ?> <?php echo ThemePileTheme::getInstance()->getVersion(); ?></em>
		</h2>
		<ul class="themepile__header__nav">
			<li class="themepile__header__nav__item">
				<a href="http://themepile.co.uk/themes/<?php echo mb_strtolower(
					ThemePileTheme::getInstance()->getName()
				); ?>/"
					 target="_blank"><?php _e( 'Theme Description', THEMEPILE_LANGUAGE ); ?></a>
			</li>
			<li class="themepile__header__nav__item">
				<a href="http://demo.themepile.co.uk/wp/<?php echo mb_strtolower(
					ThemePileTheme::getInstance()->getName()
				); ?>/wp-content/themes/<?php echo mb_strtolower(
					ThemePileTheme::getInstance()->getName()
				); ?>/documentation.pdf"
					 target="_blank"><?php _e( 'Theme Documentation', THEMEPILE_LANGUAGE ); ?></a>
			</li>
			<li class="themepile__header__nav__item">
				<a href="http://themepile.co.uk/get-support"
					 target="_blank"><?php _e( 'Support Center', THEMEPILE_LANGUAGE ); ?></a>
			</li>

		</ul>
	<?php
	}

	add_action( 'themepile_option_page_head', 'themepile_option_page_head' );

}

if ( ! function_exists( 'themepile_option_page_navigation' ) ) {
	function themepile_option_page_navigation() {
		global $themepile_option_pages;
		foreach ( glob( THEMEPILE_FRAMEWORK_PATH . "/options/*.php", GLOB_BRACE ) as $index => $option ) {

			$option_name                          = basename( $option, '.php' );
			$themepile_option_pages[$option_name] = $option_name;
		}

		$index = 0;
		?>
		<ul class="themepile__sidebar__nav">
			<?php
			foreach ( apply_filters( 'themepile_filter_admin_menu_sort', $themepile_option_pages ) as $option_name ) {
				$index ++;
				?>
				<li class="themepile__sidebar__nav__item">
					<a href="#<?php echo strtolower( $option_name ); ?>-options" class="themepile__sidebar__nav-link">
						<?php echo ucfirst( $option_name ); ?> Options
					</a>
				</li>
			<?php
			}
			?>
		</ul>
	<?php
	}

	add_action( 'themepile_option_page_navigation', 'themepile_option_page_navigation' );

}

if ( ! function_exists( 'themepile_option_page_content' ) ) {
	function themepile_option_page_content() {
		global $themepile_option_pages;
		if ( ! is_array( $themepile_option_pages ) ) {
			return;
		}

		foreach ( $themepile_option_pages as $option ) {
			?>
			<div id="<?php echo $option; ?>-options" class="themepile__content__item"><?php
			include_once( THEMEPILE_FRAMEWORK_PATH . '/options/' . $option . '.php' );
			?></div><?php
		}
	}

	add_action( 'themepile_option_page_content', 'themepile_option_page_content' );
}