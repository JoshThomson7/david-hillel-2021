<?php
/**
 * Blog Functions
 *
 * @author  Various
 * @package blog/
 *

*/

/*
 *	Blog page
*/
function blog_templates($page_template) {
	global $post;

	if(is_page('blog')) {
		$page_template = get_stylesheet_directory() . '/modules/blog/templates/blog.php';
	}

	return $page_template;

}
add_filter( 'page_template', 'blog_templates' );


/*
 *	Single blog
*/
function blog_single_template($single_template) {
    global $post;

    if ($post->post_type === 'post') {
        $single_template = get_stylesheet_directory() . '/modules/blog/templates/blog-single.php';
    }

    return $single_template;
}
add_filter( 'single_template', 'blog_single_template' );

/*
 *	Archive blog
*/
function blog_category_template( $archive_template ) {
    global $post;

    if ( is_category() ) {
        $archive_template = get_stylesheet_directory() . '/modules/blog/templates/blog-archive.php';
    }

    return $archive_template;
}

add_filter( 'category_template', 'blog_category_template' ) ;

/*
 *	Archive blog
*/
function blog_archive_template( $archive_template ) {
    global $post;

    if ( is_archive() ) {
        $archive_template = get_stylesheet_directory() . '/modules/blog/templates/blog-archive.php';
    }

    return $archive_template;
}

add_filter( 'archive_template', 'blog_archive_template' ) ;
