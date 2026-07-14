<?php
if (! defined('ABSPATH')) {
    exit;
}

// 1. Register Post Type and Custom Fields to the REST API
function lawfirmpro_register_testimonials_cpt()
{
    $labels = array(
        'name'          => __('Testimonials', 'lawfirmpro'),
        'singular_name' => __('Testimonial', 'lawfirmpro'),
        'add_new_item'  => __('Add Testimonial', 'lawfirmpro'),
        'edit_item'     => __('Edit Testimonial', 'lawfirmpro'),
        'menu_name'     => __('Testimonials', 'lawfirmpro'),
    );

    register_post_type('testimonial', array(
        'labels'       => $labels,
        'public'       => true,
        'show_in_rest' => true, // Allows Gutenberg usage
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'), // Added custom-fields support
        'has_archive'  => true,
        'rewrite'      => array('slug' => 'testimonials'),
    ));

    // Register Location field to REST API
    register_post_meta('testimonial', '_testimonial_location', array(
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'string',
        'default'      => '',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        },
    ));

    register_post_meta('testimonial', '_testimonial_rating', array(
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'number',
        'default'      => 5,
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        },
    ));
}
add_action('init', 'lawfirmpro_register_testimonials_cpt');

// 2. Add Meta Box container for backend entry
function lawfirmpro_add_testimonial_fields_metabox()
{
    add_meta_box(
        'lawfirmpro_testimonial_details',
        __('Testimonial Details', 'lawfirmpro'),
        'lawfirmpro_render_testimonial_fields',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'lawfirmpro_add_testimonial_fields_metabox');

function lawfirmpro_render_testimonial_fields($post)
{
    $location = get_post_meta($post->ID, '_testimonial_location', true);
    $rating   = get_post_meta($post->ID, '_testimonial_rating', true);
    wp_nonce_field('lawfirmpro_save_testimonial_fields', 'lawfirmpro_fields_nonce');
?>
    <p>
        <label for="testimonial_location" style="display:block; margin-bottom:5px; font-weight:bold;"><?php _e('Client Location:', 'lawfirmpro'); ?></label>
        <input type="text" id="testimonial_location" name="testimonial_location" value="<?php echo esc_attr($location); ?>" style="width:100%; max-width:400px; padding:8px;" placeholder="e.g. USA" />
    </p>
    <p>
        <label for="testimonial_rating" style="display:block; margin-bottom:5px; font-weight:bold;"><?php _e('Star Rating (Type 1 to 5):', 'lawfirmpro'); ?></label>
        <input type="number" id="testimonial_rating" name="testimonial_rating" min="1" max="5" value="<?php echo esc_attr($rating); ?>" style="width:100%; max-width:400px; padding:8px;" placeholder="5" />
    </p>
<?php
}

function lawfirmpro_save_testimonial_fields_data($post_id)
{
    if (!isset($_POST['lawfirmpro_fields_nonce']) || !wp_verify_nonce($_POST['lawfirmpro_fields_nonce'], 'lawfirmpro_save_testimonial_fields')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['testimonial_location'])) {
        update_post_meta($post_id, '_testimonial_location', sanitize_text_field($_POST['testimonial_location']));
    }
    if (isset($_POST['testimonial_rating'])) {
        update_post_meta($post_id, '_testimonial_rating', sanitize_text_field($_POST['testimonial_rating']));
    }
}
add_action('save_post', 'lawfirmpro_save_testimonial_fields_data');

/**
 * Testimonial Meta Shortcode
 * Usage:
 * [testimonial_meta field="location"]
 * [testimonial_meta field="rating"]
 */
function lawfirmpro_testimonial_meta_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'field' => '',
        ),
        $atts,
        'testimonial_meta'
    );

    $post_id = get_the_ID();

    if (!$post_id) {
        return '';
    }

    if ($atts['field'] === 'location') {

        $location = get_post_meta(
            $post_id,
            '_testimonial_location',
            true
        );

        return !empty($location)
            ? '<p class="testimonial-location">' .
            esc_html($location) .
            '</p>'
            : '';
    }

    if ($atts['field'] === 'rating') {

        $rating = get_post_meta(
            $post_id,
            '_testimonial_rating',
            true
        );

        $rating = !empty($rating)
            ? intval($rating)
            : 5;

        return '<div class="testimonial-stars">' .
            str_repeat('<img src="' . esc_url(get_theme_file_uri('/assets/images/star.png')) . '" alt="star">', $rating) .
            '</div>';
    }

    return '';
}

add_shortcode(
    'testimonial_meta',
    'lawfirmpro_testimonial_meta_shortcode'
);

/**

 * Testimonial Meta Shortcode v2
 *
 * Usage:
 * [testimonial_meta_v2 field="location"]
 * [testimonial_meta_v2 field="rating"]
 */

function lawfirmpro_testimonial_meta_shortcode_v2($atts)
{
    $atts = shortcode_atts(
        array(
            'field' => '',
        ),
        $atts,
        'testimonial_meta_v2'
    );

    $post_id = get_the_ID();

    if (!$post_id) {
        return '';
    }

    if ($atts['field'] === 'location') {

        $location = get_post_meta(
            $post_id,
            '_testimonial_location',
            true
        );

        return !empty($location)
            ? '<p class="testimonial-location-v2">' .
            esc_html($location) .
            '</p>'
            : '';
    }

    if ($atts['field'] === 'rating') {

        $rating = get_post_meta(
            $post_id,
            '_testimonial_rating',
            true
        );

        $rating = !empty($rating)
            ? intval($rating)
            : 5;

        return '<div class="testimonial-stars-v2">' .
            str_repeat('<img src="' . esc_url(get_theme_file_uri('/assets/images/star.png')) . '" alt="star">', $rating) .
            '</div>';
    }

    return '';
}

add_shortcode(
    'testimonial_meta_v2',
    'lawfirmpro_testimonial_meta_shortcode_v2'
);
