<?php
/*
    Single property sidebar
*/

global $post;
$property_id = $post->ID;
$opening_times = new APF_Opening_Times;

$isSoldLet = apf_is_sold_or_let();
?>
<div class="apf__single__property__sidebar">

    <?php
        // Get branch
        $property_branch_id = get_field('property_branch');
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
            )
        ));
        while($branch_query->have_posts()) : $branch_query->the_post();
            $attachment_id = get_field('branch_image');
            $branch_image = vt_resize( $attachment_id,'' , 400, 264, true );
            $branch_address = get_field('branch_address');
    ?>
    
        
    <article class="viewing">
            <h3><?php echo $isSoldLet ? 'Viewings closed' : 'Book a viewing'; ?></h3>

            <?php if(!$isSoldLet): ?>

                <?php
                    while(have_rows('departments')) : the_row();

                    if(get_sub_field('dept_name') == 'Sales' || get_sub_field('dept_name') == 'Lettings'):

                        if(get_sub_field('dept_name') == 'Sales' && has_term('to-let', 'property_department', $property_id)) {
                            continue;
                        }

                        if(get_sub_field('dept_name') == 'Lettings' && has_term('for-sale', 'property_department', $property_id)) {
                            continue;
                        }

                        $dept_address_obj = get_sub_field('dept_branch_address');
                        $dept_address = str_replace(',', '<br>', $dept_address_obj['address']);
                ?>


                        <?php if(get_sub_field('dept_branch_phone')): ?><p>Call <span style="font-weight: bold;"><?php the_sub_field('dept_branch_phone'); ?></span> or book online</p><?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; ?>

                <a href="#" class="apf__book__viewing__button" title="Book a viewing">Book a viewing</a>
                
            <?php else: ?>
                <p>Viewings are now closed for this property. If you're looking for similar properties, feel free to get in touch so we can help you find the perfect home.</p>
            <?php endif; ?>

        </article>

        <article class="branch">
            <h3>Branch</h3>

            <div class="branch__img">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <img src="<?php echo $branch_image['url']; ?>" alt="<?php the_title(); ?>">
                </a>
            </div><!-- branch__img -->

            <div class="branch__details">
                <div class="branch__dept">
                    <?php
                        while(have_rows('departments')) : the_row();

                        if(get_sub_field('dept_name') == 'Sales' || get_sub_field('dept_name') == 'Lettings'):

                            if(get_sub_field('dept_name') == 'Sales' && has_term('to-let', 'property_department', $property_id)) {
                                continue;
                            }

                            if(get_sub_field('dept_name') == 'Lettings' && has_term('for-sale', 'property_department', $property_id)) {
                                continue;
                            }

                            $dept_address_obj = get_sub_field('dept_branch_address');
                            $dept_address = str_replace(',', '<br>', $dept_address_obj['address']);
                    ?>

                            <h4><?php the_title(); echo ' '.get_sub_field('dept_name') ?></h4>
                            <p class="address"><i class="fal fa-map-marker"></i><?php echo $dept_address; ?></p>

                            <?php if(get_sub_field('dept_branch_phone')): ?><p><i class="fal fa-phone"></i><?php the_sub_field('dept_branch_phone'); ?></p><?php endif; ?>
                            <?php if(get_sub_field('dept_branch_email')): ?><p><i class="fal fa-envelope"></i><?php echo hide_email(get_sub_field('dept_branch_email')); ?></p><?php endif; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div><!-- branch-dept -->

                <div class="branch__hours">
                    <h4>Opening hours</h4>

                    <ul class="hours-table">        
                        <?php
                            foreach($opening_times->opening_times($post->ID) as $opening_time):
                                $today = date("l");
                                $is_today = $opening_time->weekday['is_today'];
                        ?>
                            <li class="<?php echo $is_today.$opening_time->status['class']; ?>"><?php echo $opening_time->display; ?></li>
                        <?php endforeach; ?>
                    </ul><!-- hours-table -->
                </div><!-- branch__hours -->
            </div><!-- branch__details -->
        </article>
    <?php endwhile; wp_reset_postdata(); ?>

    <article class="share">
        <h3>Share</h3>
        <p>Have a friend who might be interested?</p>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-532c1f08328bf447"></script>

        <div class="addthis_toolbox addthis_32x32_style" addthis:url="<?php the_permalink(); ?>" addthis:title="<?php the_title(); ?>">
            <a class="addthis_button_facebook"></a>
            <a class="addthis_button_twitter"></a>
            <a class="addthis_button_pinterest_share"></a>
            <a class="addthis_button_google_plusone_share"></a>
            <a class="addthis_button_linkedin"></a>
            <a class="addthis_button_email"></a>
        </div><!-- apf__single__property__share -->
    </article>

    <article class="documents">
        <h3>Useful links</h3>
        <ul>
            <?php if(has_term('to-let', 'property_type', $property_id)): ?>
                <li><a href="<?php echo esc_url(home_url()); ?>/tenant-fees/" target="_blank"><i class="fal fa-tag"></i>Tenant Fees</a></li>
            <?php endif; ?>

            <?php if(get_field('property_epc')): ?>
                <li><a href="#epc" title="View EPC" class="scroll"><i class="fi flaticon-plug"></i>View EPC</a></li>
            <?php endif; ?>

            <?php if(get_field('property_brochure')): ?>
                <li><a href="<?php the_field('property_brochure'); ?>" target="_blank" class="apf__article__button"><i class="fi flaticon-big-brochure"></i>View brochure <?php echo $brochure_num; ?></a>
            <?php endif; ?>

            <li><a href="<?php echo apf_property_search_url(); ?>" title="Back to search"><i class="fal fa-search"></i>Back to search</a></li>
        </ul>
    </article>

</div><!-- apf__single__property__sidebar -->
