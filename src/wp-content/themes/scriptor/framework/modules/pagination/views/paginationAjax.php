<div class="themepile-pagination modularis-pagination modularis-pagination--ajax" <?php if ( $pagination->countPages == 1 ): ?>style="display: none;"<?php endif?>>
	<a class="modularis-button modularis-button--link" href="<?php echo $pagination->getNextLink() ?>"
		 data-themepile-lang-loading="<?php echo __( 'Loading', THEMEPILE_LANGUAGE ) ?>"
		 data-themepile-lang-loaded="<?php echo __( 'Load More', THEMEPILE_LANGUAGE ) ?>"
		 data-page="<?php echo ( $pagination->currentPage + 1 ) ?>"
		 data-type="<?php echo $pagination->postType ?>"
		 data-term="<?php echo $pagination->term ?>"
		 data-taxonomy="<?php echo $pagination->taxonomy ?>">
		<?php echo __( 'Load More', THEMEPILE_LANGUAGE ) ?>
	</a>
</div>