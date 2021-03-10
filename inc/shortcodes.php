<?php
/**
 * All shortcodes
 *
 *
 * @package Bootstrap4
 */

    
// breadcrump shortcode
function breadcrumb_handler($atts, $output){
    $args = shortcode_atts(array(
        'id' => '',
        'post_type' => '',
    ), $atts);

    $output = '
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="'.home_url().'" rel="nofollow">Home</a>
        </li>
    ';

    if (is_single()) {
        
        $post_id = get_post($args['id']);
        if(!empty($args['post_type'])){
            if($args['post_type'] == get_post_type()){
                if(!empty($args['id'])){
                    if($post_id){
                        $parent_title = $post_id->post_title;
                        $link = get_page_link($args['id']);
                        // single parent title
                        $output .= '<li class="breadcrumb-item"><a href="'.$link.'">'.$parent_title.'</a></li>';
                    }
                }
            }
        }

        // single post title
        $output .= '<li class="breadcrumb-item active">'.get_the_title().'</li>';
    } elseif (is_page()) {
        $output .= '<li class="breadcrumb-item active">'.get_the_title().'</li>';
    }

    $output .= '</ol>';

    echo $output;
}
add_shortcode( 'breadcrumb', 'breadcrumb_handler' );