/*
*   Advanced Property Framework Map
*
*   Scripts and functions for the APF XML Map
*
*   @package Advanced Property Framework
*   @version 1.0
*/

function apf_init_map() {

    var $ = jQuery;

    // Check if .apf and #map div exist on page so it doesn't throw errors
    if( $('.apf').length > 0 && $('#map').length > 0) {

        var centre = new google.maps.LatLng(50.710412, -1.301558);

        var map = new google.maps.Map(document.getElementById("map"), {
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
            scrollwheel: false
        });

        var i;
        var gmarkers = [];
        var infowindow = new google.maps.InfoWindow();
        var bounds = new google.maps.LatLngBounds();

        var marker_icon = new google.maps.MarkerImage(apf_ajax_object.apf_path+"/img/marker-property.png", null, null, null, new google.maps.Size(50,38));
        var hover_icon = new google.maps.MarkerImage(apf_ajax_object.apf_path+"/img/marker-property-hover.png", null, null, null, new google.maps.Size(60,46));

        // Read the data
        downloadUrl(apf_ajax_object.apf_properties_map_url, function(doc) {
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
            $('#infowindow').append('<p class="empty-text">Tap on a property to preview its details.</p>');
            $('#infowindow').removeClass('open');
            $('#infowindow').addClass('closed empty');
        });

        $('#infowindow').on('click', "a.infowindow-close", function(e) {
            e.preventDefault();

            for (var i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setIcon(marker_icon);
            }

            $('#infowindow').empty();
            $('#infowindow').append('<p class="empty-text">Tap on a property to preview its details.</p>');
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

    } // End check #map

}

jQuery(document).ready(function($) {
    apf_init_map();

    $('.apf__map__hide').on('click', function(e) {
        $(this).toggleClass('active');
        $('.apf__results').toggleClass('apf__map__hidden');
    });

    $('.apf__switch__view__mobile').on('click', function(e) {
        e.preventDefault();

        $('.apf__results__map__wrap').removeAttr('style');
        $('.apf__results__map').toggleClass('apf__results__map__active');

        // if ($(this).text() === "Map") {
        //    $(this).text("Close");
        //    apf_init_map();
        // } else {
        //    $(this).text("Map");
        // }

    });
});
