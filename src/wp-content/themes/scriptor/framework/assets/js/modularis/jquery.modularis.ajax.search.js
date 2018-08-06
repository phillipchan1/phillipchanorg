;
(function ($, window, document, undefined) {

    "use strict";

    var pluginName = "modularisUIAjaxSearch",
        defaults = {
        };

    // The actual plugin constructor
    function ModularisUIAjaxSearch(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.$element = $(this.element);
        this.$input = this.$element.find('input[type="search"]');
        this.$submit = this.$element.find('*[type="submit"]');
        this.$close = this.$element.find('*[type="button"]');
        this.$element.on('submit', $.proxy(this, '_request'));
        this.$close.on('click', $.proxy(this, '_closeSearchResult'));
        this.$view =  $('#site-search-result');
        this.$serachList =  null;

        this.$close.hide();
    }

    ModularisUIAjaxSearch.prototype = {
        _request    : function (event) {
            this._toggleFormControls(true);
            $.ajax({
                type:"POST",
                url: window.THEMEPILE_AJAX_PATH,
                data: {
                    'action' : 'themepile_ajax_search',
                    's' :this.$input.val()
                },
                dataType : 'json',
                success: $.proxy(this, '_buildView')
            });
            return false;
        },
        _buildView : function (data) {
            this._toggleFormControls(false);
            if(data['success']) {
                this.$serachList = $(_.template(this.$view.html(),
                    {
	'items' : data['data'],
	'not_found' : data['data']['not_found'] || ''
                    })
                ).appendTo($('.site-nav-inner'));

                this.$submit.hide();
                this.$close.show();
            }
        },
        _toggleFormControls : function (_is) {
            this.$submit.prop('disabled', _is);
            this.$input.prop('disabled', _is);
        },
        _closeSearchResult : function (event) {
            this.$serachList.remove();
            this.$submit.show();
            this.$close.hide();
            return false;
        },
        _error : function() {
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ModularisUIAjaxSearch(this, options));
            }
        });
    };


})(jQuery, window, document);