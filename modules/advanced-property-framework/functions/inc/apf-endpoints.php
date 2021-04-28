<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF Property Tabs
 *
 * Add property single endpoints for pretty permalinks
 *
 * @see 	http://wordpress.stackexchange.com/questions/42279/custom-post-type-permalink-endpoint
 *			https://codex.wordpress.org/Rewrite_API/add_rewrite_endpoint
 * @author  Various
 * @package Advanced Property Framework
 *

*/
add_action('init', 'apf_endpoints');

function apf_endpoints() {

    add_rewrite_endpoint('gallery', EP_PERMALINK);
    add_rewrite_endpoint('map', EP_PERMALINK);
    add_rewrite_endpoint('video', EP_PERMALINK);
    add_rewrite_endpoint('floorplan', EP_PERMALINK);

}

/*
	If nothing follows the endpoint, your query var will be empty (but set), so it will always evaluate as false when you try to catch it.

	You can get around this by filtering 'request' and changing the value of your endpoint variables to true if they are set.
*/
add_filter( 'request', 'apf_filter_request' );

function apf_filter_request( $vars ) {

    if( isset( $vars['gallery'] ) ) $vars['gallery'] = true;
    if( isset( $vars['map'] ) ) $vars['map'] = true;
    if( isset( $vars['video'] ) ) $vars['video'] = true;
    if( isset( $vars['floorplan'] ) ) $vars['floorplan'] = true;
    return $vars;

}

/*
    WordPress query vars are awesome, however, if there are no vars set,
    the only way to check for that is to check for all of them.
*/
function apf_is_endpoint() {

    if( get_query_var('gallery') || get_query_var('map') || get_query_var('video') || get_query_var('floorplan') ) {
        return true;
    }

}
