<?php
/**
 * Template-tags
 *
 * @package Olivia
 */

if ( ! function_exists( 'the_archive_title' ) ) :
	/**
	 * Shim for `the_archive_title()`.
	 *
	 * Display the archive title based on the queried object.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param string $before Optional. Content to prepend to the title. Default empty.
	 * @param string $after  Optional. Content to append to the title. Default empty.
	 */
	function the_archive_title( $before = '', $after = '' ) {
		if ( is_category() ) {
			$title = sprintf( esc_html__( 'Category: %s', 'olivia' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( esc_html__( 'Tag: %s', 'olivia' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( esc_html__( 'Author: %s', 'olivia' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Year: %s', 'olivia' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'olivia' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Month: %s', 'olivia' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'olivia' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Day: %s', 'olivia' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'olivia' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = esc_html_x( 'Asides', 'post format archive title', 'olivia' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = esc_html_x( 'Galleries', 'post format archive title', 'olivia' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = esc_html_x( 'Images', 'post format archive title', 'olivia' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = esc_html_x( 'Videos', 'post format archive title', 'olivia' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = esc_html_x( 'Quotes', 'post format archive title', 'olivia' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = esc_html_x( 'Links', 'post format archive title', 'olivia' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = esc_html_x( 'Statuses', 'post format archive title', 'olivia' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = esc_html_x( 'Audio', 'post format archive title', 'olivia' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = esc_html_x( 'Chats', 'post format archive title', 'olivia' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( esc_html__( 'Archives: %s', 'olivia' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( esc_html__( '%1$s: %2$s', 'olivia' ), $tax->labels->singular_name, single_term_title( '', false ) );
		} else {
			$title = esc_html__( 'Archives', 'olivia' );
		}

		/**
		 * Filter the archive title.
		 *
		 * @param string $title Archive title to be displayed.
		 */
		$title = apply_filters( 'get_the_archive_title', $title );
		if ( ! empty( $title ) ) {
			echo $before . $title . $after;  // WPCS: XSS OK.
		}
	}
endif;


if ( ! function_exists( 'the_archive_description' ) ) :
	/**
	 * Shim for `the_archive_description()`.
	 *
	 * Display category, tag, or term description.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param string $before Optional. Content to prepend to the description. Default empty.
	 * @param string $after  Optional. Content to append to the description. Default empty.
	 */
	function the_archive_description( $before = '', $after = '' ) {

		$description = apply_filters( 'get_the_archive_description', term_description() );

		if ( ! empty( $description ) ) {
			/**
			 * Filter the archive description.
			 *
			 * @see term_description()
			 *
			 * @param string $description Archive description to be displayed.
			 */
			echo $before . $description . $after;  // WPCS: XSS OK.
		}
	}
endif;


/**
 * Display the author description on author archive
 */
function the_author_archive_description( $before = '', $after = '' ) {

	$author_description  = get_the_author_meta( 'description' );

	if ( ! empty( $author_description ) ) {
		/**
		 * Get the author bio
		 */
		echo $author_description;
	}
}


/**
 * Site title and logo
 */
function at_olivia_title_logo() {
?>	
	
	<?php if( get_theme_mod( 'at_olivia_opt_site_logo' ) === 1) { ?>
		<div class="site-title-wrap round-logo">
	<?php } else { ?>
		<div class="site-title-wrap">
	<?php } // end if ?>
		
		<!-- Use the Site Logo feature, if supported -->
		<?php if ( function_exists( 'jetpack_the_site_logo' ) && jetpack_has_site_logo() ) {

			echo '<div class="has-avatar" data-avatar="true">';
			jetpack_the_site_logo();
			echo '</div>';

		} else {
			// Use the standard Customizer logo
			$logo = get_theme_mod( 'at_olivia_customizer_logo' );
			if ( ! empty( $logo ) ) {
				echo '<div class="has-avatar" data-avatar="true">';
				if ( is_front_page() && is_home() ) { ?>
					<h1 class="site-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
					</h1>
	 			<?php } else { ?>
					<p class="site-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
					</p>
	 			<?php }
	 			echo '</div>';
			}
		} ?>
			
		<?php if( get_theme_mod( 'at_olivia_hide_site_title' ) === 0) { ?>
			<div class="titles-wrap">
				<?php if ( is_front_page() && is_home() ) { ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	 			<?php } else { ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
	 			<?php } ?>
			</div>
		<?php } // end if ?>
	</div><!-- .site-title-wrap -->
<?php }

/**
 * Site Description
 */
function at_olivia_site_desc() {
?>
	<div class="site-description">
		<?php if ( get_bloginfo( 'description' ) ) { ?>
			<p><?php bloginfo( 'description' ); ?></p>
		<?php } ?>
	</div>
<?php }

/**
 * Custom comment output
 */
function at_olivia_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>


<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID() ?>">

	<div class="row">

		<div class="comment-block" id="comment-<?php comment_ID(); ?>">

			<div class="comment-wrap">

				<div class="col col--10-of-12 col--am">

					<div class="comment-content">
						<cite class="comment-cite">
						    <?php comment_author_link() ?>
						</cite>

						<?php comment_text() ?>

						<div class="row">
							<div class="col col--6-of-12 col--am">
								<p class="reply">
									<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
								</p>
							</div>
							<div class="col col--6-of-12 col--am">
								<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( esc_html__( '%1$s at %2$s', 'olivia' ), get_comment_date(),  get_comment_time() ); ?></a>
								<?php edit_comment_link( esc_html__( '(Edit)', 'olivia' ), '&nbsp;', '' ); ?>
							</div>
						</div>

					</div>

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'olivia' ) ?></em>
					<?php endif; ?>

				</div><!-- .col -->

				<div class="col col--2-of-12 col--am">

					<?php echo get_avatar( $comment->comment_author_email, 60 ); ?>

				</div><!-- .col -->

			</div>
		</div>

	</div><!-- .row -->
<?php
}


/**
 * Modify title reply text to add span
 */
function comment_reform ( $arg ) {
	$arg['title_reply'] = '<span>' . esc_html__( 'Leave a reply', 'olivia' ) . '</span>';
	return $arg;
}
add_filter( 'comment_form_defaults', 'comment_reform' );


/**
 * Add grid for comment
 */
function at_olivia_comment_form_before() {
	echo '<div class="col col--push-3-of-12">';
}
add_action( 'comment_form_before', 'at_olivia_comment_form_before' );

/**
 * Close div for comment
 */
function at_olivia_comment_form_after() {
	echo '</div>';
}
add_action( 'comment_form_after', 'at_olivia_comment_form_after' );


/**
 * Author list
 */
function at_olivia_author_list() {

	// Get all users order by amount of posts.
	$users = get_users( 'orderby=post_count&order=DESC&who=authors&number=4' );

	echo '<aside class="author-widget">';

	echo '<ul class="author-list">';

	foreach ( $users as $user ) {
		$user_post_count = count_user_posts( $user->ID );
		if ( $user_post_count > 0 ) { ?>
			<li>
				<?php echo get_avatar( $user->user_email, '50' ); ?>

				<div class="author-drawer-text">
					<h2 class="author-drawer-name"><?php echo esc_html( $user->display_name ); ?></h2>

					<?php if ( $user->description ) { ?>
						<div class="author-drawer-desc"><?php echo esc_html( get_user_meta( $user->ID, 'description', true ) ); ?></div>
					<?php } ?>

					<div class="author-drawer-links">
						<a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>"><?php esc_html_e( 'View All Posts', 'olivia' ); ?></a>

						<?php if( ! empty( $user->user_url ) ) {
							printf( '<a href="%s">%s</a>', $user->user_url, 'Website', 'olivia' );
						} ?>
					</div><!-- .author-drawer-links -->
				</div><!-- .author-drawer-text -->
			</li><!-- .author-drawer -->
		<?php }
	}
	echo '</ul></aside>';
}


/**
 * Next/previous post links
 */
function at_olivia_post_navigation() { ?>

	<!-- Next and previous post links -->
	<?php $nextPost = get_next_post();

	$prevPost = get_previous_post();

	if ( $nextPost || $prevPost ) { ?>

		<nav class="post-navigation">
			<?php
				if( $prevPost ) {
					echo '<div class="overflow-link">';
						previous_post_link( '%link', '<span class="icon-arrow-right"></span>' );
					echo '</div>';
			} ?>

			<?php
				if( $nextPost ) {
					echo '<div class="overflow-link">';
						next_post_link( '%link', '<span class="icon-arrow-left"></span>' );
					echo '</div>';
			} ?>
		</nav><!-- .post-navigation -->
	<?php }
}

/**
 * Displays post pagination links
 *
 * @since olivia 1.0
 */
function at_olivia_page_navs() {
	$prev_link = get_previous_posts_link(__('<span class="page-prev icon-arrow-left"></span>', 'olivia'));
	$next_link = get_next_posts_link(__('<span class="page-next icon-arrow-right"></span>', 'olivia'));
	// as suggested in comments
	if ($prev_link || $next_link) {
	  echo '<div class="navigation">';
	  if ($next_link){
	    echo $next_link;
	  }
	  if ($prev_link){
	    echo $prev_link;
	  }
	  echo '</div>';
	}
}

/**
 * Output categories for the hero header
 *
 * * @since olivia 1.0
 */
function at_olivia_hero_cats() {
	global $post;

	$categories = get_the_category( $post->ID );

	if ( $categories ) {
		// Limit the number of categories output to 3 to keep things tidy
		$i = 0;

		echo '<div class="hero-cats">';
			foreach( ( get_the_category( $post->ID ) ) as $cat ) {
				echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a>';
				if ( ++$i == 3 ) {
					break;
				}
			}
		echo '</div>';
	}
}



/**
 * Author post
 */
function at_olivia_author_box() {
	global $post, $current_user;
	$author = get_userdata( $post->post_author );
	?>

	<div class="author-profile-wrap">
		<div class="row">

			<div class="col col--3-of-12">
				<h3 class="author-profile-title">
					<?php if ( is_archive() ) { ?>
						<?php esc_html_e( 'All posts by', 'olivia' ); ?>
					<?php } else { ?>
						<?php esc_html_e( 'Posted by', 'olivia' ); ?>
					<?php } ?>
					<?php echo esc_html( get_the_author() ); ?>
				</h3>
			</div>

			<div class="col col--9-of-12">

				<div class="row">
					<div class="col col--10-of-12 col--am">
						
						<div class="author-profile">
							<div class="author-profile-info">

								<?php if ( empty( $author->description ) && $post->post_author == $current_user->ID ) { ?>	

									<div class="author-description">
										<p>
										<?php
											$profileString = sprintf( wp_kses( __( 'Complete your author profile info to be shown here. <a href="%1$s">Edit your profile &rarr;</a>', 'olivia' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'profile.php' ) ) );
											echo $profileString;
										?>
										</p>
									</div>
								<?php } else if ( $author->description ) { ?>
									
									<div class="author-description">
										<p><?php the_author_meta( 'description' ); ?></p>
									</div>
								<?php } ?>

								<div class="author-profile-links">
									<a href="<?php echo get_author_posts_url( $author->ID ); ?>"><i class="fa fa-arrow-circle-o-right"></i> <?php esc_html_e( 'All Posts', 'olivia' ); ?></a>

									<?php if ( $author->user_url ) { ?>
										<?php printf( '<a href="%s"><i class="fa fa-arrow-circle-o-right"></i> %s</a>', $author->user_url, 'Website', 'olivia' ); ?>
									<?php } ?>
								</div>

							</div><!-- .author-profile-info -->
						</div><!-- .author-profile -->
					</div>
					<div class="col col--2-of-12 col--am">
						<a class="author-profile-avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr_e( 'Posts by', 'olivia' ); ?> <?php the_author(); ?>">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'at_olivia_author_bio_avatar_size', 80 ) ); ?>
						</a>
					</div><!-- .col -->
				</div><!-- .row -->

			</div><!-- .col -->
		</div><!-- .row -->
	</div><!-- .author-profile-wrap -->

	<?php
	// Add Jetpack related posts if enabled.
	if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
	    echo do_shortcode( '[jetpack-related-posts]' );
	}
}
