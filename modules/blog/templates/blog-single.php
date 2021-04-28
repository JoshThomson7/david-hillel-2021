<?php
/*
*	Blog Single
*
*	@package Blog
*	@version 1.0
*/
get_header();
global $post;
?>

<section class="blog__wrapper">
	<div class="max__width">
    
        <?php dimox_breadcrumbs()?>

        <div class="blog__single__wrapper">

            <article class="blog__single__content">
                <?php 
                //To do: Featured Image // Page banner? 
                //To do: Transition Content to acf 
                //To do: Sidebar?

                ?>
                <?php while(have_posts()) : the_post(); ?>
                    <?php the_content(); ?>   
                <?php endwhile; ?>

                <?php flexible_content(); ?>
            </article>

            <?php require_once('blog-sidebar.php'); ?>

        </div>

    </div><!-- max__width -->     
</section><!-- blog__wrapper -->
<?php get_footer(); ?>
