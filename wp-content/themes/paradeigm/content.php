<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 * Used for Gallery post format.
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

	<?php
	// Show Featured Preview
	if ( get_post_meta( $post->ID, 'hypha_featured_preview_meta', true ) ) {
		// Featured Preview Metabox
		$featured_preview = get_post_meta( get_the_ID(), 'hypha_featured_preview_meta', true );	
		if ( ! wp_oembed_get( $featured_preview ) ) {
			printf( '<div class="featured-preview">%1$s</div>', do_shortcode( $featured_preview ) );
		} else {
			printf( '<div class="featured-preview">%1$s</div>', wp_oembed_get( $featured_preview ) );
		}

	} else {
		if ( has_post_format( 'gallery' ) && get_post_gallery() && !is_single() ) {
			
			echo get_post_gallery();
			
		} else {
			// Featured Image
			if ( '' != get_the_post_thumbnail() && !is_single() ) {
				printf( '<figure><a class="featured-image" href="%1$s" title="%2$s" rel="bookmark"><div class="featured-info"><div class="info-wrapper">%3$s</div></div>%4$s</a></figure>',
					get_the_permalink(),
					esc_attr( sprintf( __( 'Permalink to %s', 'hyphatheme' ), the_title_attribute( 'echo=0' ) ) ),
					__( 'Read More', 'hyphatheme' ),
					get_the_post_thumbnail( get_the_ID(), 'block-thumb' )
				);
						
			}
		}
	}
	?>
	
	<div class="entry-container">
		<div class="entry-header">	
			<?php
			// Entry Titles
			if ( !is_single() ) { ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php } ?>
			
			<?php
			// Single Meta List / Excerpt
			if ( is_single() ) {
				printf( '<div class="entry-meta clearfix">%1$s%2$s</div>',
					get_the_category_list(),
					get_the_tag_list('<ul class="post-tags"><li>','</li><li>','</li></ul>')
				);
			}
			?>
		</div><!-- .entry-header -->
	
		<div class="entry-content">
			<?php
			if ( is_single() ) {
				the_content();
				wp_link_pages( array(
					'before' => '<span class="page-links">',
					'after' => '</span>',
					'link_before' => '<span>',
					'link_after' => '</span>'
				));
			
			} else {
				if ( strpos( $post->post_content, '<!--more-->' ) ) :
					the_content();
				else :
					the_excerpt();
				endif;	
			}
			?>
		</div><!-- .entry-content -->
		
		<div class="entry-footer">
			<?php if ( !is_single() ) {
				edit_post_link( '<i class="fa fa-edit"></i>' . __( 'Edit', 'hyphatheme' ), '<span class="edit-link">', '</span>' );
			} ?>
		</div><!-- .entry-footer -->
	</div><!-- .entry-container -->
	
</article><!-- #post-<?php the_ID(); ?> -->