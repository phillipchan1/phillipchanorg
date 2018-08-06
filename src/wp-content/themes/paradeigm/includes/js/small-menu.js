/**
 * Handles toggling the main navigation menu for small screens.
 */
jQuery( document ).ready( function( $ ) {
	var $masthead = $( '.headcap' ),
	    timeout = false;

	$.fn.smallMenu = function() {
		$masthead.find( '.site-navigation' ).removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
		$masthead.find( '.site-navigation h1' ).removeClass( 'assistive-text' ).addClass( 'menu-toggle' );

		$( '.menu-toggle' ).unbind( 'click' ).click( function() {
			$masthead.find( '.menu' ).slideToggle(200);
			$( this ).toggleClass( 'toggled-on' );
			$('.menu-search').toggle();
		} );
	};
	
	// Check viewport width on first load.
	if ( $("#media-query").css( "max-width" ) == "764px" ) {
		$.fn.smallMenu();
	}

	// Check viewport width when user resizes the browser window.
	$( window ).resize( function() {

		if ( false !== timeout )
			clearTimeout( timeout );

		timeout = setTimeout( function() {
			if ( $("#media-query").css( "max-width" ) == "764px" ) {
				$.fn.smallMenu();
			} else {
				$masthead.find( '.site-navigation' ).removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
				$masthead.find( '.site-navigation h1' ).removeClass( 'menu-toggle' ).addClass( 'assistive-text' );
				$masthead.find( '.menu' ).removeAttr( 'style' );
				$('.menu-search').hide();
			}
		}, 200 );
	} );
} );