<?php
/**
 * APF AJAX
 *
 * Used for Ajaxifying property results. Yeah!
 *
 * @author  Various
 * @package Advanced Property Framework
 *
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function fetchProperties($data) {

    $search_params = isset($_POST['search_data']) && !empty($_POST['search_data']) ? $_POST['search_data'] : '';

    $apf_market = isset($search_params['apf_market']) && !empty($search_params['apf_market']) ? htmlspecialchars(trim($search_params['apf_market'])) : 'residential';
    $apf_dept = isset($search_params['apf_dept']) && !empty($search_params['apf_dept']) ? htmlspecialchars(trim($search_params['apf_dept'])) : 'for-sale';
    $apf_location = isset($search_params['apf_location']) && !empty($search_params['apf_location']) ? str_replace(',', '', trim($search_params['apf_location'])) : '';
    
	$apf_minprice = isset($search_params['apf_minprice']) && !empty($search_params['apf_minprice']) ? $search_params['apf_minprice'] : 0;
	$apf_maxprice = isset($search_params['apf_maxprice']) && !empty($search_params['apf_maxprice']) ? $search_params['apf_maxprice'] : 9999999999;
	$apf_minbeds = isset($search_params['apf_minbeds']) && !empty($search_params['apf_minbeds']) ? $search_params['apf_minbeds'] : 0;
	$apf_maxbeds = isset($search_params['apf_maxbeds']) && !empty($search_params['apf_maxbeds']) ? $search_params['apf_maxbeds'] : 9999999999;
	$apf_view = isset($search_params['apf_view']) && !empty($search_params['apf_view']) ? $search_params['apf_view'] : 'grid';
	$apf_order = isset($search_params['apf_order']) && !empty($search_params['apf_order']) ? $search_params['apf_order'] : 'price_desc';
    $apf_status = isset($search_params['apf_status']) && !empty($search_params['apf_status']) ? $search_params['apf_status'] : '';
    $apf_new_homes = isset($search_params['apf_new_homes']) && !empty($search_params['apf_new_homes']) ? $search_params['apf_new_homes'] : '';
    $apf_branch = isset($search_params['apf_branch']) && !empty($search_params['apf_branch']) ? $search_params['apf_branch'] : '';
    $apf_page = isset($search_params['apf_page']) && !empty($search_params['apf_page']) ? $search_params['apf_page'] : 1;
    
    $args = array(
        'post_type'         => 'property',
        'post_status'       => 'publish',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy'  => 'property_market',
                'field'     => 'slug',
                'terms'     => $apf_market,
                'operator'  => 'IN'
            ),
            array(
                'taxonomy'  => 'property_department',
                'field'     => 'slug',
                'terms'     => $apf_dept,
                'operator'  => 'IN'
            )
        ),
        'meta_query' => array(
            array(
                'key'       => 'property_address_searchable',
                'value'     => $apf_location,
                'compare'   => 'LIKE'
            ),
            array(
                'key'       => 'property_price',
                'value'     => array($apf_minprice, $apf_maxprice),
                'compare'   => 'BETWEEN',
                'type'      => 'numeric'
            ),
            array(
                'key'       => 'property_bedrooms',
                'value'     => array($apf_minbeds, $apf_maxbeds),
                'compare'   => 'BETWEEN',
                'type'      => 'numeric'
            ),
            array(
                'key'       => 'property_status',
                'value'     => apf_property_search_exclude_status($apf_status),
                'compare'   => 'NOT IN',
            )
        ),
        'posts_per_page'    => 16,
        'paged'             => $apf_page,
        'fields'            => 'ids'
    );

    if($apf_new_homes === 'true') {
        array_push($args['meta_query'], array(
            'key'       => 'property_new_home',
            'value'     => 1,
            'compare'   => '=',
        ));
    }

    switch ($apf_order) {
        case 'price_asc':
            $args['meta_key'] = 'property_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;

        case 'date_desc':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;

        case 'date_asc':
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
            break;
        
        default:
            $args['meta_key'] = 'property_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
    }

    if($apf_branch) {
        $args['meta_query'][] = array(
            'key'       => 'property_branch',
            'value'     => $apf_branch,
            'compare'   => '='
        );
    }

    // WP_Query
    $query = new WP_Query($args);

    // Return
    $data = new stdClass();
    $data->search_params = $search_params;
    $data->WP_Query = new WP_Query($args);

    return $data;

}

function apf_property_search() {

	// Security check
    wp_verify_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M', 'apf_security');
    
    $search_params = isset($_POST['search_data']) && !empty($_POST['search_data']) ? $_POST['search_data'] : '';
    $properties = fetchProperties($search_params);
	require_once(apf_path().'templates/apf-loop.php');

	wp_die();
}

add_action('wp_ajax_nopriv_apf_property_search', 'apf_property_search');
add_action('wp_ajax_apf_property_search', 'apf_property_search');

/**
 * Filter Map.
 *
 * @since	1.0
 */
function apf_map() {

    // Security check.
    wp_verify_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M', 'ajax_security');

    $search_params = isset($_POST['search_data']) && !empty($_POST['search_data']) ? $_POST['search_data'] : '';
    $properties = fetchProperties($search_params);
    wp_send_json($properties->WP_Query->posts);
    wp_die();

}

add_action('wp_ajax_nopriv_apf_map', 'apf_map');
add_action('wp_ajax_apf_map', 'apf_map');

/*
*	Get total number of pages
*	Important: Must go after the query or it won't work
*/
function apf_total_pages($pages = '') {
    global $property_query;

    if($pages == '') {
         global $wp_query;
         $pages = $wp_query->max_num_pages;

         if(!$pages) {
             $pages = 1;
         }
    }

    return $pages;
}
