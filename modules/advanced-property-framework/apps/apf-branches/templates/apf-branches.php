<?php
/*
    Branches template
*/

get_header();

avb_banners('inner');

$opening_times = new APF_Opening_Times;

flexible_content();

wp_reset_postdata();
?>
<section class="find-a-branch">
    <div class="max__width">
        <?php // Branches query
            $branches_query = new WP_Query(array(
                'post_type'=> 'branch',
                'posts_per_page' => -1,
                'order_by' => 'name',
            ));
            if($branches_query->have_posts()):
        ?>
            <div class="branches">
                <?php
                    while($branches_query->have_posts()) : $branches_query->the_post();

                    $times = $opening_times->todays_times(get_the_ID());
                ?>
                    <div class="branch">
                        <h2>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                            <span><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="arrow__link">Full details <i class="fas fa-arrow-right"></i></a></span>
                        </h2>

                        <?php if(get_field('branch_image')): ?>
                            <div class="branch-thumb">
                                <?php
                                    $attachment_id = get_field('branch_image');
                                    $branch_image = vt_resize( $attachment_id,'' , 690, 560, true ); // Set to false if you don't want to crop the image
                                ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <img src="<?php echo $branch_image['url'] ?>" alt="<?php the_title(); ?>" />
                                    <div class="get-agent-review">
                                        <?php the_field('branch_getagent_review_code'); ?>
                                    </div>
                                </a>
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
                                    <p class="phone">
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
                                    <?php
                                        // echo '<pre>';
                                        // print_r($todays_times);
                                        // echo '</pre>';
                                    ?>
                                    <h3>Opening hours <small class="<?php echo $todays_times->status['class']; ?>"><?php echo $todays_times->status['text']; ?></small></h3>
                                    <ul class="hours-table">
                                        
                                        <?php
                                            foreach($opening_times->opening_times($post->ID) as $opening_time):
                                                $today = date("l");
                                                $is_today = $opening_time->weekday['is_today']
                                        ?>
                                            <li class="<?php echo $is_today.$opening_time->status['class']; ?>"><?php echo $opening_time->display; ?></li>
                                        <?php endforeach; ?>
                                    </ul><!-- hours-table -->
                                </div><!-- branch-hours -->
                            <?php endif; ?>

                        </div><!-- branch-details -->

                        <div class="clear"></div>
                    </div><!-- branch -->
                <?php endwhile; wp_reset_postdata(); ?>
            </div><!-- branches -->
        <?php endif; ?>
    </div><!-- max__width -->
</section><!-- find-a-branch -->

<?php get_footer(); ?>
