<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF ACF Pre Save
 *
 * Clever functions to set relationships between
 * properties and developments
 *
 * @author  Various
 * @package Advanced Property Framework
 *

*/

function apf_acf_init() {
    $apf_settings = new APF_Settings();
	acf_update_setting('google_api_key', $apf_settings->google_maps_api_key());
}
add_action('acf/init', 'apf_acf_init');

/* ------------------------------------------*/
/* 	SAVE PROPERTY LAT/LNG DATA
/* 	In order to use radius searching, save
/*  the lat/long data into separate custom
/*  fields when property data is saved.
* -------------------------------------------*/
function get_property_map_data($post_id) {

	// Check if this is a clinic post
	if(get_post_type($post_id) == 'property'){

		// Get the existing address data from the Google Map field
		$property_map_data = get_field('property_address', $post_id);

        if($property_map_data) {
		    $property_address = $property_map_data['address'];
            update_field('property_address_searchable', $property_address, $post_id);
        }
	}

    return $post_id;
}

// Run after ACF saves the $_POST['acf'] data
add_action('acf/save_post', 'get_property_map_data', 20);


/*--------------------------------------------------------------------------*/
/*    function aef_price_validator();
/*	  checks if event start date is greater than
/*	  event end date and if it is, throws an error
/*--------------------------------------------------------------------------*/
add_filter('acf/validate_value/name=property_price', 'aef_price_validator', 10, 4);

function aef_price_validator( $valid, $value, $field, $input ) {

	// bail early if value is already invalid
	if( !$valid ) {
		return $valid;
	}

	$price = $_POST['acf']['field_57fe5641328df'];

	if (strpos($price, '£') !== false) {
		$valid = 'No pound sign, por favor :)';
	}

	return $valid;

}

if( function_exists('acf_add_options_page') ) {
    acf_add_options_sub_page(array(
        'page_title'  => 'Settings',
        'menu_title'  => 'Settings',
        'parent_slug' => 'edit.php?post_type=property',
    ));
}
