<?php

if(class_exists( 'Kirki' )){
    Kirki::add_panel( 'footer', array(
        'priority'    => 30,
        'title'       => __( 'Footer', 'bootstrap4' ),
        'description' => __( 'customize header panels', 'bootstrap4' ),
    ) );

    Kirki::add_section( 'footer_background', array(
        'title'          => __( 'Background Color', 'bootstrap4' ),
        'description'    => __( 'Customize footer background color', 'bootstrap4' ),
        'panel'          => 'footer',
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
    ) );
    
        Kirki::add_field( 'bootstrap4_config', [
            'type'        => 'color',
            'settings'    => 'footer_background_setting',
            'label'       => __( 'Color Control (hex-only)', 'bootstrap4' ),
            'description' => esc_html__( 'This is a color control - without alpha channel.', 'bootstrap4' ),
            'section'     => 'footer_background',
            'default'     => '',
        ] );

    Kirki::add_section( 'footer_copyright', array(
        'title'          => __( 'Copyright', 'bootstrap4' ),
        'panel'          => 'footer',
        'priority'       => 20,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
    ) );

        Kirki::add_field( 'bootstrap4_config', [
            'type'     => 'text',
            'settings' => 'footer_copyrightText_setting',
            'label'    => esc_html__( 'Copyright Text', 'bootstrap4' ),
            'section'  => 'footer_copyright',
            'default'  => esc_html__( 'Bootstrap 2019', 'bootstrap4' ),
            'priority' => 10,
        ] );

        Kirki::add_field( 'bootstrap4_config', [
            'type'        => 'color',
            'settings'    => 'footer_copyrightColor_setting',
            'label'       => __( 'Copyright Text Color', 'bootstrap4' ),
            'description' => esc_html__( 'This is a color control - without alpha channel.', 'bootstrap4' ),
            'section'     => 'footer_copyright',
            'default'     => '',
            'priority'    => 20,
        ] );
}