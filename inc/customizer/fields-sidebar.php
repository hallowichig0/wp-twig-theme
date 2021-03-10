<?php

if(class_exists( 'Kirki' )){
    Kirki::add_panel( 'sidebar_blog', array(
        'priority'    => 20,
        'title'       => __( 'Sidebar for Blog', 'bootstrap4' ),
        'description' => __( 'customize sidebar panels', 'bootstrap4' ),
    ) );

    Kirki::add_section( 'sidebar_blog_toggle', array(
        'title'          => __( 'Enable or Disable Sidebar', 'bootstrap4' ),
        'description'    => __( 'This feature can enable/disable the sidebar', 'bootstrap4' ),
        'panel'          => 'sidebar_blog',
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
    ) );

        Kirki::add_field( 'bootstrap4_config', [
            'type'        => 'toggle',
            'settings'    => 'sidebar_blog_toggleSwitch_setting',
            'label'       => esc_html__( 'Enable/Disable', 'bootstrap4' ),
            'section'     => 'sidebar_blog_toggle',
            'default'     => false,
            'priority'    => 10,
        ] );
    
    /**
     * Sidebar Widgets
     */
    include_once wp_normalize_path( get_template_directory() . '/inc/customizer/sidebar-widgets.php' );
    
}