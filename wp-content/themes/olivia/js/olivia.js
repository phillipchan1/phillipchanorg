(function($) {

"use strict";

var app = {
    init: function () {
		this.cacheDom();
		this.bindEvents();
		this.fadePost();
		this.fadeFeatured();
		this.runFitVids();
		this.checkHasAvatar();
		this.dropMenu();
    },
    cacheDom: function() {
		this.$theHtml = $('html');
		this.$theBody = $('body');
		this.$fsPanel = $('#fullscreen-menu');
		this.$fsMainNav = this.$fsPanel.find('.main-navigation');
		this.$fsMainNavLi = this.$fsMainNav.find('li');
		this.$panelMenu = $('#panel-menu');
		this.$wrapMenu = $('.wrap-fs-menu');
		this.$panelWidget = $('#panel-widget');
		this.$wrapWidget = $('.wrap-fs-widgets');
		this.$widgets = $('#sidebar .widget');
		this.$listPost = $('.list-post');
		this.$listArticles = $('#articles-list');
		this.$featuredPosts = $('.featured-posts');
		this.$featuredPostsArticles = this.$featuredPosts.find('article');
		this.$contentArea = $('.content-area');
		this.$westSide = $('.west-side');
	},
	bindEvents: function() {
		this.$panelMenu.on('click', this.toggleFsMenu.bind(this));
		this.$panelWidget.on('click', this.toggleFsWidget.bind(this));
		this.$theBody.keyup(this.keyboardKey.bind(this));
		this.$listPost.on('click', this.lpAllClickable);
		this.$theBody.on('mouseenter', ".list-post", this.lpMouseEnter);
		this.$theBody.on('mouseleave', ".list-post", this.lpMouseLeave);
		this.$theBody.on('post-load', this.reLayoutInfinite.bind(this));
	},
	runFitVids: function() {
		this.$contentArea.fitVids();
	},
	// Fade in the images as they load
	fadeFeatured: function() {
		this.$featuredPostsArticles.each(function(i) {
			var thisItem = $(this);
			setTimeout(function() {
				thisItem.addClass('fadeInLeft');
			}, 90*i);
		});
	},
	// Fade in posts as they load
	fadePost: function() {
		this.$listArticles.find('.list-post').each(function(i){
			var thisItem = $(this);
			thisItem.stop(true,true).delay(i*100).animate({opacity:'1',left:'0'},50);
		});
	},
	reLayoutInfinite: function() {
		var $loader = $('.infinite-loader');
		var $newItems = $('.new-infinite-posts');
		var $elements = $newItems.find('.post');
		this.$listArticles.append($elements);

		// Show the initial IS handle
		$('#infinite-handle').show();

		$newItems.remove();
		$loader.remove();

		// apply animation to new load posts
		this.fadePost();
		// make new posts div clickable
		$elements.on('click', this.lpAllClickable);
	},
	lpAllClickable: function() {
		var $this = $(this);
		window.location = $this.find("a:first").attr("href");
		return false;
	},
	lpMouseEnter: function() {
		var $this = $(this);
		$this.addClass("is-hovered");
		$this.find(".featured-image").addClass("is-hovered");
	},
	lpMouseLeave: function() {
		var $this = $(this);
		$this.removeClass("is-hovered");
		$this.find(".featured-image").removeClass("is-hovered");
	},
	keyboardKey: function(e) {
		// Close all with the escape key
		if (e.which === 27) {
			this.$theBody.removeClass('panel-widget-open');
			this.toggleWidgetItems();
			this.$theBody.removeClass('panel-menu-open');
			this.toggleMenuItems();
		}
		// // open menu with the 'm' key
		// if (e.which === 77 && tag !== 'input' && tag !== 'textarea') {
		// 	this.toggleFsMenu();
		// }
		// // open widget with the 'w' key
		// if (e.which === 87 && tag !== 'input' && tag !== 'textarea') {
		// 	this.toggleFsWidget();
		// }
	},
	toggleFsMenu: function() {
		if (this.$theBody.hasClass('panel-widget-open')) {
			//panel widget still open, have to close first.
			this.$theBody.removeClass('panel-widget-open');
			this.toggleWidgetItems();
		}

		this.$theBody.toggleClass('panel-menu-open');
		this.toggleMenuItems();
	},
	toggleMenuItems: function() {
		var hasClass = this.$theBody.hasClass('panel-menu-open');

		if (hasClass) {
			this.$wrapMenu.show();
			this.$wrapWidget.hide();
		} else {
			this.$wrapMenu.hide();
		}

		this.$fsMainNavLi.each(function(){
			var thisItem = $(this),
					i = thisItem.index();

			if (hasClass) {
				thisItem.stop(true,true).delay(i*100).animate({opacity:'1',left:'0'},500);
			} else {
				thisItem.stop(true,true).animate({opacity:'0',left:'-10px'},300);
			}
		});
	},
	toggleFsWidget:function() {
		if (this.$theBody.hasClass('panel-menu-open')) {
			//panel menu still open, have to close first.
			this.$theBody.removeClass('panel-menu-open');
			this.toggleMenuItems();
		}

		this.$theBody.toggleClass('panel-widget-open');
		this.toggleWidgetItems();
	},
	toggleWidgetItems: function() {
		var hasClass = this.$theBody.hasClass('panel-widget-open');

		if (hasClass) {
			this.$wrapMenu.hide();
			this.$wrapWidget.show();
		} else {
			this.$wrapWidget.hide();
		}

		this.$widgets.each(function(){
			var thisItem = $(this),
					i = thisItem.index();

			if (hasClass) {
				thisItem.stop(true,true).delay(i*100).animate({opacity:'1',left:'0'},500);
			} else {
				thisItem.stop(true,true).animate({opacity:'0',left:'-10px'},0);
			}
		});
	},
	checkHasAvatar: function() {
		var hasAvatar = this.$westSide.find('.has-avatar').length;
		if (hasAvatar) {
			this.$westSide.addClass('with-avatar');
		} else {
			this.$westSide.addClass('no-avatar');
		}
	},
	dropMenu: function() {
		var $fsNav = $("#fullscreen-menu nav");

		//if menu item has child
		var $subMenu = $fsNav.find('.sub-menu');
		var $menuHasChild = $fsNav.find('.menu-item-has-children');

		//if page Has Child
		var $children = $fsNav.find('.children');
		var $pageHasChild = $fsNav.find('.page_item_has_children');

		$subMenu.css({display: "none"}); //opera fix
		$children.css({display: "none"}); //opera fix

		$menuHasChild.on('click', function(){
			var $linkChild = $(this).find('a');

			if ($linkChild.hasClass('is-clicked')) {
				$linkChild.removeClass('is-clicked');
				$(this).find('ul:first').stop().slideUp('fast');
				$linkChild.toggleClass('is-open');
			} else {
				$linkChild.addClass('is-clicked');
				$(this).find('ul:first').stop().slideDown('fast');
				$linkChild.toggleClass('is-open');
			}
		});

		$pageHasChild.on('click', function(){
			var $linkChild = $(this).find('a');

			if ($linkChild.hasClass('is-clicked')) {
				$linkChild.removeClass('is-clicked');
				$(this).find('ul:first').stop().slideUp('fast');
				$linkChild.toggleClass('is-open');
			} else {
				$linkChild.addClass('is-clicked');
				$(this).find('ul:first').stop().slideDown('fast');
				$linkChild.toggleClass('is-open');
			}
		});
	}
};

$(document).ready(function() {
    app.init();
});

})(jQuery);
