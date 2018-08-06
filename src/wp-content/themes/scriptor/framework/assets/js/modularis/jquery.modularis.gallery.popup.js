;
(function ($, window, document, undefined) {

    "use strict";

    var pluginName = "modularisUIGalleryPopup",
        defaults = {
            'padding'       : 50,
            'animationSpeed': 250
        };

    // The actual plugin constructor
    function ModularisUIGalleryPopup(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.$element = $(this.element);
        this.$body = $('body');
        this.$window = $(window);
        this.$view = $('#gallery-popup');
        this.$thumb = this.$element.find('img');
        this.$item = this.$element.parents('.gallery-item');
        this.$popup = null;
        this.$popupImage = null;

        this._imageURL = this.$element.attr('href');

        this.$element.on('click.'+pluginName, $.proxy(this, '_request'));
        this.$window.on('resize.'+pluginName, $.proxy(this, '_resizePopup'));

    }

    ModularisUIGalleryPopup.prototype = {
        _request: function (event) {
            new ImagePreloader({
                "images": [
                    {
	src   : this._imageURL,
	onload: $.proxy(this, '_initPopup')
                    }
                ]
            });
            this._loadingToggle(true);
            return false;
        },
        _initPopup : function(data, image) {
            this._buildPopupView(data, image);
            this._setupPopup();
            this._loadingToggle(false);
        },

        _buildPopupView: function (data, image) {
            this.$popup = $(_.template(this.$view.html(), { 'image': $(image).attr('src')})).appendTo('body');
        },

        _setupPopup: function () {

            this.$popupImage = this.$popup.find('img');
            this.$popupImage.data('original-width', this.$popupImage.width());
            this.$popupImage.data('original-height', this.$popupImage.height());

            this._setPopupSize();
            this._setThumbImage();

            this.$popup.off('click.'+pluginName).on('click.'+pluginName, $.proxy(this, '_closePopup'));
            this.$body.addClass('gallery-popup--opened');

            this.$popupImage.css(
                {
                    'top'   : this.thumbImageY,
                    'left'  : this.thumbImageX,
                    'width' : this.thumbImageWidth,
                    'height': this.thumbImageHeight
                }
            );

            this._resizePopup();
        },

        _setThumbImage : function() {
            this.thumbImageX = this.$thumb.offset().left;
            this.thumbImageY = this.$thumb.offset().top;
            this.thumbImageWidth = this.$thumb.width();
            this.thumbImageHeight = this.$thumb.height();
        },

        _setPopupSize : function() {
            this.finalImageHeight = this.$window.height() - this.options.padding * 2;
            this.finalImageWidth = this.finalImageHeight * this._getImageProportion();
            if(this.finalImageWidth >= this.$window.width()-(this.options.padding * 2)) {
                this.finalImageWidth = this.$window.width()-(this.options.padding * 2);
                this.finalImageHeight = this.finalImageWidth / this._getImageProportion();
            }
        },

        _resizePopup : function() {
            if(this.$popupImage) {
                this._setPopupSize();
                this._setPopupPosition(
                    {
	'top'   : this.options.padding,
	'left'  : this.$window.width() / 2 - this.finalImageWidth / 2,
	'width' : this.finalImageWidth,
	'height': this.finalImageHeight
                    }
                );
            }
        },

        _loadingToggle: function (_load) {
            return _load ?  this.$item.addClass('gallery-popup--loading') :  this.$item.removeClass('gallery-popup--loading');
        },

        _getImageProportion: function () {
            return this.$popupImage.data('original-width') / this.$popupImage.data('original-height');
        },


        _setPopupPosition: function (_css, _callback) {
            this.$popupImage.stop().animate(_css, this.options.animationSpeed, _callback);
        },

        _closePopup: function () {
            if (this.$popupImage) {
                this.$body.removeClass('gallery-popup--opened');
                this._setThumbImage();
                this._setPopupPosition(
                    {
	'top'   : this.thumbImageY,
	'left'  : this.thumbImageX,
	'width' : this.thumbImageWidth,
	'height': this.thumbImageHeight
                    },
                    $.proxy(this, '_removePopup')
                );
            }

        },
        _removePopup: function () {
            this.$popup.remove();
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new ModularisUIGalleryPopup(this, options));
            }
        });
    };


})(jQuery, window, document);