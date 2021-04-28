<?php
/*
*   Team Archive Template
*/

get_header();

global $post;

avb_banners('inner');
?>
<section class="team__filters">

    <div class="max__width">

        <form action="" id="team__search__form" class="team__search__form">

            <div class="input__search__text">
                <input type="text" name="team_name" id="team_search_keyword" placeholder="Name">
                <span class="fal fa-search"></span>
            </div>

            <?php 
            /**
             * Department Dropdown
             */
            // $args = array(
            //     'class'       => 'select-submit2',
            //     'hide_empty'  => false,
            //     'name'        => 'team_department',
            //     'id'          => 'team_department',
            //     'orderby'     => 'NAME',
            //     'order'       => 'ASC',
            //     'data-placeholder'  => 'Department',
            //     'taxonomy'    => 'team_department',
            //     // 'hierarchical'=> true
            // );
            // wp_dropdown_categories( $args ); 

            $departments = get_terms( array(
                'taxonomy' => 'team_department',
                'hide_empty' => false,
            ));

            if(!empty($departments)): ?>
                <select class="select-submit2" name="team_department">
                    <option value="">Any department</option>
                    <?php foreach($departments as $department): ?>
                        <option value="<?php echo $department->term_id; ?>"><?php echo $department->name; ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif;
            
            
            /**
             * Branch Dropdown
             */
            $branches_query = new WP_Query(array(
                'post_type' => 'branch',
                'post_status' => 'publish',
                'posts_per_page' => -1
            ));

            if($branches_query->have_posts()):
            ?>
                <select class="select-submit2" name="team_branch">
                    <option value="">Any branch</option>
                    <?php while($branches_query->have_posts()) : $branches_query->the_post(); ?>
                        <option value="<?php echo get_the_id()?>"><?php the_title(); ?></option>
                    <?php endwhile; wp_reset_postdata(); ?>
                </select>
            <?php endif; ?>
        </form> <!--team__search__form-->
    </div>

    <div class="team__results" id="team__results">
        
        <?php 
        /**
         * Render on first load
         */

         include(atm_path().'helpers/team-loop.php');
        ?>

    </div>

</section>
<?php 

flexible_content();

get_footer();
?>
