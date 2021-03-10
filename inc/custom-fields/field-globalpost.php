<?php

acf_add_local_field_group(array(
    'key'   => 'global_post',
    'title' => 'Feature',
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
                'param' => 'post_type',
                'operator'  => '==',
                'value' => 'post',
            ),
        ),
    ),
));

    // post thumbnail field
    acf_add_local_field(array(
        'key'   =>  'post_thumbnail_field_key',
        'label' =>  'Thumbnail',
        'name'  =>  'post_thumbnail_field',
        'type'  =>  'image',
        'required'  => 1,
        'parent'    =>  'global_post',
    ));