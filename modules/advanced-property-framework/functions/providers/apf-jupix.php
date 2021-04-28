<?php
/* ======================================================================================= */
//
//      APF Functions v1.0
//      ------------------------------------------------
//      Custom functions for Jupix feeds
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
        if(has_term('commercial', 'property_market', $property_id)) {

            //Let's do some clever stuff here
            $price_start = '';
            $price_end = '';

            if(get_field('property_commercial_sale')) {

                if(get_field('property_price_to')) { $price_end = number_format((float)get_field('property_price_to'));}
                if(get_field('property_price_from')) { $price_start = number_format((float)get_field('property_price_to'));}

                if(get_field('property_price_to') && get_field('property_price_from')) { 
                    $price = $price_start. ' – ' .$price_end;
                } else { 
                    $price = $price_start.$price_end;
                }

            } else { 

                if(get_field('property_rent_to')) { $price_end = number_format((float)get_field('property_rent_to'));}
                if(get_field('property_rent_from')) { $price_start = number_format((float)get_field('property_rent_from'));}

                if(get_field('property_rent_to') && get_field('property_rent_from')) { 
                    $price = $price_start. ' – ' .$price_end;
                } else { 
                    $price = $price_start.$price_end;
                }

            }

        } else {

            if(has_term('for-sale', 'property_department', $property_id)) {

                $price = number_format((float)get_field('property_price', $property_id));

            } elseif(has_term('to-let', 'property_department', $property_id)) {

                $price = number_format((float)get_field('property_rent', $property_id));

            }

        }

        if($html)
            $price = '<span class="apf__digits">'.$price.'</span>';
        else
            $price = $price;

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

    // Period
        $period = get_field('property_period', $property_id);

        if($show_period == false) {
            $period = '';

        } elseif($show_period == true) {

            if($period == 1) {
                $period = 'pcm';
            } elseif($period == 2) {
                $period = 'pw';
            } elseif($period == 3) {
                $period = 'pa';
            } else {
                $period = '';
            }

            if($html)
                $period = '<span class="apf__period"> '.$period.'</span>';
            else
                $period = ' '.$period;

        }

    if(has_term('lettings', 'property_department', $property_id)) { 
        if(apf_is_property_search()) { 
            $tenants_fees = '<span class="apf__fees"><a href="'.esc_url(home_url()).'/lettings-fees/" target="_blank">Letting Fees</a></span>';
        }
    }

    // echo/return
    $property_price = $pre_price.$currency.$price.$period.$tenants_fees;

    if($echo)
        echo $property_price;
    else
        return $property_price;
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
    if( get_post_thumbnail_id() ) {

        $attachment_id = get_post_thumbnail_id();

        if($width && $height) {
            
            $property_image = vt_resize($attachment_id, '', $width, $height, $crop);
            $property_image = $property_image['url'];

        } else { 

            $property_image = wp_get_attachment_image_src($attachment_id, 'full');
            $property_image = $property_image[0];

        }

    } elseif(get_field('property_image', $property_id)) { 

        $property_image_url = get_field('property_image');

        // If it's an external URI we can't do VT Resize so, spit out the image URL
        $property_image = $property_image_url;


    } elseif(get_field('property_gallery', $property_id)) { 

        $gallery = get_field('property_gallery', $property_id);

        $image_count = 0;
        foreach($gallery as $image) { 
            $property_image_url = $image['url'];

            $image_count++;
            if($image_count == 0) { break;}
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
            <?php
                while(have_rows('property_gallery')): the_row();

                    $property_image_url = get_sub_field('property_gallery_image');
            ?>
                    <div data-thumb="<?php echo $property_image_url; ?>" class="property__gallery__slide" data-src="<?php echo $property_image_url; ?>">
                        <div class="property__image" style="background-image: url(<?php echo $property_image_url; ?>);"></div>
                    </div><!-- property__gallery__slide -->
                    <?php
                endwhile;
            ?>
        </div><!-- property__gallery -->
    <?php
    endif;
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
/*    function apf_property_type()
/*
/*    @param bool $echo
/*
/*    Usage: apf_property_type(false);
/*--------------------------------------------------------------------------*/
function apf_property_type($echo = true) {

    global $post;
    $property_id = $post->ID;

    $property_type = get_field('property_type', $property_id);

    switch ($property_type) {
        case '1':
            $property_type = 'Barn Conversion';
            break;
        case '2':
            $property_type = 'Cottage';
            break;
        case '3':
            $property_type = 'Chalet';
            break;
        case '4':
            $property_type = 'Detached House';
            break;
        case '5':
            $property_type = 'Semi-Detached House';
            break;
        case '6':
            $property_type = 'Farm House';
            break;
        case '7':
            $property_type = 'Manor House';
            break;
        case '8':
            $property_type = 'Mews';
            break;
        case '9':
            $property_type = 'Mid Terraced House';
            break;
        case '10':
            $property_type = 'End Terraced House';
            break;
        case '11':
            $property_type = 'Town House';
            break;
        case '12':
            $property_type = 'Villa';
            break;
        case '28':
            $property_type = 'Link Detached';
            break;
        case '29':
            $property_type = 'Shared House';
            break;
        case '31':
            $property_type = 'Sheltered Housing';
            break;
        case '13':
            $property_type = 'Apartment';
            break;
        case '14':
            $property_type = 'Bedsit';
            break;
        case '15':
            $property_type = 'Ground Floor Flat';
            break;
        case '16':
            $property_type = 'Flat';
            break;
        case '17':
            $property_type = 'Ground Floor Maisonette';
            break;
        case '18':
            $property_type = 'Maisonette';
            break;
        case '19':
            $property_type = 'Penthouse';
            break;
        case '20':
            $property_type = 'Studio';
            break;
        case '30':
            $property_type = 'Shared Flat';
            break;
        case '21':
            $property_type = 'Detached Bungalow';
            break;
        case '22':
            $property_type = 'Semi-Detached Bungalow';
            break;
        case '34':
            $property_type = 'Mid Terraced Bungalow';
            break;
        case '35':
            $property_type = 'End Terraced Bungalow';
            break;
        case '23':
            $property_type = 'Building Plot / Land';
            break;
        case '24':
            $property_type = 'Garage';
            break;
        case '25':
            $property_type = 'House Boat';
            break;
        case '26':
            $property_type = 'Mobile Home';
            break;
        case '27':
            $property_type = 'Parking';
            break;
        case '32':
            $property_type = 'Equestrian';
            break;
        case '33':
            $property_type = 'Unconverted Barn';
            break;
        case '39':
            $property_type = 'Land';
            break;
    }

    if($echo)
        echo $property_type;
    else
        return $property_type;
}


/*--------------------------------------------------------------------------*/
/*    function apf_the_property_seo_title()
/*    echoes the property seo title ie. 5 bedroom house for sale
/*    the ones that aren't empty 
/*--------------------------------------------------------------------------*/
function apf_the_property_seo_title($property_id = null) {
    
    global $post;
    $property_id = $post->ID;
    $property_seo_title = '';

    if(has_term('commercial', 'property_market', $property_id)) {
     
        $property_seo_title = 'Commercial property';

    } else {
    
        // Number of bedrooms
        $property_beds = get_field('property_bedrooms', $property_id);
        if($property_beds != 0) { 
            $property_seo_title .= $property_beds.' bedroom';
        }

        // Property type
        $property_type = apf_property_type(false);
        if($property_type) { 
            $property_seo_title .= ' '.$property_type;
        } else {
            $property_seo_title .= ' property';
        }

    }

    $new_home = '';
    if(get_field('property_new_home', $property_id) == 0) {
        $new_home = ' <small class="new-home">New Home</small>';
    }

    // Check if sales or lettings
    if(has_term('to-let', 'property_department', $property_id)) {
        $property_seo_title .= ' to let';
    } else {
        $property_seo_title .= ' for sale';
    }

    echo $property_seo_title.$new_home;
    
}


/*--------------------------------------------------------------------------*/
/*    function apf_the_property_status()
/*    echoes the property status 
/*--------------------------------------------------------------------------*/
function apf_the_property_status($echo = true, $html = true) {

    global $post;
    $property_id = $post->ID;

    switch(get_field('property_status', $property_id)) {
        case 1:
            $color = ' apf__status__amber';
            $property_status = 'On Hold';
            break;
        case 2:
            $property_status = '';
            break;
        case 3:
            $color = ' apf__status__amber';
            $property_status = has_term('lettings', 'property_department', $property_id) ? 'References Pending' : 'Under Offer';
            break;
        case 4:
            $color = ' apf__status__red';
            $property_status = has_term('lettings', 'property_department', $property_id) ? 'Let Agreed' : 'Sold STC';
            break;
        case 5:
            $color = ' apf__status__red';
            $property_status = has_term('lettings', 'property_department', $property_id) ? 'Let' : 'Sold';
            break;
        case 6:
            $color = ' apf__status__red';
            $property_status = 'Withdrawn';
        break;
    }

    $html_open = '';
    $html_close = '';

    if($html) {
        $html_open = '<span class="apf__property__status'.$color.'">';
        $html_close = '</span>';
    }

    if($echo)
        echo $html_open.$property_status.$html_close;
    else
        return $html_open.$property_status.$html_open;

}


/*--------------------------------------------------------------------------*/
/*    function apf_property_search_exclude_status()
/*    checks if the option to exclude Sold STC/Let Agreed has been
/*    checked and acts accoringly 
/*--------------------------------------------------------------------------*/
function apf_property_search_exclude_status($status) {
    
    if($status == 'exclude') {

        $property_status = array(3, 4, 5, 6);

    } else { 

        $property_status = '';
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