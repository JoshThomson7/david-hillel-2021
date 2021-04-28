<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
    Inner banner
*/

global $post;

$page_banner = '';
$page_banner_overlay_opacity = 0.55;
$page_banner_class = '';
$page_banner_caption = '';
$page_banner_alignment = '';

if(is_page()) {

    if(get_field('page_banner_type') == 'standard') {

        if(get_field('page_banner')) {
            $attachment_id = get_field('page_banner');
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

    }

    $page_banner_overlay_opacity = get_field('page_banner_overlay_opacity');
    $page_banner_caption = '<h3>'.get_field('page_sub_heading').'</h3>';

    if(get_field('page_heading')) {
        $page_title = get_field('page_heading');
    } else {
        $page_title = get_the_title($post->ID);
    }

    if(get_field('page_banner_text_alignment' == 'align-centre')) {
        $page_banner_alignment = ' align-centre';
    } elseif(get_field('page_banner_text_alignment') == 'align-right') {
        $page_banner_alignment = ' align-right';
    } else {
        $page_banner_alignment = '';
    }

} elseif(is_singular('team')) {

    if(get_field('page_banner')) {
        $attachment_id = get_field('page_banner');
    } else {
        $attachment_id = get_post_thumbnail_id();
    }

    $page_banner_overlay_opacity = get_field('page_banner_overlay_opacity');
    $page_banner_caption = '<h3>'.get_field('team_member_title').'</h3>';

    $page_title = get_the_title($post->ID);

} elseif(is_archive()) {

    $attachment_id = get_post_thumbnail_id();

    $page_banner_class = ' single-post';

    if(is_category()) {
        $attachment_id = get_field('page_banner', 306);
        $page_title = single_cat_title('', false);
        $page_banner_caption = '<p>Blog Category</p>';

    } elseif(is_tag()) {
        $attachment_id = get_field('page_banner', 306);
        $page_title = single_tag_title('', false);
        $page_banner_caption = '<p>Blog Tag</p>';

    } elseif(is_tax()) {
        $term_obj = get_queried_object();

        $attachment_id = get_field('page_banner', 306);

       /* if(get_field('tax_banner_image', 'feature_'.$term_obj->term_id)) {
            $attachment_id = get_field('tax_banner_image', 'feature_'.$term_obj->term_id);
        } else {
            $banner_no_img = ' no-img';
        }*/

        $page_title = $term_obj->name;
        $page_banner_caption = '';
    }

} elseif(is_single()) {

    $attachment_id = get_field('page_banner');
    $page_banner_class = ' single-post';
    $page_title = get_the_title($post->ID);

}

if(!empty($attachment_id)) {
    $page_banner = vt_resize($attachment_id,'' , 1800, 600, true);
    $page_banner = ' style="background-image:url('.$page_banner['url'].');"';
}
?>

    <section class="banners inner<?php echo $page_banner_class; ?>">

        <div class="banner"<?php echo $page_banner; ?>>

            <div class="max__width">
                <div class="banner__caption <?php the_field('page_banner_text_alignment'); ?>">
                    <h1><?php echo $page_title; ?></h1>
                    <?php echo $page_banner_caption; ?>
                </div><!-- banner__caption -->
            </div><!-- max__width -->

            <div class="banner__overlay" style="background:rgba(9, 10, 10, <?php echo $page_banner_overlay_opacity; ?>)"></div>

            <?php if(get_field('page_banner_type') == 'video'): ?>
                <div class="banner__video__player">
                    <div id="player0"></div>
                </div><!-- banner__video__player -->

                <?php if(get_field('page_banner_video_mobile_alt')): ?><div class="banner__video__altimg"<?php echo $banner_altimg; ?>></div><?php endif; ?>
            <?php endif; ?>
        </div><!-- banner -->

        <?php if(get_field('page_banner_search')): ?>

            <div class="banners__apf__search">
                <div class="max__width">
                    <?php require_once(apf_path().'templates/apf-search-form.php'); ?>
                </div><!-- max__width -->
            </div><!-- banners__apf__search -->

        <?php endif; ?>

    </section><!-- banners -->
