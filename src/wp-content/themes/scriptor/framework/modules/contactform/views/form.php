<?php if ( ! defined( 'ABSPATH' ) ) {
	die();
} ?>
<form method="post" class="form contact-form" action="#">
	<?php $form->before_inputs(); ?>
	<?php if ( ! $form->getResult() && sizeof( $_POST ) != 0 ) : ?>
		<div class="modularis-alert modularis-alert--error">
			<?php echo __('Sorry , but we can\'t send email, please try later', THEMEPILE_LANGUAGE); ?>
		</div>
	<?php elseif ( $form->getResult() && sizeof( $_POST ) != 0 ): ?>
		<div class="modularis-alert modularis-alert--success">
		<?php echo __('Email has been sent. Thank You.', THEMEPILE_LANGUAGE); ?>
		</div>
	<?php endif; ?>
	<?php foreach ( $form->getInputs() as $input ): ?>
		<p class="form-row">
			<?php
				extract( $input );
				$form->render_input( $type, $name, $placeholder, $validate );
				unset( $type, $name, $placeholder, $validate );
			?>
		</p>
	<?php endforeach; ?>
	<?php $form->after_inputs(); ?>
	<p class="form-row">
		<button type="submit"><?php echo __( 'Submit', THEMEPILE_LANGUAGE ); ?></button>
	</p>
</form>