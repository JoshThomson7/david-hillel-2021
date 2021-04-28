        <header class="apf__single__property__head fullwidth">

            <?php if(!apf_is_endpoint()): ?>
            
                <div class="apf__single__property__gallery">

                    <div class="fancyass__shape">
                        <div class="apf__single__property__heading">

                            <div class="apf__single__property__price">

                                <?php if(apf_the_property_status()): ?>
                                    <div class="apf__status">
                                        <?php echo apf_the_property_status(); ?>
                                    </div><!-- apf__status -->
                                <?php endif; ?>

                                <div class="apf__price"><?php apf_the_property_price(); ?></div>

                            </div><!-- apf__single__property__price -->

                            <div class="apf__single__property__title">

                                <h1><?php apf_the_property_seo_title(); ?><span><?php the_title(); ?></span></h1>

                                <ul>
                                    <?php if(get_field('property_bedrooms')): ?>
                                        <li><span class="fi flaticon-sofa"></span> <?php the_field('property_bedrooms'); ?></li>
                                    <?php endif; ?>
                                    
                                    <?php if(get_field('property_livingrooms')): ?>
                                        <li><span class="fi flaticon-bed"></span> <?php the_field('property_livingrooms'); ?></li>
                                    <?php endif; ?>

                                    <?php if(get_field('property_bathrooms')): ?>
                                        <li><span class="fi flaticon-bath"></span> <?php the_field('property_bathrooms'); ?></li>
                                    <?php endif; ?>
                                </ul>

                            </div><!-- apf__single__property__title -->

                        </div><!-- apf__single__property__heading -->

                        <svg class="shape" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 760 988.39" style="enable-background:new 0 0 760 988.39;" xml:space="preserve">
                            <g>
                                <polyline style="opacity:0.3;fill:#FFFFFF;" points="0,0.39 0,788.39 489,0.39"/>
                                <polyline style="opacity:0.3;fill:#FFFFFF;" points="0,0.39 0,477.39 600,0.39"/>
                                <polygon style="opacity:0.5;fill:#FFFFFF;" points="0,78.445 583,331.39 0,532.445"/>
                                <polygon style="opacity:0.5;fill:#FFFFFF;" points="0,0 145.555,-0.002 380,511.39 0,425.947"/>
                            </g>
                        </svg>

                    </div><!-- fancyass__shape -->
                    
                    <div class="property__gallery">
                        <?php 
                            $property_gallery = get_field('property_gallery');

                            foreach($property_gallery as $property_image):

                                $thumb = wp_get_attachment_image_src($property_image['ID'], 'large');
                                $full = wp_get_attachment_image_src($property_image['ID'], 'full');

                                //Check for portrait images
                                $property_image_meta = wp_get_attachment_metadata($property_image['ID']); 
                                $property_image_width = $property_image_meta['width'];
                                $property_image_height = $property_image_meta['height'];

                                $property_image_orientation = '';
                                if($property_image_height > $property_image_width) { $property_image_orientation = ' portrait';}
                        ?>

                            <div data-thumb="<?php echo $thumb[0]; ?>" class="property__gallery__slide<?php echo $property_image_orientation; ?>" data-src="<?php echo $full[0]; ?>">
                                <div class="property__image" style="background-image:url(<?php echo $full[0]; ?>);"></div>
                            </div>

                        <?php endforeach; ?>
                    </div><!-- property__gallery -->

                </div><!-- apf__single__property__gallery -->

            <?php endif; ?>

            <div class="apf__single__property__tabs">

                <div class="max__width">

                    <ul>
                        <li><a href="<?php echo get_permalink($post->ID); ?>" title="Overview"<?php if(!apf_is_endpoint()): ?> class="active"<?php endif; ?>><span class="ion-android-document"></span><strong>Overview</strong></a></li>
                        
                        <li><a href="<?php echo get_permalink($post->ID); ?>gallery/" title="Images"<?php if(get_query_var('gallery')): ?> class="active"<?php endif; ?>><span class="ion-camera"></span><strong>Gallery</strong></a></li>
                        
                        <?php if(get_field('property_video')): ?>
                            <li><a href="<?php echo get_permalink($post->ID); ?>video/" title="Virtual Tour"<?php if(get_query_var('video')): ?> class="active"<?php endif; ?>><span class="ion-videocamera"></span><strong>Virtual Tour</strong></a></li>
                        <?php endif; ?>
                        
                        <li><a href="<?php echo get_permalink($post->ID); ?>map/" title="Maps"<?php if(get_query_var('map')): ?> class="active"<?php endif; ?>><span class="ion-ios-location"></span><strong>Maps</strong></a></li>

                        <?php if(have_rows('property_floorplans')): ?>
                            <li><a href="<?php echo get_permalink($post->ID); ?>floorplan/" title="Floorplan"<?php if(get_query_var('floorplan')): ?> class="active"<?php endif; ?>><span class="ion-qr-scanner"></span><strong>Floorplan</strong></a></li>
                        <?php endif; ?>

                        <?php if(get_field('property_epc_eer') || get_field('property_epc_eir')): ?>
                            <li><a href="<?php echo get_permalink($post->ID); ?>/#epc" title="EPC"><span class="ion-flash"></span><strong>EPC</strong></a></li>
                        <?php endif; ?>

                        <li><a href="<?php echo get_permalink($post->ID); ?>#brochure" title="PDF Brochure"><span class="ion-ios-paper"></span><strong>PDF Brochure</strong></a></li>

                    </ul>

                </div><!-- max__width -->

            </div><!-- apf__single__property__tabs -->

        </header><!-- apf__single__property__header -->

        <?php if(get_query_var('gallery')): ?>GALLERY!!!!<?php endif; ?>