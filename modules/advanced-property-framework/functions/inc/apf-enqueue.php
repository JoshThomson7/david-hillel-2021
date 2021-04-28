<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF Enqueue
 *
 * Enqueue necessesary files for APF
 *
 * @author  Various
 * @package Advanced Property Framework
 *

*/

/*
* Load sessions and add scripts to wp_head()
*/
function apf_wp_head() {
	apf_sessions();

	echo "<script>";
	apf_property_js_vars();
	echo "</script>";
}
//add_action( 'wp_head', 'apf_wp_head', 0);


/*
/* Enqueue Scripts
*/
function apf_enqueue() {

    $apf_settings = new APF_Settings();

	// Google Maps
	wp_enqueue_script('google-maps', 'http://maps.googleapis.com/maps/api/js?v=3&key='.$apf_settings->google_maps_api_key());
    wp_enqueue_script('apf-global', apf_path(true).'assets/js/apf-min.js', array('jquery'), '', false);

    // style
    wp_enqueue_style('apf-global', apf_path(true).'assets/css/apf-min.css' );

	// Ajax
	wp_localize_script('apf-global', 'apf_ajax_object', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
        'ajax_nonce' => wp_create_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M'),
        'apf_path' => apf_path(true),
        'apf_page' => get_permalink(get_page_by_path('property-search')),
        'apf_properties_map_url' => get_permalink(get_page_by_path('property-search/xml')),
        'apf_branches_map_url' => get_permalink(get_page_by_path('find-a-branch/xml'))
	));

}
add_action('wp_enqueue_scripts', 'apf_enqueue', 20);
