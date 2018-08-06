<?php
/**
 * The default template for displaying page content
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

<article id="page-<?php the_ID(); ?>" <?php post_class(); ?> data-postid="<?php the_ID(); ?>">
						
	<div class="entry-container">
		
		<div class="entry-content">
			<?php
			the_content();
			wp_link_pages( array(
				'before' => '<span class="page-links">',
				'after' => '</span>',
				'link_before' => '<span>',
				'link_after' => '</span>'
			));
			?>
		</div><!-- .entry-content -->
		
		<div class="entry-footer">
			<?php edit_post_link( '<i class="fa fa-edit"></i>' . __( 'Edit', 'hyphatheme' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-footer -->
	</div><!-- .entry-container -->
						
</article><!-- #page-<?php the_ID(); ?> -->