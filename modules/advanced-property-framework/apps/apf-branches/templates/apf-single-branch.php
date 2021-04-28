<?php
/*
    Branches template
*/

global $post;

get_header();

avb_banners('inner');

// Address
$address = get_field('branch_address');

$opening_times = new APF_Opening_Times;
$times = $opening_times->todays_times($post->ID);
$depts = get_field('departments');
?>

<section class="find-a-branch">
    <div class="max__width">
        <div class="branches">

            <div class="branch single__branch">
                <?php if(get_field('branch_image')): ?>
                    <div class="branch-thumb">
                        <?php
                            $attachment_id = get_field('branch_image');
                            $branch_image = vt_resize( $attachment_id,'' , 690, 560, true ); // Set to false if you don't want to crop the image
                        ?>
                        <img src="<?php echo $branch_image['url'] ?>" alt="<?php the_title(); ?>" />
                    </div><!-- branch-thumb -->
                <?php endif; ?>

                <div class="branch-details">
                    <div class="branch-address">
                        <?php
                            while(have_rows('departments')) : the_row();
                            $dept_address_obj = get_sub_field('dept_branch_address');
                            $dept_address = str_replace(',', '<br>', $dept_address_obj['address']);
                        ?>

                            <h3><?php the_sub_field('dept_name'); ?></h3>
                            <p class="address">
                                <i class="fal fa-map-marker"></i>
                                <?php echo ( !$dept_address ? 'No address set' : str_replace(',', '<br />', $dept_address) ); ?>
                            </p>

                            <?php if(get_sub_field('dept_branch_phone')): ?>
                                <p>
                                    <i class="fal fa-phone"></i>
                                    <?php the_sub_field('dept_branch_phone'); ?>
                                </p>
                            <?php endif; ?>

                            <?php if(get_sub_field('dept_branch_email')): ?>
                                <p>
                                    <i class="fal fa-envelope"></i>
                                    <?php echo hide_email(get_sub_field('dept_branch_email')); ?>
                                </p>
                            <?php endif; ?>

                        <?php endwhile; ?>

                    </div><!-- branch-address -->

                    <?php
                        if($opening_times->has_times()):
                        
                        $todays_times = $opening_times->todays_times($post->ID);
                    ?>
                        <div class="branch-hours">
                            <h3>Opening hours <small class="<?php echo $todays_times->status['class']; ?>"><?php echo $todays_times->status['text']; ?></small></h3>
                            <ul class="hours-table">
                                
                                <?php
                                    foreach($opening_times->opening_times($post->ID) as $opening_time):
                                        $today = date("l");
                                        $is_today = $opening_time->weekday['is_today'];
                                ?>
                                    <li class="<?php echo $is_today.$opening_time->status['class']; ?>"><?php echo $opening_time->display; ?></li>
                                <?php endforeach; ?>
                            </ul><!-- hours-table -->
                        </div><!-- branch-hours -->
                    <?php endif; ?>

                </div><!-- branch-details -->

            </div><!-- branch -->
        </div><!-- branches -->
    </div><!-- max__width -->

    <div class="flexible__content">
        <section class="fc_buttons" style="padding:0 0 60px 0;">
            <div class="max__width">
                <div class="buttons__wrap align-left">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('property-search'))); ?>?apf_market=residential&amp;apf_dept=for-sale&amp;apf_location=&amp;apf_minprice=&amp;apf_maxprice=&amp;apf_minbeds=0&amp;apf_maxbeds=100&amp;apf_view=grid&amp;apf_status=&amp;apf_branch=<?php the_field('branch_id'); ?>&amp;apf_order=price_desc">See properties For Sale</a>

                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('property-search'))); ?>?apf_market=residential&amp;apf_dept=to-let&amp;apf_location=&amp;apf_minprice=&amp;apf_maxprice=&amp;apf_minbeds=0&amp;apf_maxbeds=100&amp;apf_view=grid&amp;apf_status=&amp;apf_branch=<?php the_field('branch_id'); ?>&amp;apf_order=price_desc">See properties To Let</a>

                </div><!-- buttons__wrap -->
            </div><!-- max__width -->
        </section>
    </div>

    <?php flexible_content(); ?>
</section><!-- find-a-branch -->

<?php get_footer(); ?>
