<?php
/*
 * Featured Testimonials
 */

 
// Filters
$testimonial_types = (array_column(get_sub_field('featured_reviews'),'featured_review_type'));
$input_options = '<div class="btn-group">';
$input_index = 0; 
foreach ($testimonial_types as $key => $type) {
    $current = ($key == 0)? 'checked' : '';

    $input_options .= '<input data-index="'.$input_index.'" id="'.$type.'" type="radio" name="testimonial-filter" autocomplete="off" '.$current.' value="'.$type.'"/>';
    $input_options .= '<label for="'.$type.'" aria-label="Click to find out more about our happy '.$type.'" class="button tertirary small">'.$type.'</label>';
    $input_index++; 
}
$input_options.= '</div><!--btn-group-->';

?>
    <div class="featured-testimonials--filter">
        <span>Happy</span>
        <?php echo $input_options?>
    </div><!--featured-testimonials--filter-->
  

<div id="featured-testimonials--carousel">
    <?php while(have_rows('featured_reviews')): the_row(); ?>
        <?php 
            $review_id = get_sub_field('featured_review');

            //Reviewer Image
            if( $attachment_id = get_post_thumbnail_id( $review_id )){
                $attachment_url = vt_resize($attachment_id, '', 500,500, true);
            }
            $attachment_url = (empty($attachment_url))? 'https://via.placeholder.com/500' : $attachment_url['url']; 

            //Content
            $section_heading = get_sub_field('testimonials_feature_box_heading');
            $caption = get_sub_field('testimonials_feature_box_caption');
            
            $button_label = get_sub_field('testimonials_feature_box_link_label');
            $button_url = get_sub_field('testimonials_feature_box_link');
            $button_target = (get_sub_field('testimonials_feature_box_link_target'))? 'target="_blank" rel="nofollow"' : '';
        ?>
        <div class="featured-testimonials--single">
            
            <div class="featured-testimonials--single--box">
                <h3><?php echo $section_heading?></h3>
                <p><?php echo $caption?></p>
                <a class="button secondary" href="<?php echo $button_url?>" <?php echo $button_target?>><?php echo $button_label?></a>
            </div>

            <div class="featured-testimonials--single--review">
                <div class="featured-testimonials--single--review-image" style="background-image: url(<?php echo $attachment_url ?>);"></div>
                <div class="featured-testimonials--single--review-content">
                    <p><?php echo trunc(get_field('testim_quote', $review_id),25);?></p>
                    <h5><?php echo get_field('testim_name',$review_id);?></h4>
                </div>
            </div>
            
        </div><!--featured-testimonials--single-->
    <?php endwhile;  ?>
</div><!-- #featured-testimonials-carousel -->


