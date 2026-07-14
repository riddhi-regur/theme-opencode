<?php

if (! defined('ABSPATH')) {
    exit;
}

function lawfirmpro_register_articles_cpt()
{

    $labels = array(
        'name'          => __('Articles', 'lawfirmpro'),
        'singular_name' => __('Article', 'lawfirmpro'),
        'add_new_item'  => __('Add Article', 'lawfirmpro'),
        'edit_item'     => __('Edit Article', 'lawfirmpro'),
        'menu_name'     => __('Articles', 'lawfirmpro'),
    );

    register_post_type(
        'article',
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
                'comments'
            ),
            'has_archive'  => true,
            'rewrite'      => array(
                'slug' => 'articles',
            ),
        )
    );
}

add_action(
    'init',
    'lawfirmpro_register_articles_cpt'
);
/**
 * Force comments enabled for articles CPT
 */
function lawfirmpro_enable_article_comments($open, $post_id)
{
    $post = get_post($post_id);

    if ($post && $post->post_type === 'article') {
        return true;
    }

    return $open;
}

add_filter(
    'comments_open',
    'lawfirmpro_enable_article_comments',
    10,
    2
);
