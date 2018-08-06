;
(function ($, window, document, undefined) {

    "use strict";

    var pluginName = "modularisUIAlert",
        defaults = {
        };

    // The actual plugin constructor
    function ModularisUIAlert(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.$element = $(this.element);
        this.$close = this.$element.find('.modularis-ui-alert__close');
        this.$close.on('click', $.proxy(this, 'close'));

    }

    ModularisUIAlert.prototype = {
        close: function (event) {
            event.preventDefault();
            this.$element.remove();
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ModularisUIAlert(this, options));
            }
        });
    };


    $('.modularis-alert').each(function () {
        var $alert = $(this);
        $alert.modularisUIAlert();
    })



})(jQuery, window, document);