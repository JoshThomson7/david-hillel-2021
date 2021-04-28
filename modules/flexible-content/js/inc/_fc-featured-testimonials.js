
jQuery(document).ready(function($){

    var slider = $('#featured-testimonials--carousel').lightSlider({
        item: 1,
        loop: false,
        cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        controls: false,
        pager: false,
        slideMargin: 0,
        enableDrag: false,
       
    });
    
    /* Handle Filter */
    $(document).on('change', 'input[name="testimonial-filter"]',function(e){
        console.log('triggered')

        let slide = $(this).data('index');
        slider.goToSlide(slide)
      
    } ); 



}); 
