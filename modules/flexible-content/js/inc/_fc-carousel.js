/*
------------------------------------------------
   ______                                 __
  / ____/___ __________  __  __________  / /
 / /   / __ `/ ___/ __ \/ / / / ___/ _ \/ /
/ /___/ /_/ / /  / /_/ / /_/ (__  )  __/ /
\____/\__,_/_/   \____/\__,_/____/\___/_/

------------------------------------------------
Carousel
*/

jQuery(document).ready(function($){

    $('.carousel_images').lightSlider({
        item: 6,
        loop: true,
        cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        controls: true,
        prevHtml: '<i class="ion-ios-arrow-left"></i>',
        nextHtml: '<i class="ion-ios-arrow-right"></i>',
        pager: false,
        autoWidth: true,
        auto: true,
        pause: 6000,
        slideMargin: 0,
        enableDrag: false,
        responsive : [
            {
                breakpoint:900,
                settings: {
                    item:1
                }
            }
        ]
    });

    $('#testimonials_carousel').lightSlider({
        item: 3,
        loop: true,
        cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        controls: false,
        prevHtml: '<i class="ion-ios-arrow-left"></i>',
        nextHtml: '<i class="ion-ios-arrow-right"></i>',
        pager: true,
        auto: true,
        pause: 6000,
        slideMargin: 0,
        enableDrag: false,
        responsive : [
            {
                breakpoint:900,
                settings: {
                    item:1
                }
            }
        ]
    });

    $('.fc-layout-carousel').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        pause: 6000,
        arrows: true,
        fade: false,
        adaptiveHeight: true,
        prevHtml: '<i class="ion-ios-arrow-left"></i>',
        nextHtml: '<i class="ion-ios-arrow-right"></i>',
        cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1)'
    });

});
