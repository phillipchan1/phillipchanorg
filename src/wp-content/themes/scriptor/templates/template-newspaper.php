<?php
$grid_args = array(
	'posts_per_page' => 9,
	'meta_query' => array(
		array(
			'key' => '_thumbnail_id',
			'compare' => 'EXISTS'
		),
	)
);
$key = 0;
$grid_query = new WP_Query( $grid_args ); ?>
<?php if ( $grid_query->have_posts() ) : $grid_size_sep = 0;?>
	<div class="posts-grid">
		<div class="posts-grid-wrapper">
			<?php while ( $grid_query->have_posts() ) : $grid_query->the_post(); $key++;?>
			<?php get_template_part( 'content', 'grid' );  ?>
			<?php
			$grid_size = get_post_meta(get_the_ID(), 'themepile-post-grid-size', true);
			$grid_size_int = (int) str_replace('themepile-post-grid-size-x', '', $grid_size);
			$grid_size_sep+=$grid_size_int;
			$grid_size_int_next = 0;
			if (isset($grid_query->posts[$key])) {
				$grid_size_next = get_post_meta($grid_query->posts[$key]->ID, 'themepile-post-grid-size', true);
				$grid_size_int_next = (int) str_replace('themepile-post-grid-size-x', '', $grid_size_next);
			}

			if ($grid_size_sep >= 6 || ($grid_size_sep + $grid_size_int_next) > 6) : ?>
			<?php $grid_size_sep=0; ?>
		</div><div class="posts-grid-wrapper">
			<?php endif; ?>

			<?php endwhile; ?>
		</div>
	</div>
<?php else:  ?>
	<?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>