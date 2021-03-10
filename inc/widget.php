<?php

register_sidebar( array(
    'name'          => esc_html__( 'Sidebar for blog', 'bootstrap4' ),
    'id'            => 'sidebar-blog',
    'description'   => esc_html__( 'Add widgets here.', 'bootstrap4' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
) );