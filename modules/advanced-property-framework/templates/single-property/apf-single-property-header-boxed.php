        <header class="apf__single__property__header boxed">

            <div class="max__width flex">
                <header class="apf__single__property__nav">
                    <a href="<?php echo apf_property_search_url(); ?>" title="Back to search results"><span class="far fa-chevron-left"></span> <strong>Back to search results</strong></a>
                    <!-- <a href="#" class="apf__single__property__nav__refine" title="Refine your search"><strong>Refine your search</strong> <span class="far fa-search"></span></a> -->
                </header><!-- apf__single__property__nav -->
            </div><!-- max__width -->

            <div class="max__width">

                <?php apf_search_form(); ?>

                <div class="apf__single__property__heading">

                    <div class="apf__single__property__title">

                        <h1><?php the_title(); ?><span><?php apf_the_property_seo_title(); ?></span></h1>

                        <ul>
                            <?php if(get_field('property_receptions')): ?>
                                <li><span class="fi flaticon-sofa"></span> <?php the_field('property_receptions'); ?></li>
                            <?php endif; ?>

                            <?php if(get_field('property_bedrooms')): ?>
                                <li><span class="fi flaticon-bed"></span> <?php the_field('property_bedrooms'); ?></li>
                            <?php endif; ?>

                            <?php if(get_field('property_bathrooms')): ?>
                                <li><span class="fi flaticon-bath"></span> <?php the_field('property_bathrooms'); ?></li>
                            <?php endif; ?>
                        </ul>

                    </div><!-- apf__single__property__title -->

                    <div class="apf__single__property__price">

                        <div class="digits"><?php apf_the_property_price(); ?></div>

                        <?php if(apf_the_property_status(false, false)): ?>
                            <div class="status">
                                <?php apf_the_property_status(); ?>
                            </div><!-- status -->
                        <?php endif; ?>

                    </div><!-- apf__single__property__price -->

                </div><!-- apf__single__property__heading -->

                <div class="apf__single__property__tabs">

                    <ul>
                        <li><a href="<?php echo get_permalink($post->ID); ?>" title="Overview"<?php if(!apf_is_endpoint()): ?> class="active"<?php endif; ?>><span class="fi flaticon-sheet"></span><strong>Overview</strong></a></li>

                        <li><a href="<?php echo get_permalink($post->ID); ?>gallery/" title="Images"<?php if(get_query_var('gallery')): ?> class="active"<?php endif; ?>><span class="fi flaticon-photo"></span><strong>Gallery</strong></a></li>

                        <?php
                            if(apf_is_endpoint()) {
                                $property_map = get_permalink($post->ID).'#map_section';
                                $property_map_scroll = '';
                            } else {
                                $property_map = '#map_section';
                                $property_map_scroll = ' class="scroll"';
                            }
                        ?>

                        <li><a href="<?php echo $property_map; ?>" title="Maps"<?php echo $property_map_scroll; ?>><span class="fi flaticon-gps"></span><strong>Maps</strong></a></li>

                        <?php if(apf_has_vtour() || get_field('property_matterport')): ?>
                            <li><a href="<?php echo get_permalink($post->ID); ?>video/" title="Virtual Tour"<?php if(get_query_var('video')): ?> class="active"<?php endif; ?>><span class="fi flaticon-video-camera"></span><strong>Virtual Tour</strong></a></li>
                        <?php endif; ?>

                        <?php if(get_field('property_floorplans')): ?>
                            <li><a href="<?php echo get_permalink($post->ID); ?>floorplan/" title="Floorplan"><span class="fi flaticon-blueprint"></span><strong>Floorplan</strong></a></li>
                        <?php endif; ?>

                        <?php
                            if(get_field('property_brochure')):

                                if(apf_is_endpoint()) {
                                    $property_brochure = get_permalink($post->ID).'/#apf_brochure';
                                    $property_brochure_scroll = '';
                                } else {
                                    $property_brochure = '#apf_brochure';
                                    $property_brochure_scroll = ' class="scroll"';
                                }
                        ?>
                                <li><a href="<?php echo $property_brochure; ?>" title="Brochure"<?php echo $property_epc_scroll; ?>><span class="fi flaticon-big-brochure"></span><strong>Brochure</strong></a></li>
                        <?php endif; ?>

                        <?php
                            if(get_field('property_epc_eer')):

                            if(apf_is_endpoint()) {
                                $property_epc = get_permalink($post->ID).'#epc';
                                $property_epc_scroll = '';
                            } else {
                                $property_epc = '#epc';
                                $property_epc_scroll = ' class="scroll"';
                            }
                        ?>
                            <li><a href="<?php echo $property_epc; ?>" title="EPC"<?php echo $property_epc_scroll; ?>><span class="fi flaticon-plug"></span><strong>EPC</strong></a></li>
                        <?php endif; ?>

                        <!-- <li class="book__viewing__tab"><a href="#" title="Book a viewing" class="apf__book__viewing__button">Book a viewing</a></li> -->
                    </ul>

                </div><!-- apf__single__property__tabs -->

            </div><!-- max__width -->

        </header><!-- apf__single__property__header -->
