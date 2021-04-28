<?php
/**
 * APF Main template
 *
 * @author  Various
 * @package Advanced Property Framework
 *
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();

// Globals
global $post, $wp_query;

require_once(get_stylesheet_directory().'/modules/advanced-video-banners/templates/avb-inner.php');
?>

    <section class="apf apf__combined">

        <?php apf_search_form(); ?>

        <div class="apf__results">

            <div class="apf__results__list">
                <div class="apf__properties"></div>
            </div><!-- apf__results__list -->

            <?php require_once('apf-map.php'); ?>

            <script>var apf_total_pages = <?php echo apf_total_pages($property_query->max_num_pages); ?>;</script>

        </div><!-- apf__results -->

    </section><!-- apf apf__combined -->
<?php get_footer(); ?>
