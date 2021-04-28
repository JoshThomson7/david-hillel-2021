<?php
/**
 * APF Single Property - Gallery
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$apf_gallery = get_field('property_gallery');

if($apf_gallery):
?>
    <article>
        <h2>Gallery</h2>

        <?php if(get_field('property_gallery')): ?>
            <ul class="masonry property__gallery__all" data-isotope='{ "itemSelector": ".masonry__item" }'>
                <?php while(have_rows('property_gallery')) : the_row(); ?>
                    <li class="masonry__item" data-src="<?php the_sub_field('property_gallery_image_url'); ?>">
                        <a href="#"><img src="<?php the_sub_field('property_gallery_image_url'); ?>"></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </article>
<?php endif; ?>