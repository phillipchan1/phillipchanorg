jQuery(document).ready(function( $ ) { 

		//Flex Slider
		$(window).load(function() {
		    $('.flexslider').flexslider({
		      prevText: "(",
		      nextText: "*"
		    });
		});
		  
		
		// Drop Menu
		function mainmenu(){
		$(".nav ul ").css({display: "none"}); // Opera Fix
		$(".nav li").hover(function(){
				$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(200);
				},function(){
				$(this).find('ul:first').css({visibility: "hidden"});
				});
		}
			
		mainmenu();
		
		// Secondary Drop Menu
		function catmenu(){
		$(".secondary-menu ul ").css({display: "none"}); // Opera Fix
		$(".secondary-menu li").hover(function(){
				$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(200);
				},function(){
				$(this).find('ul:first').css({visibility: "hidden"});
				});
		}
			
		catmenu();
		
		// Lightbox
		$(".lightbox").fancybox({
			'titlePosition'		: 'outside',
			'overlayColor'		: '#ddd',
			'overlayOpacity'	: 0.9,
			'titleShow'			: 'false',
			'speedIn' : '1400', 
			'speedOut' : '1400'
		});
	
		//FitVids
		$(".okvideo,.post-content").fitVids();	
				
		// Tabs
		$('#tabs > div').hide();
		$('#tabs div:first').show();
		$('#tabs ul li:first').addClass('active');
		
		$('#tabs > ul li a').click(function(){
			$('#tabs ul li').removeClass('active');
			$(this).parent().addClass('active');
			var currentTab = $(this).attr('href');
			$('#tabs > div').hide();
			$(currentTab).fadeIn('fast', function() { });
			return false;
		});		
		
		//Responsive Menu
		$('.nav').mobileMenu();
		
		//Responsive Menu
		$('.secondary-menu').mobileMenu();
		
		//Select
		$(document).ready(function(){	
		
		    if (!$.browser.opera) {
		
		        $('select.select-menu').each(function(){
		            var title = $(this).attr('title');
		            if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
		            $(this)
		                .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
		                .after('<span class="select">' + title + '</span>')
		                .change(function(){
		                    val = $('option:selected',this).text();
		                    $(this).next().text(val);
		                    })
		        });
		
		    };
				
		});	
		
});
