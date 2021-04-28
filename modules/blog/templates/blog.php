<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
	Blog Main Page

*/
global $post;
get_header();
?>

<section class="blog__wrapper">
	<div class="max__width">

		<?php require('inc/blog-featured.php')?>

		<?php require('inc/blog-results.php')?>

		<?php // require('inc/blog-category-links.php')?>

	</div><!-- max__width -->

	<div class="blog__sidebar">
		<div class="max__width">
			<article>
				<div class="widget__heading">
					<h3><span>Blog</span>Categories</h3>
				</div><!-- widget__heading -->

				<div class="widget__content">
					<ul>
						<?php 
							$args = array(
								'orderby'            => 'name',
								'order'              => 'ASC',
								'title_li'           => __( '' ),
								'taxonomy'           => 'category',
								'walker'             => null
							);
							wp_list_categories( $args ); 
						?>
					</ul>
				</div><!-- widget__content -->
			</article>

			<article>
				<div class="widget__heading">
					<h3><span>Blog</span>Tags</h3>
				</div><!-- widget__heading -->

				<div class="widget__content">
					<div class="tagcloud">
						<?php 
							$args = array(
								'smallest'                  => 8, 
								'largest'                   => 22,
								'unit'                      => 'px', 
								'number'                    => 45,
								'taxonomy'                  => 'post_tag'
							);
							wp_tag_cloud($args);
						?>
					</div><!-- tagcloud -->
				</div><!-- widget__content -->
			</article>

			<article>
				<div class="widget__heading">
					<h3><span>Blog</span>Archive</h3>
				</div><!-- widget__heading -->

				<div class="widget__content">
					<ul>
						<?php
							$args = array(
								'type'            => 'monthly',
								'limit'           => '',
								'format'          => 'html', 
								'show_post_count' => false,
								'echo'            => 1,
								'order'           => 'DESC'
							);
							wp_get_archives($args);
						?>
					</ul>
				</div><!-- widget__content -->
			</article>
		</div>
	</div><!-- blog__sidebar -->
</section>

<?php get_footer(); ?>
