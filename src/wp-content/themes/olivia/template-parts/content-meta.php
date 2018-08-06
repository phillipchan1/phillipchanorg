<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Olivia
 */

// Get the post tags
$post_tags = get_the_tags();
?>
	
<?php if ( is_single() && ( has_category() || $post_tags ) ) { ?>
	<div class="entry-meta">
		<ul class="meta-list">
			<!-- Categories -->
			<?php if ( has_category() ) { ?>

				<li class="meta-cat">
					<span><?php _e( 'Posted in:', 'olivia' ); ?></span>

					<?php the_category( ', ' ); ?>
				</li>

			<?php } ?>

			<!-- Tags -->
			<?php if ( $post_tags ) { ?>

				<li class="meta-tag">
					<?php
					if( $tags = get_the_tags() ) {
						foreach( $tags as $tag ) {
							$sep = ( $tag === end( $tags ) ) ? '' : ', ';
							echo '<a href="' . get_term_link( $tag, $tag->taxonomy ) . '">#' . $tag->name . '</a>' . $sep;
						}
					} 
					?>
				</li>

			<?php } ?>

		</ul><!-- .meta-list -->
	</div><!-- .entry-meta -->
<?php } ?>

<?php if ( function_exists( 'sharing_display' ) ) { ?>
	<div class="share-icons">
		<?php echo sharing_display(); ?>
	</div>
<?php } ?>
