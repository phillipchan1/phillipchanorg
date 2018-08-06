<div class="themepile-pagination modularis-pagination modularis-pagination--default">
	<ol class="modularis-pagination__list">
		<li class="modularis-pagination-list-item modularis-pagination-list-item--prev">
			<?php if ( $pagination->currentPage > 1 ): ?>
				<a href="<?php echo $pagination->getPrevLink() ?>"><?php echo __( 'Prev', THEMEPILE_LANGUAGE ) ?></a>
			<?php else: ?>
				<span><?php echo __( 'Prev', THEMEPILE_LANGUAGE ) ?> </span>
			<?php endif?>
		</li>
		<?php for ( $i = $pagination->getStartVisiblePage(); $i <= $pagination->getEndVisiblePage(); $i ++ ): ?>
			<?php if ( $i == $pagination->currentPage ): ?>
				<li class="modularis-pagination-list-item modularis-pagination-list-item--current">
					<span><?php echo $i ?></span>
				</li>
			<?php else: ?>
				<li class="modularis-pagination-list-item">
					<a href="<?php echo esc_url( get_pagenum_link( $i ) ) ?>"><?php echo $i ?></a>
				</li>
			<?php endif ?>
		<?php endfor?>
		<li class="modularis-pagination-list-item modularis-pagination-list-item--next">
			<?php if ( $pagination->currentPage < $pagination->countPages ): ?>
				<a href="<?php echo $pagination->getNextLink() ?>"><?php echo __( 'Next', THEMEPILE_LANGUAGE ) ?></a>
			<?php else: ?>
				<span><?php echo __( 'Next', THEMEPILE_LANGUAGE ) ?></span>
			<?php endif?>
		</li>
	</ol>
</div>