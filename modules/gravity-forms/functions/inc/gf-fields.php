<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Property field
	Form: Arrange a viewing (ID: 1)
*/
// Property ID
add_filter('gform_field_value_apf_property_id', 'gf_property_id');
function gf_property_id($value){

    $property_id = get_top_parent_page_id();

	$value = $property_id;

	return $value;
}

// Property title
add_filter('gform_field_value_apf_property_title', 'gf_property_title');
function gf_property_title($value){
    global $post;

    $_GET['apf_property_title'] = get_top_parent_page_id();

    $property_title = get_the_title($_GET['apf_property_title']);

    $property_price = '';
    if(get_post_type($post) === 'property') {
        $property_price = ' - '.apf_the_property_price(true, false, false, false);
    }

	$value = $property_title.$property_price;

	return $value;
}

// Property URL
add_filter('gform_field_value_apf_property_url', 'gf_property_url');
function gf_property_url($value){

    $_GET['apf_property_url'] = get_top_parent_page_id();

    $property_url = get_permalink($_GET['apf_property_url']);

	$value = $property_url;

	return $value;
}

// Branch email
add_filter('gform_field_value_apf_branch_email', 'gf_branch_email');
function gf_branch_email($value) {

    $_GET['apf_branch_email'] = get_top_parent_page_id();

    $property_id = $_GET['apf_branch_email'];
    $branch = get_field('property_branch', $property_id);
    $branch_email = '';

    // Get branch
    $branch_query = new WP_Query(array(
        'post_type'         => 'branch',
        'post_status'       => 'publish',
        'meta_query' => array(
            array(
                'key'       => 'branch_id',
                'value'     => $branch,
                'compare'   => 'IN'
            )
        )
    ));

    while($branch_query->have_posts()) {
        $branch_query->the_post();
        
        while(have_rows('departments')) {
            the_row();

            if(get_sub_field('dept_name') == 'Sales' || get_sub_field('dept_name') == 'Lettings') {

                if(get_sub_field('dept_name') == 'Sales' && has_term('to-let', 'property_department', $property_id)) {
                    continue;
                }

                if(get_sub_field('dept_name') == 'Lettings' && has_term('for-sale', 'property_department', $property_id)) {
                    continue;
                }

                $branch_email = get_sub_field('dept_branch_email');

            }

        }

    } wp_reset_postdata();

	$value = $branch_email;

	return $value;
}

// Callwell email
add_filter('gform_field_value_apf_callwell_email', 'gf_callwell_email');
function gf_callwell_email($value) {

    $_GET['apf_callwell_email'] = get_top_parent_page_id();

    $property_id = $_GET['apf_callwell_email'];
    $branch = get_field('property_branch', $property_id);
    $branch_email = '';

    // Get branch
    $branch_query = new WP_Query(array(
        'post_type'         => 'branch',
        'post_status'       => 'publish',
        'meta_query' => array(
            array(
                'key'       => 'branch_id',
                'value'     => $branch,
                'compare'   => 'IN'
            )
        )
    ));

    while($branch_query->have_posts()) {
        $branch_query->the_post();
        
        while(have_rows('departments')) {
            the_row();

            if(get_sub_field('dept_name') == 'Sales' || get_sub_field('dept_name') == 'Lettings') {

                if(get_sub_field('dept_name') == 'Sales' && has_term('to-let', 'property_department', $property_id)) {
                    continue;
                }

                if(get_sub_field('dept_name') == 'Lettings' && has_term('for-sale', 'property_department', $property_id)) {
                    continue;
                }

                $branch_email = get_sub_field('dept_branch_viewing_email');

            }

        }

    } wp_reset_postdata();

	$value = $branch_email;

	return $value;
}

// Referer URL
add_filter('gform_field_value_referer', 'gf_referer');
function gf_referer($value){

    if(isset($_GET['referer']) && !empty($_GET['referer']) && is_numeric($_GET['referer'])) {

        $referer_url = get_permalink($_GET['referer']);
        $value = $referer_url;
    }

	return $value;
}

/*
	Date field
	Form: Arrange a viewing (ID: 1)
*/
add_filter( 'gform_pre_render_3', 'gf_radio_date' );
add_filter( 'gform_pre_validation_3', 'gf_radio_date' );
add_filter( 'gform_pre_submission_filter_3', 'gf_radio_date' );
add_filter( 'gform_admin_pre_render_3', 'gf_radio_date' );

