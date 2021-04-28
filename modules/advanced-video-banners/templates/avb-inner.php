<?php
/**
 * AVB Inner Banners
 *
 * @package advanced-video-banners/
 * @version 1.0
 * @dependencies
 *    - ACF PRO: https://www.advancedcustomfields.com/pro/
 *     - Lighslider: http://sachinchoolur.github.io/lightslider/examples.html
 *     @see lib/lightslider
*      - YouTube API: https://developers.google.com/youtube/iframe_api_reference
*/

global $post;

$page_banner = '';
$page_banner_overlay_opacity = 'opacity-80';
$page_banner_class = '';
$page_banner_caption = '';
$blog_page_id = '';
$page_banner_size = get_field('page_banner_size');

if(is_page()) {

    if(get_field('page_banner_type') == 'standard') {

        if(get_field('page_banner')) {
            $attachment_id = get_field('page_banner');
        }

        $sheep = '';
        if(get_field('page_banner_sheep')) {
            $sheep = get_field('page_banner_sheep');
        }

    } elseif(get_field('page_banner_type') == 'video') {

        $page_banner_video_id = get_field('page_banner_video_id');

        // Alt image
        $banner_altimg = '';

        if(get_field('page_banner_video_mobile_alt')) {
            $attachment_id_alt = get_field('page_banner_video_mobile_alt');
            $banner_altimg = vt_resize($attachment_id_alt,'' , 1500, 800, true);
            $banner_altimg = ' style="background-image:url('.$banner_altimg['url'].');'.$$banner_altimg_block.'"';
        }

    } else {
        if(get_field('page_banner')) {
            $attachment_id = get_field('page_banner');
        } else {
            $attachment_id = get_post_thumbnail_id();
        }
    }

    $page_banner_size = get_field('page_banner_size');
    $page_banner_overlay_opacity = 'opacity-'.get_field('page_banner_overlay_opacity');

    if(get_field('page_caption')) { $page_banner_caption = '<p>'.get_field('page_caption').'</p>';}

    if(get_field('page_heading')) {
        $page_title = get_field('page_heading');
    } else {
        $page_title = get_the_title($post->ID);
    }

} elseif(is_singular('team')) {

    if(get_field('page_banner')) {
        $attachment_id = get_field('page_banner');
    } else {
        $attachment_id = get_post_thumbnail_id();
    }

    $page_banner_size = get_field('page_banner_size');
    $page_banner_overlay_opacity = 'opacity-'.get_field('page_banner_overlay_opacity');
    if(get_field('page_caption')) { $page_banner_caption = '<p>'.get_field('page_caption').'</p>';}

    $page_title = get_the_title($post->ID);

} elseif(is_singular('branch')) {

    if(get_field('branch_image')) {
        $attachment_id = get_field('branch_image');
    } else {
        $attachment_id = get_post_thumbnail_id();
    }

    if(get_field('page_caption')) { $page_banner_caption = '<p>'.get_field('page_caption').'</p>';}

    $page_title = get_the_title($post->ID);
    $page_banner_size = get_field('page_banner_size');

} elseif(is_archive()) {

    $attachment_id = get_post_thumbnail_id();

    $page_banner_class = ' single-post';

    if(is_category()) {
        $attachment_id = get_field('page_banner', $blog_page_id);
        $page_title = single_cat_title('', false);
        $page_banner_caption = '<p>Blog Category</p>';

    } elseif(is_tag()) {
        $attachment_id = get_field('page_banner', $blog_page_id);
        $page_title = single_tag_title('', false);
        $page_banner_caption = '<p>Blog Tag</p>';

    } elseif(is_month()) {
        $attachment_id = get_field('page_banner', $blog_page_id);
        $page_title = single_month_title(' ', false);
        $page_banner_caption = '<p>Blog Month</p>';

    } elseif(is_tax()) {
        $term_obj = get_queried_object();

        $attachment_id = get_field('page_banner', $blog_page_id);

       /* if(get_field('tax_banner_image', 'feature_'.$term_obj->term_id)) {
            $attachment_id = get_field('tax_banner_image', 'feature_'.$term_obj->term_id);
        } else {
            $banner_no_img = ' no-img';
        }*/

        $page_title = $term_obj->name;
        $page_banner_caption = '';
    }

} elseif(is_single()) {

    if(get_field('page_banner')) {
        $attachment_id = get_field('page_banner');
    } else {
        $attachment_id = get_post_thumbnail_id();
    }

    $page_banner_size = get_field('page_banner_size');
    $page_banner_class = ' single-post';
    $page_title = get_the_title($post->ID);

} 

if(!empty($attachment_id)) {
    $page_banner = vt_resize($attachment_id,'' , 1800, 800, true);
    $page_banner = ' style="background-image:url('.$page_banner['url'].');"';
}

?>

    <section class="banners inner<?php echo $page_banner_class; ?>">
        
        <div class="banner <?php echo $page_banner_size; ?>" <?php echo $page_banner; ?>>

            <div class="banner__width max__width">
                <div class="banner__caption">
                    <h1><?php echo $page_title; ?></h1>
                    <?php echo $page_banner_caption; ?>
                </div><!-- banner__caption -->

                <?php
                    if(get_field('page_show_property_search')) {
                        apf_search_form(true);
                    }
                ?>
            </div><!-- banner__width -->

            <div class="banner__overlay <?php echo $page_banner_overlay_opacity; ?>"></div>

            <?php if(get_field('page_banner_type') == 'video'): ?>
                <div class="banner__video__player">
                    <div id="player0"></div>
                </div><!-- banner__video__player -->
            <?php endif; ?>

            <?php if(get_field('page_banner_video_mobile_alt')): ?><div class="banner__video__altimg"<?php echo $banner_altimg; ?>></div><?php endif; ?>

        </div><!-- banner -->

    </section><!-- banners -->
