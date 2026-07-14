<?php

if (! defined('ABSPATH')) {
    exit;
}

function lawfirmpro_register_faqs_cpt()
{

    $labels = array(
        'name'          => __('FAQs', 'lawfirmpro'),
        'singular_name' => __('FAQ', 'lawfirmpro'),
        'add_new_item'  => __('Add FAQ', 'lawfirmpro'),
        'edit_item'     => __('Edit FAQ', 'lawfirmpro'),
        'menu_name'     => __('FAQs', 'lawfirmpro'),
    );

    register_post_type(
        'faq',
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
                'slug' => 'faqs',
            ),
        )
    );
}

add_action(
    'init',
    'lawfirmpro_register_faqs_cpt'
);
