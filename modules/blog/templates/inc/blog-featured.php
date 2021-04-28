<?php 
global $post;

// Prepare query
$blog = new WP_Query(array(
	'post_type'         => 'post',
	'post_status'       => 'publish',
	'posts_per_page'    => 	3,
	'orderby'           => 'date',
	'order'             => 'desc',
));

$exclude_news_ids =array();

if ($blog->have_posts()) :
	?>
	<div class="social__blogs">
		<?php
		$news_count = 1;
		while ($blog->have_posts()) : $blog->the_post();

			$exclude_news_ids[] = $post->ID;
			if(has_post_thumbnail()):                                                              
				$attachment_id = get_post_thumbnail_id( $post->ID );                    
			else:                          
				$attachment_id = get_field('default_banner_image','options'); 
			endif;

			$blog_img = vt_resize($attachment_id, '', 780, 500, true);

			$blog_cats = wp_get_post_terms(get_the_id(), 'category');

			if ($news_count > 1) {
				$blog_class = ' small';
			} else {
				$blog_class = ' big';
			}

			?>

			<div class="social__blog<?php echo $blog_class; ?>" style="background-image:url(<?php echo $blog_img['url']; ?>)">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="social__blog__overlay">
					<div class="caption">
						<div class="caption__date">
							<div class="caption__date__day"><?php the_time('j'); ?></div>
							<div class="caption__date__month"><?php the_time('M'); ?></div>
							<div class="caption__date__year"><?php the_time('Y'); ?></div>
						</div><!-- caption__date -->

						<div class="caption__content">
							<h6><span class="pe-7s-ticket"></span> <?php echo $blog_cats[0]->name; ?></h6>
							<h3><?php the_title(); ?></h3>
							<?php if ($news_count == 1) : ?><p><?php echo trunc(get_the_excerpt(), 20); ?></p><?php endif; ?>
						</div><!-- caption__content -->
					</div><!-- caption -->
				</a>
			</div><!-- social__blog big -->

			<?php $news_count++;

		endwhile;wp_reset_query(); ?>

	</div><!-- social__blogs -->

<?php endif; ?>