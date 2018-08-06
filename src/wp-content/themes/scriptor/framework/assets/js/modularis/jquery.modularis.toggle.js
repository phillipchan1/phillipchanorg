;
(function ($, window, document, undefined) {

    "use strict";

    var pluginName = "modularisUIToggle",
        defaults = {
        };

    // The actual plugin constructor
    function ModularisUIToggle(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.$element = $(this.element);
        this.$toggle = this.$element.find('.modularis-toggle-control');
        this.$icon = this.$element.find('.modularis-toggle-control-icon');
        this.$toggle.on('click', $.proxy(this, 'toggle'));

        this.changeIcon('modularis-toggle--open');

    }

    ModularisUIToggle.prototype = {
        toggle    : function (event) {
            event.preventDefault();
            this.$element.toggleClass('modularis-toggle--open modularis-toggle--closed');
            this.changeIcon('modularis-toggle--open');
        },
        changeIcon: function (_class) {
            if (this.$element.hasClass(_class)) {
                this.$icon.text('-');
            } else {
                this.$icon.text('+');
            }
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ModularisUIToggle(this, options));
            }
        });
    };


    $('.modularis-toggle').each(function () {
        var $toggle = $(this);
        $toggle.modularisUIToggle();
    })




})(jQuery, window, document);