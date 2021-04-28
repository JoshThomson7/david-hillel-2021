<?php
/*
    Grid Boxes
*/

$grid_box_num = get_sub_field('grid_boxes_num');
$grid_box_img_align = ' '.get_sub_field('grid_box_image_alignment');
$grid_box_spacing = get_sub_field('grid_box_spacing') ? ' style="border: '.get_sub_field('grid_box_spacing').'px transparent solid;"' : '';
?>
<div class="grid__boxes__wrapper">
    <?php
        while(have_rows('grid_boxes')) : the_row();

        $link_open = '';
        $link_close = '';
        $overlay_link_open = '';
        $overlay_link_close = '';

        if(get_sub_field( 'grid_box_button_url' )) {
            if(get_sub_field('grid_box_overlay')) {
                $overlay_link_open = '<a href="'.get_sub_field("grid_box_button_url").'" class="grid__overlay__a">';
                $overlay_link_close = '</a>';
            } else {
                $link_open = '<a href="'.get_sub_field("grid_box_button_url").'">';
                $link_close = '</a>';
            }
        }

        // tab
        $new_tab = '';

        if(get_sub_field('grid_box_new_tab')) {
            $new_tab = 'target="_blank"';
        }

        // box image
        if(get_sub_field('grid_box_image')) {
            $attachment_id = get_sub_field('grid_box_image');
            $grid_box_img = vt_resize($attachment_id,'' , 800, 600, true);
            $grid_box_img = '<div class="grid__box__image" style="background-image:url('.$grid_box_img['url'].');">'.$link_open.$link_close.'</div>';
        }

        // overlay
        $overlay = '';
        $overlay_opacity = '';
        $overlay_text_align = ' '.get_sub_field('grid_box_overlay_text_align');
        if(get_sub_field('grid_box_overlay')) {
            $overlay = ' overlay';
            $overlay_opacity = ' style="background:rgba(28, 28, 49, '.get_sub_field('grid_box_overlay_opacity').');"';
            $grid_box_img_align = '';
        }
    ?>
        <article class="<?php echo $grid_box_num.$grid_box_img_align.$overlay; ?>"<?php echo $grid_box_spacing; ?>>
            <?php echo $overlay_link_open; ?>
            <?php echo $grid_box_img; ?>

            <div class="grid__box__content<?php echo $overlay_text_align; ?>">
                <?php echo $link_open; if(get_sub_field('grid_box_heading')): ?>
                    <h3><?php the_sub_field('grid_box_heading'); ?>
                    <?php if(get_sub_field('grid_box_button_url')) :?>
                        <i class="fa fa-arrow-right"></i>
                    <?php else: ?>
                    <?php endif; ?>
                    </h3>
                <?php endif; echo $link_close; ?>
                <?php if(get_sub_field('grid_box_caption')): ?><?php the_sub_field('grid_box_caption'); ?><?php endif; ?>

                <?php if(get_sub_field('grid_box_button_label') && !get_sub_field('grid_box_overlay')): ?>
                    <a <?php echo $new_tab; ?> href="<?php the_sub_field('grid_box_button_url'); ?>" class="button primary"><?php the_sub_field('grid_box_button_label'); ?></a>
                <?php endif; ?>
            </div><!-- grid__box__content -->

            <?php echo $overlay_link_close; ?>
        </article>
    <?php endwhile; ?>
</div><!-- grid__boxes__wrapper -->
