<?php
/**
 * AVB Home Banners
 *
 * @package advanced-video-banners/
 * @version 1.0
 * @dependencies
 *      ACF PRO: https://www.advancedcustomfields.com/pro/
 *      Lighslider: http://sachinchoolur.github.io/lightslider/examples.html
 *      @see lib/lightslider
 *      YouTube API: https://developers.google.com/youtube/iframe_api_reference
*/

global $post;

if(get_field('home_banners')):

$overlay_style = get_field('home_banners_overlay_style');
?>
    <section class="banners" data-banner-overlay-style="<?php echo $overlay_style; ?>">

        <div id="home_banners">

            <?php
                $banner_counter = 0;
                while(have_rows('home_banners', $post->ID)) : the_row();

                include('inc/avb-home-banner-options.php');
            ?>

                <div class="banner<?php echo $banner_class; ?>">

                    <div class="max__width banner__width">

                        <div class="banner__caption">

                            <?php if(get_sub_field('home_banner_heading')): ?><h2><?php the_sub_field('home_banner_heading'); ?></h2><?php endif; ?>
                            <?php if(get_sub_field('home_banner_caption')): ?><p><?php the_sub_field('home_banner_caption'); ?></p><?php endif; ?>

                            <?php if(get_sub_field('home_banner_button_play') || get_sub_field('home_banner_button_url')): ?>
                                <a href="<?php echo $button_url; ?>"<?php echo $target.$button_class; ?> title="<?php the_sub_field('home_banner_button_label'); ?>" class="button">
                                    <span><?php the_sub_field('home_banner_button_label'); ?></span>
                                </a>
                            <?php endif; ?>

                        </div><!-- banner__caption -->
                            
                        <?php if(get_field('show_form')): ?>
                            <div id="landingForm" class="landing__form">
                                <?php if(get_field('landing_banner_form_heading')): ?><h3><?php the_field('landing_banner_form_heading') ?></h3><?php endif; ?>
                                <?php echo get_field('landing_banner_form_id') ? do_shortcode('[gravityform id="'.get_field('landing_banner_form_id').'" title="false" description="false" ajax="true"]') : ''; ?>
                            </div>
                            <?php if(!empty(get_field('landing_banner_form_mobile_button'))):?>
                                <div class="landing__form__button mobile-only">
                                        <a href="#" id="banner_modal_form" class="button tertiary"><span><?php the_field('landing_banner_form_mobile_button')?></span></a>
                                </div>
                            <?php endif;?>
                        <?php endif; ?>

                        <?php the_sub_field('home_banner_embed'); ?>

                    </div><!-- banner__width -->

                    <?php if($overlay_style === 'overlay_standard'): ?>
                        <div class="banner__overlay <?php echo $opacity; ?>"></div>

                    <?php elseif($overlay_style === 'overlay_gradient'): ?>
                        <div class="banner__overlay <?php echo $opacity; ?>"></div>
                    <?php endif; ?>

                    <?php echo $banner_video; ?>
                    <?php echo $banner_img; ?>

                    <?php if($overlay_style === 'overlay_skewed'): ?>
                        <div class="banner__caption__skew <?php echo $opacity; ?>"></div>
                    <?php endif; ?>

                    <!-- <div class="banner__top__gradient"></div> -->

                </div><!-- banner<?php echo $banner_class; ?> -->

            <?php $banner_counter++; endwhile; ?>
        </div><!-- #home_banners -->
    </section><!-- banners -->
<?php endif; ?>
