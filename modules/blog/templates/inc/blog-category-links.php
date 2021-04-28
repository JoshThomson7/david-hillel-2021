<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
global $post; 

$terms = get_terms( 'category',array(
    'hide_empty' => true,
    )
);

if ( $terms ) { ?>
    <div class="blog__categories">

        <h4>Categories</h4>

        <div class="blog__categories__wrapper">
            <?php foreach ( $terms as $term ): ?>			
                <article>
                    <a href="<?php echo get_term_link( $term ); ?>"><?php echo $term->name; ?></a>    												
                </article>
            <?php endforeach; ?>
        </div> <!--blog__categories__wrapper-->
    </div> <!-- blog__categories-->

<?php } ?>