<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * AT Post Type
 *
 * Register testimonials post type
 *
 * @package Advanced Testimonials
 * @version 1.0
*/

add_action( 'init', 'at_post_type', 4 );

function at_post_type() {
  	$labels = array(
		'name' => __( 'Testimonials' ),
		'singular_name' => __( 'Testimonial' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Create Testimonial' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Testimonial' ),
		'new_item' => __( 'New Testimonial' ),
		'view' => __( 'View Testimonial' ),
		'view_item' => __( 'View Testimonial' ),
		'search_items' => __( 'Search Testimonial' ),
		'not_found' => __( 'No testimonials found' ),
		'not_found_in_trash' => __( 'No testimonials found in trash' ),
		'parent' => __( 'Parent Testimonials' ),
	  );

	$args = array(
		'labels' => $labels,
		'description' => __( 'This is where you can create testimonials.' ),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'publicly_queryable' => false,
		'exclude_from_search' => false,
		'menu_icon' => 'dashicons-format-status',
		'menu_position' => 36,
		'hierarchical' => true,
		'_builtin' => false, // It's a custom post type, not built in!
		'rewrite' => array( 'slug' => 'testimonial', 'with_front' => true ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
	  );

	register_post_type('testimonial', $args);
}

/*================================================================================================================*/
/*                                                                                                                */
/*                                                2. TAXONOMIES                                                   */
/*                                                                                                                */
/*================================================================================================================*/

add_action( 'init', 'create_testimonial_taxonomy', 0 );

function create_testimonial_taxonomy() {
	/*--------------------------------------------------------------------------*/
	/*                             Testimonials                        			*/
	/*--------------------------------------------------------------------------*/

	/* Category */
    $labels = array(
        'name' => _x( 'Categories', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => __( 'Parent Categories' ),
        'parent_item_colon' => __( 'Parent Categories:' ),
        'edit_item' => __( 'Edit Category' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category' ),
        'menu_name' => __( 'Categories' )
    );

    register_taxonomy('testimonial_category',array('testimonial'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'public' => false
	));
}


/* ----------------------------------------------------------------------*/
/*
/* 	Create columns
/*
/* ----------------------------------------------------------------------*/

// Manage Columns

add_filter( 'manage_edit-testimonial_columns', 'my_edit_testimonial_columns' ) ;

function my_edit_testimonial_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
        'title' => __( 'Title' ),
		'label' => __( 'Label' ),
		'author' => __( 'Author' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

// Manage Column Data

add_action( 'manage_testimonial_posts_custom_column', 'my_manage_testimonial_columns', 10, 2 );

function my_manage_testimonial_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'label' :

			if(get_field('testim_label', $post_id)) {

				echo the_field('testim_label', $post_id);

			} else {

				echo the_field('testim_name', $post_id);

			}

            break;

		// Break out of the switch statement
		default :
			break;
	}
}