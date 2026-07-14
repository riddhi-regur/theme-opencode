<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Remove WordPress version number from head and feeds
 */
remove_action('wp_head', 'wp_generator');

/**
 * Disable XML-RPC for security
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove unnecessary meta tags from head
 */
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Disable the REST API user enumeration endpoint for non-logged users
 */
add_filter('rest_endpoints', function ($endpoints) {
    if (!is_user_logged_in()) {
        if (isset($endpoints['/wp/v2/users'])) {
            unset($endpoints['/wp/v2/users']);
        }
        if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
            unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
        }
    }
    return $endpoints;
});

/**
 * Add security headers
 */
add_action('send_headers', function () {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
});
