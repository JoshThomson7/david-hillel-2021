<?php 
global $post; 

//Image
if(get_field('team_second_image', $post->ID)) {
    $attachment_id = get_field('team_second_image', $post->ID);
} else {
    $attachment_id = get_post_thumbnail_id($post->ID);
}
$team_img = vt_resize($attachment_id,'' , 900, 900, false);

?>

<div class="masonry__item">
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

