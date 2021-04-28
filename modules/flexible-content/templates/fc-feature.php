<?php
/*
--------------------------------------------
    ______           __
   / ____/__  ____ _/ /___  __________
  / /_  / _ \/ __ `/ __/ / / / ___/ _ \
 / __/ /  __/ /_/ / /_/ /_/ / /  /  __/
/_/    \___/\__,_/\__/\__,_/_/   \___/

-------------------------------------------
Feature
*/
// Feature image
$attachment_id = get_sub_field('feature_image');
$feature_img = vt_resize($attachment_id,'' , 800, 600, true);

// Feature image align
$feature_img_bg = '';
if(get_sub_field('feature_image_bg')) {
    $feature_img_bg = ' as__bg';
}

// Feature image align
$feature_img_align = '';
if(get_sub_field('feature_image_align') == 'right') {
    $feature_img_align = ' right';
}

// Tab
$new_tab = '';

if(get_sub_field('feature_new_tab')) {
    $new_tab = 'target="_blank"';
}

// Video
$feature_img_video = '';
if(get_sub_field('feature_video_id')) {
    $feature_img_video = '<a href="http://www.youtube.com/watch?v='.get_sub_field('feature_video_id').'"><span><strong class="ion-ios-play"></strong></span></a>';
}
?>

<div class="fc_feature_wrapper<?php echo $feature_img_align; ?>">
    <div class="feature__image<?php echo $feature_img_bg; ?>">
        <?php echo $feature_img_video; ?>
        <img src="<?php echo $feature_img['url']; ?>" alt="" />
        <?php if(get_sub_field('feature_video_id')): ?><div class="feature__video-overlay"></div><?php endif; ?>
    </div><!-- feature__image -->

    <div class="feature__text">
        <?php if(get_sub_field('feature_heading')): ?><h3><?php the_sub_field('feature_heading') ?></h3><?php endif; ?>
        <?php the_sub_field('feature_text'); ?>

        <?php if(get_sub_field('feature_link_text') && get_sub_field('feature_link_url')): ?>
            <div class="feature__action">
                <a <?php echo $new_tab; ?> href="<?php the_sub_field('feature_link_url'); ?>" class="arrow__link">
                    <?php the_sub_field('feature_link_text'); ?>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div><!-- feature__action -->
        <?php endif; ?>
    </div><!-- feature__text -->
</div><!-- fc_feature_wrapper -->
