// Genrate XML
function apf_update_properties_ajax() {

    var $ = jQuery;

    $('#apf_update_properties').html('<p>1. Generating import file from Reapit.</p><svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="#b70e0c"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle></g></svg>');

    $.ajax({
        url: apf_ajax_object.ajax_url,
        dataType: 'html',
        type: 'POST',
        async: true,
        data: ({
            'action' : 'apf_update_properties_ajax',
            'apf_security' : apf_ajax_object.ajax_nonce
        }),

        success: function(data) {
            $('#apf_update_properties').html(data);
            apf_update_properties_ajax_2();
        }

    });
}

// Run import
function apf_update_properties_ajax_2() {

    var $ = jQuery;

    $('#apf_update_properties').append('<p class="apf__update__running">2. Running import.</p><svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="#b70e0c"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle></g></svg>');

    setTimeout(function(){
        $('.apf__update__running').text('Patience my young padawan. Still running.');
    }, 10000);

    setTimeout(function(){
        $('.apf__update__running').text('Put the kettle on?');
    }, 20000);

    setTimeout(function(){
        $('.apf__update__running').text('(Sip) Aaah much better!');
    }, 30000);

    setTimeout(function(){
        $('.apf__update__running').text('Pub?');
    }, 40000);

    setTimeout(function(){
        $('.apf__update__running').text('Is it Friday yet?');
    }, 50000);

    setTimeout(function(){
        $('.apf__update__running').text('Blimey! I\'m just a website and even I am getting bored.');
    }, 60000);

    setTimeout(function(){
        $('.apf__update__running').text('Time to call Alex? He is awesome, he can fix this. Nah it\'s working, just give it a bit more time.');
    }, 120000);

    setTimeout(function(){
        $('.apf__update__running').text('Alright, maybe call Alex now.');
    }, 600000);

    $.ajax({
        url: apf_ajax_object.ajax_url,
        dataType: 'html',
        type: 'POST',
        async: true,
        data: ({
            'action' : 'apf_update_properties_ajax_2',
            'apf_security' : apf_ajax_object.ajax_nonce
        }),

        success: function(data) {
            $('#apf_update_properties').html(data);
            $('a.apf__update__trigger').removeClass('disabled').text('Update now');
        }

    });

}

jQuery(document).ready(function($) {

    jQuery(document).on('click', '.apf__update__trigger', function(e) {
        e.preventDefault();

        $(this).addClass('disabled').text('Updating');
        apf_update_properties_ajax();
    });

});
