<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Custom Columns
 *
 * Creates custom columns on the property custom post type
 *
 * @author  Multiple Authors
 * @package modules/property-framework
 * @version 1.0
*/


/* ----------------------------------------------------------------------*/
/*
/* 	Create columns
/*
/* ----------------------------------------------------------------------*/

// Manage Columns

add_filter( 'manage_edit-property_columns', 'my_edit_property_columns' ) ;

function my_edit_property_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'property_img' => __( 'Image' ),
        'title' => __( 'Property' ),
        'property_market' => __( 'Market' ),
		'property_department' => __( 'Department' ),
		'property_area' => __( 'Area' ),
		'property_price' => __( 'Price' ),
        'property_status' => __( 'Status' ),
		'date' => __( 'Date' )
	);

	return $columns;
}


// Manage Column Data

add_action( 'manage_property_posts_custom_column', 'my_manage_property_columns', 10, 2 );

function my_manage_property_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'property_img' :

			if(apf_has_property_image()) {

				echo '<a href="'.get_admin_url().'post.php?post='.$post_id.'&action=edit"><img src="'.apf_the_property_image('', '', false, false).'"" /></a>';

			} else {

				echo __( '<div class="dashicons dashicons-format-image" style="font-size:82px; height:82px; color:#e0e0e0;"></div>' );

			}

            break;
            
        case 'property_market' :

            // Get the terms
            $terms = get_the_terms( $post_id, 'property_market' );

            // If terms were found
            if ( !empty( $terms ) ) {

                $out = array();

                // Loop through each term, linking to the 'edit posts' page for the specific term
                foreach ( $terms as $term ) {
                    $out[] = sprintf( '<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'property_market' => $term->slug ), 'edit.php' ) ),
                        esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'property_market', 'display' ) )
                    );
                }

                // Join the terms and separate them with a comma
                echo join( ', ', $out );
            }

            // If no terms were found, output a default message
            else {
                _e( 'No type assigned' );
            }

            break;

		case 'property_department' :

			// Get the terms
			$terms = get_the_terms( $post_id, 'property_department' );

			// If terms were found
			if ( !empty( $terms ) ) {

				$out = array();

				// Loop through each term, linking to the 'edit posts' page for the specific term
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'property_department' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'property_department', 'display' ) )
					);
				}

				// Join the terms and separate them with a comma
				echo join( ', ', $out );
			}

			// If no terms were found, output a default message
			else {
				_e( 'No type assigned' );
			}

			break;

		case 'property_area' :

			// Get the terms
			$terms = get_the_terms( $post_id, 'property_area' );

			// If terms were found
			if ( !empty( $terms ) ) {

				$out = array();

				// Loop through each term, linking to the 'edit posts' page for the specific term
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'property_area' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'property_area', 'display' ) )
					);
				}

				// Join the terms and separate them with a comma
				echo join( ', ', $out );
			}

			// If no terms were found, output a default message
			else {
				_e( 'No area assigned' );
			}

			break;

		case 'property_price' :

			echo '<strong>' . apf_the_property_price(true, true, true, false) . '</strong>';

			break;

        case 'property_status' :

    		echo apf_the_property_status(false, true);

    		break;

		// Break out of the switch statement
		default :
			break;
	}
}

/* ----------------------------------------------------------------------*/
/*
/* 	Create columns
/*
/*  This adds dropdowns at the top of the list of properties
/*	to filter them by taxonomy
/*
/* ----------------------------------------------------------------------*/

// property_type
add_action( 'restrict_manage_posts', 'my_restrict_manage_property_type_posts' );
function my_restrict_manage_property_type_posts() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'property') {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array('property_type');

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

// property_area
add_action( 'restrict_manage_posts', 'my_restrict_manage_property_area_posts' );
function my_restrict_manage_property_area_posts() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'property') {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array('property_area');

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


/* ----------------------------------------------------------------------*/
/*
/* 	Column widths
/*
/*  Change column widths to get rectangular images
/*
/* ----------------------------------------------------------------------*/
add_action('admin_head', 'apf_column_widths');
function apf_column_widths() {
    echo '<style type="text/css">';
    echo '.column-property_img { width:120px !important; overflow:hidden }';
    echo '.column-property_img img { max-width:100% !important;}';
    echo '</style>';
}
