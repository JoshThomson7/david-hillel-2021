<?php
/**
 * Flexible Content Functions
 *
 * @package flexible-content/
 * @version 1.0
 * @dependencies
 *    - ACF PRO: https://www.advancedcustomfields.com/pro/
*/

function flexible_content() {
    include(get_stylesheet_directory().'/modules/flexible-content/flexible-content.php');
}

function fc_field_section($row_layout, $open_close) {
    $row_layout = get_row_layout();

    // section heading
    $options = get_sub_field('fc_options');
    $option_heading = $options['heading'];
    $option_heading_center = $options['heading_center'];
    $option_caption = $options['caption'];
    $option_tab = $options['tab_name'];

    // generate section ID
    $tab_id = '';
    if($option_tab) {
        $tab_id = ' id="'.strtolower(preg_replace("#[^A-Za-z0-9]#", "", $option_tab)).'_section"';
    }

    // styles
    $styles = get_sub_field('fc_styles');

    // padding
    $padding = $styles['fc_padding'];
    $padding_top = !empty($padding['fc_padding_top']) ? $padding['fc_padding_top'].'px' : '0';
    $padding_right = !empty($padding['fc_padding_right']) ? $padding['fc_padding_right'].'px' : '0';
    $padding_bottom = !empty($padding['fc_padding_bottom']) ? $padding['fc_padding_bottom'].'px' : '0';
    $padding_left = !empty($padding['fc_padding_left']) ? $padding['fc_padding_left'].'px' : '0';

    $padding_style = ' style="padding:'.$padding_top.' '.$padding_right.' '.$padding_bottom.' '.$padding_left.';"';

    // grey background
    $grey = $styles['fc_grey_bg'] ? $styles['fc_grey_bg'] : null;
    $grey_class = null;
    if($grey) {
        $grey_class = $grey == true ? ' grey' : '';
    }

    // skewed edges vs curved separators
    $is_skewed = $styles['fc_is_skewed'] ? $styles['fc_is_skewed'] : null;
    $has_curved = $styles['fc_has_curved_separator'] ? $styles['fc_has_curved_separator'] : null;

    $skew_class = '';
    $curved_class = '';

    // skewed
    $top_edge_direction = '';
    $bottom_edge_direction = '';

    if($is_skewed) {
        $skew_edges = $styles['fc_skewed_edges'];

        // top edge
        $skew_edge_top = $skew_edges['top_edge'];
        $skew_edge_top_direction = $skew_edge_top['direction'];
        
        if($skew_edge_top_direction) {
            $top_edge_direction = ' top__'.$skew_edge_top_direction;
        }

        // bottom edge
        $skew_edge_bottom = $skew_edges['bottom_edge'];
        $skew_edge_bottom_direction = $skew_edge_bottom['direction'];
        if($skew_edge_bottom_direction) {
            $bottom_edge_direction = ' bottom__'.$skew_edge_bottom_direction;
        }

        $skew_class = ' is__skewed';

    // curved
    } elseif($has_curved) {

        $curved = $styles['fc_curved_separator'];
        $curved_class = ' is__curved__'.$curved;

    }

    // full width
    $full_width = $styles['fc_full_width'] == true ? true : false;

    // open/close
    if($open_close === 'open') {

        if($row_layout === 'fc_carousel_open') {

            $html = '<div class="fc-layout-carousel '.$row_layout.$grey_class.$skew_class.$curved_class.$top_edge_direction.$bottom_edge_direction.'" '.$padding_style.'>';

        } else {
            $html = '<section'.$tab_id.' class="'.$row_layout.$grey_class.$skew_class.$curved_class.$top_edge_direction.$bottom_edge_direction.'" '.$padding_style.'>';

            // check if full with
            if(!$full_width) {
                $html .='<div class="max__width">';
            }

            if($option_heading || $option_caption) {
                $centre_heading = '';
                if($option_heading_center) {
                    $centre_heading = ' centred';
                }

                $section_heading = '';
                if($option_heading) {
                    $section_heading = '<h2>'.$option_heading.'</h2>';
                }

                $section_caption = '';
                if($option_caption) {
                    $section_caption = $option_caption;
                }

                $html .= '<div class="section__heading'.$centre_heading.'">'.$section_heading.$section_caption.'</div>';
            }
        }


    } elseif($open_close === 'close') {

        if($row_layout === 'fc_carousel_close') {

            $html = '</div>';

        } else {

            // check if full with
            if(!$full_width) {
                $html = '</div><!-- max__width -->';
                $html .= '</section><!-- '.$row_layout.' -->';
            } else {

                $html = '</section><!-- '.$row_layout.' -->';
            }

        }

    }

    switch ($row_layout) {
        case 'fc_carousel_open':
            $skip_close = true;
            $skip_open = false;
            break;

        case 'fc_carousel_close':
            $skip_close = false;
            $skip_open = true;
            break;
        
        default:
            $skip_close = false;
            $skip_open = false;
            break;
    }

    return array(
        'html' => $html,
        'skip_open' => $skip_open,
        'skip_close' => $skip_close,
    );
}
