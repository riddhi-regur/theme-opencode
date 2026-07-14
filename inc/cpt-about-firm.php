<?php

if (! defined('ABSPATH')) {
    exit;
}

function lawfirmpro_register_about_firm_cpt()
{

    $labels = array(
        'name'          => __('About Firms', 'lawfirmpro'),
        'singular_name' => __('About Firm', 'lawfirmpro'),
        'add_new_item'  => __('Add About Firm', 'lawfirmpro'),
        'edit_item'     => __('Edit About Firm', 'lawfirmpro'),
        'menu_name'     => __('About Firms', 'lawfirmpro'),
    );

    register_post_type(
        'about_firm',
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
                'slug' => 'about-firms',
            ),
        )
    );
}

add_action(
    'init',
    'lawfirmpro_register_about_firm_cpt'
);
