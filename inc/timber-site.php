<?php
/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class Bootstrap4Site extends Timber\Site {
    /** Add timber support. */
	public function __construct() {
        
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );

        add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'register_enqueue' ) );
        add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );

		parent::__construct();
    }

    /**
     * Enqueue stylesheet and script.
     * Using async on style. Just put this #asyncstyle at the end of src. (Ex. https://example.com/embed.css#asyncstyle)
     * In enqueue style with async. This should be the output: wp_enqueue_style( 'myexternal-css', 'https://example.com/embed.css#asyncstyle', array(), '', 'print' );
     * Using async on script. Just put this #asyncsript at the end of src. (Ex. https://example.com/embed.js#asyncscript)
     */
    public function register_enqueue() {
        include get_template_directory() . '/inc/enqueue.php';
    }
    /**
     * Register widget area.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function register_widget() {
        include get_template_directory() . '/inc/widget.php';
    }
    /** This is where you can register custom post types. */
	public function register_post_types() {
        include get_template_directory() . '/inc/custom-post-type.php';
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {
        include get_template_directory() . '/inc/custom-taxonomy.php';
    }
    
    /** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {

		// Adding a timberhelper
		$context['wp_title'] = Timber\Helper::get_wp_title('|', 'left');
		// $menu_id = get_term_by('slug', 'primary-menu', 'nav_menu')->term_id;
		$context['primary_menu']  = new Timber\Menu('primary-menu');
		$context['footer_menu']  = new Timber\Menu('footer-menu');

		// Other
		$context['site']  = $this;
        $context['site_logo'] = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
        $context['is_front_page'] = is_front_page();
        $context['is_page'] = is_page();
        $context['is_home'] = is_home();
        $context['is_single'] = is_single();
        $context['is_search'] = is_search();
		
		return $context;
	}
	
	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *  This is good to add your custom functions here
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );	

		// Adding a function. (1st param: This is the name that you will call on twig. 2nd param: Your function from php)
        $twig->addFunction( new Timber\Twig_Function( 'custom_widget_search', 'get_widget_search' ) );
        $twig->addFunction( new Timber\Twig_Function( 'custom_widget_category', 'get_widget_category' ) );
        $twig->addFunction( new Timber\Twig_Function( 'custom_widget_archive', 'get_widget_archive' ) );
        $twig->addFunction( new Timber\Twig_Function( 'breadcrumb', 'get_breadcrumb' ) );
    
		// Adding functions as filters.
		// $twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}
    
    public function theme_supports() {
        /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on Bootstrap 4 Theme, use a find and replace
        * to change 'bootstrap4' to the name of your theme in all the template files.
        */
        load_theme_textdomain( 'bootstrap4', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Header Logo
        add_theme_support( 'custom-logo', array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array( 'site-title', 'site-description'),
        ));

        /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        add_theme_support( 'post-thumbnails');

        /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
        add_theme_support( 'html5', array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        /*
        * All Custom thumbnails
        */
        add_image_size( 'banner-scale', 1920, 1080, true ); // scale
        add_image_size( 'banner-scale-crop', 1920, 1080, array( 'center', 'center' ) ); // scale & crop
        add_image_size( 'thumbnail-10-10', 10, 10, array( 'center', 'center' ) );

        /*
        * Register Navigation Menu
        */
        register_nav_menus( array(
			'primary-menu' => __( 'Primary Menu', 'bootstrap4' ),
			'footer-menu' => __( 'Footer Menu', 'bootstrap4' ),
        ) );
    }
}
new Bootstrap4Site();