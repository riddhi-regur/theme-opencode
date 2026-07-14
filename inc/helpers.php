<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get theme mod value with a fallback default
 *
 * @param string $key     The option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function lawfirmpro_get_mod($key = '', $default = '')
{
    return get_theme_mod('lawfirmpro_' . $key, $default);
}

/**
 * Check if the current page is the front page
 *
 * @return bool
 */
function lawfirmpro_is_front_page()
{
    return is_front_page();
}

/**
 * Get the reading time for a post
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function lawfirmpro_reading_time($post_id = null)
{
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $minutes = ceil($word_count / 250);

    return $minutes . ' min read';
}

/**
 * Trim text to a specified length
 *
 * @param string $text   The text to trim.
 * @param int    $length Maximum length.
 * @param string $suffix Suffix to append.
 * @return string
 */
function lawfirmpro_trim_text($text = '', $length = 100, $suffix = '...')
{
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . $suffix;
}
