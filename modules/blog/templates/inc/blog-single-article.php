<?php 
global $post;


if(has_post_thumbnail()):                                                              
    $attachment_id = get_post_thumbnail_id( $post->ID );                    
else:                          
    $attachment_id = get_field('default_banner_image','options'); 
endif;

$post_img = vt_resize($attachment_id,'' , 250, 150, true);
?>

<div class="blog__post">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
        <div class="blog__post__img" style="background:url(<?php echo $post_img['url'];?>)"></div><!-- blog__post__img -->
       
        <div class="blog__post__content">
            <h5><?php the_title(); ?> <span><?php the_time('j M Y'); ?></span></h5>
            <p><?php echo trunc(get_the_excerpt(), 20); ?></p>
        </div>
    </a>
</div><!-- blog__post -->