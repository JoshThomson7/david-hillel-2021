<?php 
/**
 * APF Functions
 *
 * @author  Various
 * @package Advanced Property Framework
 *
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//require_once('inc/apf-sessions.php');
require_once('inc/apf-post-type.php');
require_once('inc/apf-cpt-columns.php');
require_once('inc/apf-pages.php');
require_once('inc/apf-templates.php');
//require_once('inc/apf-property-js-vars.php');
require_once('inc/apf-enqueue.php');
require_once('inc/apf-endpoints.php');
require_once('inc/apf-acf-functions.php');
require_once('inc/apf-ajax.php');

// apps
require_once('class-apf-settings.php');
require_once(apf_path().'apps/apf-branches/functions/apf-branches-functions.php');
require_once(apf_path().'apps/apf-update/functions/apf-update-ajax.php');

$apf_settings = new APF_Settings();
switch ($apf_settings->provider()) {
    case 'jupix':
        require_once('providers/apf-jupix.php');
        break;
    
    case 'veco':
        require_once('providers/apf-veco.php');
        break;
}

/*--------------------------------------------------------------------------*/
/*    function apf_path()
/*    returns the full APF path
/*--------------------------------------------------------------------------*/
function apf_path($apf_url = false) {

    if($apf_url) {
        $apf_path = get_stylesheet_directory_uri()  . '/modules/advanced-property-framework/';
    } else {
        $apf_path = get_stylesheet_directory()  . '/modules/advanced-property-framework/';
    }

    return $apf_path;
}

/*--------------------------------------------------------------------------*/
/*    function apf_search_form()
/*    outputs property search form
/*--------------------------------------------------------------------------*/
function apf_search_form($is_banner = null) {

    if($is_banner === true) { 
        echo '<div class="avb__apf__search">';
        echo '<div class="max__width">';
    }

    require_once(apf_path().'templates/apf-search-form.php');

    if($is_banner === true) { 
        echo '</div>';
        echo '</div>';
    }

}

/*--------------------------------------------------------------------------*/
/*    function is_apf()
/*    checks if the current page belongs to APF
/*--------------------------------------------------------------------------*/
function is_apf() {

    global $post;

    $property_search_obj = get_page_by_path('property-search', OBJECT, 'page');
    $property_search_id = $property_search_obj->ID;

    if($property_search_id == $post->ID || is_singular('property')) {
        return true;
    } else {
        return false;
    }
}

/*--------------------------------------------------------------------------*/
/*    function apf_is_property_search()
/*    checks if we're in the property search page
/*--------------------------------------------------------------------------*/
function apf_is_property_search() {

    global $post;

    $property_search_obj = get_page_by_path('property-search', OBJECT, 'page');
    $property_search_id = $property_search_obj->ID;

    if($property_search_id == $post->ID) {
        return true;
    } else {
        return false;
    }
}

/*--------------------------------------------------------------------------*/
/*    Add .apf class to body_class
/*--------------------------------------------------------------------------*/
add_filter( 'body_class','apf_body_class' );
function apf_body_class( $classes ) {

    if(is_apf()) {
        $classes[] = 'apf__body';
    }

    if(apf_is_property_search()) {
        $classes[] = 'apf__property__search';
    }

    if(is_singular('property')) {
        $classes[] = 'apf__single';
    }

    if(is_singular('branch')) {
        $classes[] = 'apf__branch__single';
    }

    return $classes;

}


/*--------------------------------------------------------------------------*/
/*    function apf_featured_image_description()
/*    Adds a description to the featured image field
/*--------------------------------------------------------------------------*/
//add_filter( 'admin_post_thumbnail_html', 'apf_featured_image_description');
function apf_featured_image_description( $content ) {
    global $typenow;

    if ( (is_edit_page('edit') || is_edit_page('new') ) && "property" == $typenow){
        $content .= '<p><i>Upload the main property image here. This will appear on the listing.</i></p>';
    }

    return $content;
}


/**
 * Returns property search page URL
 */
function apf_property_search_url() {
    return get_permalink(get_page_by_path('property-search'));
}


/*--------------------------------------------------------------------------*/
/*    function apf_pagination()
/*--------------------------------------------------------------------------*/
function apf_pagination($pages = '', $range = 4, $apf_page = 1) {
    $showitems = ($range * 2)+1;

    $paged = $apf_page;
    echo $paged;

    if(empty($paged)) $paged = 1;

    if($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;

        if(!$pages) {
            $pages = 1;
        }
    }

    if(1 != $pages) {

        echo "<div class=\"apf__pagination\"><div class=\"apf__page__count\">Page ".$paged." of ".$pages."</div><div class=\"apf__page__numbers\">";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href=\"#\" class=\"apf-paginate apf__pagination\" data-apf-page=\"1\">&laquo;</a>";
        if($paged > 1 && $showitems < $pages) echo "<a href=\"#\" class=\"apf-paginate apf__paginate\" data-apf-page=\"".($paged - 1)."\">&lsaquo;</a>";

        for ($i=1; $i <= $pages; $i++) {

            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                echo ($paged == $i)? "<span class=\"apf__current__page\">".$i."</span>":"<a href=\"#\" class=\"inactive apf-paginate apf__paginate\" data-apf-page=\"".$i."\">".$i."</a>";
            }

        }

        if ($paged < $pages && $showitems < $pages) echo "<a href=\"#\" class=\"apf-paginate apf__paginate\" data-apf-page=\"".($paged + 1)."\">&rsaquo;</a>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href=\"#\" class=\"apf-paginate apf__paginate\" data-apf-page=\"".$pages."\">&raquo;</a>";
        echo "</div></div>\n";
    }
}