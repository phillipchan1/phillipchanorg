;
(function ($) {

    /**
     * Create console object if browser doesn't support console output
     *
     */
    if (typeof console == "undefined") {
        console = {
            log: function (msg) {
                //alert(msg);
            }
        };
    }

    /**
     * Disable selection on doubleclick
     *
     * Usage: bind on element mousedown
     */
    function disableSelection() {
        this.onselectstart = function () {
            return false;
        };
        return false;
    }

    /**
     * Check if argument is function
     * @return {bool} is function
     */
    function isFunc(o) {
        return Object.prototype.toString.call(o) === "[object Function]";
    }

    /**
     * Default slider options
     *
     * Internal auto-calculated options:
     * - order
     * - visible
     * - width
     */
    var slider_defaults = {
        "buttonNext"      : null,         // next slide button: string or jQuery element
        "buttonPrev"      : null,         // prev slide button: string or jQuery element
        "classDisabled"   : "disabled", // class for disabled prev-next buttons
        "container"       : "ul:first",     // sliders container selector or jQuery element
        "easing"          : "swing",           // [linear|swing] by default. use jquery easing plugin for more effects
        "effect"          : "change",          // [change|fade|lift|rotate|slide|shift]
        "interval"        : 0,               // in ms, [0|null|false] to slide manually
        "offset"          : 0,                 // current slide offset for rotate effect. in px or "center" to auto calculate offset
        "onInit"          : null,              // init function, called before slide initialization
        "onSlide"         : null,             // function(index, slides, isNext) run before slide change
        "onSlideEnd"      : null,          // function(index) run after slider was changed to "index" slide
        "rotate"          : true,              // move to the first slider after the last one and vice versa
        "scroll"          : null,              // scroll value in pixels for shift effect
        "slideElement"    : "> li",      // slide html element
        "speed"           : 600,                // slide effect speed in ms
        "start"           : 0,                  // slide number to start sliding from
        "stopOnChange"    : false,       // stop animation on manual slide change
        "stopOnMouseHover": false,   // stop auto slide change if mouse is over the slide
        "stopOnWindowBlur": false,   // stop slider animation on window/tab lost focus
        "useHashAttr"     : "data-hash",  // slide attribute name for url hash update
        "useQueue"        : true,            // use sliding queue
        "wrapper"         : null              // slider container jQuery object
    };

    /**
     * Default thumbnails options
     *
     */
    var thumbs_defaults = {
        "buttonNext"   : null,         // next slide button: string or jQuery element
        "buttonPrev"   : null,         // prev slide button: string or jQuery element
        "classActive"  : "active",     // class, added to current slide's thumbnail
        "classDisabled": "disabled", // class for disabled prev-next buttons
        "container"    : "ul:first",     // thumbnails container or jQuery element
        "current"      : "center",         // center | visible | null
        "direction"    : null,           // null | h | v
        "element"      : "> li",             // thumb element selector
        "onScroll"     : null,            // function(begin, end) that called when thumbs are scrolled
        "scroll"       : null,              // scroll [<=>] distance in px
        "height"       : null,              // fixed thumbnail height in pixels
        "wrapper"      : null,             // thumbnails container jQuery object
        "width"        : null                // fixed thumbnail width in pixels
    };


    themePileSlider = function (slider_options, thumbs_options) {

        this.animate = 0;  // intervalId for animation
        this.index = 0;  // current slide index
        this.length = 1;  // at least 1 slide
        this.queue = [];

        this.slider = $.extend({}, slider_defaults);
        this.thumbs = $.extend({}, thumbs_defaults);

        if (slider_options) {
            this.init(slider_options, thumbs_options);
        } else {
            return this;
        }
    };


    themePileSlider.prototype = {

        /*
         * destroy
         * effects: [change|fade|lift|rotate|shift|slide]
         * init
         * next
         * prev
         * queueNext
         * restart
         * show
         * start
         * stop
         * thumbsInit
         * thumbsScroll
         * thumbsSet
         */


        destroy: function () {

            this.stop();

            this.slider.slides.unbind('click');

            this.slider.buttonNext && this.slider.buttonNext.unbind('click').unbind('mousedown', disableSelection);
            this.slider.buttonPrev && this.slider.buttonPrev.unbind('click').unbind('mousedown', disableSelection);

            if (this.thumbs && this.thumbs.wrapper) {
                this.thumbs.container.find(this.thumbs.element).unbind('click');
                this.thumbs.buttonNext && this.thumbs.buttonNext.unbind('click').unbind('mousedown', disableSelection);
                this.thumbs.buttonPrev && this.thumbs.buttonPrev.unbind('click').unbind('mousedown', disableSelection);
            }
        },


        effects: {

            change: function (index, isNext) {
                this.slider.slides.hide();
                this.slider.slides.eq(index).show();
                this.queueNext();
            },

            fade: function (index, isNext) {
                this.slider.slides.eq(index).css("z-index", 0).show();
                this.slider.slides.eq(this.index).css("z-index", 1)
                    .fadeOut(this.slider.speed, this.proxy('queueNext'));
            },

            lift: function (index, isNext) {
                this.effects.slide.apply(this, [index, isNext, true]);
            },

            rotate: function (index, isNext) {

                var self = this;
                var slider = this.slider;
                var order = slider.order.slice();
                var forward = $.inArray(index, order) > $.inArray(this.index, order);
                var i, marginLeft, offset = 0, slide;

                while (order[0] != index)
                    order.push(order.shift());

                if (slider.offset) {
                    offset = slider.offset != 'center' ? parseInt(slider.offset) :
	Math.round((slider.visible - slider.slides.eq(0).outerWidth(true)) / 2);
                }

                do {
                    order.unshift(order.pop());
                    offset -= slider.slides.eq(order[0]).outerWidth(true);
                } while (offset > 0);

                marginLeft = parseInt(slider.container.css('margin-left'));

                if (forward) {
                    for (i = 0; i < slider.order.length; i++) {
	if (slider.order[i] == order[0]) break;
	slide = slider.slides.eq(slider.order[i]);
	slide.clone().insertBefore(slide).addClass('slide-clone');
	slide.appendTo(slider.container);
	marginLeft -= slide.outerWidth(true);
                    }
                } else {
                    for (i = slider.order.length - 1; i >= 0; i--) {
	slide = slider.slides.eq(slider.order[i]);
	slide.clone().insertBefore(slide).addClass('slide-clone');
	slide.prependTo(slider.container);
	marginLeft -= slide.outerWidth(true);
	if (slider.order[i] == order[0]) break;
                    }
                    slider.container.css({"margin-left": marginLeft + "px"});
                    marginLeft = offset;
                }

                slider.container.delay(100).animate(
                    {"margin-left": marginLeft + 1 + "px"},
                    this.slider.speed,
                    this.slider.easing,
                    function () {
	slider.container.css({"margin-left": offset + 1 + "px"});
	slider.container.find('.slide-clone').remove();
	slider.order = order;
	self.queueNext();
                    });
            },

            shift: function (index) {

                var i, offset = Math.max(this.slider.width - this.slider.visible, 0);

                if (this.slider.slides[index].offset < offset) {
                    offset = this.slider.slides[index].offset;
                } else {
                    if (index > this.index) {
	for (i = 0; i < this.queue.length; i++) {
	    if (this.queue[i] < index) break;
	    index = this.queue[i];
	    this.queue[i] = this.length - 1;
	}
                    } else {
	for (i = this.length - 1; i >= 0; i--) {
	    if (this.slider.slides[i].offset < offset) {
	        offset = this.slider.slides[i].offset;
	        this.queue[0] = i;
	        break;
	    }
	}
                    }
                }

                this.slider.container.animate(
                    {"margin-left": "-" + offset + "px"},
                    this.slider.speed,
                    this.slider.easing,
                    this.proxy('queueNext'));

                var isFirst = offset <= 0;
                var isLast = offset >= this.slider.width - this.slider.visible;
                this.updateButtons(this.slider, isFirst, isLast);
            },

            slide: function (index, isNext, isLift) {

                var self = this;

                var cssOffset = {};
                var cssReset = {"margin-left": 0, "margin-top": 0};
                var container = this.slider.container;
                var forward = index > this.index;
                var slides = this.slider.slides;

                var elem = slides.eq(index);
                var prev = slides.eq(this.index);

                if (isNext) {
                    forward = !forward;
                    if (index == 0) {
	elem.appendTo(container);
                    } else {
	elem.prependTo(container);
                    }
                }

                slides.hide();
                elem.show();
                prev.show();

                if (forward) {
                    cssOffset = isLift ? {"margin-top": "-" + prev.outerHeight(true) + "px"} :
                    {"margin-left": "-" + prev.outerWidth(true) + "px"};
                    container.css(cssReset)
	.animate(
	cssOffset,
	this.slider.speed,
	this.slider.easing,
	function () {
	    isNext && elem.prependTo(container);
	    prev.hide();
	    container.css(cssReset);
	    self.queueNext();
	}
                    );
                } else {
                    cssOffset = isLift ? {"margin-top": "-" + elem.outerHeight(true) + "px"} :
                    {"margin-left": "-" + elem.outerWidth(true) + "px"};
                    container.css(cssOffset)
	.animate(
	cssReset,
	this.slider.speed,
	this.slider.easing,
	function () {
	    isNext && elem.appendTo(container);
	    prev.hide();
	    self.queueNext();
	});
                }
            }
        },


        init: function (slider_options, thumbs_options) {

            var buttonNext, buttonPrev;
            var self = this;

            this.slider = $.extend(this.slider, slider_options);
            this.thumbs = $.extend({}, thumbs_defaults, this.thumbs, thumbs_options);

            // SLIDES
            if (!this.slider.wrapper) {
                console.log("Slider wrapper container is not set!");
                return this;
            }

            if (typeof this.slider.container == "string") {
                this.slider.container = this.slider.wrapper.find(this.slider.container);
            }

            this.slider.slides = this.slider.container.find(this.slider.slideElement);
            this.slider.visible = this.slider.container.parent().width();
            this.slider.width = 0;

            this.length = this.slider.slides.length;

            if (this.length == 0) {
                console.log("Slider is empty!");
                return this;
            }

            // bind prev <=> next buttons
            buttonNext = !!this.slider.buttonNext ? $(this.slider.buttonNext) : this.slider.wrapper.find('.next');
            buttonNext.unbind('click').click(this.proxy('next')).unbind('mousedown', disableSelection).mousedown(disableSelection);
            buttonPrev = !!this.slider.buttonPrev ? $(this.slider.buttonPrev) : this.slider.wrapper.find('.prev');
            buttonPrev.unbind('click').click(this.proxy('prev')).unbind('mousedown', disableSelection).mousedown(disableSelection);

            this.slider.buttonNext = buttonNext;
            this.slider.buttonPrev = buttonPrev;

            // EFFECT DEPENDABLE OPTIONS
            if (!this.effects[this.slider.effect]) this.slider.effect = 'change';
            this.init[this.slider.effect] && this.init[this.slider.effect].apply(this);

            // THUMBNAILS PANEL
            this.thumbsInit();

            // DEFINE START SLIDE IF HASH USED
            if (this.slider.useHashAttr && location.hash) {
                this.slider.slides.invoke(function (slide, i) {
                    var hash = slide.attr(this.slider.useHashAttr);
                    if (hash && location.hash == '#' + hash) {
	this.slider.start = i;
                    }
                }, this);
            }

            // HANDLE TAB/PAGE SWITCH
            this.slider.stopOnWindowBlur && $(window)
                .blur(function () {
                    clearTimeout(self.animate);
                })
                .focus(function () {
                    if (self.animate) {
	self.start();
                    }
                });

            // INIT FUNCTION
            isFunc(this.slider.onInit) && this.slider.onInit.apply(this);

            // STOP AUTO SLIDE CHANGES ON MOUSE HOVER
            this.slider.stopOnMouseHover && this.slider.slides.hover(this.proxy('stop'), this.proxy('start'));

            // SCROLL TO INIT SLIDE IF DEFINED
            if (this.slider.start > 0 || this.index) {
                var speed = this.slider.speed;
                this.slider.speed = 0;
                this.show(this.index || this.slider.start);
                this.slider.speed = speed;
            }

            // START SLIDER
            this.start();

            return this;
        },


        next: function (queued) {
            var index = this.queue.length ? this.queue[this.queue.length - 1] : this.index;
            if (!this.slider.rotate && index == this.length - 1) return false;
            this.show(index == this.length ? 1 : index + 1);
            queued ? this.start() : this.restart();
            return false;
        },


        prev: function () {
            var index = this.queue.length ? this.queue[this.queue.length - 1] : this.index;
            if (!this.slider.rotate && index == 0) return false;
            this.show(index == -1 ? this.length - 2 : index - 1);
            this.restart();
            return false;
        },


        queueNext: function () {
            this.index = this.queue.shift();
            isFunc(this.slider.onSlideEnd) && this.slider.onSlideEnd.apply(this, [this.index]);
            this.queue.length && this.show(this.queue.shift(), true);
        },


        restart: function () {
            this.slider.stopOnChange ? this.stop() : this.start();
            return false;
        },


        /**
         * @param {int} slide index number
         * @param {bool} is it queued. false by default
         */
        show: function (index, queue) {

            var next = false;

            if (!queue && this.queue.length > 0) {
                this.slider.useQueue && this.queue.push(index);
                return;
            }

            if (index >= this.length) {
                index = this.slider.rotate ? index % this.length : this.length - 1;
                next = (index == 0);
            }

            if (index < 0) {
                index = this.slider.rotate ? this.length + (index % this.length) : 0;
                next = (index == this.length - 1);
            }

            if (index == this.index) {
                this.queue.length && this.queueNext();
            } else {
                this.queue.unshift(index);
                if (this.slider.useHashAttr && this.slider.slides.eq(index).attr(this.slider.useHashAttr))
                    location.hash = this.slider.slides.eq(index).attr(this.slider.useHashAttr);
                isFunc(this.slider.onSlide) && this.slider.onSlide.apply(this, [index, this.slider.slides, next]);
                !this.slider.rotate && this.updateButtons(this.slider, index == 0, index == (this.slider.length - 1));
                this.effects[this.slider.effect].apply(this, [index, next]);
                this.thumbs && this.thumbsSet(index);
            }
        },


        start: function () {
            this.animate && this.stop();
            if (this.slider.interval)
                this.animate = setTimeout(this.proxy('next', [true]), this.slider.interval);
        },


        stop: function () {
            clearTimeout(this.animate);
            this.animate = 0;
        },


        /**
         * init thumbnails if they set
         *
         */
        thumbsInit: function () {

            if (!this.thumbs.wrapper || this.thumbs.wrapper.length == 0) {
                this.thumbs = null;
                return;
            }

            this.thumbs['animate'] = false;
            this.thumbs['elements'] = [];
            this.thumbs['offset'] = 0;
            this.thumbs['visible'] = 0;

            if (typeof this.thumbs.container == "string") {
                this.thumbs.container = this.thumbs.wrapper.find(this.thumbs.container);
            }

            // bind prev <=> next buttons
            buttonNext = this.thumbs.buttonNext ? $(this.thumbs.buttonNext) : this.thumbs.wrapper.find('.next');
            buttonNext.unbind('click').click(this.proxy('thumbsScroll', [true])).unbind('mousedown', disableSelection).mousedown(disableSelection);
            buttonPrev = this.thumbs.buttonPrev ? $(this.thumbs.buttonPrev) : this.thumbs.wrapper.find('.prev');
            buttonPrev.unbind('click').click(this.proxy('thumbsScroll', [false])).unbind('mousedown', disableSelection).mousedown(disableSelection);

            this.thumbs.buttonNext = buttonNext;
            this.thumbs.buttonPrev = buttonPrev;

            var d = this.thumbs.direction;
            var offset = 0;
            var wrapper = this.thumbs.container.parent();

            this.thumbs.visible = (d == "h") ? wrapper.width() : wrapper.height();
            this.thumbs.container.find(this.thumbs.element).invoke(function (thumb, index) {

                // bind thumbnail click handler
                thumb.unbind('click').click(this.proxy('show', [index])).click(this.proxy('restart'));

                this.thumbs.elements[index] = thumb;
                this.thumbs.elements[index].offsetStart = offset;
                if (d == "h") {
                    thumb.css("width", thumb.width() + 'px');
                    offset += this.thumbs.width || thumb.outerWidth(true);
                }
                if (d == "v") {
                    thumb.css("height", thumb.height() + 'px');
                    offset += this.thumbs.height || thumb.outerHeight(true);
                }
                this.thumbs.elements[index].offsetEnd = offset;
            }, this);

            if (d == "h") this.thumbs.container.css("width", offset + 'px');
            if (d == "v") this.thumbs.container.css("height", offset + 'px');
            this.thumbs.container.size = offset;

            this.thumbsSet(this.index, false); // do not scroll thumbnails on re-init !
        },


        /**
         * @param {boolean} slide forward; false by default
         */
        thumbsScroll: function (forward) {

            var d = this.thumbs.direction;
            var o = this.thumbs.offset;
            var e = null;

            if (!d || (!this.slider.useQueue && this.thumbs.animate)) return false;

            if (this.thumbs.scroll) {
                o = forward ? o + this.thumbs.scroll : o - this.thumbs.scroll;
            } else {
                if (forward) {
                    o += this.thumbs.visible;
                    for (var i = 0; i < this.thumbs.elements.length; i++) {
	if (this.thumbs.elements[i].offsetEnd > o) {
	    e = this.thumbs.elements[i];
	    break;
	}
                    }
                    o = e ? e.offsetEnd - this.thumbs.visible : this.thumbs.offset;
                } else {
                    for (var i = (this.thumbs.elements.length - 1); i >= 0; i--) {
	if (this.thumbs.elements[i].offsetStart < o) {
	    e = this.thumbs.elements[i];
	    break;
	}
                    }
                    o = e ? e.offsetStart : o;
                }
            }

            var max = this.thumbs.container.size - this.thumbs.visible;
            if (o > max) o = max;
            if (o < 0) o = 0;

            this.thumbs.animate = true;
            var margin = (this.thumbs.direction == "h") ? {"margin-left": "-" + o + "px"} : {"margin-top": "-" + o + "px"};
            this.thumbs.container.animate(margin, this.proxy(function () {
                this.thumbs.animate = false;
            }));
            this.thumbs.offset = o;

            this.thumbs.onScroll && this.thumbs.onScroll(o <= 0, o >= max);

            return false;
        },


        /**
         *
         * @param {int} slide thumbnail index
         * @param {boolean} scroll to thumbnail; true by default
         */
        thumbsSet: function (index, scroll) {

            // if slider does not have thumbnails
            if (!this.thumbs) {
                return false;
            }

            // do not generate error when required thumbnail does not exist
            if (!this.thumbs.elements[index]) {
                return false;
            }

            // add active class to the current thumbnail
            this.thumbs.container.find(this.thumbs.element).removeClass(this.thumbs.classActive);
            this.thumbs.elements[index].addClass(this.thumbs.classActive);

            // slide to selected thumbnail
            if (this.thumbs.current && this.thumbs.direction) {

                var o = this.thumbs.offset;
                var v = this.thumbs.visible;
                var s = this.thumbs.elements[index].offsetStart;
                var e = this.thumbs.elements[index].offsetEnd;
                var c = (e - s) / 2 + s;
                var w = this.thumbs.container.size;

                if (typeof scroll == 'undefined' || scroll) {
                    this.thumbs.container.stop();

                    switch (this.thumbs.current) {
	case "visible":
	    if (s < o) o = s; // bug with thumb border in ff with vertical direction
	    if (e > (o + v)) o = e - v;
	    break;
	default: // center current slide thumbnail
	    o = c - v / 2;
	    if (c > (w - v / 2)) o = w - v;
	    if (c < (v / 2)) o = 0;
                    }
                }

                var margin = (this.thumbs.direction == "h") ? {"margin-left": "-" + o + "px"} : {"margin-top": "-" + o + "px"};
                this.thumbs.container.animate(margin);
                this.thumbs.offset = o;

                this.updateButtons(this.thumbs, o <= 0, o >= w - v);
                this.thumbs.onScroll && this.thumbs.onScroll(o <= 0, o >= w - v);
            }
        },

        updateButtons: function (slider, isFirst, isLast) {
            slider.buttonNext[isLast ? 'addClass' : 'removeClass'](slider.classDisabled);
            slider.buttonPrev[isFirst ? 'addClass' : 'removeClass'](slider.classDisabled);
        },


        /**
         * Proxy to call function in context of current object
         * @param {mixed} function or string
         * @param {array} function arguments; use null to define incoming arguments
         * @param {object} context
         */
        proxy: function (func, args, context) {
            context = context || this;
            args = args || [];
            if (typeof func == 'string')
                func = context[func];
            return function () {
                var a = args.slice();
                for (var i = 0; i < arguments.length; i++)
                    if (typeof a[i] == 'undefined' || a[i] === null)
	a[i] = arguments[i];
                return func.apply(context, a);
            };
        }
    };


    /*
     * Slider extensions: change init function
     */
    themePileSlider.prototype.init.change = function () {
        this.slider.slides.hide().eq(0).show();
        !this.slider.rotate && this.updateButtons(this.slider, true, this.length == 1);
    };


    themePileSlider.prototype.init.fade = themePileSlider.prototype.init.change;
    themePileSlider.prototype.init.lift = themePileSlider.prototype.init.change;
    themePileSlider.prototype.init.slide = themePileSlider.prototype.init.change;


    /*
     * Slider extensions: rotate init function
     */
    themePileSlider.prototype.init.rotate = function () {

        $.extend(this.slider, {
            "offset": this.slider.offset || 0,
            "order" : [],
            "rotate": true
        });

        this.slider.slides.invoke(function (slide, i) {
            slide.css("width", slide.width() + 'px'); // overwrite slide width to fix float values
            this.slider.width += this.slider.scroll || slide.outerWidth(true);
            this.slider.order.push(i);
        }, this);

        var offset = 0;
        if (this.slider.offset) {
            offset = this.slider.offset != 'center' ? parseInt(this.slider.offset) :
                Math.round((this.slider.visible - this.slider.slides.eq(0).outerWidth(true)) / 2);
        }

        var slide;
        do {
            this.slider.order.unshift(this.slider.order.pop());
            slide = this.slider.slides.eq(this.slider.order[0]);
            this.slider.container.prepend(slide);
            offset -= this.slider.scroll || slide.outerWidth(true);
        } while (offset > 0);

        this.slider.container.css({
            "margin-left": offset + 'px',
            "width"      : this.slider.width * 2 + "px"
        });
    };


    /*
     * Slider extensions: shift init function
     *    if slides <li> width is not set in css - it can be float value, so scroll callculation may work incorrectly.
     * @param {object} slider options object
     * @param {object} thumbnails options object
     */
    themePileSlider.prototype.init.shift = function (slider, thumbs) {

        $.extend(this.slider, {"rotate": false});

        this.slider.slides.invoke(function (slide, i) {
            slide.css("width", slide.width() + 'px'); // overwrite slide width to fix float values
            this.slider.slides[i].offset = this.slider.scroll * i || this.slider.width;
            this.slider.width += this.slider.scroll || slide.outerWidth(true);
        }, this);

        this.slider.container.css({"width": this.slider.width + 'px'});
        this.updateButtons(this.slider, true, this.slider.width <= this.slider.visible);
    }


    /*
     * Extend jQuery as plugin
     * @param {object|string} slider options or slider command to execute
     * @param {object|array} thumbnails or command arguments as array []
     */
    $.fn.themePileSlider = function (options, args) {
        return this.each(function () {
            var wrapper = $(this);
            var slider = wrapper.data('themePileSlider');
            if (options == 'destroy' && !slider) return;
            if (slider) {
                options = (typeof options == "string" && slider[options]) ? options : 'init';
                slider[options].apply(slider, $.isArray(args) ? args : []);
                options == 'destroy' && wrapper.removeData('themePileSlider');
            } else {
                options = $.extend({

                    "effect"  : wrapper.attr('data-slider-effect') || slider_defaults.effect,
                    "easing"  : wrapper.attr('data-slider-easing') || slider_defaults.easing,
                    "interval": Number(wrapper.attr('data-slider-interval')) || slider_defaults.interval,
                    "speed"   : Number(wrapper.attr('data-slider-speed')) || slider_defaults.speed,
                    "start"   : Number(wrapper.attr('data-slider-start')) || slider_defaults.start,
                    "useQueue": wrapper.attr('data-slider-queue') || slider_defaults.useQueue

                }, options, {"wrapper": wrapper});

                slider = new themePileSlider(options, $.extend({}, args));
                wrapper.data('themePileSlider', slider);
            }
        });
    };


    /**
     * $.invoke(elements, func, context, extend)
     *
     * @param {array|object} list of elements to iterate
     * @param {function} function with arguments(element, name)
     * @param {context} applied this; default: current element
     * @param {boolean} extend each element as jQuery object
     */
    $.invoke = function (elements, func, context, extend) {
        return $.each(elements, function (name, elem) {
            func.apply(context || this, [extend ? $(elem) : elem, name]);
        });
    };


    /**
     * $('elements').invoke(function(elem, name){}, context)
     *
     * @param {function} function with arguments(element, name)
     * @param {context} applied this; default: current element
     */
    $.fn.invoke = function (func, context) {
        return $.invoke(this, func, context, true);
    };

})(jQuery);