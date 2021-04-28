<?php
if(is_singular('property')):

global $post;
?>
    <div class="apf__book__viewing__form view">
        <div class="max__width">
            <div class="apf__book__viewing__form__wrapper">
                <a href="#" class="apf__book__viewing close"><span class="fal fa-times"></span></a>

                <h2>Book a viewing</h2>
                <h3>You're requesting a viewing for:<strong><?php echo get_the_title($post->ID); ?> - <?php apf_the_property_price(); ?></strong></h3>
                <?php echo do_shortcode('[gravityform id="3" title="false" description="false" ajax="true"]'); ?>
            </div><!-- apf__book__viewing__wrapper -->
        </div><!-- max__width -->
    </div><!-- apf__book__viewing -->

<?php endif; ?>
