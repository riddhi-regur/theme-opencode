<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Settings
 */
add_action('admin_init', function () {

    register_setting(
        'lawfirmpro_contact_settings',
        'lawfirmpro_contact'
    );
});

/**
 * Admin Menu
 */
add_action('admin_menu', function () {

    add_menu_page(
        __('Theme Settings', 'lawfirmpro'),
        __('Theme Settings', 'lawfirmpro'),
        'manage_options',
        'lawfirmpro-theme-settings',
        'lawfirmpro_theme_settings_page',
        'dashicons-admin-generic',
        60
    );
});

/**
 * Settings Page
 */
function lawfirmpro_theme_settings_page()
{
    $contact = get_option('lawfirmpro_contact', []);
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';

?>
    <div class="wrap">
        <h1>Theme Settings</h1>

        <nav class="nav-tab-wrapper">
            <a href="?page=lawfirmpro-theme-settings&tab=general" class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>">General</a>
            <a href="?page=lawfirmpro-theme-settings&tab=social" class="nav-tab <?php echo $active_tab === 'social' ? 'nav-tab-active' : ''; ?>">Social Media</a>
            <a href="?page=lawfirmpro-theme-settings&tab=pages" class="nav-tab <?php echo $active_tab === 'pages' ? 'nav-tab-active' : ''; ?>">Page Links</a>
            <a href="?page=lawfirmpro-theme-settings&tab=stats" class="nav-tab <?php echo $active_tab === 'stats' ? 'nav-tab-active' : ''; ?>">Statistics</a>
            <a href="?page=lawfirmpro-theme-settings&tab=headings" class="nav-tab <?php echo $active_tab === 'headings' ? 'nav-tab-active' : ''; ?>">Headings</a>
            <a href="?page=lawfirmpro-theme-settings&tab=labels" class="nav-tab <?php echo $active_tab === 'labels' ? 'nav-tab-active' : ''; ?>">Labels</a>
            <a href="?page=lawfirmpro-theme-settings&tab=bodytext" class="nav-tab <?php echo $active_tab === 'bodytext' ? 'nav-tab-active' : ''; ?>">Body Text</a>
        </nav>

        <form method="post" action="options.php">

            <?php settings_fields('lawfirmpro_contact_settings'); ?>

            <?php if ($active_tab === 'general') : ?>
                <table class="form-table">
                    <tr>
                        <th>Phone</th>
                        <td>
                            <input type="text" class="regular-text" name="lawfirmpro_contact[phone]" value="<?php echo esc_attr($contact['phone'] ?? ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Another Phone</th>
                        <td>
                            <input type="text" class="regular-text" name="lawfirmpro_contact[another_phone]" value="<?php echo esc_attr($contact['another_phone'] ?? ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>
                            <input type="email" class="regular-text" name="lawfirmpro_contact[email]" value="<?php echo esc_attr($contact['email'] ?? ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            <textarea rows="5" cols="50" name="lawfirmpro_contact[address]"><?php echo esc_textarea($contact['address'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>WhatsApp</th>
                        <td>
                            <input type="text" class="regular-text" name="lawfirmpro_contact[whatsapp]" value="<?php echo esc_attr($contact['whatsapp'] ?? ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Google Maps Embed URL</th>
                        <td>
                            <input type="url" class="regular-text" name="lawfirmpro_contact[map_url]" value="<?php echo esc_attr($contact['map_url'] ?? ''); ?>" placeholder="https://www.google.com/maps/embed?pb=...">
                            <p class="description">Paste a Google Maps embed URL from the Share > Embed a map option.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Copyright Text</th>
                        <td>
                            <input type="text" class="regular-text" name="lawfirmpro_contact[copyright_text]" value="<?php echo esc_attr($contact['copyright_text'] ?? ''); ?>" placeholder="© 2025 Your Firm Name. All rights reserved.">
                            <p class="description">Leave blank to use default: © {year} {site_name}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>

            <?php elseif ($active_tab === 'social') : ?>
                <table class="form-table">
                    <tr>
                        <th>Facebook URL</th>
                        <td>
                            <input type="url" class="regular-text" name="lawfirmpro_contact[facebook_url]" value="<?php echo esc_attr($contact['facebook_url'] ?? ''); ?>" placeholder="https://facebook.com/yourpage">
                        </td>
                    </tr>
                    <tr>
                        <th>Instagram URL</th>
                        <td>
                            <input type="url" class="regular-text" name="lawfirmpro_contact[instagram_url]" value="<?php echo esc_attr($contact['instagram_url'] ?? ''); ?>" placeholder="https://instagram.com/yourpage">
                        </td>
                    </tr>
                    <tr>
                        <th>Twitter / X URL</th>
                        <td>
                            <input type="url" class="regular-text" name="lawfirmpro_contact[twitter_url]" value="<?php echo esc_attr($contact['twitter_url'] ?? ''); ?>" placeholder="https://twitter.com/yourhandle">
                        </td>
                    </tr>
                    <tr>
                        <th>LinkedIn URL</th>
                        <td>
                            <input type="url" class="regular-text" name="lawfirmpro_contact[linkedin_url]" value="<?php echo esc_attr($contact['linkedin_url'] ?? ''); ?>" placeholder="https://linkedin.com/company/yourpage">
                        </td>
                    </tr>
                    <tr>
                        <th>YouTube URL</th>
                        <td>
                            <input type="url" class="regular-text" name="lawfirmpro_contact[youtube_url]" value="<?php echo esc_attr($contact['youtube_url'] ?? ''); ?>" placeholder="https://youtube.com/yourchannel">
                        </td>
                    </tr>
                </table>

            <?php elseif ($active_tab === 'pages') : ?>
                <table class="form-table">
                    <tr>
                        <th>Contact Page ID</th>
                        <td>
                            <?php wp_dropdown_pages(['name' => 'lawfirmpro_contact[contact_page_id]', 'selected' => $contact['contact_page_id'] ?? '', 'post_type' => 'page', 'show_option_none' => '-- Select Page --', 'class' => 'regular-text']); ?>
                            <p class="description">Page used for "Get Legal Advice" buttons. Falls back to /contact/.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>About Page ID</th>
                        <td>
                            <?php wp_dropdown_pages(['name' => 'lawfirmpro_contact[about_page_id]', 'selected' => $contact['about_page_id'] ?? '', 'post_type' => 'page', 'show_option_none' => '-- Select Page --', 'class' => 'regular-text']); ?>
                            <p class="description">Page used for "Learn More" buttons. Falls back to /about/.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Practice Areas Page ID</th>
                        <td>
                            <?php wp_dropdown_pages(['name' => 'lawfirmpro_contact[practice_areas_page_id]', 'selected' => $contact['practice_areas_page_id'] ?? '', 'post_type' => 'page', 'show_option_none' => '-- Select Page --', 'class' => 'regular-text']); ?>
                            <p class="description">Page used for practice area links. Falls back to /practice-areas/.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Attorneys Page ID</th>
                        <td>
                            <?php wp_dropdown_pages(['name' => 'lawfirmpro_contact[attorneys_page_id]', 'selected' => $contact['attorneys_page_id'] ?? '', 'post_type' => 'page', 'show_option_none' => '-- Select Page --', 'class' => 'regular-text']); ?>
                            <p class="description">Page used for attorney links. Falls back to /attorneys/.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Articles Page ID</th>
                        <td>
                            <?php wp_dropdown_pages(['name' => 'lawfirmpro_contact[articles_page_id]', 'selected' => $contact['articles_page_id'] ?? '', 'post_type' => 'page', 'show_option_none' => '-- Select Page --', 'class' => 'regular-text']); ?>
                            <p class="description">Page used for article/blog links. Falls back to /articles/.</p>
                        </td>
                    </tr>
                </table>

            <?php elseif ($active_tab === 'stats') : ?>
                <table class="form-table">
                    <tr><th colspan="2"><h2>Statistic 1</h2></th></tr>
                    <tr>
                        <th>Number</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[stat_1_number]" value="<?php echo esc_attr($contact['stat_1_number'] ?? ''); ?>" placeholder="100+"></td>
                    </tr>
                    <tr>
                        <th>Label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[stat_1_label]" value="<?php echo esc_attr($contact['stat_1_label'] ?? ''); ?>" placeholder="Successful Cases"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Statistic 2</h2></th></tr>
                    <tr>
                        <th>Number</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[stat_2_number]" value="<?php echo esc_attr($contact['stat_2_number'] ?? ''); ?>" placeholder="30+"></td>
                    </tr>
                    <tr>
                        <th>Label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[stat_2_label]" value="<?php echo esc_attr($contact['stat_2_label'] ?? ''); ?>" placeholder="Years of Legal Experience"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Statistic 3</h2></th></tr>
                    <tr>
                        <th>Number</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[stat_3_number]" value="<?php echo esc_attr($contact['stat_3_number'] ?? ''); ?>" placeholder="1.4K+"></td>
                    </tr>
                    <tr>
                        <th>Label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[stat_3_label]" value="<?php echo esc_attr($contact['stat_3_label'] ?? ''); ?>" placeholder="Happy Customers"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Statistic 4</h2></th></tr>
                    <tr>
                        <th>Number</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[stat_4_number]" value="<?php echo esc_attr($contact['stat_4_number'] ?? ''); ?>" placeholder="1.4K+"></td>
                    </tr>
                    <tr>
                        <th>Label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[stat_4_label]" value="<?php echo esc_attr($contact['stat_4_label'] ?? ''); ?>" placeholder="Happy Customers"></td>
                    </tr>
                </table>

            <?php elseif ($active_tab === 'headings') : ?>
                <table class="form-table">
                    <tr><th colspan="2"><h2>Homepage Headings</h2></th></tr>
                    <tr>
                        <th>Hero Heading (v1)</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_hero_v1]" value="<?php echo esc_attr($contact['heading_hero_v1'] ?? ''); ?>" placeholder="Trusted Legal Advice When You Need It Most"></td>
                    </tr>
                    <tr>
                        <th>Hero Heading (v2)</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_hero_v2]" value="<?php echo esc_attr($contact['heading_hero_v2'] ?? ''); ?>" placeholder="Reliable Legal Help from Expert Lawyers"></td>
                    </tr>
                    <tr>
                        <th>Offers Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_offers]" value="<?php echo esc_attr($contact['heading_offers'] ?? ''); ?>" placeholder="How Can I Help You?"></td>
                    </tr>
                    <tr>
                        <th>Practice Areas Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_practice]" value="<?php echo esc_attr($contact['heading_practice'] ?? ''); ?>" placeholder="Our Expertise Practice Areas"></td>
                    </tr>
                    <tr>
                        <th>Attorneys Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_attorneys]" value="<?php echo esc_attr($contact['heading_attorneys'] ?? ''); ?>" placeholder="Meet Our Experienced Attorneys"></td>
                    </tr>
                    <tr>
                        <th>Articles Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_articles]" value="<?php echo esc_attr($contact['heading_articles'] ?? ''); ?>" placeholder="Latest Articles"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Other Section Headings</h2></th></tr>
                    <tr>
                        <th>Testimonials Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_testimonials]" value="<?php echo esc_attr($contact['heading_testimonials'] ?? ''); ?>" placeholder="Real Stories from Real Clients"></td>
                    </tr>
                    <tr>
                        <th>FAQ Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_faq]" value="<?php echo esc_attr($contact['heading_faq'] ?? ''); ?>" placeholder="Frequently Asked Questions"></td>
                    </tr>
                    <tr>
                        <th>Contact Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_contact]" value="<?php echo esc_attr($contact['heading_contact'] ?? ''); ?>" placeholder="Get In Touch"></td>
                    </tr>
                    <tr>
                        <th>Contact Hero Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_contact_hero]" value="<?php echo esc_attr($contact['heading_contact_hero'] ?? ''); ?>" placeholder="Speak With Our Legal Experts"></td>
                    </tr>
                    <tr><th colspan="2"><h2>About Page Headings</h2></th></tr>
                    <tr>
                        <th>About Hero Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_about_hero]" value="<?php echo esc_attr($contact['heading_about_hero'] ?? ''); ?>" placeholder="Legal Excellence Built on Trust and Experience"></td>
                    </tr>
                    <tr>
                        <th>About Results Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_about_results]" value="<?php echo esc_attr($contact['heading_about_results'] ?? ''); ?>" placeholder="Experienced Solicitors. Proven Results."></td>
                    </tr>
                    <tr>
                        <th>About Lawyers Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_about_lawyers]" value="<?php echo esc_attr($contact['heading_about_lawyers'] ?? ''); ?>" placeholder="Supporting You Every Step of the Way"></td>
                    </tr>
                    <tr>
                        <th>About Contact Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_about_contact]" value="<?php echo esc_attr($contact['heading_about_contact'] ?? ''); ?>" placeholder="Speak to an Experienced Solicitor Today"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Home About Section</h2></th></tr>
                    <tr>
                        <th>Home About Heading 1</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_home_about_1]" value="<?php echo esc_attr($contact['heading_home_about_1'] ?? ''); ?>" placeholder="Trusted by Clients"></td>
                    </tr>
                    <tr>
                        <th>Home About Heading 2</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_home_about_2]" value="<?php echo esc_attr($contact['heading_home_about_2'] ?? ''); ?>" placeholder="Across England & Wales"></td>
                    </tr>
                    <tr>
                        <th>Home V2 About Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_home_v2_about]" value="<?php echo esc_attr($contact['heading_home_v2_about'] ?? ''); ?>" placeholder="Protecting Your Rights With Dedication"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Consultation & Choose Firm</h2></th></tr>
                    <tr>
                        <th>Consultation Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_consultation]" value="<?php echo esc_attr($contact['heading_consultation'] ?? ''); ?>" placeholder="Book a Free Consultation"></td>
                    </tr>
                    <tr>
                        <th>Choose Firm Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_choose_firm]" value="<?php echo esc_attr($contact['heading_choose_firm'] ?? ''); ?>" placeholder="How to Choose the Right Lawyer for Your Case"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Service Detail Headings</h2></th></tr>
                    <tr>
                        <th>Feature 1 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_feature_1]" value="<?php echo esc_attr($contact['heading_sd_feature_1'] ?? ''); ?>" placeholder="Tailored Funding Options"></td>
                    </tr>
                    <tr>
                        <th>Feature 2 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_feature_2]" value="<?php echo esc_attr($contact['heading_sd_feature_2'] ?? ''); ?>" placeholder="Seamless Process"></td>
                    </tr>
                    <tr>
                        <th>Feature 3 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_feature_3]" value="<?php echo esc_attr($contact['heading_sd_feature_3'] ?? ''); ?>" placeholder="Diversified Portfolio"></td>
                    </tr>
                    <tr>
                        <th>Solutions Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_solutions]" value="<?php echo esc_attr($contact['heading_sd_solutions'] ?? ''); ?>" placeholder="Funding Solutions For Growing Businesses"></td>
                    </tr>
                    <tr>
                        <th>Step 1 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_step_1]" value="<?php echo esc_attr($contact['heading_sd_step_1'] ?? ''); ?>" placeholder="Planning the case"></td>
                    </tr>
                    <tr>
                        <th>Step 2 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_step_2]" value="<?php echo esc_attr($contact['heading_sd_step_2'] ?? ''); ?>" placeholder="Evaluate Situation"></td>
                    </tr>
                    <tr>
                        <th>Step 3 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_step_3]" value="<?php echo esc_attr($contact['heading_sd_step_3'] ?? ''); ?>" placeholder="Initiate Court Case"></td>
                    </tr>
                    <tr>
                        <th>Step 4 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_step_4]" value="<?php echo esc_attr($contact['heading_sd_step_4'] ?? ''); ?>" placeholder="Gather Information"></td>
                    </tr>
                    <tr>
                        <th>Section 3 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_section3]" value="<?php echo esc_attr($contact['heading_sd_section3'] ?? ''); ?>" placeholder="Assets With Assurance Of Expert Guidance"></td>
                    </tr>
                    <tr>
                        <th>Card 1 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_card_1]" value="<?php echo esc_attr($contact['heading_sd_card_1'] ?? ''); ?>" placeholder="Analysis Case"></td>
                    </tr>
                    <tr>
                        <th>Card 2 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_card_2]" value="<?php echo esc_attr($contact['heading_sd_card_2'] ?? ''); ?>" placeholder="Information List"></td>
                    </tr>
                    <tr>
                        <th>Card 3 Heading</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[heading_sd_card_3]" value="<?php echo esc_attr($contact['heading_sd_card_3'] ?? ''); ?>" placeholder="Documentation"></td>
                    </tr>
                </table>

            <?php elseif ($active_tab === 'labels') : ?>
                <table class="form-table">
                    <tr>
                        <th>"Call us today" label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_call_today]" value="<?php echo esc_attr($contact['label_call_today'] ?? ''); ?>" placeholder="Call us today"></td>
                    </tr>
                    <tr>
                        <th>"Location" label (contact section)</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_location]" value="<?php echo esc_attr($contact['label_location'] ?? ''); ?>" placeholder="Location"></td>
                    </tr>
                    <tr>
                        <th>"Phone Number" label (contact section)</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_phone_number]" value="<?php echo esc_attr($contact['label_phone_number'] ?? ''); ?>" placeholder="Phone Number"></td>
                    </tr>
                    <tr>
                        <th>"Support Email" label (contact section)</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_support_email]" value="<?php echo esc_attr($contact['label_support_email'] ?? ''); ?>" placeholder="Support Email"></td>
                    </tr>
                    <tr>
                        <th>"Quick links" label (footer)</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_quick_links]" value="<?php echo esc_attr($contact['label_quick_links'] ?? ''); ?>" placeholder="Quick links"></td>
                    </tr>
                    <tr>
                        <th>"Contact Info" label (footer)</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_contact_info]" value="<?php echo esc_attr($contact['label_contact_info'] ?? ''); ?>" placeholder="Contact Info"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Pill Button Labels</h2></th></tr>
                    <tr>
                        <th>"Contact" pill label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_contact]" value="<?php echo esc_attr($contact['label_contact'] ?? ''); ?>" placeholder="Contact"></td>
                    </tr>
                    <tr>
                        <th>"About Us" pill label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_about_us]" value="<?php echo esc_attr($contact['label_about_us'] ?? ''); ?>" placeholder="About Us"></td>
                    </tr>
                    <tr>
                        <th>"Services" pill label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_services]" value="<?php echo esc_attr($contact['label_services'] ?? ''); ?>" placeholder="Services"></td>
                    </tr>
                    <tr>
                        <th>"Team" pill label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_team]" value="<?php echo esc_attr($contact['label_team'] ?? ''); ?>" placeholder="Team"></td>
                    </tr>
                    <tr>
                        <th>"Blog" pill label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_blog]" value="<?php echo esc_attr($contact['label_blog'] ?? ''); ?>" placeholder="Blog"></td>
                    </tr>
                    <tr>
                        <th>"Testimonials" pill label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_testimonials]" value="<?php echo esc_attr($contact['label_testimonials'] ?? ''); ?>" placeholder="Testimonials"></td>
                    </tr>
                    <tr>
                        <th>"FAQs" pill label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_faqs]" value="<?php echo esc_attr($contact['label_faqs'] ?? ''); ?>" placeholder="FAQs"></td>
                    </tr>
                    <tr>
                        <th>"Need Help?" pill label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_need_help]" value="<?php echo esc_attr($contact['label_need_help'] ?? ''); ?>" placeholder="Need Help?"></td>
                    </tr>
                    <tr>
                        <th>"Education" label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_education]" value="<?php echo esc_attr($contact['label_education'] ?? ''); ?>" placeholder="Education"></td>
                    </tr>
                    <tr>
                        <th>"Career" label</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[label_career]" value="<?php echo esc_attr($contact['label_career'] ?? ''); ?>" placeholder="Career"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Button CTA Labels</h2></th></tr>
                    <tr>
                        <th>"Explore Services" button</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[btn_explore_services]" value="<?php echo esc_attr($contact['btn_explore_services'] ?? ''); ?>" placeholder="Explore Services ➔"></td>
                    </tr>
                    <tr>
                        <th>"Request a Quote" button</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[btn_request_quote]" value="<?php echo esc_attr($contact['btn_request_quote'] ?? ''); ?>" placeholder="Request a Quote ➔"></td>
                    </tr>
                    <tr>
                        <th>"Read More" button</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[btn_read_more]" value="<?php echo esc_attr($contact['btn_read_more'] ?? ''); ?>" placeholder="Read More ➔"></td>
                    </tr>
                    <tr>
                        <th>"Learn More" button</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[btn_learn_more]" value="<?php echo esc_attr($contact['btn_learn_more'] ?? ''); ?>" placeholder="Learn More"></td>
                    </tr>
                    <tr>
                        <th>"View All Services" button</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[btn_view_all_services]" value="<?php echo esc_attr($contact['btn_view_all_services'] ?? ''); ?>" placeholder="View All Services ➔"></td>
                    </tr>
                    <tr>
                        <th>"Meet Our Team" button</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[btn_meet_team]" value="<?php echo esc_attr($contact['btn_meet_team'] ?? ''); ?>" placeholder="Meet Our Team ➔"></td>
                    </tr>
                    <tr>
                        <th>"Our Articles" button</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[btn_our_articles]" value="<?php echo esc_attr($contact['btn_our_articles'] ?? ''); ?>" placeholder="Our Articles ➔"></td>
                    </tr>
                    <tr>
                        <th>"View Service" button</th>
                        <td><input type="text" class="regular-text" name="lawfirmpro_contact[btn_view_service]" value="<?php echo esc_attr($contact['btn_view_service'] ?? ''); ?>" placeholder="View Service ➔"></td>
                    </tr>
                    <tr><th colspan="2"><h2>Paragraph Texts</h2></th></tr>
                    <tr>
                        <th>Footer About Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_footer_about]" placeholder="Our experienced lawyers provide clear, effective legal solutions tailored to your needs."><?php echo esc_textarea($contact['text_footer_about'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Choose Firm Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_choose_firm]" placeholder="How to Choose the Right Lawyer for Your Case"><?php echo esc_textarea($contact['text_choose_firm'] ?? ''); ?></textarea></td>
                    </tr>
                </table>

            <?php elseif ($active_tab === 'bodytext') : ?>
                <table class="form-table">
                    <tr><th colspan="2"><h2>Home Version 1 Sections</h2></th></tr>
                    <tr>
                        <th>Home About Paragraph 1</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_home_about_p1]" placeholder="For over 25 years, we've helped individuals, families..."><?php echo esc_textarea($contact['text_home_about_p1'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Home About Paragraph 2</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_home_about_p2]" placeholder="From first consultations to courtroom advocacy..."><?php echo esc_textarea($contact['text_home_about_p2'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Practice Areas Subtext</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_practice_sub]" placeholder="Expert legal solutions tailored to protect your rights..."><?php echo esc_textarea($contact['text_practice_sub'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Attorneys Subtext</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_attorneys_sub]" placeholder="Our team brings together specialists..."><?php echo esc_textarea($contact['text_attorneys_sub'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Articles Subtext</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_articles_sub]" placeholder="Stay informed with the latest legal insights..."><?php echo esc_textarea($contact['text_articles_sub'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Consultation Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_consultation]" placeholder="Ready to discuss your legal needs?..."><?php echo esc_textarea($contact['text_consultation'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr><th colspan="2"><h2>Home Version 2 Sections</h2></th></tr>
                    <tr>
                        <th>V2 About Paragraph 1</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_home_v2_about_p1]" placeholder="With over 25 years of experience..."><?php echo esc_textarea($contact['text_home_v2_about_p1'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>V2 About Paragraph 2</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_home_v2_about_p2]" placeholder="From conveyancing and family law..."><?php echo esc_textarea($contact['text_home_v2_about_p2'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>V2 Practice Areas Subtext</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_practice_sub_v2]" placeholder="Expert legal solutions..."><?php echo esc_textarea($contact['text_practice_sub_v2'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>V2 Attorneys Subtext</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_attorneys_sub_v2]" placeholder="Our experienced solicitors..."><?php echo esc_textarea($contact['text_attorneys_sub_v2'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>V2 Articles Subtext</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_articles_sub_v2]" placeholder="Stay informed with the latest legal insights..."><?php echo esc_textarea($contact['text_articles_sub_v2'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Offers Subtext</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_offers_sub]" placeholder="How we can help you..."><?php echo esc_textarea($contact['text_offers_sub'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>V2 Offers Subtext</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_offers_sub_v2]" placeholder="How we can help you..."><?php echo esc_textarea($contact['text_offers_sub_v2'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr><th colspan="2"><h2>About Page</h2></th></tr>
                    <tr>
                        <th>About Hero Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_about_hero]" placeholder="For over 25 years, we've provided trusted legal advice..."><?php echo esc_textarea($contact['text_about_hero'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>About Contact Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_about_contact]" placeholder="Whether you need immediate legal advice..."><?php echo esc_textarea($contact['text_about_contact'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>About Lawyers Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_about_lawyers]" placeholder="Legal matters can be stressful..."><?php echo esc_textarea($contact['text_about_lawyers'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>About Results Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_about_results]" placeholder="Our team brings together specialists..."><?php echo esc_textarea($contact['text_about_results'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr><th colspan="2"><h2>Contact Page</h2></th></tr>
                    <tr>
                        <th>Contact Hero Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_contact_hero]" placeholder="Whether you need legal advice..."><?php echo esc_textarea($contact['text_contact_hero'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr><th colspan="2"><h2>Archive Pages</h2></th></tr>
                    <tr>
                        <th>Practice Areas Archive Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_practice_areas]" placeholder="From family law and criminal defence..."><?php echo esc_textarea($contact['text_practice_areas'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Attorneys Archive Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_attorneys]" placeholder="Our experienced solicitors..."><?php echo esc_textarea($contact['text_attorneys'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Articles Archive Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_articles]" placeholder="Stay informed with the latest legal insights..."><?php echo esc_textarea($contact['text_articles'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr><th colspan="2"><h2>Service Detail Sections</h2></th></tr>
                    <tr>
                        <th>Service Detail Intro</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_sd_intro]" placeholder="Our team brings together specialists..."><?php echo esc_textarea($contact['text_sd_intro'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Feature Body Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_sd_body]" placeholder="We pride ourselves on delivering practical..."><?php echo esc_textarea($contact['text_sd_body'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Step Body Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_sd_step_body]" placeholder="With decades of combined experience..."><?php echo esc_textarea($contact['text_sd_step_body'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Section 3 Body Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_sd_section3_body]" placeholder="Our solicitors bring decades of combined experience..."><?php echo esc_textarea($contact['text_sd_section3_body'] ?? ''); ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Card Body Text</th>
                        <td><textarea rows="3" cols="50" name="lawfirmpro_contact[text_sd_card_body]" placeholder="Our team brings together specialists..."><?php echo esc_textarea($contact['text_sd_card_body'] ?? ''); ?></textarea></td>
                    </tr>
                </table>

            <?php endif; ?>

            <?php submit_button(); ?>

        </form>
    </div>
<?php
}

