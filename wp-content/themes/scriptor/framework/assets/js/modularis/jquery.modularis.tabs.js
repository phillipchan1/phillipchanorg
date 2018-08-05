;
(function ($, window, document, undefined) {

    "use strict";

    var pluginName = "modularisUITabs",
        defaults = {
        };

    // The actual plugin constructor
    function ModularisUITabs(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.$element = $(this.element);
        this.$tab = this.$element.find('.modularis-tabs-navigation-item');
        this.$content = this.$element.find('.modularis-tabs-content');
        this.$tab.on('click', $.proxy(this, 'show'));

        this.$tab.eq(0).addClass('modularis-tabs-navigation-item--show');
        this.$content.eq(0).addClass('modularis-tabs-content--show');

    }

    ModularisUITabs.prototype = {
        show: function (event) {
            event.preventDefault();
            var $tab = $(event.currentTarget);
            this.$tab.removeClass('modularis-tabs-navigation-item--show');
            $tab.addClass('modularis-tabs-navigation-item--show');
            this.$content.removeClass('modularis-tabs-content--show');
            this.$content.eq($tab.index()).addClass('modularis-tabs-content--show');

        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ModularisUITabs(this, options));
            }
        });
    };

    $('.modularis-tabs').each(function () {
        var $tabs = $(this);
        $tabs.modularisUITabs();
    })



})(jQuery, window, document);