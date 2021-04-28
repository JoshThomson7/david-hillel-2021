<?php
/*
    Masonry
*/

if(!$reuse_id) {
    $reuse_id = null;
}
?>

    <div class="masonry__wrapper">
        <?php if(have_rows('masonry', $reuse_id)): ?>
            <div class="masonry" data-isotope='{ "itemSelector": ".masonry__item" }'>
                <?php
                    while(have_rows('masonry', $reuse_id)) : the_row();

                    $row_layout = get_row_layout();

                    if(get_row_layout() === 'blog'):

                        $orderby = 'date';
                        $post_in = '';

                        if(get_sub_field('ms_blog_type') == 'latest') {
                            $orderby = 'date';

                        } elseif(get_sub_field('ms_blog_type') == 'featured') {
                            $post_in = array(get_sub_field('ms_blog_featured'));

                        } elseif(get_sub_field('ms_blog_type') == 'random') {
                            $orderby = 'rand';
                        }

                        $args = array(
                            'post_type'         => 'post',
 		        	        'post_status'       => 'publish',
 		        	        'posts_per_page'    => 1,
                            'post__in'          => $post_in,
                            'orderby'           => $orderby,
                            'order'             => 'desc'
                        );

                        $ms_blog = new WP_Query($args);
                ?>
                        <div class="masonry__item <?php echo $row_layout; ?>">

                            <div class="masonry__item__wrapper">
                                <?php
                                    while($ms_blog->have_posts()) : $ms_blog->the_post();

                                    if(get_field('page_banner')) { 
                                        $attachment_id = get_field('page_banner');
                                    } elseif(has_post_thumbnail()) {
                                        $attachment_id = get_post_thumbnail_id();
                                    }

                                    $blog_img = vt_resize($attachment_id,'' , 900, 576, true);
                                ?>
                                    <a href="<?php the_permalink(); ?>" class="blog__img" style="background-image:url(<?php echo $blog_img['url']; ?>)">
                                        <div class="blog__img__gradient"></div>
                                    </a>

                                    <div class="blog__content">
                                        <h3>
                                            <span><?php the_category( ', ' ); ?></span>
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <p><?php echo trunc(get_the_excerpt(), 20); ?></p>

                                        <div class="blog__meta">
                                            <date><?php the_time('j M Y'); ?></date>
                                            <a href="<?php the_permalink(); ?>" title="Full article">Full article</a>
                                        </div><!-- blog__meta -->
                                    </div><!-- blog__content -->
                                <?php endwhile; wp_reset_postdata(); ?>

                            </div><!-- masonry__item__wrapper -->

                        </div><!-- masonry__item -->

                <?php
                    elseif(get_row_layout() === 'property'):

                        $orderby = 'date';
                        $post_in = '';

                        if(get_sub_field('ms_property_type') === 'latest') {
                            $orderby = 'date';

                        } elseif(get_sub_field('ms_property_type') === 'featured') {
                            $post_in = array(get_sub_field('ms_property_featured'));

                        } elseif(get_sub_field('ms_property_type') === 'random') {
                            $orderby = 'rand';
                        }

                        $args = array(
                            'post_type'         => 'property',
                            'post_status'       => 'publish',
                            'posts_per_page'    => 1,
                            'post__in'          => $post_in,
                            'orderby'           => $orderby,
                            'order'             => 'desc'
                        );

                        $ms_property = new WP_Query($args);
                ?>
                        <div class="masonry__item <?php echo $row_layout; ?>">
                            
                            <div class="masonry__item__wrapper">
                                <?php
                                    while($ms_property->have_posts()):
                                        $ms_property->the_post();
                                        require(apf_path().'/templates/apf-loop-item.php');
                                    endwhile; wp_reset_postdata();
                                ?>
                            </div><!-- masonry__item__wrapper -->

                        </div><!-- masonry__item -->

                <?php
                    elseif(get_row_layout() === 'team'):
                        $team_id = get_sub_field('ms_team_member');
                        $member_id = strtolower(preg_replace("#[^A-Za-z0-9]#", "", get_the_title($team_id)));
                        $get_post_object = get_post($team_id);

                        //Image
                        if(get_field('team_second_image', $team_id)) {
                            $attachment_id = get_field('team_second_image', $team_id);
                        } else {
                            $attachment_id = get_post_thumbnail_id($team_id);
                        }
                        $team_img = vt_resize($attachment_id,'' , 900, 900, false);

                        
                ?>
                        <div class="masonry__item <?php echo $row_layout; ?>">

                            <div class="masonry__item__wrapper">
                                <div class="team__wrap">
                                    
                                        <article data-image-list="<?php echo $team_img['url']; ?>">
                                            <a href="<?php the_permalink($team_id); ?>" title="<?php echo $team_name; ?>" class="">
                                                <span class="team__overlay">
                                                    <span class="team__more"><?php echo 'Meet '.explode(' ',trim(get_the_title($team_id)))[0]?></span>
                                                </span><!-- team__overlay -->
                                                <img src="<?php echo $team_img['url']; ?>" alt="<?php echo $team_name; ?>" />

                                                <h5><?php echo get_the_title($team_id); ?></h5>

                                            </a>

                                        </article>

                                </div> <!-- team__wrap -->

                            </div><!-- masonry__item__wrapper -->
                                
                        </div><!-- masonry__item -->

                <?php
                    elseif(get_row_layout() === 'team_tall'):
                        $team_id = get_sub_field('ms_team_member_tall');
                        $member_id = strtolower(preg_replace("#[^A-Za-z0-9]#", "", get_the_title($team_id)));
                        $get_post_object = get_post($team_id);

                        //Image
                        if(get_field('team_second_image', $team_id)) {
                            $attachment_id = get_field('team_second_image', $team_id);
                        } else {
                            $attachment_id = get_post_thumbnail_id($team_id);
                        }
                        $team_img = vt_resize($attachment_id,'' , 900, 900, false);
 
                ?>

                    <div class="masonry__item <?php echo $row_layout; ?>">

                        <div class="masonry__item__wrapper">
                            <div class="team__wrap">
                                
                                    <article data-image-list="<?php echo $team_img['url']; ?>">
                                        <a href="<?php the_permalink($team_id); ?>" title="<?php echo $team_name; ?>">
                                            <span class="team__overlay">
                                                <span class="team__more"><?php echo 'Meet '.explode(' ',trim(get_the_title($team_id)))[0]?></span>
                                            </span><!-- team__overlay -->
                                            <img src="<?php echo $team_img['url']; ?>" alt="<?php echo $team_name; ?>" />

                                            <h5><?php echo get_the_title($team_id); ?></h5>

                                        </a>

                                    </article>

                            </div> <!-- team__wrap -->
                        </div><!-- masonry__item__wrapper -->
                    </div><!-- masonry__item -->


                <?php
                    elseif(get_row_layout() === 'testimonial'):

                        $orderby = 'date';
                        $post_in = '';

                        if(get_sub_field('ms_testimonial_type') == 'latest') {
                            $orderby = 'date';

                        } elseif(get_sub_field('ms_testimonial_type') == 'featured') {
                            $post_in = array(get_sub_field('ms_testimonial_featured'));

                        } elseif(get_sub_field('ms_testimonial_type') == 'random') {
                            $orderby = 'rand';
                        }

                        $args = array(
                            'post_type'         => 'testimonial',
                            'post_status'       => 'publish',
                            'posts_per_page'    => 1,
                            'post__in'          => $post_in,
                            'orderby'           => $orderby,
                            'order'             => 'desc'
                        );

                        $ms_testim = new WP_Query($args);
                ?>
                        <div class="masonry__item <?php echo $row_layout; ?>">
                            <div class="masonry__item__wrapper">
                                <?php while($ms_testim->have_posts()) : $ms_testim->the_post(); ?>
                                    <div class="testim__top">
                                        <figure><i class="ion-heart"></i></figure>
                                        <a href="<?php echo esc_url(home_url()); ?>/testimonials/">Read all testimonials <i class="ion-arrow-right-c"></i></a>
                                    </div><!-- testim__top -->

                                    <div class="testim__content">
                                        <p><?php echo trunc(get_field('testim_quote'), 30); ?></p>
                                        <h6><?php the_field('testim_name'); ?></h6>
                                    </div><!-- testim__content -->
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div><!-- masonry__item__wrapper -->
                        </div><!-- masonry__item -->

                <?php
                    elseif(get_row_layout() === 'feature_tall'):

                    $attachment_id = get_sub_field('ms_feature_tall_image');
                    $feat_tall_img = vt_resize($attachment_id,'' , 800, 800, true);

                    $link = get_sub_field('masonry_link');
                    $target = '';
                    if($link['masonry_link'] && $link['masonry_link_target']) {
                        $target = ' target="_blank"';
                    }
                ?>
                        <div class="masonry__item <?php echo $row_layout; ?>">
                            <div class="masonry__item__wrapper">
                                <a href="<?php echo $link['masonry_link_url']; ?>" title="<?php the_sub_field('ms_feature_tall_heading'); ?>" style="background-image:url(<?php echo $feat_tall_img['url']; ?>)"<?php echo $target; ?>>
                                    <div class="feat__tall__content">
                                        <h4><?php the_sub_field('ms_feature_tall_sub_heading'); ?></h4>
                                        <h3><?php the_sub_field('ms_feature_tall_heading'); ?></h3>
                                        <?php the_sub_field('ms_feature_tall_caption'); ?>
                                    </div><!-- feat__tall__content -->
                                </a>
                            </div><!-- masonry__item__wrapper -->
                        </div><!-- masonry__item -->

                <?php
                    elseif(get_row_layout() === 'feature'):

                    $attachment_id = get_sub_field('ms_feature_image');
                    $feat_tall_img = vt_resize($attachment_id,'' , 800, 400, true);

                    $link = get_sub_field('masonry_link');

                    $target = '';
                    if($link['masonry_link_url'] && $link['masonry_link_target']) {
                        $target = ' target="_blank"';
                    }
                ?>
                        <div class="masonry__item <?php echo $row_layout; ?>">
                            <div class="masonry__item__wrapper">
                                <a href="<?php echo $link['masonry_link_url']; ?>" title="<?php the_sub_field('ms_feature_tall_heading'); ?>" style="background-image:url(<?php echo $feat_tall_img['url']; ?>)"<?php echo $target; ?>>
                                    <div class="feat__overlay" style="background-color:rgba(5, 32, 52, <?php the_sub_field('ms_feature_overlay_opacity'); ?>);">
                                        <h3><?php the_sub_field('ms_feature_heading'); ?></h3>
                                        <h4><?php the_sub_field('ms_feature_sub_heading'); ?></h4>
                                    </div><!-- feat__tall__content -->
                                </a>
                            </div><!-- masonry__item__wrapper -->
                        </div><!-- masonry__item -->

                <?php elseif(get_row_layout() === 'video'):

                    $thumbnail_id = get_sub_field('ms_video_thumb');
                    $attach_image = vt_resize($thumbnail_id,'' , 800, 400, true);

                    $video_id = get_sub_field('ms_video_id');
                    ?>
                        <div class="masonry__item <?php echo $row_layout; ?>">
                            <div class="masonry__item__wrapper">
                                <a class="play__video" href="https://www.youtube.com/watch?v=<?php echo $video_id?>" title="<?php the_sub_field('ms_video_heading'); ?>" style="background-image:url(<?php echo $attach_image['url']; ?>)">
                                    <div class="feat__overlay">
                                        <span class="fas fa-play"></span>
                                        <h3><?php the_sub_field('ms_video_heading'); ?></h3>
                                        <h4><?php the_sub_field('ms_video_sub_heading'); ?></h4>
                                    </div><!-- feat__tall__content -->
                                </a>
                            </div><!-- masonry__item__wrapper -->
                        </div><!-- masonry__item -->


                <?php endif; ?>
                <?php endwhile; ?>
            </div><!-- masonry -->
        <?php endif; ?>
    </div><!-- masonry__wrapper -->
