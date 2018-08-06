;
(function ($, window, document, undefined) {

    "use strict";

    var pluginName = "modularisUIPagination",
        defaults = {
        };

    // The actual plugin constructor
    function ModularisUIPagination(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.$element = $(this.element);
        this.$button = this.$element.find('.modularis-button');
        this.$button.on('click', $.proxy(this, 'loadPosts'));
    }

    ModularisUIPagination.prototype = {
        loadPosts: function (event) {

            event.preventDefault();

            this.$button.text(this.$button.attr('data-themepile-lang-loading'));
            this.$element.addClass('modularis-pagination--ajax--loading');

            $.post(window.THEMEPILE_AJAX_PATH,
                { action     : 'pagination',
                    page     : this.$button.attr('data-page'),
                    post_type: this.$button.attr('data-type'),
                    term     : this.$button.attr('data-term'),
                    taxonomy : this.$button.attr('data-taxonomy')
                },
                $.proxy(this, 'onPostLoaded'),
                'json'
            );
        },

        onPostLoaded: function (data) {


            this.$button.text(this.$button.attr('data-themepile-lang-loaded'));
            this.$element.removeClass('modularis-pagination--ajax--loading');
            $(data.result).insertBefore(this.$element);
            var _nextPage = data.currentPage + 1;
            var _expression = /([\/?&]paged?[\/=])\d+/;
            var _newHref = this.$button.attr('href').replace(_expression, '$1' + _nextPage);
            if (_nextPage > data.countPages) {
                this.$element.hide();
            }
            this.$button.attr('data-page', _nextPage);
            this.$button.attr('href', _newHref);

            if (window.history) {
                history.pushState({pagination: data.currentPage}, null, this.$button.attr('href').replace(_expression, '$1' + data.currentPage));
            }

            this.$element.trigger({
                type: "onPostLoaded",
                user: "foo",
                pass: "bar"
            });

        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ModularisUIPagination(this, options));
            }
        });
    };


})(jQuery, window, document);