<?php

acf_add_local_field_group(array(
    'key'   => 'frontpage',
    'title' => 'Paragraph',
    'fields'    => array (),
    'position'  => 'acf_after_title',
    'menu_order'    => 0,
    'label_placement'   => 'top',
    'style' => 'default',
    'active'    => true,
	'description'   => '',
    'location'  => array (
        array (
            array (
                'param' => 'page_type',
                'operator'  => '==',
                'value' => 'front_page',
            ),
        ),
    ),
));

    // section 1
    acf_add_local_field(array(
        'key'   => 'frontpage_accordion_section1_key',
        'label' => 'Section 1',
        'name'  => 'frontpage_accordion_section1',
        'type'  => 'accordion',
        'parent'    => 'frontpage',
        'instructions'  => '',
        'required'  => 0,
        'conditional_logic' => 0,
        'wrapper'   => array(
            'width' => '',
            'class' => '',
            'id'    => '',
        ),
        'open'  => 0,
        'multi_expand'  => 0,
        'endpoint'  => 0,
    ));
    // section title field
    acf_add_local_field(array(
        'key'   => 'frontpage_section1_title_field_key',
        'label' => 'Section Title',
        'name'  => 'frontpage_section1_title_field',
        'type'  => 'text',
        'required'  => 1,
        'parent'    => 'frontpage',
    ));