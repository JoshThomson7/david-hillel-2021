<?php
/*
    Contact
*/

$map = get_sub_field('contact_address');
?>

    <div class="fc_contact_wrapper">
        <article>
            <ul>
                <li class="address"><i class="ion-ios-location"></i> <span><?php the_sub_field( 'contact_address' );; ?></span></li>
                <li><i class="ion-android-call"></i> <span><?php the_sub_field( 'contact_phone' ); ?></span></li>
                <li><i class="ion-paper-airplane"></i> <span><?php echo hide_email(get_sub_field( 'contact_email' )); ?></span></li>
            </ul>
        </article>

        <article class="map">
            <?php the_sub_field( 'contact_address_iframe' ); ?>
            <!-- <div id="map_single"></div> -->
        </article>
    </div><!-- fc_contact_wrapper -->