/**
 * Helper: get a theme option value
 */
function lawfirmpro_get_contact($key = '')
{
    $contact = get_option('lawfirmpro_contact', []);
    return $contact[$key] ?? '';
}

/**
 * Helper: get a page URL by theme option key (page ID)
 */
function lawfirmpro_get_page_url($key, $fallback = '/')
{
    $page_id = lawfirmpro_get_contact($key);
    if ($page_id && get_post_status($page_id) === 'publish') {
        return get_permalink($page_id);
    }
    return $fallback;
}

/**
 * Helper: get a heading with theme option fallback
 */
function lawfirmpro_get_heading($key, $fallback = '')
{
    $value = lawfirmpro_get_contact($key);
    return !empty($value) ? $value : $fallback;
}

/**
 * Helper: get a label with theme option fallback
 */
function lawfirmpro_get_label($key, $fallback = '')
{
    $value = lawfirmpro_get_contact($key);
    return !empty($value) ? $value : $fallback;
}

// ============================================================
// SHORTCODES
// ============================================================

/**
 * [lawfirmpro_phone]
 */
function lawfirmpro_phone_shortcode()
{
    $phone = lawfirmpro_get_contact('phone');
    if (!$phone) {
        return '';
    }
    return sprintf(
        '<a href="tel:%1$s">%2$s</a>',
        esc_attr($phone),
        esc_html($phone)
    );
}
add_shortcode('lawfirmpro_phone', 'lawfirmpro_phone_shortcode');

