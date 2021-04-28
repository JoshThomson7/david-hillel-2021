<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Off-canvas nav AJAX
 *
 * @author  Various
 * @package Off-canvas nav
 *
*/
function oc_nav_ajax() {

	/*
	/* Security check
	*/
	wp_verify_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M', 'oc_nav_security');

    // DEBUG
    $reuse_id = 'option';
    require(get_stylesheet_directory().'/modules/flexible-content/templates/fc-masonry.php');

	wp_die();
}

add_action('wp_ajax_nopriv_oc_nav_ajax', 'oc_nav_ajax');
add_action('wp_ajax_oc_nav_ajax', 'oc_nav_ajax');