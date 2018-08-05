;
(function ($, window, document, undefined) {

    "use strict";

    var pluginName = "modularisUIShare",
        defaults = {
        };

    // The actual plugin constructor
    function ModularisUIShare(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.$element = $(this.element);
        this.$element.on('click', $.proxy(this, 'openWindow'));
    }

    ModularisUIShare.prototype = {
        openWindow: function (event) {
            var defaultWindowWidth = 600;
            var defaultWindowHeight = 400;
            if(this.$element.data('action') == 'share-on-google') {
                defaultWindowHeight = 825
            }
            window.open(this.$element.attr('href'),'','toolbar=0,status=0,width='+defaultWindowWidth+',height='+defaultWindowHeight);
            return false;
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ModularisUIShare(this, options));
            }
        });
    };

})(jQuery, window, document);