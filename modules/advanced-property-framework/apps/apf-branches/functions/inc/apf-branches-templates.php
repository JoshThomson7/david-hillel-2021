<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF Branches Templates
 *
 * Programatcially assign templates
 *
 * @author  Various
 * @package Advanced Property Framework
 *

*/

/*
 *	Branches
*/
function apf_branches_templates($page_template) {
	global $post;

	// Property search
	if(is_page('find-a-branch')) {
		$page_template = apf_path() . 'apps/apf-branches/templates/apf-branches.php';

    } elseif(is_page('find-a-branch/xml')) {
        $page_template = apf_path() . 'apps/apf-branches/templates/apf-branches-xml.php';

    }

	return $page_template;

}
add_filter( 'page_template', 'apf_branches_templates' );


/*
 *	Single Branch
*/
function apf_branch_single_template($single_template) {
    global $post;

    if ($post->post_type == 'branch') {
        $single_template = apf_path() . 'apps/apf-branches/templates/apf-single-branch.php';
    }

    return $single_template;
}
add_filter( 'single_template', 'apf_branch_single_template' );
