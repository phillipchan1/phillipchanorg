;
(function ($, window, document, undefined) {

    var pluginName = "themepileGoogleGetLocation",
        defaults = {};

    // The actual plugin constructor
    function ThemepileGoogleGetLocation(element, options) {

        this.element = element;
        this.$element = $(this.element);
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.address = this.$element.find('[data-themepile-google-get-location-address]');
        this.search = this.$element.find('[data-themepile-google-get-location-search-submit]');
        this.lat = this.$element.find('[data-themepile-google-get-location-map-lat]');
        this.lng = this.$element.find('[data-themepile-google-get-location-map-lng]');

        this.geocoder = new google.maps.Geocoder();

        this.search.on('click', $.proxy(this, 'getLatLng'));
    }

    ThemepileGoogleGetLocation.prototype = {
        getLatLng  : function (event) {
            event.preventDefault();
            this.search.html(this.search.attr('data-themepile-lang-loading'));
            if (this.geocoder) {
                this.address.attr('disabled', 'disabled');
                this.geocoder.geocode({ 'address': this.address.val() }, $.proxy(this, 'onGetLatLng'));
            }
        },
        onGetLatLng: function (results, status) {
            this.address.removeAttr('disabled');
            if (status == google.maps.GeocoderStatus.OK) {
                this.lat.val(results[0].geometry.location.lat());
                this.lng.val(results[0].geometry.location.lng());
                this.search.html(this.search.attr('data-themepile-lang-success'));
            }
            else {
                this.lat.val(0);
                this.lng.val(0);
                this.search.html(this.search.attr('data-themepile-lang-google-status') + status + ".<br>" + this.search.attr('data-themepile-lang-error'));
            }

        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ThemepileGoogleGetLocation(this, options));
            }
        });
    };

})(jQuery, window, document);
