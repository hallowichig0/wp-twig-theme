<?php
/**
 * Integrate all custom functions here
 *
 * @package Bootstrap4
 */


class Bootstrap4Function extends Timber\Site {

    public function __construct() {

        add_filter( 'timber/twig', array( $this, 'custom_function_add_to_twig' ) );

		parent::__construct();
    }
    
    /** This is where you can add your custom functions to twig.
	 *  This is good to add your custom functions here
	 * @param string $twig get extension.
	 */
	public function custom_function_add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );

		// Adding a function. (1st param: This is the name that you will call on twig. 2nd param: Your function from php)
        $twig->addFunction( new Timber\Twig_Function( 'custom_widget_search', array($this, 'get_widget_search') ) );
        $twig->addFunction( new Timber\Twig_Function( 'custom_widget_category', array($this, 'get_widget_category') ) );
        $twig->addFunction( new Timber\Twig_Function( 'custom_widget_archive', array($this, 'get_widget_archive') ) );
        $twig->addFunction( new Timber\Twig_Function( 'breadcrumb', array($this, 'get_breadcrumb') ) );
		return $twig;
	}

    // custom widget search
    public function get_widget_search(){
        ?>
            <div class="card mb-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php
    }

    // custom widget category
    public function get_widget_category(){
        $categories = get_categories();
        ?>
            <!-- Categories Widget -->
            <div class="card mb-4">
            <h5 class="card-header">Categories</h5>
                <div class="card-body">
                    <div class="row">
                        <?php
                        foreach ($categories as $cat):
                            $category_link = get_category_link($cat->cat_ID);
                            echo '
                                <div class="col-lg-6">
                                    <a href="'.esc_url( $category_link ).'" title="'.esc_attr($cat->name).'"> '.$cat->name.'</a>
                                </div>
                            ';
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        <?php
    }

    // custom widget archive
    public function get_widget_archive() {
        ?>
            <div class="card my-4">
                <h5 class="card-header">Archives</h5>
                <div class="card-body">
                    <div class="row">
                        <?php echo $this->get_archive_by_year_and_month(); // this is from inc/custom-function.php ?>
                    </div>
                </div>
            </div>
        <?php
    }

    // breadcrumb
    public function get_breadcrumb() {
        $html = '';
        $html .= '
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
                    $html .= '<li class="breadcrumb-item"><a href="'.$cat_link.'">'.$cat_title.'</a></li>';
                }
            // }
            if (is_single()) {

                // single post title
                $html .= '<li class="breadcrumb-item active">'.get_the_title().'</li>';         
            }
        } elseif (is_page()) {
            $html .= '<li class="breadcrumb-item active">'.get_the_title().'</li>';
        }
        $html .= '</ol>';

        return $html;
    }

    // List archives by year, then month
    public function get_archive_by_year_and_month(){
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
        return $html;
    }

}
$customFunction = new Bootstrap4Function();