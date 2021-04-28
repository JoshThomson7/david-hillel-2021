<?php
// Prepare query
global $wp_query;
$pages = $wp_query->max_num_pages;

$args = array(
    'post_type'         => 'property',
    'post_status'       => 'publish',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy'  => 'property_dept',
            'field'     => 'slug',
            'terms'     => $apf_dept,
            'operator'  => 'IN'
        ),
        array(
            'taxonomy'  => 'property_type',
            'field'     => 'slug',
            'terms'     => $apf_type,
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
        // array(
        //     'key'       => 'property_status',
        //     'value'     => apf_property_search_exclude_status($apf_status),
        //     'compare'   => 'NOT IN',
        // )
    ),
    'posts_per_page'    => 16,
    'paged'             => $apf_page,
    'fields'            => 'ids'
);


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
        'key'       => 'property_branch_id',
        'value'     => $apf_branch,
        'compare'   => '=',
        'type'      => 'numeric'
    );
}

$property_query = new WP_Query($args);
?>
