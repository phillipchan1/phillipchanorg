<?php
/**
 * Display Author Card
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */
?>

	
<div id="author-info">

	<div id="author-avatar">
		<a class="author-archive" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'hypha_author_bio_avatar_size', 100 ) ); ?>
		</a>
	</div><!-- .author-avatar -->
				
	<div class="author-profile">
		<h2 class="author-title tab-title"><?php printf( __( 'About %s', 'hyphatheme' ), get_the_author() ); ?></h2>
		
		<?php if ( get_the_author_meta( 'description' ) ) : ?>
			<p class="author-description">
				<?php the_author_meta( 'description' ); ?>
			</p><!-- .author-description -->
		<?php endif; // if author has description ?>
				
		<?php if ( hypha_get_social_icons( 'author' ) ) : ?>
			<div class="author-social">
				<?php echo hypha_get_social_icons( 'author' ); ?>
			</div><!-- .author-social -->
		<?php endif; // if author has social ?>
			
	</div><!-- .author-profile -->
		
</div><!-- author-info -->
	
