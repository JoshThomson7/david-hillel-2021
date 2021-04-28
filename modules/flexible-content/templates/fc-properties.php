<?php
/**
 * Properties
*/

$markets = get_sub_field('property_markets');
$departments = get_sub_field('property_departments');
$new_home_only = get_sub_field('property_new_homes_only');
$ppp = get_sub_field('property_per_page');
$rand = get_sub_field('property_random');
$area = get_sub_field('property_area');
$sold_let = get_sub_field('property_sold_let');
$min_price_sales = get_sub_field('property_price_min_sales');
$min_price_lets = get_sub_field('property_price_min_lettings');

$args = array(
    'post_type'         => 'property',
    'posts_per_page'    => $ppp,
    'fields'            => 'ids',
    'post_status'       => 'publish',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy'  => 'property_market',
            'field'     => 'slug',
            'terms'     => $markets,
            'operator'  => 'IN'
        ),
    )
);

$sold_let_compare = 'NOT IN';
if($sold_let !== 'exclude') {
    $sold_let_compare = 'IN';
}

$args['meta_query'] = array(
    array(
        'key'       => 'property_status',
        'value'     => apf_property_search_exclude_status($sold_let),
        'compare'   => $sold_let_compare,
    )
);

// Filter by price
if($min_price_sales || $min_price_lets) {

    if($min_price_sales) {
        $args['tax_query'] = array(
            array(
                'taxonomy'  => 'property_department',
                'field'     => 'slug',
                'terms'     => 'for-sale',
                'operator'  => 'IN'
            )
        );

        $args['meta_query'][] = array(
            'key'       => 'property_price',
            'value'     => $min_price_sales,
            'compare'   => '>=',
            'type'      => 'numeric'
        );
    }

    if($min_price_lets) {
        $args['tax_query'] = array(
            array(
                'taxonomy'  => 'property_department',
                'field'     => 'slug',
                'terms'     => 'to-let',
                'operator'  => 'IN'
            )
        );

        $args['meta_query'][] = array(
            'key'       => 'property_price',
            'value'     => $min_price_lets,
            'compare'   => '>=',
            'type'      => 'numeric'
        );
    }
    
} else {
    $args['tax_query'] = array(
        array(
            'taxonomy'  => 'property_department',
            'field'     => 'slug',
            'terms'     => $departments,
            'operator'  => 'IN'
        )
    );
}

if($new_home_only) {
    $args['meta_query'][] = array(
        'key'       => 'property_new_home',
        'value'     => 1,
        'compare'   => '=',
    );
}

if($area) {
    $args['meta_query'][] = array(
        'key'       => 'property_address_searchable',
        'value'     => $area,
        'compare'   => 'LIKE'
    );
}

if($rand) {
    $args['orderby'] = 'rand';
}

$properties = new WP_Query($args);
?>

<div class="fc_properties" style="margin: 0 -10px;">
    <?php
        if($properties->have_posts()) {
            $properties_count = 1;
            while($properties->have_posts()) {
                $properties->the_post();
                require apf_path().'templates/apf-loop-item.php';
                $properties_count++;
            } wp_reset_query();
        }
    ?>
</div>
