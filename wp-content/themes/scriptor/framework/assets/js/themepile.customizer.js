/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 */

(function ($) {

    // Site title and description.
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.b-logo__title a').html(to);
        });
    });
    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.b-logo__title a').attr('title', to);
        });
    });
    wp.customize('themepile_theme_options[header_link_color]', function (value) {
        value.bind(function (to) {
            $('.menu_item a').css('color', to);
        });
    });
    wp.customize('themepile_theme_options[image_upload_logo]', function (value) {
        value.bind(function (to) {
            $('.b-logo-link').find('img').attr('src', $(to).attr('src'));
        });
    });
    wp.customize('themepile_theme_options[facebook]', function (value) {
        value.bind(function (to) {
            //$( '.b-logo-link' ).css( 'background' ,  'url:(' + $(to).attr('src') + ')' );
        });
    });
})(jQuery);


