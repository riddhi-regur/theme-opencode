<?php

function lawfirmpro_register_testimonial_location_block()
{
    register_block_type('lawfirmpro/testimonial-location', array(
        'render_callback' => function ($attributes, $content, $block) {
            $post_id = isset($block->context['postId']) ? $block->context['postId'] : get_the_ID();
            if (!$post_id) {
                return '';
            }

            $location = get_post_meta($post_id, '_testimonial_location', true);
            $class = !empty($attributes['className']) ? $attributes['className'] : 'testimonial-location';
            $text = !empty($location) ? esc_html($location) : '';

            return '<p class="' . esc_attr($class) . '">' . $text . '</p>';
        },
        'uses_context' => array('postId', 'postType'),
    ));
}
add_action('init', 'lawfirmpro_register_testimonial_location_block');

function lawfirmpro_register_testimonial_rating_block()
{
    register_block_type('lawfirmpro/testimonial-rating', array(
        'render_callback' => function ($attributes, $content, $block) {
            $post_id = isset($block->context['postId']) ? $block->context['postId'] : get_the_ID();
            if (!$post_id) {
                return '';
            }

            $rating = get_post_meta($post_id, '_testimonial_rating', true);
            $rating = !empty($rating) ? intval($rating) : 5;
            $class = !empty($attributes['className']) ? $attributes['className'] : 'testimonial-stars';

            return '<div class="' . esc_attr($class) . '">' .
                str_repeat('<img src="' . esc_url(get_theme_file_uri('/assets/images/star.png')) . '" alt="star">', $rating) .
                '</div>';
        },
        'uses_context' => array('postId', 'postType'),
    ));
}
add_action('init', 'lawfirmpro_register_testimonial_rating_block');

function lawfirmpro_register_post_navigation_block()
{
    register_block_type('lawfirmpro/post-navigation', array(
        'render_callback' => function ($attributes, $content, $block) {
            $prev_post = get_previous_post();
            $next_post = get_next_post();

            if (!$prev_post && !$next_post) {
                return '';
            }

            $left = '';
            if ($prev_post) {
                $arrow = esc_url(get_theme_file_uri('/assets/images/arrow-alt-circle-left.png'));
                $title = esc_html(get_the_title($prev_post));
                $link = esc_url(get_permalink($prev_post));
                $left = '<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);gap:var(--wp--preset--spacing--0);display:flex;flex-direction:column">'
                    . '<div class="wp-block-group" style="gap:4px;display:flex;flex-wrap:nowrap">'
                    . '<figure class="wp-block-image size-full" style="align-self:stretch;width:14px;margin-top:5px;margin-bottom:0px;"><img src="' . $arrow . '" alt="" class="wp-image-1032"/></figure>'
                    . '<p class="has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family" style="font-size:14px">Previous Article</p>'
                    . '</div>'
                    . '<a class="wp-block-post-navigation-link" href="' . $link . '" rel="prev" style="font-size:18px;font-style:normal;font-weight:600">' . $title . '</a>'
                    . '</div>';
            }

            $right = '';
            if ($next_post) {
                $arrow = esc_url(get_theme_file_uri('/assets/images/arrow-alt-circle-right.png'));
                $title = esc_html(get_the_title($next_post));
                $link = esc_url(get_permalink($next_post));
                $right = '<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);gap:var(--wp--preset--spacing--0);display:flex;flex-direction:column;align-items:flex-end">'
                    . '<div class="wp-block-group" style="gap:4px;display:flex;flex-wrap:nowrap;justify-content:flex-end">'
                    . '<p class="has-text-align-right has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family" style="font-size:14px">Next Article</p>'
                    . '<figure class="wp-block-image size-full" style="align-self:stretch;width:14px;margin-top:5px;margin-bottom:0px;"><img src="' . $arrow . '" alt="" class="wp-image-1040"/></figure>'
                    . '</div>'
                    . '<a class="wp-block-post-navigation-link" href="' . $link . '" rel="next" style="font-size:18px;font-style:normal;font-weight:600">' . $title . '</a>'
                    . '</div>';
            }

            $justify = 'space-between';
            if ($prev_post && !$next_post) {
                $justify = 'flex-start';
            } elseif (!$prev_post && $next_post) {
                $justify = 'flex-end';
            }

            return '<div class="wp-block-group alignwide" style="display:flex;flex-wrap:nowrap;justify-content:' . $justify . '">'
                . $left . $right
                . '</div>';
        },
    ));
}
add_action('init', 'lawfirmpro_register_post_navigation_block');
