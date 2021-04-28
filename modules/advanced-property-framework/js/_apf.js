/*
*   Advanced Property Framework scripts
*
*   Scripts and functions for APF
*
*   @package Advanced Property Framework
*   @version 1.0
*/

// @codekit-prepend "inc/_apf-downloadxml.js";
// @codekit-prepend "inc/_apf-map-sticky.js";
// @codekit-prepend "inc/_apf-filter-form.js";
// @codekit-prepend "inc/_apf-search.js";
// @codekit-prepend "inc/_apf-book-viewing-form.js";
// @codekit-prepend "inc/_apf-single-map.js";

// Apps
// @codekit-prepend "../apps/apf-update/js/_apf-update-ajax.js";
// @codekit-prepend "../apps/apf-branches/js/_apf-branches.js";

jQuery(document).ready(function($) {

    // lazyload
    var bLazy = new Blazy({
        selector: '.blazy'
    });

	$('.property__gallery').lightSlider({
        item: 1,
	    loop: false,
	    easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        enableDrag: false,
	    gallery: true,
        thumbItem: 6,
        slideMargin: 0,
        onSliderLoad: function(el) {
            el.lightGallery({
                selector: '.property__gallery .property__gallery__slide',
                download: false,
                hash: false
            });
        }
	});



    $('.property__gallery__all').lightGallery({
        hash: false,
        selector: '.property__gallery__all li',
        fullScreen: false,
        download: false
    });

});