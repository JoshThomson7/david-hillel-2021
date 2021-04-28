<?php
/**
 * APF Single Property - Floorplan
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<article>
        <h2>Floorplans</h2>

        <?php if(get_field('property_floorplans')): ?>
            <ul class="masonry property__gallery__all" data-isotope='{ "itemSelector": ".masonry__item" }'>
                <?php while(have_rows('property_floorplans')) : the_row(); ?>
                    <li class="masonry__item" data-src="<?php the_sub_field('property_floorplan_image_url'); ?>">
                        <a href="#"><img src="<?php the_sub_field('property_floorplan_image_url'); ?>"></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </article>