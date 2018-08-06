<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-postid="<?php the_ID(); ?>">

	<?php 
	// Show Post Format Icon
	if ( !is_single() ) {
		printf( '<div class="post-format-icon"><a href="%1$s" title="%2$s"><i class="fa %3$s"></i></a></div><!-- .post-format-icon -->',
			get_the_permalink(),
			esc_attr( sprintf( __( 'Permalink to %s', 'hyphatheme' ), the_title_attribute( 'echo=0' ) ) ),
			is_sticky() ? 'fa-thumb-tack' : 'fa-link'
		);
	}
	?>

	<?php
	// Grab first link from content and use it for the featured image permalink
	$get_post_link = get_the_permalink();
	if ( preg_match( '/<a (.+?)>/', get_the_content(), $match ) ) {
		$link = array();
		foreach ( wp_kses_hair( $match[1], array( 'http' ) ) as $attr ) {
			$link[$attr['name']] = $attr['value'];
		}
		$get_post_link = $link['href'];
	}

	// Show Featured Image
	if ( '' != get_the_post_thumbnail() && !is_single() ) {
		printf( '<figure><a class="featured-image" href="%1$s" rel="bookmark"><div class="featured-info"><div class="info-wrapper">%2$s</div></div>%3$s</a></figure>',
			esc_url( $get_post_link ),
			get_the_title(),
			get_the_post_thumbnail( get_the_ID(), 'block-thumb' )
		);
	}
	?>
	
	<div class="entry-container">
		
		<?php if ( !is_single() && '' == get_the_post_thumbnail() ) { ?>
			<h2 class="entry-title"><a href="<?php echo esc_url( $get_post_link ) ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php } ?>
		
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
		<?php } ?>
		
		<div class="entry-footer">
			<?php if ( !is_single() ) {
				edit_post_link( '<i class="fa fa-edit"></i>' . __( 'Edit', 'hyphatheme' ), '<span class="edit-link">', '</span>' );
			} ?>
		</div><!-- .entry-footer -->
	</div><!-- .entry-container -->
	
</article><!-- #post-<?php the_ID(); ?> -->