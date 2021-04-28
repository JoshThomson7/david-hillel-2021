<?php
/**
 * Blog Functions
 *
 * @author  Various
 * @package blog/
 *
*/

require_once('inc/blog-pages.php');
require_once('inc/blog-templates.php');


/*--------------------------------------------------------------------------*/
/*    Add blog classes to body_class
/*--------------------------------------------------------------------------*/
add_filter( 'body_class','blog_class' );
function blog_class( $classes ) {
    
    if(is_page('blog')|| is_single() || is_category() || is_archive()){
        $classes[] = 'blog';
    }

    if(is_page('blog')){
        $classes[] = 'blog__home';
    }
    
    if(is_single()) {
        $classes[] = 'blog__single';
    }

    if(is_category() || is_archive() ){
        $classes[] = 'blog__archives';
    }
    return $classes;
}


/*--------------------------------------------------------------------------*/
/*    function blog_path()
/*    returns the full blog path
/*--------------------------------------------------------------------------*/
function blog_path($blog_url = false) {

    if($blog_url) {
        $blog_path = get_stylesheet_directory_uri()  . '/modules/blog/';
    } else {
        $blog_path = get_stylesheet_directory()  . '/modules/blog/';
    }
    return $blog_path;
}


/*--------------------------------------------------------------------------*/
/*    Enqueue Scripts
/*--------------------------------------------------------------------------*/
function blog_enqueue_scripts(){

    if(is_page('blog')|| is_single() || is_category() || is_archive()){
        wp_enqueue_style( 'fl1-blog', blog_path(true) . 'css/blog-min.css', array(), '0.0.1' );
    }

}
add_action( 'wp_enqueue_scripts', 'blog_enqueue_scripts' );

