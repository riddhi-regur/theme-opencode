<?php

/**
 * Theme Setup — Pages
 */
function lawfirmpro_theme_setup()
{
    $pages = array(
        'home-version-1' => 'Home Version 1',
        'home-version-2' => 'Home Version 2',
        'about'          => 'About',
        'contact'        => 'Contact',
        'blog'           => 'Blogs',
    );

    foreach ($pages as $slug => $title) {
        $page = get_page_by_path($slug, OBJECT, 'page');

        if (! $page) {
            $page_id = wp_insert_post(array(
                'post_title'  => $title,
                'post_name'   => $slug,
                'post_type'   => 'page',
                'post_status' => 'publish',
            ));
        }
    }
}
add_action('after_switch_theme', 'lawfirmpro_theme_setup');

/**
 * Create navigation menus on init (runs once).
 */
function lawfirmpro_create_navigation_menus()
{
    if (get_option('lawfirmpro_menu_created')) {
        return;
    }

    $home_url           = home_url('/');
    $home_v1_url        = home_url('/home-version-1/');
    $home_v2_url        = home_url('/home-version-2/');
    $about_url          = home_url('/about/');
    $practice_areas_url = home_url('/practice-areas/');
    $articles_url       = home_url('/articles/');
    $attorneys_url      = home_url('/attorneys/');
    $contact_url        = home_url('/contact/');

    // ─── Header Menu: "Primary" ────────────────────────────────────
    $header_menu_name = 'Navigation';
    $header_menu      = wp_get_nav_menu_object($header_menu_name);
    $header_id        = 0;

    if (! $header_menu) {
        $header_id = wp_create_nav_menu($header_menu_name);

        // Home (with submenu)
        $home_id = wp_update_nav_menu_item($header_id, 0, array(
            'menu-item-title'   => __('Home', 'lawfirmpro'),
            'menu-item-classes' => 'home',
            'menu-item-url'     => $home_url,
            'menu-item-status'  => 'publish',
        ));

        wp_update_nav_menu_item($header_id, 0, array(
            'menu-item-title'    => __('Home Version 1', 'lawfirmpro'),
            'menu-item-url'      => $home_url,
            'menu-item-parent-id' => $home_id,
            'menu-item-status'   => 'publish',
        ));

        wp_update_nav_menu_item($header_id, 0, array(
            'menu-item-title'    => __('Home Version 2', 'lawfirmpro'),
            'menu-item-url'      => $home_v2_url,
            'menu-item-parent-id' => $home_id,
            'menu-item-status'   => 'publish',
        ));

        // Practice Areas
        wp_update_nav_menu_item($header_id, 0, array(
            'menu-item-title'  => __('Practice Areas', 'lawfirmpro'),
            'menu-item-url'    => $practice_areas_url,
            'menu-item-status' => 'publish',
        ));

        // Blogs
        wp_update_nav_menu_item($header_id, 0, array(
            'menu-item-title'  => __('Blogs', 'lawfirmpro'),
            'menu-item-url'    => $articles_url,
            'menu-item-status' => 'publish',
        ));

        // Attorneys
        wp_update_nav_menu_item($header_id, 0, array(
            'menu-item-title'  => __('Attorneys', 'lawfirmpro'),
            'menu-item-url'    => $attorneys_url,
            'menu-item-status' => 'publish',
        ));

        // Contact
        wp_update_nav_menu_item($header_id, 0, array(
            'menu-item-title'  => __('Contact', 'lawfirmpro'),
            'menu-item-url'    => $contact_url,
            'menu-item-status' => 'publish',
        ));
    } else {
        $header_id = $header_menu->term_id;
    }

    // ─── Footer Menu ───────────────────────────────────────────────
    $footer_menu_name = 'Footer Menu';
    $footer_menu      = wp_get_nav_menu_object($footer_menu_name);
    $footer_id        = 0;

    if (! $footer_menu) {
        $footer_id = wp_create_nav_menu($footer_menu_name);

        $footer_items = array(
            'Home'           => $home_url,
            'Blogs'          => $articles_url,
            'About'          => $about_url,
            'Practice Areas' => $practice_areas_url,
            'Attorneys'      => $attorneys_url,
            'Contact'        => $contact_url,
        );

        foreach ($footer_items as $label => $url) {
            wp_update_nav_menu_item($footer_id, 0, array(
                'menu-item-title'  => __($label, 'lawfirmpro'),
                'menu-item-url'    => $url,
                'menu-item-status' => 'publish',
            ));
        }
    } else {
        $footer_id = $footer_menu->term_id;
    }

    // ─── Assign locations (always ensure they're set) ──────────────
    $locations = get_theme_mod('nav_menu_locations', array());
    $changed   = false;

    if (empty($locations['navigation']) || (int) $locations['navigation'] !== (int) $header_id) {
        $locations['navigation'] = $header_id;
        $changed = true;
    }

    if (empty($locations['Footer Menu']) || (int) $locations['Footer Menu'] !== (int) $footer_id) {
        $locations['Footer Menu'] = $footer_id;
        $changed = true;
    }

    if ($changed) {
        set_theme_mod('nav_menu_locations', $locations);
    }

    update_option('lawfirmpro_menu_created', true);
}
add_action('init', 'lawfirmpro_create_navigation_menus');

