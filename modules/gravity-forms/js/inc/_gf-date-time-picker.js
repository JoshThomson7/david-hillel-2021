jQuery(document).ready(function($) {

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
});
