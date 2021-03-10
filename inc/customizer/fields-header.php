<?php
if(class_exists( 'Kirki' )){

    Kirki::add_panel( 'header', array(
        'priority'    => 10,
        'title'       => __( 'Header', 'bootstrap4' ),
        'description' => __( 'customize header panels', 'bootstrap4' ),
    ) );

    Kirki::add_section( 'header_background', array(
        'title'          => __( 'Background', 'bootstrap4' ),
        'description'    => __( 'Setup your logo', 'bootstrap4' ),
        'panel'          => 'header',
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
    ) );

        Kirki::add_field( 'bootstrap4_config', [
            'type'        => 'color',
            'settings'    => 'header_background_field_setting',
            'label'       => __( 'Background Color', 'bootstrap4' ),
            'description' => esc_html__( 'This is a color control - without alpha channel.', 'bootstrap4' ),
            'section'     => 'header_background',
            'default'     => '',
        ] );

    Kirki::add_section( 'header_Logo', array(
        'title'          => __( 'Logo', 'bootstrap4' ),
        'description'    => __( 'Setup your logo', 'bootstrap4' ),
        'panel'          => 'header',
        'priority'       => 20,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
    ) );

        Kirki::add_field( 'bootstrap4_config', [
            'type'        => 'color',
            'settings'    => 'header_logoColorTitle_field_setting',
            'label'       => __( 'Logo Title Color', 'bootstrap4' ),
            'description' => esc_html__( 'This is a color control - without alpha channel.', 'bootstrap4' ),
            'section'     => 'header_Logo',
            'default'     => '',
        ] );

        Kirki::add_field( 'bootstrap4_config', [
            'type'        => 'color',
            'settings'    => 'header_logoColorSubTitle_field_setting',
            'label'       => __( 'Logo Subtitle Color', 'bootstrap4' ),
            'description' => esc_html__( 'This is a color control - without alpha channel.', 'bootstrap4' ),
            'section'     => 'header_Logo',
            'default'     => '',
        ] );
    
    Kirki::add_section( 'header_contact', array(
        'title'          => __( 'Contact', 'bootstrap4' ),
        'description'    => __( 'Header Contact Details.', 'bootstrap4' ),
        'panel'          => 'header',
        'priority'       => 30,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
    ) );

        Kirki::add_field( 'bootstrap4_config', [
            'type'        => 'text',
            'settings'    => 'header_contactText_field_setting',
            'label'       => __( 'Add Contact Number', 'bootstrap4' ),
            'section'     => 'header_contact',
            'default'     => '',
        ] );

        Kirki::add_field( 'bootstrap4_config', [
            'type'        => 'color',
            'settings'    => 'header_contactColor_field_setting',
            'label'       => __( 'Contact Text Color', 'bootstrap4' ),
            'description' => esc_html__( 'This is a color control - without alpha channel.', 'bootstrap4' ),
            'section'     => 'header_contact',
            'default'     => '',
        ] );

    Kirki::add_section( 'header_social_media', array(
        'title'          => __( 'Social Media', 'bootstrap4' ),
        'description'    => __( 'You can add social media links by pressing the "Add Social Media"', 'bootstrap4' ),
        'panel'          => 'header',
        'priority'       => 40,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
    ) );

        Kirki::add_field( 'bootstrap4_config', [
            'type'          => 'repeater',
            'section'       => 'header_social_media',
            'priority'      => 10,
            'row_label'     => [
                'type'      => 'text',
                'value'     => esc_html__( 'Social Media', 'bootstrap4' ),
            ],
            'button_label'  => esc_html__('+ Add Social Media', 'bootstrap4' ),
            'default'       => '',
            'settings'      => 'header_social_media_repeater',
            'fields' => [
                'header_social_media_select' => array(
                    'type'		=> 'select',
                    'default'   => 'fb',
                    'choices' 	=> array(
                        'fb'		=> 'Facebook',
                        'instagram' => 'Instagram',
                        'twitter'	=> 'Twitter',
                        'pinterest' => 'Pinterest',
                        'linkedin'  => 'Linkedin',
                    ),
                ),
                'header_social_media_link' => array(
                    'type'		=> 'text',
                    'label'       => __( 'Link', 'bootstrap4' ),
                    'default'     => '',
                ),
            ],
            'choices' => [
                'limit' => 5,
            ],
        ] );

}