/**
 * Create wp_navigation block entities for the navigation block.
 * The block-based navigation system uses wp_navigation posts, not nav_menu terms.
 */
function lawfirmpro_create_block_navigation()
{
    $home_url           = home_url('/');
    $home_v1_url        = home_url('/home-version-1/');
    $home_v2_url        = home_url('/home-version-2/');
    $about_url          = home_url('/about/');
    $practice_areas_url = home_url('/practice-areas/');
    $articles_url       = home_url('/articles/');
    $attorneys_url      = home_url('/attorneys/');
    $contact_url        = home_url('/contact/');

    // ─── Header wp_navigation ─────────────────────────────────────
    $existing_header = get_posts(array(
        'post_type'   => 'wp_navigation',
        'name'        => 'navigation',
        'numberposts' => 1,
    ));

    if (empty($existing_header)) {
        $header_content = '<!-- wp:navigation-submenu {"label":"Home","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($home_url) . '"} -->'
            . '<!-- wp:navigation-link {"label":"Home Version 1","kind":"custom","type":"page","url":"' . esc_url($home_v1_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"Home Version 2","kind":"custom","type":"page","url":"' . esc_url($home_v2_url) . '"} /-->'
            . '<!-- /wp:navigation-submenu -->'
            . '<!-- wp:navigation-link {"label":"Practice Areas","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($practice_areas_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"Blogs","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($articles_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"Attorneys","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($attorneys_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"Contact","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($contact_url) . '"} /-->';

        wp_insert_post(array(
            'post_title'   => 'Navigation',
            'post_name'    => 'navigation',
            'post_type'    => 'wp_navigation',
            'post_status'  => 'publish',
            'post_content' => $header_content,
        ));
    }

    // ─── Footer wp_navigation ─────────────────────────────────────
    $existing_footer = get_posts(array(
        'post_type'   => 'wp_navigation',
        'name'        => 'footer-menu',
        'numberposts' => 1,
    ));

    if (empty($existing_footer)) {
        $footer_content = '<!-- wp:navigation-link {"label":"Home","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($home_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"Blogs","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($articles_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"About","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($about_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"Practice Areas","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($practice_areas_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"Attorneys","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($attorneys_url) . '"} /-->'
            . '<!-- wp:navigation-link {"label":"Contact","kind":"custom","isTopLevelLink":true,"url":"' . esc_url($contact_url) . '"} /-->';

        wp_insert_post(array(
            'post_title'   => 'Footer Menu',
            'post_name'    => 'footer-menu',
            'post_type'    => 'wp_navigation',
            'post_status'  => 'publish',
            'post_content' => $footer_content,
        ));
    }
}
add_action('init', 'lawfirmpro_create_block_navigation');
