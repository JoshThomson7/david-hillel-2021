<article<?php echo $apf_ajax_page; ?>>
    
    <div class="apf__property__border">

        <a href="<?php the_permalink(); ?>" class="apf__property__img" title="<?php the_title(); ?>" style="background-image:url('<?php apf_the_property_image(null, null, false, true); ?>');">

            <?php apf_the_property_status(); ?>

            <div class="apf__property__img__overlay">
                <span class="fal fa-map-marker-plus"></span>
            </div><!-- property__img__overlay -->
        </a>

        <div class="apf__property__details__wrap">

            <div class="apf__property__details">
                <h3><?php apf_the_property_price(); ?></h3>
                <h5><?php apf_the_property_seo_title(); ?></h5>
                <p><i class="fal fa-map-marker-alt"></i><?php the_title(); ?></p>
            </div><!-- apf__property__details -->

            <div class="apf__property__meta">
                <div class="apf__property__meta__data">
                    <?php if(get_field('property_receptions')): ?>
                        <span><i class="fi flaticon-sofa"></i><?php the_field('property_receptions'); ?></span>
                    <?php endif; ?>

                    <?php if(get_field('property_bedrooms')): ?>
                        <span><i class="fi flaticon-bed"></i><?php the_field('property_bedrooms'); ?></span>
                    <?php endif; ?>

                    <?php if(get_field('property_bathrooms')): ?>
                        <span><i class="fi flaticon-bath"></i><?php the_field('property_bathrooms'); ?></span>
                    <?php endif; ?>
                </div><!-- apf__property__meta__data -->

                <a href="<?php the_permalink(); ?>" title="Full details" class="apf__property__meta__action arrow__link">Full details<i class="fa fa-arrow-right"></i></a>
            </div><!-- apf__property__meta -->

        </div><!-- apf__property__details__wrap -->

    </div><!-- apf__property__border -->
</article>