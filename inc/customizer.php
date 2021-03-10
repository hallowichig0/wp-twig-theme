<?php
/**
 * Customizer.
 *
 * @package Bootstrap4
 */
if(class_exists( 'Kirki' )){

    Kirki::add_config( 'bootstrap4_config', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod',
    ) );
    
    /**
     * Include files for panels, section & fields.
     */
    include_once wp_normalize_path( get_template_directory() . '/inc/customizer/fields-header.php' );
    include_once wp_normalize_path( get_template_directory() . '/inc/customizer/fields-footer.php' );
    include_once wp_normalize_path( get_template_directory() . '/inc/customizer/fields-sidebar.php' );

}