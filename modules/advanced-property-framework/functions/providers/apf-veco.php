<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* ======================================================================================= */
//
//      APF Functions v1.0
//      ------------------------------------------------
//      Custom functions for the property search engine
//
/* ======================================================================================= */

/*--------------------------------------------------------------------------*/
/*    function apf_the_property_price()
/*    returns the property price rightly formatted
/*
/*    @param bool $show_currency (optional)
/*    @param bool $show_period (optional)
/*    @param bool $echo
/*
/*    Usage: apf_the_property_price(false, true, false);
/*--------------------------------------------------------------------------*/
function apf_the_property_price($show_currency = true, $show_period = true, $html = true, $echo = true) {
    global $post;

    $property_id = $post->ID;

    // Price
        $price = number_format((float)get_field('property_price', $property_id));

        if($html)
            $price = '<span class="apf__digits">'.$price.'</span>';
        else
            $price = $price;

    // Pre-price text
        $pre_price = get_field('property_price_pre', $property_id);

        if($pre_price) {

            if($html)
                $pre_price = '<span class="apf__preprice">'.$pre_price.'</span> ';
            else
                $pre_price = $pre_price.' ';

        } else {
            $pre_price = '';
        }

    // Currency
        $currency = get_field('property_currency', $property_id);

        if($show_currency == false) {
            $currency = '';

        } elseif($show_currency == true) {
            if($currency == 'GBP'){
                $currency = '&pound;';
            } elseif($currency == 'USD'){
                $currency = '$';
            } elseif($currency == 'EUR'){
                $currency = '€';
            } elseif($currency == ''){
                $currency = '&pound;';
            } else {
                $currency = $currency.' ';
            }

            if($html)
                $currency = '<span class="apf__currency">'.$currency.'</span>';
            else
                $currency = $currency;

        }

    // Price qualifier
        $qualifier = get_field('property_price_qualifier', $property_id);

        if($qualifier) {
            if($qualifier !== 'Asking Price') {
                if($html) {
                    $qualifier = ' <span class="apf__qualifier">'.$qualifier.'</span>';
                } else {

                }
            } else {
                $qualifier = '';
            }
        }

    // Period

        if(has_term('to-let', 'property_department', $property_id)) {
            $period = get_field('property_period', $property_id);

            if($show_period == false) {
                $period = '';

            } elseif($show_period == true) {

                if($period == 'per-week') {
                    $period = 'pcw';
                } elseif($period == 'per-person-week') {
                    $period = 'pppw';
                } elseif($period == 'per-month') {
                    $period = 'pcm';
                } elseif($period == 'per-person-month') {
                    $period = 'pppm';
                } else {
                    $period = 'pcm';
                }

                if($html)
                    $period = '<span class="apf__period"> '.$period.'</span>';
                else
                    $period = ' '.$period;

            }
        } else {
            $period = false;
        }

    // echo/return
    $property_price = $pre_price.$currency.$price.$period.$qualifier;

    if($echo)
        echo $property_price;
    else
        return $property_price;
}

/*--------------------------------------------------------------------------*/
/*    function apf_has_property_image()
/*
/*    @param int $width (optional)
/*    @param int $height (optional)
/*    @param bool $crop
/*    @param bool $echo
/*
/*    Usage: if(apf_has_property_image());
/*--------------------------------------------------------------------------*/
function apf_has_property_image($property_id = null) {
    global $post;

    if($property_id == null) {
        $property_id = $post->ID;
    } else {
        $property_id = $property_id;
    }

    if( get_post_thumbnail_id() || get_field('property_image', $property_id) || get_field('property_gallery', $property_id)) {
        return true;
    }

}

