<?php
/**
 * The template for displaying posts in the Aside post format
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-postid="<?php the_ID(); ?>">

	<?php 
	// Show Post Format Icon
	if ( is_sticky() && !is_single() ) {
		printf( '<div class="post-format-icon"><a href="%1$s" title="%2$s"><i class="fa %3$s"></i></a></div><!-- .post-format-icon -->',
			get_the_permalink(),
			esc_attr( sprintf( __( 'Permalink to %s', 'hyphatheme' ), the_title_attribute( 'echo=0' ) ) ),
			'fa-thumb-tack'
		);
	}
	?>
	
	<div class="entry-container">
		<?php if ( is_single() ) { ?>
			<div class="entry-header">	
				<?php
				// Single Meta List / Excerpt
				printf( '<div class="entry-meta clearfix">%1$s%2$s</div>',
					get_the_category_list(),
					get_the_tag_list('<ul class="post-tags"><li>','</li><li>','</li></ul>')
				);
				?>
			</div><!-- .entry-header -->
		<?php } ?>
		
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
		
		<div class="entry-footer">
			<?php
			// Entry Titles
			if ( !is_single() ) { ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'hyphatheme' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><i class="fa fa-pencil"></i><?php the_title(); ?></a></h2>
			<?php } ?>
				
			<?php if ( !is_single() ) {
				edit_post_link( '<i class="fa fa-edit"></i>' . __( 'Edit', 'hyphatheme' ), '<span class="edit-link">', '</span>' );
			} ?>
		</div><!-- .entry-footer -->
	</div><!-- .entry-container -->
	
</article><!-- #post-<?php the_ID(); ?> -->