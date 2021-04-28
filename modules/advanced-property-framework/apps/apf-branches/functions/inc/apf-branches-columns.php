<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF Branches Dashboard Columns
 *
 * @author  Various
 * @package Advanced Property Framework
 *
*/

// ------------------------------------------ Manage Columns ------------------------------------------ //

add_filter( 'manage_edit-branch_columns', 'my_edit_branch_columns' ) ;

function my_edit_branch_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'branch_img' => __( 'Image' ),
		'title' => __( 'Branch' ),
        'branch_address' => __( 'Address' ),
        'branch_email' => __( 'Email' ),
        'branch_id' => __( 'Jupix Branch ID' ),
		'date' => __( 'Date' )
	);

	return $columns;
}


// ------------------------------------------ Manage Column Data ------------------------------------------ //

add_action( 'manage_branch_posts_custom_column', 'my_manage_branch_columns', 10, 2 );

function my_manage_branch_columns( $column, $post_id ) {

	switch( $column ) {

		case 'branch_img' :

            /* Get the post meta. */
            if(get_field('branch_image', $post_id)) {
                $attachment_id = get_field('branch_image', $post_id);
            } elseif(get_post_thumbnail_id($post_id)) {
                $attachment_id = get_post_thumbnail_id($post_id);
            }
			$new_home_img = vt_resize( $attachment_id,'' , 300, 160, true ); // Set to false if you don't want to crop the image
			$new_home_img_url = $new_home_img['url'];

			/* If no photo is found, output a default one */
			if ( empty( $attachment_id ) )
				echo __( '<div class="dashicons dashicons-format-image" style="font-size:40px; color:#e0e0e0;"></div>' );

			/* If there is a photo, show it. */
			else
				echo '<a href="'.get_admin_url().'post.php?post='.$post_id.'&action=edit"><img src="'.$new_home_img_url.'"" /></a>';

			break;

		case 'branch_address' :

			/* Get the post meta. */
			$get_address = get_field('branch_address', $post_id);
			$address = $get_address['address'];

			/* If no photo is found, output a default one */
			if ( empty($address) )
				echo '--';

			/* If there is a photo, show it. */
			else
				echo str_replace(',', '<br>', $address);

            break;

        case 'branch_email' :

			/* Get the post meta. */
			$branch_email = get_field('branch_email', $post_id);

			/* If no photo is found, output a default one */
			if ( !empty($branch_email) )
				echo $branch_email;

			/* If there is a photo, show it. */
			else
				echo '--';

            break;
            
        case 'branch_id' :

			/* Get the post meta. */
			$branch_id = get_field('branch_id', $post_id);

			/* If no photo is found, output a default one */
			if ( !empty($branch_id) )
				echo '<strong>'.$branch_id.'</strong>';

			/* If there is a photo, show it. */
			else
				echo '--';

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

// ------------------------------------------ Manage dropdown filtering ------------------------------------------ //
//
//	This adds a dropdown at the top of the list of posts to filter them by taxonomy
//
add_action( 'restrict_manage_posts', 'my_restrict_manage_branch_location_posts' );
function my_restrict_manage_branch_location_posts() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'branch') {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array('branch_location');

        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug);

            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Show All $tax_name</option>";
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
    }
}

add_action('admin_head', 'apf_branches_column_widths');
function apf_branches_column_widths() {
    echo '<style type="text/css">';
    echo '.column-branch_img { width:120px !important; overflow:hidden }';
    echo '.column-branch_img img { max-width:100% !important;}';
    echo '</style>';
}