jQuery(document).ready(function ($) {

	/* Fitvids
	/*-----------------------------------------------*/
	$( ".post-entry" ).fitVids();
		
	
	
	
	/* Menus
	/*-----------------------------------------------*/
	
	// Menu / Search Toggle
	$(".menu-search-toggle").click(function() {
	  $(".main-navigation .menu-item, .menu-search, .menu-search-toggle .fa-search, .menu-search-toggle .fa-times").toggle();
	  $("#menu-search-input").focus();
	  return false;
	});
	
	
	// Center Nav Child Menus
	$(".main-navigation li").each( function() {
	    if( $(this).find("ul").length > 0 )
	    {
	        var parent_width = $(this).outerWidth( true );
	        var child_width = $(this).find("ul").outerWidth( true );
	        var new_width = parseInt((child_width - parent_width)/2);
	        $(this).find("ul:not(ul ul ul)").css('margin-left', -new_width+"px");
	    }
	});
	
	
    /* Masonry
	/*-----------------------------------------------*/
		
	// Footer Widgets
	$( '#footer-widgets' ).masonry( {
		itemSelector: 'aside',
		gutterWidth: 0,
		isResizable: true
	} );
	
	
	// Post Entry
	if ( hypha_scripts_js_vars.load_masonry ) {
		var $bricks = $( ".masonry-index #main-content" );
		
		$bricks.imagesLoaded( function(){
			$bricks.masonry( {
				itemSelector: '.post-entry',
				gutterWidth: 0,
				isResizable: true,
				stamp: '#sidebar-widgets'
			} );
			
			// Fade posts in after images are ready (prevents jumping and re-rendering)
			$( ".loader-icon" ).hide();
			$( '#sidebar-toggle' ).fadeIn( 50 );
			$( ".post-entry" ).fadeTo( "slow", 1 );
		});

	}
	
	
	
	
	/* Sidebar
	/*-----------------------------------------------*/
	var isStamped = false;
	var $stamp = $( "#sidebar-widgets" );
	
	$("#sidebar-toggle").click( function(e) {
		e.preventDefault();
		$(this).toggleClass('active');
		$stamp.find("aside").toggleClass('animated fadeIn');
		$stamp.toggle();
		
		if ( isStamped ) {
    		$bricks.masonry( 'unstamp', $stamp );
  		} else {
    		$bricks.masonry( 'stamp', $stamp );
  		}
  		
  		$bricks.masonry();
		isStamped = !isStamped;
				
		return false;
	});
	
	
		
		
	/* Infinite Scroll
	/*-----------------------------------------------*/
	infinite_count = 0;
	$( document.body ).on( 'post-load', function () {
				
		$bricks.masonry( {
			itemSelector: '.post-entry',
			gutterWidth: 0,
			isResizable: true,
			stamp: "#sidebar-widgets"
		} );
					
		infinite_count = infinite_count + 1;
		
		// Re-intialize FitVids
		$( ".post-entry" ).fitVids();

		var $newItems = $( '#infinite-view-' + infinite_count + ' .post-entry' );
		$newItems.hide();

		$bricks.imagesLoaded( function() {
			$bricks.masonry( "appended", $newItems, true ).masonry( "reload" );
			$( ".post-entry" ).fadeTo( "slow", 1 );
		});
		
	});
	
	
	
	
	/* Flexslider
	/*-----------------------------------------------*/
	var isFlexed;
	$(window).on("resize load", function () {	
		if ( $("#media-query").css( "max-width" ) == "764px" ) {
			// Mobile
			if ( isFlexed == 'desktop' ) { $('.flexslider').removeData("flexslider") };
			$minMax = 1;
			isFlexed = 'mobile';
			
		} else {
			// Desktop
			if ( isFlexed == 'mobile' ) { $('.flexslider').removeData("flexslider") };
			$minMax = 3;
			isFlexed = 'desktop';
		}
		
		$itemWidth = parseInt( $('.featured-content').width() / $minMax );
		
		// Initialize
		$(".flexslider").flexslider({
			slideshow: false,
			controlNav: false,
			animation: "slide",
			animationLoop: false,
			itemWidth: $itemWidth,
			minItems: $minMax,
			maxItems: $minMax,
			move: 1
		});
	});
	
	
	
	
	/* Post Tabs
	/*-----------------------------------------------*/
	var pathname = window.location.href;
	$(".post-tab").hide();
	$( "#post-tabs > div").hide();
	
	// If only 1 Tab, remove tabs
	if ( $( ".post-tab-nav li" ).length < 2 ) {
		$( ".post-tab-nav li" ).remove();
	}
	
	// Click Comments
	$('.comments a').click(function () {
    	openPostTabs();
	});
	
	// If Path URL has #, Less than 2 Tabs, Customizer Open
	if ( ( pathname.indexOf('#') > -1 ) || ( $( ".post-tab-nav li" ).length < 2 ) || ( hypha_scripts_js_vars.post_tabs == 'open' )  ) 	{
		openPostTabs();
	}
	
	// Open Post Tab
	function openPostTabs() {
    	$( "#post-tabs div:first" ).show();
		$( "#post-tabs ul li:first" ).addClass( "active" );
		$( "#post-tabs").addClass( "active" );
	}
	
	// Post Tabs Click
	$( "#post-tabs > ul > li a" ).click( function() {
		
		// Slide down only once
        if ( !$( "#post-tabs").hasClass( "active" ) ) {
        	$(".post-tab").slideDown();
        	$( "#post-tabs").addClass( "active" );
        }
        
		$( '#post-tabs ul li').removeClass('active');
		$( this ).parent().addClass( "active" );
		var currentTab = $(this).attr( "href" );
		$( "#post-tabs > div" ).hide();
		$( currentTab ).show();
		return false;
	});
	
	
	/* Scroll To Top
	/*-----------------------------------------------*/
	$('#scroll-to-top i').click( function() {
		$('html, body').animate( { scrollTop : 0 }, 1000 );
		return false;
	});
	
});