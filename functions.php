<?php
/**
 * Bootstrap4 Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootstrap4
 */
$get_template_directory = get_template_directory();

/**
 * Add Welcome message to dashboard
 */
function bootstrap4_reminder(){
    $theme_page_url = 'http://jegson.herokuapp.com/';

    if(!get_option( 'triggered_welcomet')){
        $message = sprintf(__( 'Welcome to Bootstrap4 Theme made by Jayson Garcia! Before diving in to your new theme, please visit the <a style="color: #fff; font-weight: bold;" href="%1$s" target="_blank">theme\'s</a> page for access to dozens of tips and in-depth tutorials.', 'bootstrap4' ),
            esc_url( $theme_page_url )
        );

        printf(
            '<div class="notice is-dismissible" style="background-color: #6C2EB9; color: #fff; border-left: none;">
                <p>%1$s</p>
            </div>',
            $message
        );
        add_option( 'triggered_welcomet', '1', '', 'yes' );
    }
}
add_action( 'admin_notices', 'bootstrap4_reminder' );

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * Reusable error notice function for admin_head()
 */
function error_activation_admin_notice() {
    echo '<style>#message2{border-left-color:#dc3232;}</style>';
}

/**
 * Display a pop-up message when trying to activate this theme without activated timber, kirki & acf plugin
 */
function check_theme_dependencies( $oldtheme_name, $oldtheme ) {
    // if ( !class_exists( 'Timber' ) ) :
    //     add_filter( 'gettext', 'update_activation_admin_notice_timber', 10, 3 );
    //     add_action( 'admin_head', 'error_activation_admin_notice' );
    //     switch_theme( $oldtheme->stylesheet );
    //     return false;
    // endif;

    if ( !class_exists( 'Kirki' ) ) :
        add_filter( 'gettext', 'update_activation_admin_notice_kirki', 10, 3 );
        add_action( 'admin_head', 'error_activation_admin_notice' );
        switch_theme( $oldtheme->stylesheet );
        return false;
    endif;

    if ( !class_exists( 'ACF' ) ) :
        add_filter( 'gettext', 'update_activation_admin_notice_acf', 10, 3 );
        add_action( 'admin_head', 'error_activation_admin_notice' );
        switch_theme( $oldtheme->stylesheet );
        return false;
    endif;
}
add_action( 'after_switch_theme', 'check_theme_dependencies', 10, 2 );

/**
 * Timber validation text
 */
function update_activation_admin_notice_timber( $translated, $original, $domain ) {
    $strings = array(
        'New theme activated.' => 'Theme not activated. Bootstrap4 Theme has dependency with timber plugin. You must activate <a target="_blank" href="https://wordpress.org/plugins/timber-library/">kirki plugin</a> first before activating this theme.'
    );

    if ( isset( $strings[$original] ) ) {
        $translations = get_translations_for_domain( $domain );
        $translated = $translations->translate( $strings[$original] );
    }

    return $translated;
}

/**
 * Kirki validation text
 */
function update_activation_admin_notice_kirki( $translated, $original, $domain ) {
    $strings = array(
        'New theme activated.' => 'Theme not activated. Bootstrap4 Theme has dependency with kirki plugin. You must activate <a target="_blank" href="https://wordpress.org/plugins/kirki/">kirki plugin</a> first before activating this theme.'
    );

    if ( isset( $strings[$original] ) ) {
        $translations = get_translations_for_domain( $domain );
        $translated = $translations->translate( $strings[$original] );
    }

    return $translated;
}

/**
 * ACF validation text
 */
function update_activation_admin_notice_acf( $translated, $original, $domain ) {
    $strings = array(
        'New theme activated.' => 'Theme not activated. Bootstrap4 Theme has dependency with ACF plugin. You must activate <a target="_blank" href="https://wordpress.org/plugins/advanced-custom-fields/">ACF plugin</a> first before activating this theme.'
    );

    if ( isset( $strings[$original] ) ) {
        $translations = get_translations_for_domain( $domain );
        $translated = $translations->translate( $strings[$original] );
    }

    return $translated;
}

function theme_prefix_the_custom_logo() {
	
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}

/**
 * Timber Site.
 */
require_once ($get_template_directory . '/inc/timber-site.php');

/**
 * Theme Filter.
 */
require_once ($get_template_directory . '/inc/theme-filter.php');
/**
 * Theme Action.
 */
require_once ($get_template_directory . '/inc/theme-action.php');

/**
 * Customizer additions.
 */
require_once ($get_template_directory . '/inc/customizer.php');

/**
 * Custom field.
 */
require_once ($get_template_directory . '/inc/custom-field.php');

/**
 * Custom Function.
 */
require_once ($get_template_directory . '/inc/custom-function.php');

/**
 * All ajax handler.
 */
require_once ($get_template_directory . '/inc/ajax-handler.php');

include_once get_theme_file_path( 'inc/kirki/class-kirki-installer-section.php' );
