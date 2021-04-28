<?php
/*
 Testimonials
 */

$display_format = get_sub_field('testimonials_display_format');
$order_by = get_sub_field('testimonials_order_by');
$posts_per_page = get_sub_field('testimonials_number');

// carousel
$carousel_open = '';
$carousel_close = '';
if($display_format == 'grid' && get_sub_field('testimonials_carousel')) {
    $carousel_open = '<div id="testimonials_carousel">';
    $carousel_close = '</div>';
}

// Prepare query
$pages = $wp_query->max_num_pages;
$testimonials = new WP_Query(array(
    'post_type'         => 'testimonial',
    'post_status'       => 'publish',
    'orderby'           => $order_by,
    'order'             => 'asc',
    'posts_per_page'    => $posts_per_page,
    'paged'             => $paged
));

echo '<div class="testimonials__wrapper '.$display_format.'">';

echo $carousel_open;
while($testimonials->have_posts()) : $testimonials->the_post();

    // Stars
    $stars = get_field('testim_rating');

    // Image
    if(has_post_thumbnail()) {
        $attachment_id = get_post_thumbnail_id();
        $test_img = vt_resize($attachment_id,'' , 200, 200, true);
        $test_img_output = $test_img['url'];
    } else {
        $test_img_output = 'https://www.northfields.co.uk/wp-content/uploads/2020/09/Northfields-icon-new-96.png';
    }

    // Align
    $align = '';
    if(get_field('testim_video_id')) {
        $align = ' '.get_field('testim_video_position');
    }
?>
    <article>
        <div class="test_img">
            <img src="<?php echo $test_img_output; ?>" alt="">
        </div>

        <div class="test_content">
            <div class="testimonial__meta">
                <h3><?php the_title(); ?></h3>
                <div class="stars">
                    <?php for($x = 1; $x <= $stars; $x++): ?>
                        <span>&#x2605;</span>
                    <?php endfor; ?>
                </div><!-- stars -->
            </div><!-- testimonial__meta -->

            <?php if(get_field('testim_video_id')): ?>
                <div class="video-wrapper">
                    <div class="video-responsive">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php the_field('testim_video_id'); ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </div><!-- video-responsive -->
                </div><!-- video-wrapper -->
            <?php endif; ?>

            <div class="testim__content">
                <p><?php if(get_sub_field('testimonials_display_format') === 'grid') { echo trunc(get_field('testim_quote'), 25); } else { the_field('testim_quote'); } ?></p>
                <h5><?php the_field('testim_name'); ?></h5>
            </div><!-- testim__content -->
        </div>
    </article>
<?php
endwhile; wp_reset_postdata();

echo '</div><!-- testimonials__wrapper -->';
echo $carousel_close;
?>

<?php 
if( $display_format == 'list'):
    pagination($testimonials->max_num_pages); 
endif; ?>
