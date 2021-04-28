<?php
/*
    Grid Links
*/
$grid_box_num = get_sub_field('boxes_per_row');
$alt_title = get_sub_field('override_page_title');
?>

<div class="grid">
    <?php
        $grid_links = get_sub_field('grid_links');

        foreach($grid_links as $grid_link):

        $attachment_id = get_field('page_banner', $grid_link->ID);
        $grid_link_img = vt_resize( $attachment_id, '', 800, 800, true);
    ?>
        <article class="<?php echo $grid_box_num; ?>">
            <a href="<?php echo get_permalink($grid_link->ID); ?>" style="background-image:url(<?php echo $grid_link_img['url']; ?>);">

                <div class="grid__link__content">
                    <?php if(get_field('override_page_title', $grid_link->ID)): ?>
                        <h3><?php the_field('override_page_title', $grid_link->ID); ?><i class="fa fa-arrow-right"></i></h3>
                    <?php else: ?>
                        <h3 class="ts"><?php echo get_the_title($grid_link->ID); ?><i class="fa fa-arrow-right"></i></h3>
                    <?php endif ; ?>
                </div><!-- grid__link__content -->
            </a>
        </article>
    <?php endforeach; ?>
</div><!-- grid -->
