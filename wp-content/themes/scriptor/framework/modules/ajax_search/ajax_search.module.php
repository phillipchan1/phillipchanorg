<?php
if ( ! function_exists( 'themepile_ajax_search' ) ) :
	function themepile_ajax_search() {
		if ( isset( $_REQUEST['s'] ) ) {
			$search_query = new WP_Query( array(
				's'              => $_REQUEST['s'],
				'posts_per_page' => 50,
				'no_found_rows'  => true,
			) );

			$results = array();
			if ( $search_query->get_posts() ) {
				foreach ( $search_query->get_posts() as $the_post ) {
					$title     = get_the_title( $the_post->ID );
					$results[] = array(
						'title'  => $title,
						'format'    => get_post_format( $the_post->ID ),
						'url'    => get_permalink( $the_post->ID ),
						'date'    => $the_post->post_date,
						'content'    => substr(strip_tags($the_post->post_content), 0 , 120) . '...',
						'format_date'    => mysql2date(get_option('date_format'),$the_post->post_date),
						'author_display_name'    => get_the_author_meta( 'display_name', $the_post->post_author ),
						'author_url'    =>  get_author_posts_url(  $the_post->post_author ),
						'tokens' => explode( ' ', $title ),
					);
				}
			}
			else {
				$results = array('not_found' => __( 'Sorry. No results match your search.', THEMEPILE_LANGUAGE ));
			}
			wp_reset_postdata();
			wp_send_json_success($results);
		}
	}
endif;

if ( ! function_exists( 'themepile_ajax_search_enqueue_scripts' ) ) :
	function themepile_ajax_search_enqueue_scripts () {
		wp_register_script( 'jquery.modularis.ajax.search', THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.ajax.search.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'jquery.modularis.ajax.search' );
	}
endif;

add_action( 'wp_ajax_nopriv_themepile_ajax_search', 'themepile_ajax_search' );
add_action( 'wp_ajax_themepile_ajax_search', 'themepile_ajax_search' );
add_action( 'wp_enqueue_scripts', 'themepile_ajax_search_enqueue_scripts' );
