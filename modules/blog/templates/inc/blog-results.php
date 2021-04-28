<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
global $post; 

/* Get all blog category terms */
$blog_terms = get_terms(
    array(
        'taxonomy'  => 'category',
        // 'hide_empty' => true,
        'orderby'    => 'title',
    )
);

?>
<div class="blog-results"> 

    <?php 
    //Display Results 
    foreach( $blog_terms as $blog_term ):?>
        <div class="blog-results-category">
            <h4><a href="<?php echo get_term_link($blog_term->term_id,  'category')?>"><?php echo $blog_term->name?></a></h4>

            <?php 

            $blogs = new WP_Query(
                array(
                'post_type'         => 'post',
                'post_status'       => 'publish',
                'cat'               => $blog_term->term_id,
                'posts_per_page'    =>  3,
                'orderby'           => 'date',
                'order'             => 'desc',
                'post__not_in'		=> $exclude_news_ids
                )
            );

            while ($blogs->have_posts()) : $blogs->the_post();

                    require(blog_path().'templates/inc/blog-single-article.php');

            endwhile; wp_reset_query(); ?>
        </div><!--blog-results-category-->

    <?php endforeach; ?>

</div><!-- blog-results -->