// add_filter( 'gform_pre_render_2', 'gf_radio_date' );
// add_filter( 'gform_pre_validation_2', 'gf_radio_date' );
// add_filter( 'gform_pre_submission_filter_2', 'gf_radio_date' );
// add_filter( 'gform_admin_pre_render_2', 'gf_radio_date' );

function gf_radio_date( $form ) {

    foreach ( $form['fields'] as &$field ) {

        // Bail early if not the field we want
        if ( $field->type != 'radio' || strpos( $field->cssClass, 'gf__radio__date' ) === false ) {
            continue;
        }

        // Get dates from today to two months in the future
        $today = new DateTime('now', wp_timezone());
        $today->modify('+1 day');

        $future = new DateTime('now', wp_timezone());
        $future->modify('+2 months');

        // $start    = new DateTime($today, wp_timezone());
        // $end      = new DateTime($future, wp_timezone());
        $interval = DateInterval::createFromDateString('1 day');
        $period   = new DatePeriod($today, $interval, $future);

        $choices = array();

        foreach ($period as $date) {
            $the_date = $date->format("Y-m-d D");

        	if (strpos($the_date, 'Sun') !== false) { continue; }

        	$weekday = $date->format("D");
        	$day = $date->format("j");
        	$month = $date->format("M");
        	$year = $date->format("Y");

        	$choices[] = array(
        		'text' => '
	        		<span class="gf__date">
	        			<span class="gf__date__weekday">'.$weekday.'</span>
	        			<span class="gf__date__day">'.$day.'</span>
	        			<span class="gf__date__month">'.$month.'</span>
	        		</span>
	        	',

        		'value' => $date->format("D, j M Y")
        	);

        }

        $field->choices = $choices;

    }

    return $form;

}


/*
	Time field
	Form: Arrange a viewing (ID: 1)
*/
add_filter( 'gform_pre_render_3', 'gf_radio_time' );
add_filter( 'gform_pre_validation_3', 'gf_radio_time' );
add_filter( 'gform_pre_submission_filter_3', 'gf_radio_time' );
add_filter( 'gform_admin_pre_render_3', 'gf_radio_time' );

// add_filter( 'gform_pre_render_2', 'gf_radio_time' );
// add_filter( 'gform_pre_validation_2', 'gf_radio_time' );
// add_filter( 'gform_pre_submission_filter_2', 'gf_radio_time' );
// add_filter( 'gform_admin_pre_render_2', 'gf_radio_time' );

function gf_radio_time( $form ) {

    foreach ( $form['fields'] as &$field ) {

        // Bail early if not the field we want
        if ( $field->type != 'radio' || strpos( $field->cssClass, 'gf__radio__time' ) === false ) {
            continue;
        }

        // Max and min times
        $today = '11:00';
        $future = '19:30';

        $start    = new DateTime($today);
        $end      = new DateTime($future);
        $interval = DateInterval::createFromDateString('30 minutes');
        $period   = new DatePeriod($start, $interval, $end);

        $choices = array();

        foreach ($period as $date) {
        	$the_date = $date->format("Y-m-d D");

        	if (strpos($the_date, 'Sun') !== false) { continue; }

        	$hour = $date->format("H");
        	$minute = $date->format("i");

            $current_time = strtotime($date->format("H:i"));

            $class = '';
            $text = ' (Subject to availability)';
            $text_html = '<span class="gf__time__message">Subject to availability</span>';

            if($current_time >= strtotime($today) && $current_time <= strtotime('12:00')) {

                $class = ' gf__out__of__hours';
                $text = ' (Subject to availability)';
                $text_html = 'Subject to availability';

            }

            if($current_time >= strtotime('18:30') && $current_time <= strtotime($future)) {

                $class .= ' gf__out__of__hours';
                $text .= ' (Out of hours)';
                $text_html = '(Out of hours)';
            }

        	$choices[] = array(
        		'text' => '
	        		<span class="gf__time'.$class.'" data-time="'.$hour.':'.$minute.'">
                        <span class="gf__time__digits">'.$hour.':'.$minute.'</span>
                        <span class="gf__time__message">'.$text_html.'</span>
                    </span>
	        	',

        		'value' => $hour.':'.$minute.$text
        	);

        }

        $field->choices = $choices;

    }

    return $form;

}
