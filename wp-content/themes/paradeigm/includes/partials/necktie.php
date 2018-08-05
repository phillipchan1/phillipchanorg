<?php
/**
 * Display Necktie
 *
 * Shows the section above the main content
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */

if ( is_home() ) :
	printf( '<div class="necktie"><div class="loader-icon"></div><i class="fa fa-caret-down"></i><h3>%1$s</h3>%2$s</div>',
		get_option( 'hypha_customizer_posts_page_text' ) ? get_option( 'hypha_customizer_posts_page_text' ) : __( 'Latest Articles', 'hyphatheme' ),
		is_active_sidebar( 'sidebar' ) ? '<a href="#" id="sidebar-toggle"><i class="fa fa-bars"></i></a>' : ''
	);
		
elseif ( is_search() ):
	printf( '<div class="necktie"><div class="loader-icon"></div><i class="fa fa-caret-down"></i><h3>' );
	printf( _n( '1 Result', '%1$s Results', $wp_query->found_posts, 'hyphatheme' ),
		number_format_i18n( $wp_query->found_posts )
	);
	printf( '</h3>%1$s</div>',
		is_active_sidebar( 'sidebar' ) ? '<a href="#" id="sidebar-toggle"><i class="fa fa-bars"></i></a>' : ''
	);

elseif ( is_archive() ) :
	printf( '<div class="necktie"><div class="loader-icon"></div><i class="fa fa-caret-down"></i><h3>' );
	printf( _n( '1 Post', '%1$s Posts', $wp_query->found_posts, 'hyphatheme' ),
		number_format_i18n( $wp_query->found_posts )
	);
	printf( '</h3>%1$s</div>',
		is_active_sidebar( 'sidebar' ) ? '<a href="#" id="sidebar-toggle"><i class="fa fa-bars"></i></a>' : ''
	);
	
endif;
?>