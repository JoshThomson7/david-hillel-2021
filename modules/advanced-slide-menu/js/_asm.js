/*
*	Advanced Slide Menu
*
*	@package Advanced New Homes
*	@version 1.0
*/

jQuery(document).ready(function($) {

    var asm_menu = $('ul.asm__main');

    $(document).on('click', 'i.asm__subnav__arrow', function(e){
        e.preventDefault();

        var parent = $(this).parent();
        parent.children('.sub-menu').addClass('current-menu').prepend('<li class="asm__back"><a href="#" title="Back">Back</a></li>');

        return false;
    });

    $(document).on('click', 'li.asm__back', function(e){
        e.preventDefault();

        var parent = $(this).parent();
        parent.removeClass('current-menu');
        $(this).remove();

        return false;
    });
    
});
