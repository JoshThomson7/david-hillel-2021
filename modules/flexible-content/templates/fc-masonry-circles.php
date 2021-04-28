<?php
/*
    Circle Masonry
*/
?>
<div class="masonry_circles_wrapper">
    <?php
    $rowCount = 0; 
    $seperator = '<div class="break"></div>';

    while(have_rows('masonry_circles')) : the_row(); $rowCount = get_row_index(); 
        //Resets
        $image_style ='';
        $class = '';

        //Link
        $link_target = (get_sub_field('masonry_circle_target'))? 'target="_blank" rel="nofollow"': '';
        $link_open = '<a href="'.get_sub_field("masonry_circle_url").'" '.$link_target.' class="circle">';
        $link_close = '</a>';

        // Overlay colour
        $color = get_sub_field('masonry_circle_colour');

        // Circle image
        if($attachment_id = get_sub_field('masonry_circle_image')) {
            $attachment_url = vt_resize($attachment_id,'' , 800, 600, true);
            $image_style = 'style="background-image:url('.$attachment_url['url'].');"';
        }

        $overlay = '<div class="circle__image__overlay opacity-'.get_sub_field('masonry_circle_opacity').'" style="background-color:'.$color.';"></div>';

        $masonry_circle_img = '<div class="circle__image '.$has_image_class.'"'.$image_style.'>'.$overlay.'</div>';

        $class .= 'size-'.get_sub_field('masonry_circle_size');
        $class .= (!empty($attachment_id))?' has_image':''; 

        if(in_array($rowCount, array(4, 8, 11, 15))){
            echo $seperator;
        }
    ?> 
        <article class="<?php echo $class?>">
            <?php echo $link_open; ?>
            <?php echo $masonry_circle_img; ?>
            <div class="circle__content">
                <?php if(get_sub_field('masonry_circle_heading')): ?><h3><?php the_sub_field('masonry_circle_heading'); ?></h3><?php endif;?>
                <?php if(get_sub_field('masonry_circle_caption')): ?><?php the_sub_field('masonry_circle_caption'); ?><?php endif; ?>
            </div><!-- circle__content -->

            <?php echo $link_close; ?>
        </article>
    <?php endwhile; ?>
</div><!-- masonry_circles_wrapper -->
