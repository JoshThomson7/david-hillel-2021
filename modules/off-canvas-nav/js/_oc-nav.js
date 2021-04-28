/**
 * Off-Canvas Navigation
 * 
 * Full-screen, overlay navigation.
 *
 */

function oc_nav_ajax() {

    var $ = jQuery;

    $.ajax({
        url: oc_nav_ajax_object.ajax_url,
        dataType: 'html',
        type: 'POST',
        cache: true,
        data: ({
            'action' : 'oc_nav_ajax',
            'oc_nav_security' : oc_nav_ajax_object.ajax_nonce
        }),

        success: function(data) {
            $('#oc_nav_response').html(data);

            var $grid = $('.masonry').imagesLoaded( function() {
                // init Isotope after all images have loaded
                $grid.isotope({
                    itemSelector: '.masonry__item'
                });
            });
        }

    });

}

jQuery(document).ready(function($) {

    var burger_element = $('.oc__nav__trigger');

    $(document).on('click', '.oc__nav__trigger', function(e) {
        e.preventDefault();
        
        $(this).find('a').toggleClass('open');
        $('.oc__nav').toggleClass('oc__nav__active');
        $('body').toggleClass('no__scroll');

        oc_nav_ajax();
    });

});