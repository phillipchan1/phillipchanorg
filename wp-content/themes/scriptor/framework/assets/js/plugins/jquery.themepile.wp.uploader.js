;
(function ($, window, document, undefined) {

    var pluginName = "themepileWPUploader",
        defaults = {};

    // The actual plugin constructor
    function ThemepileWPUploader(element, options) {

        this.element = element;
        this.$element = $(this.element);
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.button = this.$element.find('[data-themepile-wp-uploader-button]');
        this.remove = this.$element.find('[data-themepile-wp-uploader-remove]');
        this.input = this.$element.find('[data-themepile-wp-uploader-input]');
        this.container = this.$element.find('[data-themepile-wp-uploader-container]');

        this.uploaderSettings = {
            title   : this.$element.attr('data-themepile-wp-uploader-dialog-title') || 'Choose Image',
            library : { type: this.$element.attr('data-themepile-wp-uploader-dialog-type') || 'image/png' },
            button  : { text: this.$element.attr('data-themepile-wp-uploader-dialog-button') || 'Add Image' },
            multiple: this.$element.attr('data-themepile-wp-uploader-multiple') || false
        };

        this.uploader = wp.media.frames.file_frame = wp.media(this.uploaderSettings);

        // Events
        this.uploader.on('select', $.proxy(this, 'onOpenDialog'));
        this.button.on('click', $.proxy(this, 'openDialog'));
        this.remove.on('click', $.proxy(this, 'removeImage'));

    }

    ThemepileWPUploader.prototype = {
        openDialog: function (event) {
            event.preventDefault();
            if (this.uploader) {
                this.uploader.open();
            }
            this.uploader.open();
        },

        onOpenDialog: function () {
            var uploaderJSON = this.uploader.state().get('selection').first().toJSON();
            //console.log(uploaderJSON)
            var url = uploaderJSON.url;
            var image = this.container.find('img');

            if (image.length != 0) {
                image.attr('src', url);
            } else {
                $('<img>').attr('src', url).appendTo(this.container);
            }
            this.input.val(uploaderJSON.url);
        },

        removeImage: function () {
            this.container.find('img').remove();
            this.input.val('');
            return false;
        }

    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ThemepileWPUploader(this, options));
            }
        });
    };

})(jQuery, window, document);
