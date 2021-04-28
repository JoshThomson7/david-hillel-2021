<?php
/*
Team (Custom)
*/
?>
<div class="team__wrap">
    <?php
        $team_members = get_sub_field('team_members');
        foreach( $team_members as $team_member ):

            $team_id = $team_member->ID;

            $attachment_id = get_post_thumbnail_id($team_id);
            $team_img = vt_resize($attachment_id,'' , 900, 900, true);

            $team_name = get_the_title($team_id);
            $first_name = explode(' ', $team_name);
            $first_name = reset($first_name);

            $member_id = strtolower(preg_replace("#[^A-Za-z0-9]#", "", $team_name));

            $job_title = '';
            if(get_field('team_job_title', $team_id)) {
                $job_title = '<span>&nbsp; '.get_field('team_job_title', $team_id).'</span>';
            }
    ?>
        <article data-image-list="<?php echo $team_img['url']; ?>">
            <a href="<?php echo get_permalink($team_id); ?>" title="<?php echo $team_name; ?>" class="team__modal">
                <span class="team__overlay">
                    <span class="team__more">Meet <?php echo $first_name; ?></span>
                </span><!-- team__overlay -->
                <img src="<?php echo $team_img['url']; ?>" alt="<?php echo $team_name; ?>" />

                <h5><?php echo $team_name?> - <?php the_field('team_job_title', $team_id); ?></h5>

            </a>

        </article>
    <?php endforeach; ?>
</div><!-- team__wrap -->

<?php /*
<div class="team__popup__holder">
    <?php
        $team_count = 1;
        $team_total = count($team_members);

        foreach($team_members as $team_member):

            $team_id = $team_member->ID;

            $team_name = get_the_title($team_id);
            $first_name = explode(' ', $team_name);
            $first_name = reset($first_name);

            $member_id = strtolower(preg_replace("#[^A-Za-z0-9]#", "", $team_name));

            if(get_field('team_second_image', $team_id)) {
                $attachment_id = get_field('team_second_image', $team_id);
            } else {
                $attachment_id = get_post_thumbnail_id($team_id);
            }

            $team_img = vt_resize($attachment_id,'' , 900, 900, true);
    ?>
        <div id="<?php echo $member_id; ?>" class="team__popup">

            <div class="team__popup__content">
                <div class="team__popup__nav">
                    <ul>
                        <li <?php if($team_count == 1): ?> class="inactive"<?php endif; ?>><a href="#" class="team__switch team__prev"><i class="fal fa-chevron-left"></i></a></li>
                        <li <?php if($team_count == $team_total): ?> class="inactive"<?php endif; ?>><a href="#" class="team__switch team__next"><i class="fal fa-chevron-right"></i></a></li>
                        <li><a href="#" class="team__close"><i class="fal fa-times"></i></a></li>
                    </ul>
                </div><!-- team__popup__nav -->

                <div class="team__popup_name">
                    <h3><?php echo $team_name; ?></h3>
                    <span><?php the_field('team_job_title', $team_id); ?></span>
                </div>

                <div class="team__popup_text">
                    <?php
                        the_field('about_your_work_response', $team_id);
                        the_field('about_you_response', $team_id);
                        the_field('about_area_response', $team_id);
                        the_field('about_photo_response', $team_id);
                    ?>
                </div>

                <!-- <div class="team__popup__meta">
                    <?php if(get_field('team_email', $team_id)): ?>
                        <article>
                            <i class="fal fa-envelope"></i>
                            <?php echo hide_email(get_field('team_email', $team_id)); ?>
                        </article>
                    <?php endif; ?>

                    <?php if(get_field('team_phone', $team_id)): ?>
                        <article>
                            <i class="fal fa-phone"></i>
                            <a href="tel:<?php the_field('team_phone', $team_id); ?>" target="_blank"><?php the_field('team_phone', $team_id); ?></a>
                        </article>
                    <?php endif; ?>
                </div> -->

            </div><!-- team__popup__content -->

            <div class="team__popup__img" style="background-image: url(<?php echo $team_img['url']; ?>)">
                <?php if(get_field('team_video_id', $team_id)): ?>
                    <a href="https://www.youtube.com/watch?v=<?php the_field('team_video_id'); ?>" class="team__video"><span class="ion-play"></span> Watch video</a>
                <?php endif; ?>
            </div><!-- team__popup__img -->

        </div><!-- team__popup -->
    <?php $team_count++; endforeach; ?>
</div><!-- team__popup__holder -->
*/?>