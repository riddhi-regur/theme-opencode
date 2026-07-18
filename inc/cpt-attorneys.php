<?php

if (! defined('ABSPATH')) {
    exit;
}

function lawfirmpro_register_attorneys_cpt()
{

    $labels = array(
        'name'          => __('Attorneys', 'lawfirmpro'),
        'singular_name' => __('Attorney', 'lawfirmpro'),
        'add_new_item'  => __('Add Attorney', 'lawfirmpro'),
        'edit_item'     => __('Edit Attorney', 'lawfirmpro'),
        'menu_name'     => __('Attorneys', 'lawfirmpro'),
    );

    register_post_type(
        'attorney',
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
                'slug' => 'attorneys',
            ),
        )
    );
}

add_action(
    'init',
    'lawfirmpro_register_attorneys_cpt'
);

/**
 * Attorney Meta Boxes
 */
function lawfirmpro_add_attorney_meta_boxes()
{
    add_meta_box(
        'attorney_career_education',
        __('Career & Education Timeline', 'lawfirmpro'),
        'lawfirmpro_attorney_career_education_cb',
        'attorney',
        'normal',
        'high'
    );
    add_meta_box(
        'attorney_social',
        __('Social Media Links', 'lawfirmpro'),
        'lawfirmpro_attorney_social_cb',
        'attorney',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'lawfirmpro_add_attorney_meta_boxes');

function lawfirmpro_attorney_career_education_cb($post)
{
    wp_nonce_field('lawfirmpro_attorney_meta', 'lawfirmpro_attorney_meta_nonce');

    $education_date = get_post_meta($post->ID, '_attorney_education_date', true);
    $career_date = get_post_meta($post->ID, '_attorney_career_date', true);

    echo '<table class="form-table">';
    echo '<tr><th>Education Period</th><td><input type="text" name="_attorney_education_date" value="' . esc_attr($education_date) . '" class="regular-text" placeholder="e.g. 1991-2012"></td></tr>';

    for ($i = 0; $i < 3; $i++) {
        $title = get_post_meta($post->ID, '_attorney_education_' . $i . '_title', true);
        echo '<tr><th>Education Entry ' . ($i + 1) . '</th><td><input type="text" name="_attorney_education_' . $i . '_title" value="' . esc_attr($title) . '" class="regular-text" placeholder="e.g. University Name, Degree"></td></tr>';
    }

    echo '<tr><th>Career Period</th><td><input type="text" name="_attorney_career_date" value="' . esc_attr($career_date) . '" class="regular-text" placeholder="e.g. 2013-2020"></td></tr>';

    for ($i = 0; $i < 3; $i++) {
        $title = get_post_meta($post->ID, '_attorney_career_' . $i . '_title', true);
        echo '<tr><th>Career Entry ' . ($i + 1) . '</th><td><input type="text" name="_attorney_career_' . $i . '_title" value="' . esc_attr($title) . '" class="regular-text" placeholder="e.g. Company Name, Role"></td></tr>';
    }

    echo '</table>';
}

function lawfirmpro_attorney_social_cb($post)
{
    wp_nonce_field('lawfirmpro_attorney_meta', 'lawfirmpro_attorney_meta_nonce');

    $facebook  = get_post_meta($post->ID, '_attorney_facebook', true);
    $twitter   = get_post_meta($post->ID, '_attorney_twitter', true);
    $linkedin  = get_post_meta($post->ID, '_attorney_linkedin', true);

    echo '<table class="form-table">';
    echo '<tr><th>Facebook URL</th><td><input type="url" name="_attorney_facebook" value="' . esc_attr($facebook) . '" class="regular-text" placeholder="https://facebook.com/..."></td></tr>';
    echo '<tr><th>Twitter/X URL</th><td><input type="url" name="_attorney_twitter" value="' . esc_attr($twitter) . '" class="regular-text" placeholder="https://twitter.com/..."></td></tr>';
    echo '<tr><th>LinkedIn URL</th><td><input type="url" name="_attorney_linkedin" value="' . esc_attr($linkedin) . '" class="regular-text" placeholder="https://linkedin.com/..."></td></tr>';
    echo '</table>';
}

function lawfirmpro_save_attorney_meta($post_id)
{
    if (!isset($_POST['lawfirmpro_attorney_meta_nonce']) || !wp_verify_nonce($_POST['lawfirmpro_attorney_meta_nonce'], 'lawfirmpro_attorney_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = ['_attorney_education_date', '_attorney_career_date', '_attorney_facebook', '_attorney_twitter', '_attorney_linkedin'];
    for ($i = 0; $i < 3; $i++) {
        $fields[] = '_attorney_education_' . $i . '_title';
        $fields[] = '_attorney_career_' . $i . '_title';
    }

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_attorney', 'lawfirmpro_save_attorney_meta');

/**
 * Attorney Social Links Shortcode
 * [attorney_social_links]
 */
function lawfirmpro_attorney_social_links_shortcode()
{
    $post_id = get_the_ID();
    if (!$post_id || get_post_type($post_id) !== 'attorney') {
        return '';
    }

    $facebook = get_post_meta($post_id, '_attorney_facebook', true);
    $twitter  = get_post_meta($post_id, '_attorney_twitter', true);
    $linkedin = get_post_meta($post_id, '_attorney_linkedin', true);

    $output = '<ul class="wp-block-social-links has-normal-icon-size has-icon-color is-style-logos-only">';
    if (!empty($facebook)) {
        $output .= '<li class="wp-social-link wp-social-link-facebook"><a href="' . esc_url($facebook) . '" target="_blank" rel="noopener">Facebook</a></li>';
    }
    if (!empty($twitter)) {
        $output .= '<li class="wp-social-link wp-social-link-twitter"><a href="' . esc_url($twitter) . '" target="_blank" rel="noopener">Twitter</a></li>';
    }
    if (!empty($linkedin)) {
        $output .= '<li class="wp-social-link wp-social-link-linkedin"><a href="' . esc_url($linkedin) . '" target="_blank" rel="noopener">LinkedIn</a></li>';
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('attorney_social_links', 'lawfirmpro_attorney_social_links_shortcode');
