<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Off-canvas nav scripts
 *
 * @author  Various
 * @package Off-canvas nav
 *
*/

function oc_nav_enqueue() {

	// Ajax
	wp_localize_script('custom-js', 'oc_nav_ajax_object', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'ajax_nonce' => wp_create_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M')
	));

}
add_action('wp_enqueue_scripts', 'oc_nav_enqueue', 20);