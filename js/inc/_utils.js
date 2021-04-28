(function ($, root, undefined) {

    /**
     * Script in charge on loading code-splitted
     * dependencies via HTML markup. Dependencies
     * will automatically be injected into <head></head>
     * 
     * @usage <div has-deps" data-deps='{"js":["search-filters"]}' data-deps-path="wp_ajax_object" data-deps-action="wp_filter"></div>
     */
    $.fn.loadDependencies = function () {

        var hasDeps = $('.has-deps');

        if (hasDeps) {
            hasDeps.each(function (index, el) {
                var modules = $(el).data('deps');
                var hasDepsPath = $(el).data('deps-path');
                var depsPath = window[hasDepsPath];
                
                if (modules && depsPath instanceof Object) {
                    $.each(modules, function (key, values) {
                        $.each(values, function (index, value) {
                            switch (key) {
                                case 'js':
                                    scripts = $.getScript(depsPath.jsPath + value + '.min.'+key);
                                    break;
                            }
                        });
                    });
                }
            
            });
        }

    }

    /**
     * Script in charge of making the main menu
     * sticky when scrolling up and hiding it
     * when crolling down.
     */
    $.fn.stickyMenu = function () {

        // Hide header on scroll down
        var didScroll;
        var lastScrollTop = 0;
        var navbarHeight = $('header.header').outerHeight();
        var delta = navbarHeight;

        $(window).scroll(function(event){
            didScroll = true;
        });

        setInterval(function() {
            if (didScroll) {
                hasScrolled();
                didScroll = false;
            }
        }, 250);

        function hasScrolled() {
            var st = $(this).scrollTop();
            
            // Make scroll more than delta
            if(Math.abs(lastScrollTop - st) <= delta)
                return;
            
            // If scrolled down and past the navbar, add class .nav-up.
            if (st > lastScrollTop && st > navbarHeight){
                // Scroll Down
                $('header.header').removeClass('sticky reset').addClass('not-sticky');
                
            } else {
                if(st >= 0 && st <= 150) {
                    $('header.header').addClass('reset').removeClass('not-sticky sticky');
                    
                } else if(st + $(window).height() < $(document).height()) {
                    $('header.header').removeClass('not-sticky reset').addClass('sticky');
                }
            }
        
            lastScrollTop = st;
        }

    }

    /**
     * Animates to clicked anchor smoothly
     */
    $.fn.smoothScroll = function () {

        $(document).on('click', '.scroll', function(e) {
            e.preventDefault();
            var elementClicked = $(this).attr("href");
            var destination = $(elementClicked).offset().top;
    
            $("html:not(:animated), body:not(:animated)").animate({
                scrollTop: destination - 170
            }, 800);
        });

    }

    /**
     * Requires Chosen JS library.
     * Turns selects into nice and
     * pretty dropdowns
     * 
     * @docs https://harvesthq.github.io/chosen/
     */
    $.fn.chosenSelect = function () {

        var chosen = $('.chosen-select').chosen({
            placeholder_text_single: 'Any',
            allow_single_deselect: true,
            inherit_select_classes: true
        });

    }

    /**
     * Expands <textarea> in height if
     * content bigger than area itself.
     */
    $.fn.textAreaResize = function () {

        $.each($('textarea[data-autoresize]'), function () {
            var offset = this.offsetHeight - this.clientHeight;

            var resizeTextarea = function (el) {
                $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            $(this).on('keyup input', function () {
                resizeTextarea(this);
            }).removeAttr('data-autoresize');
        });

    }

    /**
     * Requires Tooltipster library.
     * Easy way to add tooltips via markup.
     * 
     * @docs https://iamceege.github.io/tooltipster/
     */
    $.fn.tooltips = function () {

        // Tooltips.
        $('.tooltip:not(.tooltipstered)').tooltipster({
            theme: 'tooltipster-dark',
            contentAsHTML: true,
            contentCloning: true,
            maxWidth: 450,
            functionPosition: function (instance, helper, position) {

                var elementID = instance.__Content[0].id;

                if (elementID && (elementID === 'tooltip_user_menu' || elementID === 'tooltip_notifications')) {
                    position.coord.left -= 30;
                }

                return position;
            },
            functionInit: function (instance, helper) {
                var $origin = $(helper.origin);
                var dataOptions = $origin.attr('data-tooltipster');

                // Override options via data attribute.
                if (dataOptions) {

                    dataOptions = JSON.parse(dataOptions);

                    $.each(dataOptions, function (name, option) {

                        // if(name === 'functionBefore') {

                        //     var tmpFn = window[option]($, instance);
                        //     instance.option(name, tmpFn);


                        // } else { 

                        instance.option(name, option);

                        //}

                    });


                }
            }
        });

    }

    /**
     * Converts footer menus into accordions
     * after a pre-defined width breakpoint
     * 
     * @param int width
     */
    $.fn.footerAccordions = function (width = 1024) {

        var winIsSmall;

	    function footerAccordion() {
	        winIsSmall = window.innerWidth < width;
	        $('footer article.footer__menu ul').toggle(!winIsSmall);
	    }

	    $('footer article.footer__menu').find('h5').click(function () {
	        if(winIsSmall){
	            $(this).toggleClass('active');
	            $(this).children().toggleClass('ion-ios-plus-empty ion-ios-minus-empty');
	            $(this).parent().find('ul').stop().slideToggle(100);
	        }
	    });

	    $(window).on('load resize', footerAccordion);

    }

    /**
     * Converst a serialised array
     * into a JSON Object
     */
    $.fn.serializeJSON = function () {

        var unindexed_array = this.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }

    /**
     * Utility to handle local storage
     */
    $.fn.jsStorage = function (item) {

        return {

            exists: function exists() { 
                return localStorage.getItem(item) ? true : false;
            },

            set: function set(data) { 
                localStorage.setItem(item, JSON.stringify(data));
            },

            get: function get() { 
                return JSON.parse(localStorage.getItem(item));
            },

            getProp: function getProp(prop) {
                return this.get(item)[prop];
            },

            remove: function remove() { 
                localStorage.removeItem(item);
            }

        }
    }

    /**
     * Outputs skeleton markup
     * as content preloader
     * 
     * @param {string} markup
     * @param {int} rows
     */
    $.fn.skeleton = function(markup, rows) {

        var skeleton = '';
        rows = rows ? rows : 7;

        for (i = 1; i < rows; i++) {
            skeleton += markup;
        }

        return skeleton;

    }

    /**
     * Converts URL parameters to object
     * 
     * @param {string} query 
     */
    $.fn.urlParamsAsObject = function(query) {

        query = query.substring(query.indexOf('?') + 1);
    
        var re = /([^&=]+)=?([^&]*)/g;
        var decodeRE = /\+/g;
    
        var decode = function (str) {
            return decodeURIComponent(str.replace(decodeRE, " "));
        };
    
        var params = {}, e;
        while (e = re.exec(query)) {
            var k = decode(e[1]), v = decode(e[2]);
            if (k.substring(k.length - 2) === '[]') {
                k = k.substring(0, k.length - 2);
                (params[k] || (params[k] = [])).push(v);
            }
            else params[k] = v;
        }
    
        var assign = function (obj, keyPath, value) {
            var lastKeyIndex = keyPath.length - 1;
            for (var i = 0; i < lastKeyIndex; ++i) {
                var key = keyPath[i];
                if (!(key in obj))
                    obj[key] = {}
                obj = obj[key];
            }
            obj[keyPath[lastKeyIndex]] = value;
        }
    
        for (var prop in params) {
            var structure = prop.split('[');
            if (structure.length > 1) {
                var levels = [];
                structure.forEach(function (item, i) {
                    var key = item.replace(/[?[\]\\ ]/g, '');
                    levels.push(key);
                });
                assign(params, levels, params[prop]);
                delete(params[prop]);
            }
        }
        return params;
    }

}(jQuery));