/*--------------------------------------------------------------------------*/
/*    function apf_the_property_image()
/*
/*    @param int $width (optional)
/*    @param int $height (optional)
/*    @param bool $crop
/*    @param bool $echo
/*
/*    Usage: apf_the_property_image(1000, 600, false, false);
/*--------------------------------------------------------------------------*/
function apf_the_property_image($width = null, $height = null, $crop = true, $echo = true) {
    global $post;

    $property_id = $post->ID;

    // width
    if($width == null) {
        $width = null;

    } else {
        $width = $width;

    }

    // height
    if($height == null) {
        $height = null;

    } else {
        $height = $height;

    }

    // crop
    if($crop) {
        $crop = true;

    } else {
        $crop = false;

    }

    // be clever about it
    if( get_post_thumbnail_id() ) { //usually for manual

        $attachment_id = get_post_thumbnail_id();

        if($width && $height) {

            $property_image = vt_resize($attachment_id, '', $width, $height, $crop);
            $property_image = $property_image['url'];

        } else {

            $property_image = wp_get_attachment_image_src($attachment_id, 'full');
            $property_image = $property_image[0];

        }

    } elseif(get_field('property_image', $property_id)) { //usually for imports

        $attachment_id = get_field('property_image', $property_id);

        if($width && $height) {

            $property_image = vt_resize('', $attachment_id, $width, $height, $crop);
            $property_image = $property_image['url'];

        } else {
            $property_image = get_field('property_image', $property_id);
            //$property_image = $property_image[0];

        }


    } elseif(get_field('property_gallery', $property_id)) { //usually for manual

        $gallery = get_field('property_gallery', $property_id);

        $image_count = 0;
        while(have_rows('property_gallery')) {
            the_row();

            $property_image_url = get_sub_field('property_gallery_image_url');

            if($image_count == 0) { break;}
            $image_count++;
        }

        if($width && $height) {

            $property_image = vt_resize('', $property_image_url, $width, $height, $crop);
            $property_image = $property_image['url'];

        } else {

            $property_image = $property_image_url;

        }

    }

    if($echo)
        echo $property_image;
    else
        return $property_image;
}


/*--------------------------------------------------------------------------*/
/*    function apf_property_gallery()
/*
/*    @param $property_id
/*--------------------------------------------------------------------------*/
function apf_property_gallery($property_id = null) {
    global $post;

    if($property_id == null) {
        $property_id = $post->ID;
    } else {
        $property_id = $property_id;
    }

    if(get_field('property_gallery', $property_id)):
    ?>
        <div class="property__gallery">
            <?php while(have_rows('property_gallery')) : the_row(); ?>

                <div data-thumb="<?php the_sub_field('property_gallery_image_url'); ?>" class="property__gallery__slide" data-src="<?php echo the_sub_field('property_gallery_image_url'); ?>">
                    <img src="<?php the_sub_field('property_gallery_image_url'); ?>">
                </div><!-- property__gallery__slide -->

            <?php endwhile; ?>
        </div><!-- property__gallery -->
    <?php
    endif;
}


/*--------------------------------------------------------------------------*/
/*    function apf_the_property_seo_title()
/*    echoes the property seo title ie. 5 bedroom house for sale
/*    the ones that aren't empty
/*--------------------------------------------------------------------------*/
function apf_the_property_seo_title($property_id = null) {
    global $post;

    if($property_id == null) {
        $property_id = $post->ID;
    } else {
        $property_id = $property_id;
    }

    // Number of bedrooms
    $property_beds = get_field('property_bedrooms', $property_id);

    // Property style
    $property_style = get_field('property_style', $property_id);

    // Property type
    $property_type = get_field('property_type', $post_id);

    // Check if sales or lettings
    if(has_term('to-let', 'property_department', $property_id)) {
        $property_branch = 'to let';
    } elseif(has_term('for-sale', 'property_department', $property_id)) {
        $property_branch = 'for sale';
    }

    if($property_beds != 0) {
        $property_beds = $property_beds.' bedroom ';
    } else {
        $property_beds = '';
    }

    if($property_type) {
        $property_type = $property_type.' ';
    } else {
        $property_type = 'property ';
    }

    $property_title = $property_beds.$property_type.$property_branch;

    if($property_style) {
        $property_title = $property_style.' '.$property_branch;
    }

    echo $property_title;

}


/*--------------------------------------------------------------------------*/
/*    function apf_the_property_status()
/*    echoes the property status
/*--------------------------------------------------------------------------*/
function apf_the_property_status($echo = true, $html = true, $property_id = null) {

    global $post;

    if($property_id) {
        $property_id = $property_id;
    } else {
        $property_id = $post->ID;
    }

    if(has_term(array('for-sale', 'to-let'), 'property_department', $property_id)) {

        switch(get_field('property_status', $property_id)) {

            case 'New Instruction':
                $color = '';
                $property_status = '';
                break;
            
            case 'SSTC':
            case 'Sold STC':
                $color = ' apf__status__red';
                $property_status = 'Sold STC';
                break;

            case 'Sold STCM':
                $color = ' apf__status__red';
                $property_status = 'Sold STCM';
                break;

            case 'Under Offer':
                $color = ' apf__status__amber';
                $property_status = 'Under Offer';
                break;

            case 'Reserved':
                $color = ' apf__status__amber';
                $property_status = 'Reserved';
                break;

            case 'Let Agreed':
                $color = ' apf__status__red';
                $property_status = 'Let Agreed';
                break;

            case 'Let STC':
                $color = ' apf__status__red';
                $property_status = 'Let Agreed';
                break;

            case 'Sold':
                $color = ' apf__status__red';
                $property_status = 'Sold';
                break;

            case 'Let':
                $color = ' apf__status__red';
                $property_status = 'Let';
                break;

        }

    }

    $html_open = '';
    $html_close = '';

    if($html) {
        $html_open = '<span class="apf__property__status'.$color.'">';
        $html_close = '</span>';
    }

    if($echo) {
        echo $html_open.$property_status.$html_close;
    } else {
        return $html_open.$property_status.$html_open;
    }

}