/**
 * [lawfirmpro_another_phone]
 */
function lawfirmpro_another_phone_shortcode()
{
    $phone = lawfirmpro_get_contact('another_phone');
    if (!$phone) {
        return '';
    }
    return sprintf(
        '<a href="tel:%1$s">%2$s</a>',
        esc_attr($phone),
        esc_html($phone)
    );
}
add_shortcode('lawfirmpro_another_phone', 'lawfirmpro_another_phone_shortcode');

/**
 * [lawfirmpro_email]
 */
function lawfirmpro_email_shortcode()
{
    $email = lawfirmpro_get_contact('email');
    if (!$email) {
        return '';
    }
    return sprintf(
        '<a href="mailto:%1$s">%2$s</a>',
        esc_attr($email),
        esc_html($email)
    );
}
add_shortcode('lawfirmpro_email', 'lawfirmpro_email_shortcode');

/**
 * [lawfirmpro_address]
 */
function lawfirmpro_address_shortcode()
{
    $address = lawfirmpro_get_contact('address');
    if (!$address) {
        return '';
    }
    return nl2br(esc_html($address));
}
add_shortcode('lawfirmpro_address', 'lawfirmpro_address_shortcode');

/**
 * [lawfirmpro_whatsapp]
 */
function lawfirmpro_whatsapp_shortcode()
{
    $number = lawfirmpro_get_contact('whatsapp');
    if (!$number) {
        return '';
    }
    $clean = preg_replace('/[^0-9]/', '', $number);
    return sprintf(
        '<a target="_blank" href="https://wa.me/%1$s">%2$s</a>',
        esc_attr($clean),
        esc_html($number)
    );
}
add_shortcode('lawfirmpro_whatsapp', 'lawfirmpro_whatsapp_shortcode');

