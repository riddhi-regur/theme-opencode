<?php

function lawfirmpro_enqueue_assets()
{
    wp_enqueue_style(
        'lawfirmpro-global',
        get_template_directory_uri() . '/assets/css/global.css',
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-header',
        get_template_directory_uri() . '/assets/css/header.css',
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-homepage-hero',
        get_template_directory_uri() . '/assets/css/homepage.css',
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-practice-areas',
        get_template_directory_uri() . '/assets/css/practice-area.css',
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-menu-overlay',
        get_template_directory_uri() . '/assets/css/menu-overlay.css',
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-faq',
        get_template_directory_uri() . '/assets/css/faq.css',
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-comments',
        get_template_directory_uri() . '/assets/css/comments.css',
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-testimonial',
        get_template_directory_uri() . '/assets/css/testimonial.css',
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-post-slider',
        get_theme_file_uri('/assets/css/post-slider.css'),
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-attorneys',
        get_theme_file_uri('/assets/css/attorneys.css'),
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-blogs',
        get_theme_file_uri('/assets/css/blogs.css'),
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_style(
        'lawfirmpro-contact',
        get_theme_file_uri('/assets/css/contact.css'),
        array(),
        LAWFIRMPRO_VERSION
    );

    wp_enqueue_script(
        'lawfirmpro-faq',
        get_theme_file_uri('/assets/js/faq.js'),
        [],
        LAWFIRMPRO_VERSION,
        true
    );

    wp_localize_script(
        'lawfirmpro-faq',
        'lawfirmpro',
        array(
            'assetsUrl' => get_theme_file_uri('/assets/'),
        )
    );

    wp_enqueue_script(
        'lawfirmpro-post-slider',
        get_theme_file_uri('/assets/js/post-slider.js'),
        [],
        LAWFIRMPRO_VERSION,
        true
    );

    wp_enqueue_script(
        'lawfirmpro-button-link',
        get_theme_file_uri('/assets/js/button-link.js'),
        [],
        LAWFIRMPRO_VERSION,
        true
    );

    wp_enqueue_script(
        'lawfirmpro-testimonial',
        get_theme_file_uri('/assets/js/testimonial-slider.js'),
        [],
        LAWFIRMPRO_VERSION,
        true
    );
}

add_action('wp_enqueue_scripts', 'lawfirmpro_enqueue_assets');