/**
 * Checks if the property is sold/let
 */
function apf_is_sold_or_let() {
    
    $status = apf_the_property_status(false, false);

    switch ($status) {
        case 'SSTC':
        case 'Sold STC':
        case 'Sold STCM':
        case 'Let Agreed':
        case 'Let STC':
        case 'Sold':
        case 'Let':
            return true;
            break;
        
        default:
            return false;
            break;
    }

}

/*--------------------------------------------------------------------------*/
/*    function apf_property_search_exclude_status()
/*    checks if the option to exclude Sold STC/Let Agreed has been
/*    checked and acts accoringly
/*--------------------------------------------------------------------------*/
function apf_property_search_exclude_status($status) {

    switch ($status) {
        case 'exclude':
            $property_status = array('Sold STC', 'SSTC', 'Sold STCM', 'Under Offer', 'Reserved', 'Let Agreed', 'Let STC', 'Sold', 'Let');
            break;

        case 'sold':
            $property_status = array('Sold STC', 'SSTC', 'Sold STCM', 'Under Offer', 'Reserved', 'Sold');
            break;

        case 'let':
            $property_status = array('Let Agreed', 'Let STC', 'Let');
            break;

        default:
            $property_status = array();
            break;
    }

    return $property_status;
}

/*--------------------------------------------------------------------------*/
/*    function apf_vtour()
/*    converts a youtube URL into embed code
/*--------------------------------------------------------------------------*/
function apf_has_vtour() {
    $vtour = get_field('property_video');

    $has_vtour = false;

    if ( strpos($vtour, 'youtu') !== false ) {
        $has_vtour = true;
    }

    return $has_vtour;
}

/*--------------------------------------------------------------------------*/
/*    function apf_vtour()
/*    converts a youtube URL into embed code
/*--------------------------------------------------------------------------*/
function apf_vtour($string) {
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "<iframe src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
        $string
    );
}

function apf_matterport($url) {
    if($url && strpos($url, 'matterport') !== false) {
        return '<iframe src="'.$url.'" allowfullscreen></iframe>';
    }

    return false;
}

function apf_property_branch_address($property_branch_id = null) {

    $branch_query = new WP_Query(array(
        'post_type'         => 'branch',
        'post_status'       => 'publish',
        'posts_per_page'    => 1,
        'meta_query' => array(
            array(
                'key'       => 'branch_id',
                'value'     => $property_branch_id,
                'compare'   => 'IN'
            )
        ),
        'fields' => 'ids'
    ));

    if(count($branch_query->posts) === 1) { 
        $branch_id = reset($branch_query->posts);

        while(have_rows('departments', $branch_id)) {
            the_row();

            if(get_sub_field('dept_name') == 'Sales' || get_sub_field('dept_name') == 'Lettings') {

                if(get_sub_field('dept_name') == 'Sales' && has_term('to-let', 'property_department', $branch_id)) {
                    continue;
                }

                if(get_sub_field('dept_name') == 'Lettings' && has_term('for-sale', 'property_department', $branch_id)) {
                    continue;
                }

                $dept_address_obj = get_sub_field('dept_branch_address');

                if(!empty($dept_address_obj)) {
                    return $dept_address_obj;
                }

            }
        }
    }

    return null;

}


/*--------------------------------------------------------------------------*/
/*    function apf_property_single_js_vars()
/*    returns the js variables to use
/*    checked and act accoringly
/*--------------------------------------------------------------------------*/
function apf_property_single_js_vars($property_id) {

    global $post;

    if($property_id == null) {
        $property_id = $post->ID;
    } else {
        $property_id = $property_id;
    }

    $property_js_vars = '';



    return $property_js_vars;
}
