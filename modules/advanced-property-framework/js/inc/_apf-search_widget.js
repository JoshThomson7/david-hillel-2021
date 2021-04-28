/**
 * APF Search
 * 
 * @package APF
 * @version 2.0
 */

(function ($, root, undefined) {

    $.widget('apf.apfSearch', {

        options: {
            instance: this,
            formEl: '',
            formData: {},
            responseEl: '#apf_response',
            salesPrices: '<option value="50000">&pound;50,000</option>'+
            '<option value="75000">&pound;75,000</option>'+
            '<option value="100000">&pound;100,000</option>'+
            '<option value="125000">&pound;125,000</option>'+
            '<option value="150000">&pound;150,000</option>'+
            '<option value="175000">&pound;175,000</option>'+
            '<option value="200000">&pound;200,000</option>'+
            '<option value="300000">&pound;300,000</option>'+
            '<option value="400000">&pound;400,000</option>'+
            '<option value="500000">&pound;500,000</option>'+
            '<option value="750000">&pound;750,000</option>'+
            '<option value="1000000">&pound;1,000,000</option>'+
            '<option value="1500000">&pound;1,500,000</option>'+
            '<option value="2000000">&pound;2,000,000</option>'+
            '<option value="2500000">&pound;2,500,000</option>'+
            '<option value="3000000">&pound;3,000,000</option>'+
            '<option value="3500000">&pound;3,500,000</option>'+
            '<option value="4000000">&pound;4,000,000</option>'+
            '<option value="4500000">&pound;4,500,000</option>'+
            '<option value="5000000">&pound;5,000,000</option>',
            lettingsPrice: '<option value="100">&pound;100 pcm</option>'+
            '<option value="200">&pound;200 pcm</option>'+
            '<option value="300">&pound;300 pcm</option>'+
            '<option value="400">&pound;400 pcm</option>'+
            '<option value="500">&pound;500 pcm</option>'+
            '<option value="600">&pound;600 pcm</option>'+
            '<option value="700">&pound;700 pcm</option>'+
            '<option value="800">&pound;800 pcm</option>'+
            '<option value="900">&pound;900 pcm</option>'+
            '<option value="1000">&pound;1,000 pcm</option>'+
            '<option value="1250">&pound;1,250 pcm</option>'+
            '<option value="1500">&pound;1,500 pcm</option>'+
            '<option value="1750">&pound;1,750 pcm</option>'+
            '<option value="2000">&pound;2,000 pcm</option>'+
            '<option value="2250">&pound;2,250 pcm</option>'+
            '<option value="2500">&pound;2,500 pcm</option>'+
            '<option value="2750">&pound;2,750 pcm</option>'+
            '<option value="3000">&pound;3,000 pcm</option>',
        },

        /**
         * Constructor
         * 
         * @access private
         */
        _create: function() {
            
            // Bail early if no response element
            if(this.options.responseEl == '') {
                console.error('"responseEl" option is required. This is the element where your data will appear after the AJAX call.');
                return;
            }

            var that = this;
            var timeout = null;

            // Set jQuery element
            this.option('formEl', this.element);

            // Check if we have URL params
            var urlParams = this._maybeGetUrlParams(true);
            if(!$.isEmptyObject(urlParams)) {
                this.option('formData', urlParams);
            } else {
                this.option('formData', this._getFormData());
            }

            // Release the Kraken!
            this.fetch();

            // Listen to form changes
            // this._on( this.element, {
            //     'change': function() {
            //         this.option('formData', this._getFormData());
            //         this.fetch();
            //     },
            //     'keyup': function() {
            //         clearTimeout(timeout);

            //         timeout = setTimeout(function () {
            //             that.option('formData', that._getFormData());
            //             that.fetch();
            //         }, 500);
            //     }
            // });

            // Listen to additional filters
            // if(this.option('additionalFilters')) {                
            //     $.each(this.option('additionalFilters'), function (index, selector) {
            //         $(document).on('change', selector, function() {
            //             that.option('formData', that._getFormData());
            //             that.fetch();
            //         });
            //     });
            // }

            // Set pagination selector
            // if(this.option('paginationSelector')) {                
            //     $(document).on('click', this.option('paginationSelector'), function(evt) {
            //         evt.preventDefault();
            //         that.option('paged', $(this).data('paged'));
            //         that.fetch();
            //     });
            // }
            
        },

        /**
         * Returns serialised form data
         * all forms/filters
         * 
         * @param {string} format
         * @access private
         */
        _getFormData: function() {

            var formData = '';
            var allForms = [this.option('formEl')];

            if(this.option('additionalFilters')) {
                $.each(this.option('additionalFilters'), function (index, selector) {
                    allForms.push($(selector));
                });
            }

            $.each(allForms, function (index, jqObject) {
                formData += '&'+jqObject.serialize();
            });

            return $()._urlParamsToObject(formData);

        },

        /**
         * Check for URL params and return them if they exist
         * 
         * @access private
         */
        _maybeGetUrlParams: function(asJson = false) {

            var params = window.location.search;

            if(params) {
                params = params.substr(1);
                if(params) {
                    params = this._urlParamsToObject(params);
                }
            }

            return params;

        },

        /**
         * Converts URL parameters to object
         * 
         * @param {string} query 
         */
        _urlParamsToObject: function(query) {

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


    });

    var apf_page_url = '';

    var sales_prices = 
        '<option value="50000">&pound;50,000</option>'+
        '<option value="75000">&pound;75,000</option>'+
        '<option value="100000">&pound;100,000</option>'+
        '<option value="125000">&pound;125,000</option>'+
        '<option value="150000">&pound;150,000</option>'+
        '<option value="175000">&pound;175,000</option>'+
        '<option value="200000">&pound;200,000</option>'+
        '<option value="300000">&pound;300,000</option>'+
        '<option value="400000">&pound;400,000</option>'+
        '<option value="500000">&pound;500,000</option>'+
        '<option value="750000">&pound;750,000</option>'+
        '<option value="1000000">&pound;1,000,000</option>'+
        '<option value="1500000">&pound;1,500,000</option>'+
        '<option value="2000000">&pound;2,000,000</option>'+
        '<option value="2500000">&pound;2,500,000</option>'+
        '<option value="3000000">&pound;3,000,000</option>'+
        '<option value="3500000">&pound;3,500,000</option>'+
        '<option value="4000000">&pound;4,000,000</option>'+
        '<option value="4500000">&pound;4,500,000</option>'+
        '<option value="5000000">&pound;5,000,000</option>';

    var lettings_prices = 
        '<option value="100">&pound;100 pcm</option>'+
        '<option value="200">&pound;200 pcm</option>'+
        '<option value="300">&pound;300 pcm</option>'+
        '<option value="400">&pound;400 pcm</option>'+
        '<option value="500">&pound;500 pcm</option>'+
        '<option value="600">&pound;600 pcm</option>'+
        '<option value="700">&pound;700 pcm</option>'+
        '<option value="800">&pound;800 pcm</option>'+
        '<option value="900">&pound;900 pcm</option>'+
        '<option value="1000">&pound;1,000 pcm</option>'+
        '<option value="1250">&pound;1,250 pcm</option>'+
        '<option value="1500">&pound;1,500 pcm</option>'+
        '<option value="1750">&pound;1,750 pcm</option>'+
        '<option value="2000">&pound;2,000 pcm</option>'+
        '<option value="2250">&pound;2,250 pcm</option>'+
        '<option value="2500">&pound;2,500 pcm</option>'+
        '<option value="2750">&pound;2,750 pcm</option>'+
        '<option value="3000">&pound;3,000 pcm</option>';

    var skeleton = 
        '<article class="skeleton">'+
            '<div class="apf__property__border">'+
                '<a class="apf__property__img"></a>'+
                '<div class="apf__property__details__wrap">'+
                    '<div class="apf__property__details">'+
                        '<h3></h3>'+
                        '<h5></h5>'+
                        '<p></p>'+
                    '</div>'+
                    '<div class="apf__property__meta">'+
                        '<div class="apf__property__meta__data">'+
                            '<span></span>'+
                            '<span></span>'+
                            '<span></span>'+
                        '</div>'+
                        '<a></a>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</article>';

    /**
     * On load
     */
    $(window).on('load', function () {

        var timeout;
        handlePriceDropdowns();
        fetchPropertiesOnLoad();

        // Fire search
        $(document).on('click', '.apf-fetch', function (evt) {

            if(evt.target.tagName === 'BUTTON' || $(evt.target).parent()[0].tagName === 'BUTTON') {
                evt.preventDefault();
            }

            var formData = handleFormData($(this));

            if($(this).hasClass('apf-json')) {
                window.location.replace(apf_ajax_object.apf_page);
            } else {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    fetchProperties(formData);
                }, 100);
            }
            
        });

        // View change
        $(document).on('click', '.apf-view-on-change', function (evt) {

            clearTimeout(timeout);

            timeout = setTimeout(() => {
                handleView($(this))
            }, 100);
            
        });

        // Search type
        $(document).on('click', '.apf-search-type label', function (evt) {
        
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                handlePriceDropdowns();
            }, 100);
        });

        // Search type
        $(document).on('click', '.apf-paginate', function (evt) {
        
            var formData = handleFormData($(this));
            fetchProperties(formData);

        });

        // Change
        $('.apf__filter__order').change(function () {
            clickedEl = $(this);

            var formData = handleFormData($(this));
            fetchProperties(formData);
        });

        // Change
        $('.apf__filter__branch').change(function () {
            clickedEl = $(this);

            var formData = handleFormData($(this));
            fetchProperties(formData);
        });

    });

    /**
     * Check if we should fetch on load
     */
    function fetchPropertiesOnLoad() {

        if($('.apf').length > 0) {
            var formData = handleFormData();
            fetchProperties(formData);
        }

    }

    /**
     * Handles price dropdowns
     */
    function handlePriceDropdowns() {

        var type = $('.apf-search-type').find('input:checked').val();

        switch (type) {
            case 'to-let':
                $('#apf_minprice').html('<option value="">No min</option>'+lettings_prices);
                $('#apf_maxprice').html('<option value="">No max</option>'+lettings_prices);
                break;
        
            default:
                $('#apf_minprice').html('<option value="">No min</option>'+sales_prices);
                $('#apf_maxprice').html('<option value="">No max</option>'+sales_prices);
                break;
        }

    }

    /**
     * Handles view change dropdowns
     */
    function handleView(clickedEl) {

        var view = clickedEl.data('view');

        switch (view) {
            case 'list':
                $('.apf__properties').addClass('list');
                break;

            case 'map':
                $('.apf__results').toggleClass('apf__map__hidden');
                break;
        
            default: // grid
                $('.apf__properties').removeClass('list');
                break;
        }

    }

    /**
     * Returns serialised form data
     */
    function getFormData(formEl, format) {
        
        switch (format) {
            case 'object':
                return formEl.serializeJSON();
                break;

            case 'array':
                return formEl.serializeArray();
                break;
        
            default:
                return formEl.serialize();
                break;
        }

    }

    /**
     * Converts JSON object to URL
     * params string
     * 
     * @param obj data 
     */
    function paramify(data) {
        return new URLSearchParams(data).toString();
    }

    /**
     * Handles form data and localStorage
     * 
     * @param obj clickedEl 
     */
    function handleFormData(clickedEl) {

        var formEl = $('#apf_search');

        // JSON Store
        var loadStore = $().jsStorage('apf_search');

        // Form data
        var jsonData = getFormData(formEl, 'object');
        var stringData = paramify(jsonData);

        // On load?
        if(!clickedEl) {
            
            if(loadStore.get()) { // localStorage has data
                jsonData = loadStore.get();
                stringData = paramify(jsonData);

            } else {  // localStorage does not have data
                var params = window.location.search;

                if(params) { // Have we got URL params?
                    stringData = params.substr(1);
                    jsonData = $().urlParamsAsObject(params);
                }
            }

        } else {
        
            if(clickedEl.hasClass('apf-paginate')) {
                var page = clickedEl.data('apf-page');
                $.extend(jsonData, {'apf_page': page});
                console.log(jsonData);
            }

        }

        // Whatever happens, reset store
        loadStore = $().jsStorage('apf_search', jsonData);
        loadStore.set();

        // Update URL
        if(!clickedEl || !clickedEl.hasClass('apf-json')) {
            history.replaceState({ id: 'apf_url' }, '', '?' + stringData);
        }

        // Highlight form elements
        highlightEl(jsonData);

        return {
            loadStore: loadStore,
            jsonData: jsonData,
            stringData: stringData
        }

    }

    /**
     * Highlights/selects/checks form
     * elements programatically
     * 
     * @param obj jsonData 
     */
    function highlightEl(jsonData) {

        $.each(jsonData, function (name, value) {
            
            var el = $('[name="'+name+'"]');

            if(el.length > 0) {
                
                var type = $(el)[0].tagName;

                switch (type) {
                    case 'INPUT':
                        
                        if( $(el).is(':radio') && $(el).val() != value ) {
                            $(el).trigger('click');

                        } else if( $(el).is(':checkbox') && $(el).val() === value ) {
                            $(el).trigger('click');
                            
                        } else if($(el).is(':text')) {
                            $(el).val(value);
                        }

                        break;

                    case 'SELECT':
                        $(el).val(value);
                        break;
                
                    default:
                        break;
                }

            }

        });

    }

    /**
     * Fetches properties via AJAX
     * 
     * @param obj formData 
     */
    function fetchProperties(formData) {

        var responseEl = $('.apf__properties');
        
        // Set our vars
        var apf_market = formData.loadStore.getProp('apf_market');
        var apf_dept = formData.loadStore.getProp('apf_dept');
        var apf_location = formData.loadStore.getProp('apf_location');
        var apf_minprice = formData.loadStore.getProp('apf_minprice');
        var apf_maxprice = formData.loadStore.getProp('apf_maxprice');
        var apf_maxprice = formData.loadStore.getProp('apf_maxprice');
        var apf_minbeds = formData.loadStore.getProp('apf_minbeds');
        var apf_maxbeds = formData.loadStore.getProp('apf_maxbeds');
        var apf_view = formData.loadStore.getProp('apf_view');
        var apf_order = formData.loadStore.getProp('apf_order');
        var apf_status = formData.loadStore.getProp('apf_status');
        var apf_branch = formData.loadStore.getProp('apf_branch');
        var apf_page = formData.loadStore.getProp('apf_page');
        
        responseEl.html($().skeleton(skeleton));

        $.ajax({
            url: apf_ajax_object.ajax_url,
            dataType: 'html',
            type: 'POST',
            data: ({
                'action': 'apf_property_search',
                'apf_security': apf_ajax_object.ajax_nonce,
                'search_data': formData.jsonData
            }),

            success: function (data) {

                responseEl.html(data);                    

                var bLazy = new Blazy({
                    selector: '.blazy'
                });

                // //scroll to results
                // if (clickedEl.hasClass("apf__paginate")) {
                //     var destination = $('.apf__properties').offset().top;
                //     $("html:not(:animated), body:not(:animated)").animate({ scrollTop: destination - 200 }, 700);
                // } else {
                //     $('.apf__properties article').addClass('in-view');
                // }
            }

        });

        mapFilter(formData.jsonData);

    }

    /**
     * Filters map after posts filter
     * 
     * @param object formData
     */
    function mapFilter(formData) {

        $('#apf_map').html('').addClass('skeleton');

        $.ajax({
            url: apf_ajax_object.ajax_url,
            dataType: 'JSON',
            type: 'POST',
            data: ({
                'action': 'apf_map',
                'ajax_security': apf_ajax_object.ajax_nonce,
                'search_data': formData
            }),
            success: function (response) {
                var postIDs = response.toString();
                apfMap(postIDs);
                $('#apf_map').removeClass('skeleton');
            },
            error: function (err) {
                console.error(err);
            }
        });


    }

    /**
     * Initialises Google Map
     * 
     * @param object postIDs 
     */
    function apfMap(postIDs) {
    
        var centre = new google.maps.LatLng(51.507425, -0.127651);

        var map = new google.maps.Map(document.getElementById("apf_map"), {
            center: centre,
            zoom: 11,
            mapTypeId: 'roadmap',

            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.CENTER_BOTTOM
            },

            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.TOP_LEFT
            },

            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.TOP_LEFT
            },
            scrollwheel: false,
            styles: [
                {
                    "featureType": "administrative",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "simplified"
                        },
                        {
                            "color": "#5b6571"
                        },
                        {
                            "lightness": "35"
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#f3f4f4"
                        }
                    ]
                },
                {
                    "featureType": "landscape.man_made",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "weight": 0.9
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#83cead"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#fee379"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#7fc8ed"
                        }
                    ]
                }
            ]
        });

        var i;
        var gmarkers = [];
        var infowindow = new google.maps.InfoWindow();
        var bounds = new google.maps.LatLngBounds();
        
        var marker_icon = new google.maps.MarkerImage(apf_ajax_object.apf_path+"/img/marker-property.png", null, null, null, new google.maps.Size(50,38));
        var hover_icon = new google.maps.MarkerImage(apf_ajax_object.apf_path+"/img/marker-property-hover.png", null, null, null, new google.maps.Size(60,46));
        
        // Read the data
        downloadUrl(apf_ajax_object.apf_properties_map_url+'?posts='+postIDs, function(doc) {
            var xml = xmlParse(doc);
            var markers = xml.documentElement.getElementsByTagName("marker");

            for (var i = 0; i < markers.length; i++) {
                // obtain the attribues of each marker
                var lat = parseFloat(markers[i].getAttribute("lat"));
                var lng = parseFloat(markers[i].getAttribute("lng"));
                var point = new google.maps.LatLng(lat,lng);
                var permalink = markers[i].getAttribute("permalink");
                var name = markers[i].getAttribute("name");
                var price = markers[i].getAttribute("price");
                var type = markers[i].getAttribute("type");
                var status = markers[i].getAttribute("status");
                var seo = markers[i].getAttribute("seo");
                var image = markers[i].getAttribute("image");
                var html =
                    '<div class="infowindow">'+
                        '<div class="infowindow__img">'+
                            '<a href="#" title="Close" class="infowindow-close"><i class="fal fa-times"></i></a>'+
                            '<a href="'+permalink+'" title="Click for full details on '+name+'">'+
                                '<img src="'+image+'" alt="'+name+'">'+
                            '</a>'+
                        '</div>'+
                        '<h3>'+
                            '<a href="'+permalink+'" title="Click for full details on '+name+'">&pound;'+price+(type == 'to-let' ? ' <small>PW</small>' : '' )+'</a>'+
                            (status !== '' ? '<span>'+status+'</span>' : '' )+
                        '</h3>'+
                        '<div class="infowindow__content">'+
                            '<h5>'+seo+'</h5>'+
                            '<p>'+name.replace(/,/g, '<br>')+'</p>'+
                            '<p class="infowindow__content__name-mobile">'+name+'</p>'+
                            '<a href="'+permalink+'" title="Click for full details on '+name+'" class="infowindow__fom">Full details</a>'+
                        '</div>'+
                    '</div>';
                // create the marker
                var marker = createMarker(point,name,html);

                bounds.extend(point);
            }

            map.fitBounds(bounds);
        });

        // A function to create the marker and set up the event window
        function createMarker(latlng,name,html,icon) {
            var contentString = html;
            var marker = new google.maps.Marker({
                position: latlng,
                icon : marker_icon,
                map: map,
                title: name
                //zIndex: Math.round(latlng.lat()*-100000)<<5
            });

            marker.myname = name;
            marker.myicon = icon;
            gmarkers.push(marker);

            google.maps.event.addListener(marker, 'click', function() {

                for (var i = 0; i < gmarkers.length; i++) {
                    gmarkers[i].setIcon(marker_icon);
                }

                marker.setIcon(hover_icon);

                $('#infowindow').addClass('open');
                $('#infowindow').removeClass('closed empty');
                $('#infowindow').empty();
                $('#infowindow').append(html);
            });
        }

        google.maps.event.addDomListener(window, "resize", function() {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });

        google.maps.event.addListener(map, 'click', function() {
            for (var i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setIcon(marker_icon);
            }

            $('#infowindow').empty();
            $('#infowindow').removeClass('open');
            $('#infowindow').addClass('closed empty');
        });

        $('#infowindow').on('click', "a.infowindow-close", function(e) {
            e.preventDefault();

            for (var i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setIcon(marker_icon);
            }

            $('#infowindow').empty();
            $('#infowindow').removeClass('open');
            $('#infowindow').addClass('closed empty');
        });

        // transit layer
        var transitLayer = new google.maps.TransitLayer();
        transitLayer.setMap(map);

        // Load stuff when map has finished loading
        google.maps.event.addListenerOnce(map, 'idle', function(){
            setTimeout(function () {
                $('.apf__properties article').hover(
                    // mouse in
                    function () {
                        var property_index = $('.apf__properties article').index(this);
                        gmarkers[property_index].setIcon(hover_icon);
                    },

                    // mouse out
                    function () {
                        var property_index = $('.apf__properties article').index(this);
                        gmarkers[property_index].setIcon(marker_icon);
                    }
                );
            }, 2000);
        });

        // responsive
        var windowWidth = $(window).width();

        if(windowWidth < 900) {
            map.setOptions({
                mapTypeControl: false,

                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL,
                    position: google.maps.ControlPosition.RIGHT_TOP
                },

                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
            });
        }
    
    }
    

})(jQuery, this);
