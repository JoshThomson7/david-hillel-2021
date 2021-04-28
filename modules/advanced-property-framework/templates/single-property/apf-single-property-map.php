<?php
/**
 * APF Single Property - Map
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$get_address = get_field("property_address");

if($get_address):
?>
    <article id="map_section">
        <h2>Map</h2>

        <div id="map_single" data-src="<?php echo esc_url(apf_path(true).'img/apf-blank.png'); ?>" data-lat="<?php echo $get_address['lat']; ?>" data-lng="<?php echo $get_address['lng']; ?>"></div>
        <!-- <div id="street_single"></div> -->
    </article>
<?php endif; ?>