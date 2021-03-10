<?php
/**
 * Integrate all custom functions here
 *
 * @package Bootstrap4
 */

// custom widget search
function get_widget_search(){
    get_template_part('inc/custom-widgets/widget', 'search');
}

// custom widget category
function get_widget_category(){
    get_template_part('inc/custom-widgets/widget', 'category');
}

// custom widget archive
function get_widget_archive() {
    get_template_part('inc/custom-widgets/widget', 'archive');
}

// breadcrumb
function get_breadcrumb() {
    echo '
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="'.home_url().'" rel="nofollow">Home</a>
        </li>
    ';
    if (is_category() || is_single()) {
        // if (is_category()) {
            
            foreach((get_the_category()) as $category) {
                $cat_title = $category->cat_name . ' ';
                $cat_link = get_category_link($category->cat_ID);
                echo '<li class="breadcrumb-item"><a href="'.$cat_link.'">'.$cat_title.'</a></li>';
            }
        // }
        if (is_single()) {

            // single post title
            echo '<li class="breadcrumb-item active">'.get_the_title().'</li>';         
        }
    } elseif (is_page()) {
        echo '<li class="breadcrumb-item active">'.get_the_title().'</li>';
    }
    echo '</ol>';
}

// List archives by year, then month
function get_archive_by_year_and_month(){
    global $wpdb;
    $html = '';
    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_type IN ('post', 'program') AND post_status = 'publish' ORDER BY post_date DESC");
    if($years){
        $html .= '<ul>';
        foreach($years as $year){
            $html.='<li class="archive-year"><a href="'.get_year_link($year).'">'.$year.'</a>';
            $html.='<ul>';
            $months = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_type IN ('post', 'program') AND post_status='publish' AND YEAR(post_date) = %d ORDER BY post_date ASC",$year));
            foreach($months as $month){
                $dateObj   = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F'); 
                $html.='<li class="archive-month"><a href="'.get_month_link($year,$month).'">'.$monthName.'</a></li>';
            }
            $html.='</ul>';
            $html.='</li>';
        }
        $html.='</ul>';
    }
    echo $html;
}