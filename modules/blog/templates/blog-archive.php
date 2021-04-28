<?php

/*
*	Blog Archive
*
*	@package Blog
*	@version 1.0
*/
get_header();

?>
<section class="blog__wrapper">
	<div class="max__width">

	<?php dimox_breadcrumbs()?>

	<?php if(is_category( )):?>
		<div class="blog__title">
			<h2>Category: <?php single_cat_title();?></h2>
		</div>
	<?php endif;?>

		<div class="blog__categories">
					
			<?php
				while (have_posts()) : the_post();
					
					require(blog_path().'templates/inc/blog-single-article.php');

				endwhile; wp_reset_query(); ?>
			
		</div><!-- blog__categories half left -->
	</div><!-- max__width -->
</section>

<?php
get_footer();
?>