/**
 * [lawfirmpro_map]
 */
function lawfirmpro_map_shortcode()
{
    $map_url = lawfirmpro_get_contact('map_url');
    if (!$map_url) {
        return '';
    }
    return sprintf(
        '<iframe src="%1$s" width="100%%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" class="contact-map-cover"></iframe>',
        esc_url($map_url)
    );
}
add_shortcode('lawfirmpro_map', 'lawfirmpro_map_shortcode');

/**
 * [lawfirmpro_link page="contact"]Button Text[/lawfirmpro_link]
 */
function lawfirmpro_link_shortcode($atts, $content = '')
{
    $atts = shortcode_atts([
        'page' => 'contact',
    ], $atts);

    $page_map = [
        'contact'        => ['contact_page_id', '/contact/'],
        'about'          => ['about_page_id', '/about/'],
        'practice-areas' => ['practice_areas_page_id', '/practice-areas/'],
        'attorneys'      => ['attorneys_page_id', '/attorneys/'],
        'articles'       => ['articles_page_id', '/articles/'],
    ];

    $key = $page_map[$atts['page']] ?? ['contact_page_id', '/contact/'];
    $url = lawfirmpro_get_page_url($key[0], $key[1]);

    return sprintf(
        '<a href="%1$s">%2$s</a>',
        esc_url($url),
        esc_html($content)
    );
}
add_shortcode('lawfirmpro_link', 'lawfirmpro_link_shortcode');

