;
(function ($) {
    'use strict';

    var $body = $('body');
    var $html = $('html');

    function app() {

        // Remove no-js class
        $html.removeClass('no-js');

        $('.site-nav-go-to-nav-link').on('click', function () {
            $body.toggleClass('scriptor--site-nav--open');
            return false;
        });

        $('.ui-show-sidebar-toggle').on('click', function () {
            $body.toggleClass('scriptor--sidebar--open');
            return false;
        });

        var action = document.location.hash;
        $body.addClass(action.replace(/#\/action\/(.*)/, '$1'));

        $('.site-nav-overlay').on('click', function () {
            $body.removeClass('scriptor--site-nav--open');
            return false;
        });

        /* Comment Form Validate */
        $('.comment-form').validate({
            rules: {
                "author": {
                    required: true
                },
                "email"    : {
                    email   : true,
                    required: true
                },
                "comment"  : {
                    required: true
                }
            }
        });

        $('.contact-form').validate({
            rules: {
                "your_name": {
                    required: true
                },
                "email"    : {
                    email   : true,
                    required: true
                },
                "message"  : {
                    required: true
                }
            }
        });

        var $masonry = $body.find('.gallery');
        var imagePreloader =  new ImagePreloader({
            "images": $masonry.find('img'),
            "onSuccess": function(){
                $masonry.masonry({
                    "gutter"            : 0,
                    "transitionDuration": '0',
                    "itemSelector"      : '.gallery-item'
                });
            }
        });

        $('.gallery .gallery-icon a').modularisUIGalleryPopup();
        $('.modularis-pagination--ajax').modularisUIPagination();
        $('.site-search-form').modularisUIAjaxSearch();
        $('.modularis-alert').modularisUIAlert();
        $('.modularis-tabs').modularisUITabs();
        $('.modularis-toggle').modularisUIToggle();
        $('.entry-actions-share-link').modularisUIShare();


        var gMap = $('.google-map');
        if (gMap.length !== 0) {
            var google = window.google;
            var lat = gMap.data('lat');
            var lng = gMap.data('lng');
            var mapOptions = {
                zoom       : 16,
                scrollwheel: false,
                center     : new google.maps.LatLng(lat, lng),
                mapTypeId  : google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(gMap.get(0), mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map     : map
            });
            marker.setMap(map);
        }

    }

    $(document).ready(app);
    $('.modularis-pagination--ajax').on('onPostLoaded', app);

})(jQuery);
