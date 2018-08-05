;
(function ($) {
    $(document).ready(function () {

        if ($(document.location.hash).length != 0) {
            $('.themepile__content__item').hide();
            $('.themepile__sidebar__nav__item').removeClass('themepile__sidebar__nav__item_state_current');
            $('.themepile__sidebar__nav-link[href="' + document.location.hash + '"]').parent().addClass('themepile__sidebar__nav__item_state_current');
            $(document.location.hash).show();
        } else {
            $('.themepile__content__item').hide();
            $('.themepile__sidebar__nav__item').eq(0).addClass('themepile__sidebar__nav__item_state_current');
            $($('.themepile__sidebar__nav__item').eq(0).find('a').attr('href')).show();
        }

        $('.themepile__sidebar__nav__item').on('click', function () {
            document.location.hash = $(this).find('a').attr('href');
            $('.themepile__sidebar__nav__item').removeClass('themepile__sidebar__nav__item_state_current');
            $(this).addClass('themepile__sidebar__nav__item_state_current');
            $('.themepile__content__item').hide();
            $($(this).find('a').attr('href')).show();
            return false;
        });

        $('[data-themepile-plugin="themepile-wp-uploader"]').themepileWPUploader();
        $('[data-themepile-plugin="themepile-google-get-location"]').themepileGoogleGetLocation();


        $('.themepile__footer input[name="reset"]').on('click', function () {
            return confirm($(this).attr('data-themepile-lang-confirm'));
        });
        /*
         ('[themepile-slider id="41" type=slide easing=linear interval=10000 speed=5000 queue=0]').replace(new RegExp('([[\s]*'+segment+'=)([^ ]*)'), '$1' + segmentValue);

         */

    });
})(jQuery);
