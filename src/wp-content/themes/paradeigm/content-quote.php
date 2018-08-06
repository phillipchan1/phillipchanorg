<?php
/**
 * The template for displaying posts in the Quote post format
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
		<div class="entry-header">	
			<?php
			// Entry Titles
			if ( is_single() ) { ?>
				<h1 class="entry-title"><i class="fa fa-quote-left"></i></h1>
			<?php } else { ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'hyphatheme' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><i class="fa fa-quote-left"></i></a></h2>
			<?php } ?>			
		</div><!-- .entry-header -->
		
		<?php if ( '' != get_the_post_thumbnail() ) { ?>
			<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>
			<div class="featured-image" style="background-image: url('<?php echo esc_url( $feat_image ); ?>')"></div>
		<?php } ?>
		
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
		
		<div class="entry-footer">
			<?php if ( !is_single() ) {
				edit_post_link( '<i class="fa fa-edit"></i>' . __( 'Edit', 'hyphatheme' ), '<span class="edit-link">', '</span>' );
			} ?>
		</div><!-- .entry-footer -->
	</div><!-- .entry-container -->
	
</article><!-- #post-<?php the_ID(); ?> -->