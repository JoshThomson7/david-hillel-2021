<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF Update Properties AJAX
 *
 * @author  Various
 * @package Advanced Property Framework / APF Update
 *
*/

/*
*   Step 1: Generate import file
*/
function apf_update_properties_ajax() {

	/*
	/* Security check
	*/
	check_ajax_referer('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M', 'apf_security');

	// IMPORTANT: Must use get_template_directory() to get the full absolute path
	// of an include that's in a different folder than this file.
	// It's probably best practice anyway for any include/require
	include(get_home_path().'apf-import/reapit-to-xml.php');

	echo '<p><i class="ion-checkmark-circled"></i>Import file generated successfully.</p>';

	die();
}

add_action('wp_ajax_nopriv_apf_update_properties_ajax', 'apf_update_properties_ajax');
add_action('wp_ajax_apf_update_properties_ajax', 'apf_update_properties_ajax');

/*
*   Step 2: Run import
*/
function apf_update_properties_ajax_2() {

	/*
	/* Security check
	*/
	check_ajax_referer('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M', 'apf_security');

	// IMPORTANT: Must use get_template_directory() to get the full absolute path
	// of an include that's in a different folder than this file.
	// It's probably best practice anyway for any include/require

    include(apf_path().'apps/apf-update/functions/apf-trigger.php');
    include(apf_path().'apps/apf-update/functions/apf-process.php');

    echo '<p><i class="ion-checkmark-circled"></i>Import file generated successfully.</p>';
    echo '<p><i class="ion-checkmark-circled"></i>Properties imported sucessfully.</p>';

	die();
}

add_action('wp_ajax_nopriv_apf_update_properties_ajax_2', 'apf_update_properties_ajax_2');
add_action('wp_ajax_apf_update_properties_ajax_2', 'apf_update_properties_ajax_2');
