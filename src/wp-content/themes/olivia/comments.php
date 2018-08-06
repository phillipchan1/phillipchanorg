<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Olivia
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>


<div id="comments" class="comments-area">
	<div class="row">

	<?php if ( have_comments() ) : ?>
		<div class="col col--3-of-12">

			<h3 class="comments-title">
				<?php
					$comments_number = get_comments_number();
					if ( 1 === $comments_number ) {
						/* translators: %s: post title */
						printf( _x( 'One comment', 'comments title', 'olivia' ) );
					} else {
						printf(
							/* translators: 1: number of comments, 2: post title */
							_nx(
								'%1$s comment',
								'%1$s comments',
								$comments_number,
								'comments title',
								'olivia'
							),
							number_format_i18n( $comments_number )
						);
					}
				?>
			</h3>

		</div><!-- .col -->

		<div class="col col--9-of-12">

			<?php the_comments_navigation(); ?>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 60,
						'callback'    => 'at_olivia_comment'
					) );
				?>
			</ol><!-- .comment-list -->

			<?php the_comments_navigation(); ?>

		</div><!-- .col -->

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<div class="col col--push-3-of-12">
			<p class="no-comments"><?php _e( 'Comments are closed.', 'olivia' ); ?></p>
		</div><!-- .col -->
	<?php endif; ?>

	<?php
		comment_form( array(
			'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h3>',
		) );
	?>

</div><!-- .comments-area -->
