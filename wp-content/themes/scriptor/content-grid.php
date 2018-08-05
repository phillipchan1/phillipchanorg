<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */
?>

<?php
	$grid_size = get_post_meta(get_the_ID(), 'themepile-post-grid-size', true);
	//echo $grid_size;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($grid_size); ?>>
	<?php if ( has_post_thumbnail() && ! post_password_required() && !is_single() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail($grid_size); ?></a>
		</div>
	<?php endif; ?>
	<header class="entry-header">
		<div class="entry-meta">
			<?php
			$categories_list = get_the_category_list( __( ', ', THEMEPILE_LANGUAGE ) );
			if ( $categories_list ) {
				echo
					'<span class="entry-meta-item categories-links">' .
					'<span class="categories-links-list">' . $categories_list . '</span>
					</span>';
			}
			?>
		</div>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<div class="entry-meta">
			<?php if ( comments_open() && ! is_single() ) : ?>
				<span class="entry-meta-item comments-link">
				<em class="entry-meta-item-label">
					<?php comments_popup_link(
						'<span class="leave-reply">' . __( 'Leave a comment', THEMEPILE_LANGUAGE ) . '</span>',
						__( 'One comment so far', THEMEPILE_LANGUAGE ), __( 'View all % comments', THEMEPILE_LANGUAGE )
					);
					?>
				</em><!-- .entry-meta-item-label -->
			</span><!-- .comments-link -->
			<?php endif; // comments_open() ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
</article><!-- #post -->
