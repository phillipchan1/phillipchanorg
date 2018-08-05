<?php
/**
 * The template for displaying image attachments.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */


get_header(); ?>
<section class="primary">
	<div class="content" role="main">

		<?php if ( have_posts() ) : ?>
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-meta">
							<?php
							$published_text = __( '<span class="entry-meta-item author">
								<em class="entry-meta-item-label">Return to</em>
								<a href="%3$s" title="Return to %4$s" rel="gallery">%5$s</a>
							</span>', THEMEPILE_LANGUAGE );
							$post_title = get_the_title( $post->post_parent );
							if ( empty( $post_title ) || 0 == $post->post_parent )
								$published_text = '
								<span class="attachment-meta">
									<time class="entry-date" datetime="%1$s">%2$s</time>
								</span>';

							printf( $published_text,
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() ),
								esc_url( get_permalink( $post->post_parent ) ),
								esc_attr( strip_tags( $post_title ) ),
								$post_title
							);

							$metadata = wp_get_attachment_metadata();
							printf( '<span class="entry-meta-item attachment-meta full-size-link"><a href="%1$s" title="%2$s">%3$s (%4$s &times; %5$s)</a></span>',
								esc_url( wp_get_attachment_url() ),
								esc_attr__( 'Link to full-size image', THEMEPILE_LANGUAGE ),
								__( 'Full resolution', THEMEPILE_LANGUAGE ),
								$metadata['width'],
								$metadata['height']
							);

							edit_post_link( __( 'Edit Post', THEMEPILE_LANGUAGE ), '<span class="entry-meta-item edit-link"><em class="entry-meta-item-label"><span class="scriptor-icon--gears-setting"></span></em> ', '</span>' );

							?>
						</div><!-- .entry-meta -->
					</header><!-- .entry-header -->
					<div class="entry-content">
						<p><?php theme_the_attached_image(); ?></p>
						<?php the_content(); ?>
						<nav id="image-navigation" class="navigation image-navigation" role="navigation">
							<span class="nav-previous"><?php previous_image_link( false, __( '<span class="meta-nav">&larr;</span> Previous', THEMEPILE_LANGUAGE ) ); ?></span>
							<span class="nav-next"><?php next_image_link( false, __( 'Next <span class="meta-nav">&rarr;</span>', THEMEPILE_LANGUAGE ) ); ?></span>
						</nav><!-- .image-navigation -->
					</div><!-- .entry-content -->
					<div class="entry-footer">
						<div class="entry-actions">
							<?php themepile_entry_share(); ?>
						</div><!-- .entry-actions -->
						<div class="entry-author-card">
							<div class="entry-author-card-avatar">
								<a class="entry-author-card-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), 64 ); ?>
								</a><!-- .entry-author-card-link -->
							</div><!-- .entry-author-card-avatar -->
							<div class="entry-author-card-text">
								<h4 class="entry-author-card-heading">
									<?php _e( 'Added by', THEMEPILE_LANGUAGE ) ?>
								</h4><!-- .entry-author-card-heading -->
								<h3 class="entry-author-card-name">
									<a class="entry-author-info-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
										<?php the_author(); ?>
									</a>
								</h3><!-- .entry-author-card-name -->
								<p class="entry-author-card-description">
									<?php the_author_meta( 'description' ); ?>
								</p>
								<div class="entry-author-card-additional">
									<time class="entry-author-card-additional-published"><?php echo get_the_date() ?></time>
								</div><!-- .entry-author-card-additional -->
								<?php themepile_entry_tags();  ?>
							</div><!-- .entry-author-card-text -->
						</div><!-- .entry-author-card -->
					</div><!-- .entry-footer -->
				</article><!-- #post -->

				<?php comments_template(); ?>
				<?php themepile_post_nav(); ?>

			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- .wrapper-inner -->
</section><!-- .content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>