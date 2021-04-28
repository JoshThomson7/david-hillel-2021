    <div class="footer-blog-posts">
        <div class="max__width">

            <?php
                $args = array (
                    'post_type'			=> 'post',
                    'orderby'			=> 'date',
                    'order'				=> 'desc',
                    'posts_per_page'	=> 4
                );

                $the_query = new WP_Query( $args );

            if ( $the_query->have_posts() ) : ?>

            <div class="blog-posts-loop">

                <?php while ($the_query -> have_posts()) : $the_query -> the_post(); 
                
                $post_thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );

                ?>

                    <div class="footer_blog_box">
                        <div class="image" style="background-image: url('<?php echo $post_thumbnail ?>')">

                        </div>
                        <div class="content">
                            <p class="title"><?php the_title(); ?></p>
                            <p class="excerpt"><?php the_excerpt(); ?></p>

                            <div class="blog_button">
                                <a href="#">Read More</a><i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>

            </div>

            <?php endif; wp_reset_postdata(); ?>
        </div>
    </div>
    
    <div class="footer-form">
        <div class="footer__signup">
            <div class="max__width">

                <div class="footer__signup__heading">
                    <h3>Sign up to our newsletter to receive regular updates</h3>
                    <p>Be the first one to know about all things <?php bloginfo('name'); ?>. Right in your inbox.</p>
                </div><!-- footer__signup__heading -->

                <!-- Begin Mailchimp Signup Form -->
                <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">

                <div id="mc_embed_signup" class="footer__signup__form">
                    <form action="#" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <div class="form__row">

                            <!-- <div class="indicates-required"><span class="asterisk">*</span> indicates required</div> -->

                            <div class="form__field">
                                <input type="text" placeholder="Name" value="" name="FNAME" class="" id="mce-FNAME">
                            </div><!-- form__field -->

                            <div class="form__field">
                                <input type="email" value="" placeholder="Email address" name="EMAIL" class="required email" id="mce-EMAIL">
                            </div>
                    
                            <!-- <div id="mce-responses" class="clear">
                                <div class="response" id="mce-error-response" style="display:none"></div>
                                <div class="response" id="mce-success-response" style="display:none"></div>
                            </div>     -->
                            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

                            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_e4c5d0adc5da141992c9eea47_4528131993" tabindex="-1" value=""></div>
                            <div class="clear"></div>
                            
                            <div class="form__field submit">
                                <button type="submit" value="Subscribe" name="subscribe">Sign Up</div>
                            </div>
                        
                        </div>
                    </form>
                </div>
                <!--End mc_embed_signup-->
            </div>
        </div><!-- footer__signup -->
    </div>
    
    <div class="flexible__content">
        <section class="fc_carousel_images footer">
            <div class="max__width" style="padding: 30px 0;">
                <?php
                    $is_option = true;
                    include(get_stylesheet_directory().'/modules/flexible-content/templates/fc-carousel.php');
                ?>
            </div><!-- max__width -->
        </section>
    </div><!-- flexible__content -->

    <footer role="contentinfo">
            
        <div class="footer__menus">
            <div class="max__width">

                <?php
                    while(have_rows('footer_menus', 'options')) : the_row();

                        $footer_menu = get_sub_field('footer_menu');
                        ?>
                        <article class="footer__menu">
                            <h5><?php echo $footer_menu->name; ?> <span class="ion-ios-plus-empty"></span></h5>

                            <?php wp_nav_menu(array('menu' => $footer_menu->name, 'container' => false, 'walker' => new clean_walker)); ?>
                        </article>

                <?php endwhile; ?>

                <article class="footer__menu social">
                   <h5>Follow Us <span class="ion-ios-plus-empty"></span></h5>
                    <?php if(get_field('header_social', 'options')): ?>
                        <ul class="social-wrapper">
                            <?php while(have_rows('header_social', 'options')) : the_row(); ?>
                                <li>
                                    <a href="<?php the_sub_field('header_social_url'); ?>" title="<?php the_sub_field('header_social_platform'); ?>" target="_blank">
                                        <i class="<?php the_sub_field('header_social_icon'); ?>"></i>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul><!-- header__social -->

                        <ul class="contact">
                            <li>Daniel Hall Building</li>
                            <li>Rothamsted Institute</li>
                            <li>Harpenden</li>
                            <li>Hertfordshire</li>
                            <li>AL5</li>  
                        </ul>

                    <?php endif; ?>

                </article>

            </div><!-- max__width -->

        </div><!-- footer__menus -->

        <div class="subfooter">
            <div class="subfooter__credits">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/img/logo.png" alt="<?php bloginfo('name'); ?>">
                <p>&copy;<?php bloginfo('name') ?> <?php echo date("Y"); ?></p>
                <p class="credit"><a href="http://www.fl1.digital/" target="_blank">Powered by FL1 Digital</a></p>
            </div><!-- subfooter__credits -->
        </div><!-- subfooter -->
            
    </footer>

    <?php gf_ajax_form_html(); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
