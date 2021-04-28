<?php
global $post;

$posts = explode(',', $_GET['posts']);

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<markers>';
?>
    <?php
        foreach($posts as $post):
            setup_postdata($post);

            // Name
            $name = htmlentities(utf8_decode(get_the_title()));

            // Permalink
            $permalink = get_permalink();

            // Address
            $lat = '';
            $lng = '';
            if(get_field('property_address')) {
                $get_address = get_field('property_address');
                $lat = $get_address['lat'];
                $lng = $get_address['lng'];
            }

            // shitty fix if properties have no lat/lng
            if(empty($lat) || empty($lat)) { 
                //continue;
                $property_branch = get_field('property_branch', get_the_ID());
                $branch_address = apf_property_branch_address($property_branch);
                $lat = $branch_address['lat'];
                $lng = $branch_address['lng'];
            }

            // Price
            if(!empty(apf_the_property_price(null, null, false, false))) {
                $property_price = apf_the_property_price(null, true, false, false);
            }

            // Feat image
            $property_image = htmlentities(utf8_decode(apf_the_property_image(null, null, false, false)));
    ?>
        <marker lat="<?php echo $lat; ?>" lng="<?php echo $lng; ?>" permalink="<?php the_permalink(); ?>" name="<?php echo $name; ?>" price="<?php echo $property_price; ?>" type="<?php echo get_post_type(); ?>" status="<?php apf_the_property_status(true, false); ?>" seo="<?php apf_the_property_seo_title(); ?>" image="<?php echo $property_image; ?>" />
        <?php endforeach; wp_reset_postdata(); ?>
</markers>
