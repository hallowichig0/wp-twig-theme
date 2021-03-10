<?php
$directory_uri = get_template_directory_uri();

// css
wp_enqueue_style( 'bootstrap-css', $directory_uri . '/library/bootstrap/dist/css/bootstrap.min.css' );
// wp_enqueue_style( 'venobox-css', $directory_uri . '/library/venobox/venobox/venobox.min.css' );
// wp_enqueue_style( 'mmenu-css', $directory_uri . '/library/mmenu-js/dist/mmenu.css' );
// wp_enqueue_style( 'aos-css', $directory_uri . '/library/aos/dist/aos.css' );
wp_enqueue_style( 'font-awesome-css', $directory_uri . '/assets/font-awesome/css/font-awesome.css', array(), '4.7.0' );
// wp_enqueue_style( 'slick-css', $directory_uri . '/library/slick-carousel/slick/slick.css' );
// wp_enqueue_style( 'custom-css', $directory_uri . '/css/custom.css' );
wp_enqueue_style( 'theme-css', get_stylesheet_uri() );

// Update jquery version & Remove unnecessary styles and scripts (Frontend only)
if ( !is_admin() || !is_customize_preview() ) {
    // Dequeue Gutenberg Block CSS
    wp_dequeue_style( 'wp-block-library' );

    /*
    * Dequeue Gutenberg Block CSS
    * if you want to embed other people's WordPress posts into your own WordPress posts, comment `wp-embed`
    */
    wp_deregister_script( 'wp-embed' );
    // Deregister WP jQuery
    wp_deregister_script( 'jquery' );
    // Deregister WP jQuery Core
    wp_deregister_script( 'jquery-core' );
    // Deregister WP jQuery Migrate
    wp_deregister_script( 'jquery-migrate' );
    // Register jQuery in the head
    wp_register_script('jquery-core', $directory_uri . '/library/jquery/dist/jquery.min.js','','',true);

    /**
     * Register jquery using jquery-core as a dependency, so other scripts could use the jquery handle
     * see https://wordpress.stackexchange.com/questions/283828/wp-register-script-multiple-identifiers
     * We first register the script and afther that we enqueue it, see why:
     * https://wordpress.stackexchange.com/questions/82490/when-should-i-use-wp-register-script-with-wp-enqueue-script-vs-just-wp-enque
     * https://stackoverflow.com/questions/39653993/what-is-diffrence-between-wp-enqueue-script-and-wp-register-script
     */
    wp_register_script( 'jquery', false, array( 'jquery-core' ), null, false );
    wp_enqueue_script( 'jquery' );
}

// script
wp_enqueue_script('jquery-effects-core'); // get the wp core jquery-ui-effect
wp_enqueue_script('jquery-once-js', $directory_uri . '/library/jquery-once/jquery.once.min.js','','',true);
// wp_enqueue_script('jquery-match-height-js', $directory_uri . '/library/jquery-match-height/dist/jquery.matchHeight-min.js','','',true);
wp_enqueue_script('bootstrap-js', $directory_uri . '/library/bootstrap/dist/js/bootstrap.min.js','','',true);
// wp_enqueue_script('venobox-js', $directory_uri . '/library/venobox/venobox/venobox.min.js','','',true);
// wp_enqueue_script('lazysizes-unveilhooks-js', $directory_uri . '/library/lazysizes/plugins/unveilhooks/ls.unveilhooks.min.js','','',true);
// wp_enqueue_script('lazysizes-js', $directory_uri . '/library/lazysizes/lazysizes.min.js','','',true);
// wp_enqueue_script('infinite-scroll-js', $directory_uri . '/library/infinite-scroll/dist/infinite-scroll.pkgd.min.js','','',true);
// wp_enqueue_script( 'mmenu-js', $directory_uri . '/library/mmenu-js/dist/mmenu.js', '','',true);
// wp_enqueue_script( 'aos-js', $directory_uri . '/library/aos/dist/aos.js', '','',true);
// wp_enqueue_script('nicescroll-js', $directory_uri . '/assets/nicescroll/jquery.nicescroll.js','','',true);
// wp_enqueue_script('slick-js', $directory_uri . '/library/slick-carousel/slick/slick.js','','',true);
wp_enqueue_script('plugins-js', $directory_uri . '/js/plugins.js','','',true);
wp_enqueue_script('theme-js', $directory_uri . '/js/main.js','','',true);
wp_enqueue_script('global-js', $directory_uri . '/js/global.js','','',true);

if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
}

if( is_front_page() ) {
    wp_enqueue_script('front-js', $directory_uri . '/js/front.js','','',true);
}

if( is_home() ) {
    wp_enqueue_script('home-js', $directory_uri . '/js/home.js','','',true);
}