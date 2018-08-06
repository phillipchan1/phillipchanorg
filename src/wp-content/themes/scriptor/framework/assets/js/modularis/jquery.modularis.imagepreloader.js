;
(function () {

    var isIE = ~navigator.userAgent.indexOf('MSIE');

    /**
     * @namespace ImagePreloader
     * @name ImagePreloader
     * @param {object} associative array of options
     *  {
     *    "images": [{"src":"1.jpg", "onload":callback, "onerror":callback}], // ["1.jpg"]
     *    "onImageError": callback, // function(image)
     *    "onImageLoad": callback,  // function(image, elem)
     *    "onLoadAll": callback,
     *    "onSuccess": callback
     *  }
     */
    ImagePreloader = function (options) {

        if (typeof options == 'undefined') {
            options = {};
        }

        this.images = {};
        this.onImageError = options.onImageError;
        this.onImageLoad = options.onImageLoad;
        this.onLoadAll = options.onLoadAll;
        this.onSuccess = options.onSuccess;

        this.container = document.createElement("div");
        this.container.style.display = "none";
        document.body.appendChild(this.container);

        var images = options.images || [];
        for (var i = 0; i < images.length; i++) {
            this.add(images[i]);
        }
    };

    ImagePreloader.prototype = {

        /**
         * @public
         * @param {string} image url
         * @return {bool} "null" if image not in the list
         */
        isLoaded: function (src) {
            return this.images[src] ? this.images[src] : null;
        },

        /**
         * @public
         * @param {mixed} image url or object {"src":"1.jpg", "onload":callback, "onerror":callback}
         */
        add: function (image) {

            if (typeof image == "string") {
                image = {"src": image};
            }

            if (isIE) {
                image.src += '?' + (new Date().getTime());
            }

            var img = new Image();
            img.onerror = this.proxy('imageLoaded', [image, img, true]);
            img.onload = this.proxy('imageLoaded', [image, img, false]);
            img.src = image.src;
            this.container.appendChild(img);

            if (typeof this.images[image.src] == 'undefined') {
                this.images[image.src] = false;
            }
        },

        /**
         * Internal function that is called when image is loaded
         * @param {object} image object
         * @param {object} image DOM HTML object
         */
        imageLoaded: function (image, element, error) {

            this.images[image.src] = true; // image was loaded, even if there is error

            if (error) {
                var useDefault = image.onerror ? image.onerror(image) : true;
                if (this.onImageError && useDefault) this.onImageError(image);
                this.onSuccess = null;
            } else {
                var useDefault = image.onload ? image.onload(image, element) : true;
                if (this.onImageLoad && useDefault) this.onImageLoad(image, element);
            }

            if (this.onLoadAll || this.onSuccess) {
                var isCallback = true;
                for (var src in this.images) {
                    if (!this.images[src]) {
	isCallback = false;
	break;
                    }
                }

                if (isCallback) {
                    if (this.onSuccess) {
	this.onSuccess();
	this.onSuccess = null; // prevent second launch
                    }
                    if (this.onLoadAll) {
	this.onLoadAll();
	this.onLoadAll = null; // prevent second launch
                    }
                }
            }
        },


        /**
         * Proxy to call function in context of current object
         * @param {mixed} function or string
         * @param {array} function arguments; use null to define incoming arguments
         */
        proxy: function (func, args) {
            var self = this;
            args = args || [];
            if (typeof func == 'string')
                func = this[func];
            return function () {
                var a = args.slice();
                for (var i = 0; i < arguments.length; i++)
                    if (typeof a[i] == 'undefined' || a[i] === null)
	a[i] = arguments[i];
                return func.apply(self, a);
            };
        }
    }

})();