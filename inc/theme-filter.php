<?php
/**
 * All theme filters
 *
 *
 * @package Bootstrap4
 */

class Bootstrap4Filter extends Timber\Site {

	public function __construct() {

        /* All without callback function */

        /**
         * Close comments on the front-end
         */
        // add_filter('comments_open', '__return_false', 20, 2);
        add_filter( 'pings_open', '__return_false', 20, 2 );
        add_filter( 'wpcf7_autop_or_not', '__return_false' ); // remove <p> & <br> in contact form 7

        remove_filter( 'the_content', 'wpautop' );
        add_filter( 'the_content', 'shortcode_unautop', 100 );

        /**
         * Remove automatically generated <p> & </br> tag in comment
         */
        remove_filter( 'comment_text', 'wpautop', 30 );

        /**
         * Excerpt Filters
         */
        remove_filter( 'the_excerpt', 'wpautop' );


        /* All with callback function */

        add_filter( 'jpeg_quality', array($this, 'image_toolkit') );
        add_filter( 'the_content', array($this, 'better_wpautop'), 99 );
        add_filter ( 'the_content', array($this, 'add_newlines_to_post_content') );
        add_filter( 'excerpt_length', array($this, 'wpdocs_custom_excerpt_length'), 999 );
        add_filter( 'excerpt_more', array($this, 'wpdocs_excerpt_more') );
        add_filter( 'next_posts_link_attributes', array($this, 'posts_link_attributes') );
        add_filter( 'previous_posts_link_attributes', array($this, 'posts_link_attributes') );
        // add_filter( 'nav_menu_css_class', array($this, 'add_additional_class_on_li'), 1, 3 );
        add_filter( 'nav_menu_link_attributes', array($this, 'add_additional_class_on_a'), 10, 3 );
        add_filter( 'wp_nav_menu_objects', array($this, 'add_menu_parent_class') );
        add_filter( 'nav_menu_css_class', array($this, 'add_active_grandparent_parent_class'), 10, 2 );
        add_filter( 'body_class', array($this, 'custom_body_class') );
        
        /**
         * adds the add_noscript_filter function to the script_loader_tag filters
         * it must use 3 as the last parameter to make $tag, $handle, $src available
         * to the filter function
         */
        add_filter('script_loader_tag', array($this, 'add_noscript_filter'), 10, 3);

        add_filter( 'clean_url', array($this, 'async_script'), 11, 1 );
        add_filter( 'clean_url', array($this, 'async_style'), 11, 1 );

        /**
         * acf/update_value/name={$field_name} - filter for a specific field based on it's name
         */
        add_filter('acf/update_value/name=post_thumbnail_field', array($this, 'acf_set_featured_image'), 10, 3);

        // add_filter( 'wp_editor_settings', array($this, 'disable_media_button') );
        // add_filter( 'script_loader_tag', array($this, 'prefix_add_defer_attribute'), 10, 2 );
        // add_filter( 'woocommerce_checkout_fields' , array($this, 'custom_override_checkout_fields') );

        parent::__construct();

    }

    /**
     * Define the image quality for JPEG manipulations. Ranges from 0 to 100. 
     * Higher values mean better image quality but bigger files.
     */
    public function image_toolkit($arg){
        return 90;
    }

    /**
     * Remove automatically </br> tag in content
     */
    public function better_wpautop($p){
        return wpautop($p,$br = false);
    }

    /**
     * Convert generated <p>&nbsp;</p> into </br> tag in content
     */
    public function add_newlines_to_post_content( $content ) {
        return nl2br( $content );
    }

    /**
     * Filter the except length to 20 words.
     */
    public function wpdocs_custom_excerpt_length( $length ) {
        return 30;
    }

    /**
     * Filter the excerpt "read more" string.
     */
    public function wpdocs_excerpt_more( $more ) {
        return '...';
    }

    /**
     * Filter for Next & Prev post link button
     */
    public function posts_link_attributes() {
        return 'class="page-link"';
    }

    /**
     * Filter to add class in <li> tag in wp_nav_menu()
     */
    public function add_additional_class_on_li($classes, $item, $args) {
            $classes[] = ''; // add additional classes here
        return $classes;
    }

    /**
     * Filter to add class in <a> tag in wp_nav_menu()
     */
    public function add_additional_class_on_a($classes, $item, $args) {
        if($args->add_a_class) {
            $classes['class'] = $args->add_a_class;
        }
        return $classes;
    }