/**
 * [lawfirmpro_stat number="100+" label="Successful Cases"]
 */
function lawfirmpro_stat_shortcode($atts)
{
    $atts = shortcode_atts([
        'number' => '',
        'label'  => '',
    ], $atts);

    if (empty($atts['number']) && empty($atts['label'])) {
        return '';
    }

    return sprintf(
        '<span class="lawfirmpro-stat"><strong>%1$s</strong> %2$s</span>',
        esc_html($atts['number']),
        esc_html($atts['label'])
    );
}
add_shortcode('lawfirmpro_stat', 'lawfirmpro_stat_shortcode');

/**
 * [lawfirmpro_heading key="heading_hero_v1" fallback="Default Text"]
 */
function lawfirmpro_heading_shortcode($atts)
{
    $atts = shortcode_atts([
        'key'      => '',
        'fallback' => '',
    ], $atts);

    $text = lawfirmpro_get_heading($atts['key'], $atts['fallback']);
    return esc_html($text);
}
add_shortcode('lawfirmpro_heading', 'lawfirmpro_heading_shortcode');

/**
 * [lawfirmpro_label key="label_call_today" fallback="Call us today"]
 */
function lawfirmpro_label_shortcode($atts)
{
    $atts = shortcode_atts([
        'key'      => '',
        'fallback' => '',
    ], $atts);

    $text = lawfirmpro_get_label($atts['key'], $atts['fallback']);
    return esc_html($text);
}
add_shortcode('lawfirmpro_label', 'lawfirmpro_label_shortcode');

/**
 * [lawfirmpro_social]
 * Outputs the social links from theme options.
 */
function lawfirmpro_social_shortcode()
{
    $socials = [
        'facebook'  => lawfirmpro_get_contact('facebook_url'),
        'instagram' => lawfirmpro_get_contact('instagram_url'),
        'twitter'   => lawfirmpro_get_contact('twitter_url'),
        'linkedin'  => lawfirmpro_get_contact('linkedin_url'),
        'youtube'   => lawfirmpro_get_contact('youtube_url'),
    ];

    $output = '<ul class="wp-block-social-links has-icon-color is-style-logos-only">';
    foreach ($socials as $service => $url) {
        if (!empty($url)) {
            $output .= sprintf(
                '<li class="wp-social-link wp-social-link-%1$s"><a href="%2$s" target="_blank" rel="noopener">%3$s</a></li>',
                esc_attr($service),
                esc_url($url),
                esc_html(ucfirst($service))
            );
        }
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('lawfirmpro_social', 'lawfirmpro_social_shortcode');
