<?php

if(class_exists( 'Kirki' )){
    Kirki::add_section( 'sidebar_blog_widgets', array(
        'title'          => __( 'Widgets', 'bootstrap4' ),
        'description'    => __( 'These widgets will not visible if the sidebar toggle was disabled.', 'bootstrap4' ),
        'panel'          => 'sidebar_blog',
        'priority'       => 20,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
    ) );

    Kirki::add_field( 'bootstrap4_config', [
        'type'          => 'repeater',
        'section'       => 'sidebar_blog_widgets',
        'priority'      => 10,
        'row_label'     => [
            'type'      => 'text',
            'value'     => esc_html__( 'Widget', 'bootstrap4' ),
        ],
        'button_label'  => esc_html__('+ Add Widgets', 'bootstrap4' ),
        'settings'      => 'sidebar_blog_widget_repeater',
        'fields' => [
            'sidebar_blog_select_widget' => array(
                'type'		=> 'select',
                'choices' 	=> array(
                    ''				=> 'Please select a widget',
                    'search'		=> 'Search',
                    'category'		=> 'Category',
                    'archive'       => 'Archive',
                ),
            ),
        ],
    ] );
}