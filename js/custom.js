// JS Awesomeness

/*
-------------------------------------------
    ____           __          __
   /  _/___  _____/ /_  ______/ /__  _____
   / // __ \/ ___/ / / / / __  / _ \/ ___/
 _/ // / / / /__/ / /_/ / /_/ /  __(__  )
/___/_/ /_/\___/_/\__,_/\__,_/\___/____/

-------------------------------------------
*/

// Libs
// @codekit-prepend "../lib/tooltipster/js/_tooltipster.bundle.min.js";
// @codekit-prepend "../lib/lightgallery/js/_lightgallery.js";
// @codekit-prepend "../lib/lightslider/js/_lightslider.js";
// @codekit-prepend "../lib/slick/js/_slick.min.js";
// @codekit-prepend "../lib/isotope/_imagesloaded.pkgd.min.js";
// @codekit-prepend "../lib/isotope/_isotope.pkgd.min.js";
// @codekit-prepend "inc/_sticky-menu.js";
// @codekit-prepend "../lib/blazy/_blazy.min.js";
// @codekit-prepend "inc/_utils.js";

// Modules
// @codekit-prepend "../modules/off-canvas-nav/js/_oc-nav.js";
// @codekit-prepend "../modules/advanced-video-banners/js/_avb.js";
// @codekit-prepend "../modules/gravity-forms/js/_gf.js";
// @codekit-prepend "../modules/flexible-content/js/_flexible-content.js";
// @codekit-prepend "../modules/advanced-slide-menu/js/_asm.js";
// @codekit-prepend "../modules/off-canvas-nav/js/_oc-nav.js";

jQuery(document).ready(function($) {

	sticky_menu();

    // --------------- Mega Menu --------------- //
    $("header.header .burger__menu, #mega_menu .button-close").click(function() {
        $("#mega_menu").fadeToggle(300);
        $('a.menu-icon-open').toggleClass('open');
        $('a.property__search__trigger').toggleClass('open');
        $('body').toggleClass('no-scroll');
        return false;
    });

    /* Dynamically open video lightgallery */
    $(document).on('click', '.play__video', function (e) {
        e.preventDefault();

        const video_link = this.href;

        if (video_link.length > 0) {
            $(this).lightGallery({
                cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
                dynamic: true,
                hash: false,
                videoMaxWidth: '1200px',
                zoom: false,
                counter: false,
                download: false,
                controls: false,
                dynamicEl: [{
                    src: video_link,
                }]

            });
        }
    })

    
	// -------------------------------------------- //
	//                 Scroll Item                  //
	// -------------------------------------------- //
	$('.scroll').click(function(e) {
		e.preventDefault();
	    var elementClicked = $(this).attr("href");
	    var destination = $(elementClicked).offset().top;

	    $("html:not(:animated),body:not(:animated)").animate({
	        scrollTop: destination - 170
	    }, 800);
	});

	// -------------------------------------------- //
	//                     Footer                   //
	// -------------------------------------------- //
	    var winIsSmall;

	    function footerAccordion() {
	        winIsSmall = window.innerWidth < 1024;
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

    // -------------------------------------------- //
    //                  Tooltipster                 //
    // -------------------------------------------- //
    $('.tooltip:not(.tooltipstered)').tooltipster({
        functionInit: function (instance, helper) {
            var $origin = $(helper.origin);
            var dataOptions = $origin.attr('data-tooltipster');

            if (dataOptions) {

                dataOptions = JSON.parse(dataOptions);

                // set defaults
                dataOptions.theme = 'tooltipster-punk';
                dataOptions.contentAsHTML = true;
                dataOptions.contentCloning = true;
                //dataOptions.trigger = 'custom';
                //dataOptions.triggerOpen = {'click': false, 'tap': true, 'mouseenter': true, 'scroll': false};
                //dataOptions.triggerClose = {'click': true, 'scroll': false, 'tap': true, 'mouseleave': false};
                //console.log(dataOptions);

                $.each(dataOptions, function (name, option) {
                    instance.option(name, option);
                });

            }
        }
    });

});
