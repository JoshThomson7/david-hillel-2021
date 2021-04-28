<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF Branches Functions
 *
 * @author  Various
 * @package Advanced Property Framework
 *
*/

/*--------------------------------------------------------------------------*/
/*                                   BRANCH                                 */
/*--------------------------------------------------------------------------*/
add_action( 'init', 'create_branch_posttype', 4 );
function create_branch_posttype() {
  	$labels = array(
		'name' => __( 'Branches' ),
		'singular_name' => __( 'Branch' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Create Branch' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Branch' ),
		'new_item' => __( 'New Branch' ),
		'view' => __( 'View Branch' ),
		'view_item' => __( 'View Branch' ),
		'search_items' => __( 'Search Branches' ),
		'not_found' => __( 'No branches found' ),
		'not_found_in_trash' => __( 'No branches found in trash' ),
		'parent' => __( 'Parent Branch' ),
	  );

	$args = array(
		'labels' => $labels,
		'description' => __( 'This is where you can create branches.' ),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_icon' => 'dashicons-location',
		'menu_position' => 29,
		'hierarchical' => true,
		'_builtin' => false, // It's a custom post type, not built in!
		'rewrite' => array( 'slug' => 'branch', 'with_front' => true ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
	  );

	register_post_type('branch', $args);
}
