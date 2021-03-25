<?php
/**
 * All theme setup
 *
 *
 * @package Bootstrap4
 */

/**
 * Default Favicon
 */
function favicon_default() {
    if( ! has_site_icon()  && ! is_customize_preview() ) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_template_directory_uri().'/images/w-logo-blue.png" />';
    }
}
add_action('wp_head', 'favicon_default');

/**
 * pre_get_posts function added to include custom post type in author loop
 */
function add_cpt_in_author( $query ) {
    if ( !is_admin() && $query->is_author() && $query->is_main_query() ) {
        $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
    }
}
add_action( 'pre_get_posts', 'add_cpt_in_author' ); 

/**
 * Uncomment this if woocommerce was not templated
 */
function add_cpt_in_archive( $query ) {
    if ( class_exists( 'WooCommerce' ) ) {
        if ( !is_admin() && $query->is_archive() && $query->is_main_query() && !is_post_type_archive( 'product' ) ) {
            $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
        }
    }else {
        if ( !is_admin() && $query->is_archive() && $query->is_main_query() ) {
            $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
        }
    }
}
add_action( 'pre_get_posts', 'add_cpt_in_archive' );

/**
 * Uncomment this if woocommerce was templated
 * pre_get_posts function added to include custom post type in archive loop
 */
// function add_cpt_in_archive( $query ) {
//     if ( class_exists( 'WooCommerce' ) ) {
//         $prod_cat = '';
//         if(!empty($query->query_vars['product_cat'])){
//             $prod_cat = $query->query_vars['product_cat'];
//         }
//         if ( !is_admin() && $query->is_archive() && $query->is_main_query() && !is_shop() && !$prod_cat) {
//             $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
//         }
//     }else {
//         if ( !is_admin() && $query->is_archive() && $query->is_main_query()) {
//             $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
//         }
//     }
// }
// add_action( 'pre_get_posts', 'add_cpt_in_archive' );

/**
 * woocommerce theme setup
 */
function setup_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action( 'after_setup_theme', 'setup_woocommerce_support' );

/**
 * Remove margin-top: 32px in html when login
 */
function remove_margin_in_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_margin_in_admin_login_header');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function bootstrap4_pingback_header() {
	echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
}
add_action( 'wp_head', 'bootstrap4_pingback_header' );

/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
function duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}

	/*
	 * Nonce verification
	 */
	if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
		return;

	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );

	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {

		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => 'Duplicate ' . $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );

		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}

		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}

		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_duplicate_post_as_draft', 'duplicate_post_as_draft' );

/*
 * Add the duplicate link to action list for post_row_actions
 */
function duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}
	return $actions;
}
add_filter( 'post_row_actions', 'duplicate_post_link', 10, 2 );
add_filter('page_row_actions', 'duplicate_post_link', 10, 2);

/**
 * Add what template file name used
 * This will be show after <body> tag
 */
add_action('wp_body_open', 'show_template');
function show_template() {
    global $template;
    if( current_user_can('administrator') ) {
        echo '<!-- Template File: ' . basename($template) . ' -->';
    }
}

/**
 * Disable Emoji Filters
 */
function disable_emoji_feature() {
	
	// Prevent Emoji from loading on the front-end
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Remove from admin area also
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// Remove from RSS feeds also
	remove_filter( 'the_content_feed', 'wp_staticize_emoji');
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji');

	// Remove from Embeds
	remove_filter( 'embed_head', 'print_emoji_detection_script' );

	// Remove from emails
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// Disable from TinyMCE editor. Currently disabled in block editor by default
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );

	/** Finally, prevent character conversion too
         ** without this, emojis still work 
         ** if it is available on the user's device
	 */

	add_filter( 'option_use_smilies', '__return_false' );
}

/**
 * Disable Emoji Action
 */
function disable_emojis_tinymce( $plugins ) {
	if( is_array($plugins) ) {
		$plugins = array_diff( $plugins, array( 'wpemoji' ) );
	}
	return $plugins;
}
add_action('init', 'disable_emoji_feature');

/**
 * Show menu pages on specific roles
 */
function remove_menu_pages() {
    if( !current_user_can('administrator') ) {
        // remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('wpcf7'); // Contact Form 7 Menu
    }
}
add_action( 'admin_init', 'remove_menu_pages' );

/**
 * Hide submenu on appearance menu
 */
function hide_appearance_submenu() {
    // check condition for the user means show menu for this user
    if( !current_user_can('administrator') ) {
        //We need this because the submenu's link (key from the array too) will always be generated with the current SERVER_URI in mind.
        $customizer_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), 'customize.php' );
        $themes = 'themes.php';
        $widget = 'widgets.php';
        $menu = 'nav-menus.php';

        // remove_submenu_page( 'themes.php', $customizer_url ); // remove customize from appearance menu
        remove_submenu_page( 'themes.php', $themes ); // remove themes from appearance menu
        remove_submenu_page( 'themes.php', $widget ); // remove widgets from appearance menu
        remove_submenu_page( 'themes.php', $menu );// remove menus from appearance menu
    }
}
add_action('admin_head', 'hide_appearance_submenu', 999);

/**
 * Unset section in customizer panel.
 * Take Note: Only section is working. To unset the panel, please use customize_loaded_components hook instead.
 * You can use remove_panel for kirki panels only
 */
function remove_customize_register( $wp_customize ) {
    // check condition for the user means show menu for this user
    if( !current_user_can('administrator') ) {

        // Wordpress Core Section
        $wp_customize->remove_section( 'title_tagline');
        $wp_customize->remove_section( 'static_front_page');
        $wp_customize->remove_section( 'custom_css');

        // Kirki Panel
        $wp_customize->remove_panel( 'sidebar_blog');

        // Kirki Section
        $wp_customize->remove_section( 'header_Logo');
        $wp_customize->remove_section( 'header_background');
        $wp_customize->remove_section( 'footer_background');

        // Kirki Control
        // $wp_customize->remove_control( 'your_settings');
    }
}
add_action( 'customize_register', 'remove_customize_register', 100 );

/**
 * Disable Comments Menu
 */
function remove_comment() {
    global $post_type;
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
// add_action( 'admin_init', 'remove_comment' );

/**
 * Disable Comments Admin Bar
 */
function remove_comment_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
// add_action( 'wp_before_admin_bar_render', 'remove_comment_admin_bar' );
