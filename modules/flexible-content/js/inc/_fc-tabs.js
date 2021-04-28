/*
---------------------------
  ______      __
 /_  __/___ _/ /_  _____
  / / / __ `/ __ \/ ___/
 / / / /_/ / /_/ (__  )
/_/  \__,_/_.___/____/

---------------------------
Tabs
*/

jQuery(document).ready(function($){

    $('.fc_tabs ul.tabbed li').click(function() {
        $('ul.tabbed li').removeClass('active');
        $(this).addClass('active');
        $('.tab__content').hide();
        var activeTab = $(this).find('a').attr('data-id');
        $('.' + activeTab).fadeIn();
        return false;
    });

    $('.fc_tabs ul.tabbed li:first').trigger('click');

});
