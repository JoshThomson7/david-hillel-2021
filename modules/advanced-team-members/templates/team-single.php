<?php /* Template Name: Single Team Template */ ?>

<?php get_header();

global $post;

$team_id = $team_member->ID;

$team_name = get_the_title($team_id);
$first_name = explode(' ', $team_name);
$first_name = reset($first_name);

$job_title = get_field('team_job_title', $team_id);
$qualifications = get_field('team_qualifications', $team_id);
$team_phone = get_field('team_phone', $team_id);
$team_email = get_field('team_email', $team_id);

// SOCIAL
$team_website = get_field('team_single_website', $team_id);
$team_facebook = get_field('team_single_facebook', $team_id);
$team_twitter = get_field('team_single_twitter', $team_id);
$team_instagram = get_field('team_single_instagram', $team_id);

$branch_link = get_field('branch_link', $team_id);
$branch_text = get_field('branch_text', $team_id);

$member_id = strtolower(preg_replace("#[^A-Za-z0-9]#", "", $team_name));

// NEW RESPONSE FIELDS
$about_work_response = get_field('about_your_work_response' , $team_id);
$about_you_response = get_field('about_you_response' , $team_id);
$about_area_response = get_field('about_area_response' , $team_id);
$about_photo_response = get_field('about_photo_response' , $team_id);
$about_photo_image = get_field('about_photo_image' , $team_id);

if(get_field('team_second_image', $team_id)) {
    $attachment_id = get_field('team_second_image', $team_id);
} else {
    $attachment_id = get_post_thumbnail_id($team_id);
}

$team_img = vt_resize($attachment_id,'' , 900, 900, true);
?>

<div class="team__single__container">

    <div class="max__width">
        <?php dimox_breadcrumbs()?>
    </div>
    <div class="max__width">

        <div class="top">
            <div class="left">  
                <div class="name">
                    <h3><?php echo $team_name ?></h3>
                    <h5><?php echo $qualifications ?></h5>
                    <p><?php echo $job_title ?></p>
                </div>

                <div class="details">

                    <div class="item">
                        <h5>About Work</h5>
                        <p><?php echo $about_work_response ?></p>
                    </div>

                    <div class="item">
                        <h5>About Me</h5>
                        <p><?php echo $about_you_response ?></p>
                    </div>

                    <div class="item">
                        <h5>About My Area</h5>
                        <p><?php echo $about_area_response ?></p>
                    </div>

                    <div class="extra-details">
                        <p>You can find <?php echo $first_name ?> at our <a href="<?php echo $branch_link ?>"><?php echo $branch_text ?></a> branch</p>

                        <a  class="video-link" href="#">Watch <?php echo $first_name ?>'s video here</a>
                    </div>

                </div>
            </div>

            <div class="right">

                <div class="contact">
                    <div class="phone">
                        <i class="fa fa-phone"></i>
                        <a href="tel:020887994362"><?php echo $team_phone ?></a>
                    </div>

                    <div class="email">
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:<?php echo $team_email ?>"><?php echo $team_email ?></a>
                    </div>

                </div>

                <img src="<?php echo $team_img['url']; ?>" alt="">

                    <?php $team_photo_hide_section = '';
                        if(get_field('team_photo_hide_section', $team_id)) {
                            $team_photo_hide_section = ' hide-section';
                        }
                    ?>

            </div>
        </div>

        <div class="about-my-photo">   

            <div class="details<?php echo $team_photo_hide_section ?>">

                <div class="left">
                    <?php echo $about_photo_image ?>
                </div>

                <div class="right">
                    <h3>What I Love About The Neighbourhood</h3>
                    <p><?php echo $about_photo_response ?></p>

                    <div class="social">
                        <?php if($team_website) :?>
                            <a target="_blank" href="<?php echo $team_website ?>"><i class="fa fa-globe"></i></a>
                        <?php endif; ?>                        

                        <?php if($team_facebook) :?>
                            <a target="_blank" href="<?php echo $team_facebook ?>"><i class="fab fa-facebook"></i></a>
                        <?php endif; ?>                        
                        
                        <?php if($team_twitter) :?>
                            <a target="_blank" href="<?php echo $team_twitter ?>"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>                        

                        <?php if($team_instagram) :?>    
                        <a target="_blank" href="<?php echo $team_instagram ?>"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>                        

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

<?php get_footer();?>