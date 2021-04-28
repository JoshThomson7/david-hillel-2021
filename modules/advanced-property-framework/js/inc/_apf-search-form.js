/*
*   Advanced Property Framework scripts
*
*   Scripts and functions for APF
*
*   @package Advanced Property Framework
*   @version 1.0
*/

var sales_label = 'to-let';
var lettings_label = 'for-sale';

var sales_prices = '<option value="50000">&pound;50,000</option>'+
'<option value="75000">&pound;75,000</option>'+
'<option value="100000">&pound;100,000</option>'+
'<option value="125000">&pound;125,000</option>'+
'<option value="150000">&pound;150,000</option>'+
'<option value="175000">&pound;175,000</option>'+
'<option value="200000">&pound;200,000</option>'+
'<option value="300000">&pound;300,000</option>'+
'<option value="400000">&pound;400,000</option>'+
'<option value="500000">&pound;500,000</option>'+
'<option value="750000">&pound;750,000</option>'+
'<option value="1000000">&pound;1,000,000</option>'+
'<option value="1500000">&pound;1,500,000</option>'+
'<option value="2000000">&pound;2,000,000</option>'+
'<option value="2500000">&pound;2,500,000</option>'+
'<option value="3000000">&pound;3,000,000</option>'+
'<option value="3500000">&pound;3,500,000</option>'+
'<option value="4000000">&pound;4,000,000</option>'+
'<option value="4500000">&pound;4,500,000</option>'+
'<option value="5000000">&pound;5,000,000</option>';

var lettings_prices = '<option value="100">&pound;100 pcm</option>'+
'<option value="200">&pound;200 pcm</option>'+
'<option value="300">&pound;300 pcm</option>'+
'<option value="400">&pound;400 pcm</option>'+
'<option value="500">&pound;500 pcm</option>'+
'<option value="600">&pound;600 pcm</option>'+
'<option value="700">&pound;700 pcm</option>'+
'<option value="800">&pound;800 pcm</option>'+
'<option value="900">&pound;900 pcm</option>'+
'<option value="1000">&pound;1,000 pcm</option>'+
'<option value="1250">&pound;1,250 pcm</option>'+
'<option value="1500">&pound;1,500 pcm</option>'+
'<option value="1750">&pound;1,750 pcm</option>'+
'<option value="2000">&pound;2,000 pcm</option>'+
'<option value="2250">&pound;2,250 pcm</option>'+
'<option value="2500">&pound;2,500 pcm</option>'+
'<option value="2750">&pound;2,750 pcm</option>'+
'<option value="3000">&pound;3,000 pcm</option>';

jQuery(document).ready(function($){
    $('.apf__checkbox__'+sales_label).attr('checked','checked');
    $('.apf__'+sales_label).addClass('checked');

    if(apf_type) {

        if(apf_type === 'sales') {

            $('.apf__'+sales_label).addClass('checked');
            $('.apf__'+lettings_label).removeClass('checked');

            $('.apf__checkbox__'+sales_label).attr('checked','checked');
            $('.apf__checkbox__'+lettings_label).removeAttr('checked');

            $('select.apf__minprice, select.apf__maxprice').html(sales_prices);

            $('select.apf__minprice').prepend('<option value="0">Min price</option>');
            $('select.apf__maxprice').prepend('<option value="10000000">Max price</option>');

        } else if(apf_type === 'lettings') {

            $('.apf__'+lettings_label).addClass('checked');
            $('.apf__'+sales_label).removeClass('checked');

            $('.apf__checkbox__'+lettings_label).attr('checked','checked');
            $('.apf__checkbox__'+sales_label).removeAttr('checked');

            $('select.apf__minprice, select.apf__maxprice').html(lettings_prices);

            $('select.apf__minprice').prepend('<option value="0">Min price</option>');
            $('select.apf__maxprice').prepend('<option value="10000000">Max price</option>');
        }

    } else {

        $('select.apf__minprice, select.apf__maxprice').html(sales_prices);
        $('select.apf__minprice').prepend('<option value="0" selected="selected">Min price</option>');
        $('select.apf__maxprice').prepend('<option value="10000000" selected="selected">Max price</option>');

    }

    if(apf_area_search) {
        $("select.apf__select.area option[value='"+apf_area_search+"']").attr('selected', 'selected');
    }

    if(apf_minprice) {
        $("select.apf__minprice option[value='"+apf_minprice+"']").attr('selected', 'selected');
    }

    if(apf_maxprice) {
        $("select.apf__maxprice option[value='"+apf_maxprice+"']").attr('selected', 'selected');
    }

    if(apf_minbeds) {
        $("select.apf__minbeds option[value='"+apf_minbeds+"']").attr('selected', 'selected');
    }

    if(apf_maxbeds) {
        $("select.apf__maxbeds option[value='"+apf_maxbeds+"']").attr('selected', 'selected');
    }

    if(apf_area_search && apf_area_search !== '') {
        $(".area-register").attr("placeholder", "Area, postcode, town, street");
    }

    // handle the user selections on click
    $('.apf__'+sales_label).click(function(event) {
        event.preventDefault();

        $(this).addClass('checked');
        $('.apf__'+lettings_label).removeClass('checked');

        $('.apf__checkbox__'+sales_label).attr('checked','checked');
        $('.apf__checkbox__'+lettings_label).removeAttr('checked');

        $('select.apf__minprice, select.apf__maxprice').html(sales_prices);

        $('select.apf__minprice').prepend('<option value="0" selected="selected">Min price</option>');
        $('select.apf__maxprice').prepend('<option value="10000000" selected="selected">Max price</option>');

        $('select.apf__minbeds option[value="0"]').attr('selected', 'selected');
        $('select.apf__maxbeds option[value="100"]').attr('selected', 'selected');
    });

    $('.apf__'+lettings_label).click(function(event) {
        event.preventDefault();

        $(this).addClass('checked');
        $('.apf__'+sales_label).removeClass('checked');

        $('.apf__checkbox__'+lettings_label).attr('checked','checked');
        $('.apf__checkbox__'+sales_label).removeAttr('checked');

        $('select.apf__minprice, select.apf__maxprice').html(lettings_prices);

        $('select.apf__minprice').prepend('<option value="0" selected="selected">Min price</option>');
        $('select.apf__maxprice').prepend('<option value="10000000" selected="selected">Max price</option>');

        $('select.apf__minbeds option[value="0"]').attr('selected', 'selected');
        $('select.apf__maxbeds option[value="100"]').attr('selected', 'selected');
    });
});
