;
(function ($) {
    $(document).ready(function () {

        var slider = $('.themepile-metabox--slider');
        var slide = $('.themepile-metabox--slider__item');
        var slideSortable = null;

        function initThemepileMetaboxSlider() {
            slideSortable = slider.sortable(
                {
                    placeholder: 'themepile-metabox--slider__item--placeholder',
                    handle     : '.themepile-metabox--slider__item__title',
                    revert     : 0,
                    opacity    : 0.8,
                    sort       : onSortableSort,
                    start      : onSortableStart,
                    stop       : onSortableStop
                }
            );
            $('[data-thtmepile-metabox-slider-control="add-slide"]').on('click', addSlide);
            $('[data-thtmepile-metabox-slider-control="remove-slide"]').on('click', removeSlide);

            initTinyMCE();
            initThemepileWPUploader();
        }

        function reInitThemepileMetaboxSlider() {
            initThemepileMetaboxSlider();
        }

        function addSlide() {
            var count = $('.themepile-metabox--slider__item').length;
            var template = _.template($("script.themepile-metabox--slider__item--template").html());
            $(template({id: count})).prependTo(slider);
            initTinyMCE();
            initThemepileWPUploader();
            return false;
        }

        function removeSlide(event) {
            var item = $(event.currentTarget).parents('.themepile-metabox--slider__item');
            item.remove();
            updateIDInFields();
            return false;
        }

        function initTinyMCE() {
            var slide = $('.themepile-metabox--slider__item');
            $.each(slide.find('.themepile-metabox-slide-content'), function (index, item) {
                tinymce.execCommand('mceAddControl', true, $(item).attr('id'));
                $('label[for="' + $(item).attr('id') + '"]').on('click', function () {
                    tinymce.execCommand('mceFocus', false, $(item).attr('id'));
                })
            });
        }

        function destroyTinyMCE() {
            var slide = $('.themepile-metabox--slider__item');
            $.each(slide.find('.themepile-metabox-slide-content'), function (index, item) {
                var textarea = $(item).attr('id');
                var content = tinyMCE.get(textarea).getContent();
                if (content) $(item).data('tiny-content', content);
                setTimeout(function () {
                    tinymce.execCommand('mceRemoveControl', false, textarea);
                }, 200);
            });
        }

        function onSortableSort(event) {
        }

        function onSortableStart(event, ui) {
            destroyTinyMCE(event, ui);
        }

        function onSortableStop(event, ui) {
            updateIDInFields();
            initTinyMCE();
            initThemepileWPUploader();
        }

        function initThemepileWPUploader() {
            $('[data-themepile-plugin="themepile-wp-uploader"]').themepileWPUploader();
        }

        function updateIDInFields() {
            var slide = $('.themepile-metabox--slider__item');
            $.each(slide, function (index, item) {
                var $item = $(item);
                $item.attr('id', 'themepile-metabox-slide[' + index + ']');
                $item.find('[data-themepile-metabox-slide-image-label]').attr('for', 'themepile-metabox-slide[' + index + '][image]');
                $item.find('[data-themepile-metabox-slide-image]').attr('id', 'themepile-metabox-slide[' + index + '][image]');
                $item.find('[data-themepile-metabox-slide-content-label]').attr('for', 'themepile-metabox-slide[' + index + '][content]');
                $item.find('[data-themepile-metabox-slide-content]').attr('id', 'themepile-metabox-slide[' + index + '][content]');
            });
        }

        initThemepileMetaboxSlider();

    });
})(jQuery);
