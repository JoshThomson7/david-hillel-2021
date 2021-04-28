/*
*   APF Book a viewing
*
*   @package Advanced Property Framework
*   @version 1.0
*/


jQuery(document).ready(function($){
    var apf_get_query_var = new URLSearchParams(location.search);

    $('.apf__book__viewing__button').click(function(e) {
        e.preventDefault();
        $('.apf__book__viewing__form.view').addClass('open');
        $('body').addClass('no__scroll');
        dateTimePicker($)
        //$('header.header, .banners, .apf').addClass('blur');
    });

    $('.apf__book__viewing.close').click(function(e) {
        e.preventDefault();
        $('.apf__book__viewing__form').removeClass('open');
        $('body').removeClass('no__scroll');
        //$('header.header, .banners, .apf').removeClass('blur');
    });

    var get_book = apf_get_query_var.get('book');
    if(get_book == 'true') {
        $('.apf__book__viewing__button').trigger( "click" );
    }
});

function dateTimePicker() {

    var $ = jQuery; 

    $('.gf__radio__date>.ginput_container>.gfield_radio').lightSlider({
        item: 6,
        loop: false,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        controls: true,
        pager: false,
        slideMove: 6,
        autoWidth: false,
        slideMargin: 0,
        responsive: [
            {
                breakpoint:1100,
                settings: {
                    item: 6,
                }
            },
            {
                breakpoint:768,
                settings: {
                    item:3,
                }
            },
        ]
    });

    $(".gf__radio__date .gfield_radio li input[type=radio]").click(function() {
        /*$(this).removeClass('checked');
        $(this).toggleClass('checked');*/
        var selected = $(this).filter(':checked').val();
        $('.gf__selected__date').html('<span>'+selected+'</span>');

        $('.gf__radio__time>.ginput_container>.gfield_radio').lightSlider({
            item: 6,
            loop: false,
            easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
            controls: true,
            autoWidth: false,
            pager:false,
            slideMove: 6,
            slideMargin: 0,
            responsive: [
                {
                    breakpoint:768,
                    settings: {
                        item:4,
                    }
                },
                {
                    breakpoint:468,
                    settings: {
                        item:3,
                    }
                }
            ]
        });
    });

    $(".gf__radio__time .gfield_radio li input[type=radio]").click(function() {
        /*$(this).removeClass('checked');
        $(this).toggleClass('checked');*/
        var selected = $(this).filter(':checked').val();
        $('.gf__selected__time').html('<span>'+selected+'</span>');
        //e.preventDefault();
    });

}
