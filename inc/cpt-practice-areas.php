<?php

if (! defined('ABSPATH')) {
    exit;
}

function lawfirmpro_register_practice_area_cpt()
{

    $labels = array(
        'name'          => __('Practice Areas', 'lawfirmpro'),
        'singular_name' => __('Practice Area', 'lawfirmpro'),
        'add_new_item'  => __('Add Practice Area', 'lawfirmpro'),
        'edit_item'     => __('Edit Practice Area', 'lawfirmpro'),
        'menu_name'     => __('Practice Areas', 'lawfirmpro'),
    );

    register_post_type(
        'practice-area',
        array(
            'labels'       => $labels,
            'public'       => true,
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-portfolio',
            'supports'     => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
            ),
            'has_archive'  => true,
            'rewrite'      => array(
                'slug' => 'practice-areas',
            ),
        )
    );
}

add_action(
    'init',
    'lawfirmpro_register_practice_area_cpt'
);
