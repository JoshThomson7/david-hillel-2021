<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once('inc/oc-enqueue.php');
require_once('inc/oc-ajax.php');

/*--------------------------------------------------------------------------*/
/*    function oc_nav_path()
/*    returns the full Off Canvas Nav path
/*--------------------------------------------------------------------------*/
function oc_nav_path($apf_url = false) {

    if($apf_url) {
        $oc_nav_path = get_stylesheet_directory_uri()  . '/modules/off-canvas-nav/';
    } else {
        $oc_nav_path = get_stylesheet_directory()  . '/modules/off-canvas-nav/';
    }

    return $oc_nav_path;
}