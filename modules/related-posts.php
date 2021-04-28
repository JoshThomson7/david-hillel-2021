<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Function: getRelatedPosts
@Paramaters: $postID the ID of the post
@Returns: a string unordered list of links of posts related to the ID."
*/


function get_related_posts($postID) {
	// Use the global variable to query the wordpress database
	global $wp_query;

	$post_type = get_post_type();

	// Get the tags of the post passed to the function
	$tags = wp_get_post_tags($postID);

	// Set up a counter then loop through the tags
	$tagCounter=0;

	// If the post has tags then loop
	if($tags)
	{
		// Set up a tag array with all the tags.
		foreach ($tags as $tag) {  $tag_array[]=  $tag->term_id;}

		// Join the tags in one string using PHP's implode. Separate with a comma like: ','
		$tag_string = '\''.implode('\',\'',$tag_array).'\'';
	}

	// Get all the categories for the ID passed
	// $categories = wp_get_post_categories($postID);

	// For each category set up the categories array
	// foreach ($categories as $category)
	// {
		$category_array[]=  get_category($category)->term_id;
	// }

	// Join the categories using PHP's implode. Separate with a comma like: ','
	//$category_string = '\''.implode('\',\'',$category_array).'\'';

	// Now set up the query.
	// We will be showing 4 related posts other than the current post and have categories and tags we set up previously.
	// We will be ordering the related posts randomly.
	$args=array
	(
		'post_type' => $post_type,
		// 'cat'=>$category_string,
		'post__not_in' => array($postID),
		'showposts'=>2,
		'caller_get_posts'=>1,
		'tag__in'=>$tag_array,
		'orderby'=>'rand'
	);

    // Pass the query
	$related_posts = new wp_query($args);

	// If the query is successful and returns posts loop through them.
	?>

	<?php if($related_posts->have_posts()): ?>
    	<div class="related-posts">
            <h2>Related projects</h2>

            <ul class="projects "style="overflow:hidden;">
                <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                    <?php
                        $attachment_id = get_post_thumbnail_id( $post->ID );
                        $feat_image = vt_resize( $attachment_id,'' , 101, 94, true ); // Use false if you don't want to set a height
                    ?>
                    <li>
                        <div class="imgb"><img src="<?php echo $feat_image['url']; ?>" alt="<?php the_title(); ?>" /></div>
                        <h4><?php the_title(); ?></h4>
                        <p><?php echo portfolio_excerpt(get_the_excerpt($post->ID)); ?></p>
                        <a href="<?php the_permalink(); ?>" title="Read more">Read more</a>
                        <div class="clear"></div>
                    </li>
                <?php endwhile; wp_reset_query(); ?>
            </ul>
		</div><!-- related-posts -->
	<?php endif; ?>

	<?php // If something goes wrong, there are no related posts, return false.
	return false;
}
