<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF Templates
 *
 * Programatcially assign templates
 *
 * @author  Various
 * @package Advanced Property Framework
 *

*/

/*
 *	Property Search
*/
function apf_templates($page_template) {
	global $post;

	// Property search
	if(apf_is_property_search()) {
		$page_template = apf_path() . 'templates/apf-search-results-combined.php';

	} elseif(is_page('property-search/xml')) {
        $page_template = apf_path() . 'templates/apf-xml.php';
        
    } elseif(is_page('property-search/import')) {
        $page_template = apf_path() . 'apps/apf-import/index.php';

    } elseif(is_page('thank-you-for-arranging-a-viewing')) {
		$page_template = apf_path() . 'templates/book-viewing/apf-book-viewing-thanks.php';

	} elseif(is_page('update-properties')) {
		$page_template = apf_path() . 'apps/apf-update/templates/apf-update-properties.php';

    }

	return $page_template;

}
add_filter( 'page_template', 'apf_templates' );


/*
 *	Single property
*/
function apf_property_single_template($single_template) {
    global $post;

    if ($post->post_type == 'property') {
        $single_template = apf_path() . 'templates/apf-single-property.php';
    }

    return $single_template;
}
add_filter( 'single_template', 'apf_property_single_template' );
