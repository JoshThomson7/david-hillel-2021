<?php
/*
    Single property template
*/

get_header();

$isSoldLet = apf_is_sold_or_let();
?>
    <section class="apf apf__single__property">

        <?php require_once('single-property/apf-single-property-header-boxed.php'); ?>

        <div class="apf__single__property__details">

            <div class="max__width">

                <div class="apf__single__property__content__wrap">

                    <div class="apf__single__property__content">

                        <?php
                            if(get_query_var('gallery')):
                                
                                require_once('single-property/apf-single-property-gallery.php');
                        
                            elseif(get_query_var('floorplan')):
                                
                                require_once('single-property/apf-single-property-floorplan.php');
                            
                            elseif(get_query_var('video') && (apf_has_vtour() || get_field('property_matterport')) ):
                                
                                require_once('single-property/apf-single-property-virtual-tour.php');
                        
                            elseif(!apf_is_endpoint()):
                        ?>

                            <div class="apf__single__property__gallery">
                                <?php apf_property_gallery(); ?>
                            </div><!-- apf__single__property__gallery -->

                            <a href="#" class="apf__book__viewing__button apf__mobile" title="Book a viewing">Book a viewing</a>

                            <?php if(get_field('property_features')): ?>
                                <article class="apf__single__property__features">
                                    <h2>Main Features</h2>
                                    <ul>
                                        <?php while(have_rows('property_features')) : the_row(); ?>
                                        <li><?php the_sub_field('property_feature') ?></li>
                                        <?php endwhile; ?>
                                    </li>
                                </article><!-- apf__single__property__features -->
                            <?php endif; ?>

                            <?php if(get_field('property_about')): ?>
                                <article>
                                    <h2>About this property</h2>
                                    <p><?php the_field('property_summary'); ?></p>
                                    <?php the_field('property_about'); ?>
                                </article>
                            <?php endif; ?>

                            <?php require_once('single-property/apf-single-property-map.php'); ?>

                            <?php if(get_field('property_brochure')): ?>
                                <article id="apf_brochure" class="apf__brochure">
                                    <h2>Brochure</h2>

                                    <div class="apf__brochure__pdf">
                                        <div class="apf__brochure__pdf__img">
                                            <img src="<?php apf_the_property_image(null, null, false, true); ?>" alt="Property Brochure" />
                                            <h4><?php the_title(); ?></h4>
                                            <h5><?php apf_the_property_price(); ?></h5>
                                        </div><!-- apf__brochure__pdf__img -->

                                        <div class="apf__brochure__action">
                                            <p>Full PDF brochure containing all the details of the property in <span><?php echo get_the_title(); ?> - <?php apf_the_property_price(); ?></span></p>
                                            <a href="<?php the_field('property_brochure'); ?>" target="_blank" class="apf__article__button">View brochure</a>
                                        </div><!-- apf__brochure__action -->
                                    </div><!-- apf__brochure__pdf -->
                                </article>
                            <?php endif; ?>

                            <?php if(get_field('property_epc_eer')): ?>
                                <article id="epc" class="epc">
                                    <h2>EPC</h2>

                                    <div class="epc__graphics">
                                        <img src="<?php the_field('property_epc_eer'); ?>" />
                                    </div><!-- epc__graphics -->
                                </article>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div><!-- apf__single__property__content -->

                    <?php require_once('single-property/apf-single-property-sidebar.php'); ?>

                </div><!-- apf__single__property__content__wrap -->

            </div><!-- max__width -->

        </div><!-- apf__single__property__details -->

    </section><!-- apf__single__property -->

    <?php if(!$isSoldLet) { require_once('book-viewing/apf-book-viewing-form.php'); } ?>

<?php get_footer(); ?>
