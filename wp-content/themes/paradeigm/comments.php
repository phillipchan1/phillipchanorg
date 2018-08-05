<?php
/**
 * The template for displaying Comments
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
 
if ( post_password_required() )
	return;
?>

<div id="comments">
	<div class="comments-inside">
	
		<?php if ( have_comments() ) : ?>
			<h3 id="comments-title" class="tab-title">
				<?php
				printf( _n( '1 Comment on <span>"%2$s"</span>', '%1$s Comments on <span>"%2$s"</span>', get_comments_number(), 'hyphatheme' ),
					number_format_i18n( get_comments_number() ),
					get_the_title()
				);
				?>
			</h3>
		<?php endif; // Checks whether there are any comments to loop over  ?>
		
		<?php if ( get_comments_number() ) : ?>
			<ol class="commentlist clearfix">
				<?php wp_list_comments("callback=hypha_get_comment"); ?>
			</ol>
		<?php endif; // Show if there are comments ?>
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through? ?>
			<nav id="comment-nav-below" role="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'hyphatheme' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'hyphatheme' ) ); ?></div>
			</nav>
		<?php endif; // Checks for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.' , 'hyphatheme' ); ?></p>
		<?php endif; // Checks if comments are allowed for the current post ?>

		<?php comment_form(); ?>
		
	</div><!-- .comments-inside -->
</div><!-- #comments -->