    /*
    * Add ancestor class on `current_page_parent` parent
    */
    public function add_menu_parent_class( $items ) {
        $parents = array();
        foreach ( $items as $item ) {
            if ( in_array('current_page_parent', $item->classes)  ) {
                $parents[] = $item->menu_item_parent;
            }
        }

        foreach ( $items as $item ) {
            if ( in_array( $item->ID, $parents ) ) {
                $item->classes[] = 'current_page_ancestor'; 
            }
        }

        return $items;    
    }

    /*
    * Add active class on parent and grandparent menu while you are in a single post or page
    */
    public function add_active_grandparent_parent_class($classes, $item) {

        if( in_array( 'current_page_parent', $classes ) || in_array( 'current_page_ancestor', $classes ) ) {
            $classes[] = 'active';
        }

        return $classes;
    }

    /**
     * Filter Body Class
     */
    public function custom_body_class($classes) {
        $classes[] = ''; // add class here
        return $classes;
    }

    /**
     * @summary        filters an enqueued style tag and adds a noscript element after it
     * 
     * @description    filters an enqueued style tag (identified by the $handle variable) and
     *                 adds a noscript element after it.
     * 
     * @access    public
     * @param     string    $tag       The tag string sent by `style_loader_tag` filter on WP_Styles::do_item
     * @param     string    $handle    The script handle as sent by `script_loader_tag` filter on WP_Styles::do_item
     * @param     string    $href      The style tag href parameter as sent by `script_loader_tag` filter on WP_Styles::do_item
     * @param     string    $media     The style tag media parameter as sent by `script_loader_tag` filter on WP_Styles::do_item
     * @return    string    $tag       The filter $tag variable with the noscript element
     */
    public function add_noscript_filter($tag, $handle, $src){
        // as this filter will run for every enqueued script
        // we need to check if the handle is equals the script
        // we want to filter. If yes, than adds the noscript element
        if ( 'script-handle' === $handle ){
            $noscript = '<noscript>';
            // you could get the inner content from other function
            $noscript .= '<h1>You need to have JavaScript enabled to view this site.</h1>';
            $noscript .= '</noscript>';
            $tag = $tag . $noscript;
        }
            return $tag;
    }

    /**
     * Add async on enqueue script
     */
    public function async_script($url)
    {
        if ( strpos( $url, '#asyncscript') === false )
            return $url;
        else if ( is_admin() )
            return str_replace( '#asyncscript', '', $url );
        else
        return str_replace( '#asyncscript', '', $url )."' async='async"; 
    }

    /**
     * Change load of style to preload
     */
    public function async_style($url)
    {
        if ( strpos( $url, '#asyncstyle') === false )
            return $url;
        else if ( is_admin() )
            return str_replace( '#asyncstyle', '', $url );
        else
        return str_replace( '#asyncstyle', '', $url )."' onload='this.media=\"all\""; 
    }

    /**
     * Update and replace featured image value with acf image field value
     */
    public function acf_set_featured_image( $value, $post_id, $field  ){
        
        if($value != ''){
            // If post_thumbnail exists
            delete_post_thumbnail( $post_id);
            // Add the value which is the image ID to the _thumbnail_id meta data for the current post
            add_post_meta($post_id, '_thumbnail_id', $value);
        }
        return $value;
    }

    /**
     * Removes "Add Media" buttons from post types.
     */
    public function disable_media_button( $settings ) {
        $current_screen = get_current_screen();

        // Post types for which the media buttons should be removed.
        $post_types = array( 'post', 'page' );

        // Bail out if media buttons should not be removed for the current post type.
        if ( ! $current_screen || ! in_array( $current_screen->post_type, $post_types, true ) ) {
            return $settings;
        }

        $settings['media_buttons'] = false;

        return $settings;
    }

    /**
     * Add defer attribute to Google reCaptcha script (Contact Form 7 Recaptcha v2)
     *
     * @param String $tag		- Script HTML
     * @param String $handle	- Unique identifier for script
     *
     * @return String $tag
     */
    public function prefix_add_defer_attribute( $tag, $handle ) {
        
        // The handle for our google recaptcha script is <code>google-recaptcha</code>
        // IF it's not this handle return early
        if( 'google-recaptcha' !== $handle ) {
            return $tag;
        }
        
        // IF we don't already have a defer attribute, add it
        if( false === strpos( $tag, 'defer ' ) && false === strpos( $tag, ' defer' ) ) {
            $tag = str_replace( 'src=', 'defer src=', $tag );
        }
        
        return $tag;
        
    }

    /**
     * Filter to change cols and rows in "woocommerce checkout order notes"
     */
    public function custom_override_checkout_fields( $fields ) {

        $fields['order']['order_comments']['custom_attributes'] = array('cols' => 100, 'rows' => 9);

        return $fields;
    }

}
new Bootstrap4Filter();