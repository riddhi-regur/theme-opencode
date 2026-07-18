<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Import CPT data from live site on theme activation.
 * Hooked to init (ensures CPTs are registered before querying).
 * Uses an option flag for idempotency.
 */
function lawfirmpro_import_cpt_data()
{
    if (get_option('lawfirmpro_cpt_data_imported')) {
        return;
    }

    lawfirmpro_import_practice_areas();
    lawfirmpro_import_attorneys();
    lawfirmpro_import_testimonials();
    lawfirmpro_import_faqs();
    lawfirmpro_import_articles();
    lawfirmpro_import_offers();
    lawfirmpro_import_about_firm();
    lawfirmpro_set_default_options();
    lawfirmpro_set_all_featured_images();

    update_option('lawfirmpro_cpt_data_imported', true);
}
add_action('init', 'lawfirmpro_import_cpt_data');

function lawfirmpro_set_featured_image($post_id, $image_filename) {
    $image_path = get_theme_file_path('assets/images/' . $image_filename);
    if (!file_exists($image_path)) return false;
    $upload_dir = wp_upload_dir();
    if (!empty($upload_dir['error'])) return false;
    wp_mkdir_p($upload_dir['path']);
    $target = $upload_dir['path'] . '/' . $image_filename;
    if (!copy($image_path, $target)) return false;
    $file_type = wp_check_filetype($image_filename, null);
    $attachment = [
        'post_title'     => sanitize_file_name($image_filename),
        'post_mime_type' => $file_type['type'] ?: 'image/png',
        'post_status'    => 'inherit',
        'guid'           => $upload_dir['url'] . '/' . $image_filename,
    ];
    $attach_id = wp_insert_attachment($attachment, $target);
    if (is_wp_error($attach_id) || !$attach_id) return false;
    if (!function_exists('wp_generate_attachment_metadata')) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }
    $metadata = wp_generate_attachment_metadata($attach_id, $target);
    wp_update_attachment_metadata($attach_id, $metadata);
    set_post_thumbnail($post_id, $attach_id);
    return true;
}
function lawfirmpro_set_all_featured_images()
{
    $image_map = [
        'practice-area' => [
            'Employment Law'          => 'lawyer-client-meeting-scaled.jpg',
            'Immigration Law'         => 'visa-application-composition-with-american-flag-2.png',
            'Real Estate Law'         => 'pexels-thirdman-7993898-scaled.jpg',
            'Criminal Defence'        => 'pexels-ron-lach-10475170-2.png',
            'Family Law'              => 'young-happy-parents-enjoying-coloring-with-their-small-daughter-home-scaled.jpg',
            'Divorce Separation'      => 'breakup-marriage-couple-with-divorce-certification-scaled.jpg',
            'Child Custody'           => 'parent-kid-talking-psychologist-scaled.jpg',
            'Corporate Law'           => 'lawyers-handshake-agreement-scaled.jpg',
            'Cyber Law'               => 'business-corporate-protection-safety-security-concept-scaled.jpg',
        ],
        'attorney' => [
            'James Thornton'  => 'Mask-group.png',
            'Sarah Mitchell'  => 'Mask-group-1.png',
            'Daniel Cooper'   => 'Mask-group-2.png',
            'William Harrison' => 'Mask-group-1-2.png',
            'Oliver Bennett'  => 'Mask-group-4.png',
            'Elis Davies'     => 'Mask-group-2-1.png',
            'Amelia Turner'   => 'Mask-group-3-1.png',
            'James Carter'    => 'Mask-group-4-1.png',
            'Daniel Foster'   => 'Mask-group-6.png',
        ],
        'article' => [
            'Understanding the UK Divorce Process in 2026'                       => 'article-img-1.png',
            'First-Time Home Buyers: Legal Checklist Before Completion'           => 'article-img-2.png',
            'Changes to UK Employment Law Every Employer Should Know'            => 'article-img-3.png',
            'Essential Legal Checks Before Buying a Business'                    => 'Mask-group-1-3.png',
            'A First-Time Buyer\'s Guide to Residential Conveyancing'           => 'Mask-group-5.png',
            'Your Rights After Unfair Dismissal'                                 => 'Mask-group-2-2.png',
            'Five Legal Mistakes Small Businesses Should Avoid'                  => 'Mask-group-4-3.png',
            'Why Every Family Should Have an Up-to-Date Will'                    => 'Mask-group-5-1.png',
            'What to Do If You\'re Asked to Attend a Police Interview'          => 'Mask-group-6-1.png',
            'Child Arrangements After Separation Explained'                      => 'Mask-group2-1.png',
            'Making a Personal Injury Claim: A Step-by-Step Guide'              => 'Mask-group1-1.png',
        ],
        'offer' => [
            'Criminal Defence' => 'image-75-1.png',
            'Family Law'       => 'pexels-august-de-richelieu-4427429-1.png',
            'Civil Litigation' => 'image-76.jpg',
        ],
        'testimonial' => [
            'Emma Richardson' => 'ratings-icon.png',
        ],
    ];

    foreach ($image_map as $post_type => $posts) {
        $existing = get_posts([
            'post_type'      => $post_type,
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ]);

        foreach ($existing as $post_id) {
            if (has_post_thumbnail($post_id)) continue;
            $title = get_the_title($post_id);
            $decoded = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
            $normal = str_replace(["’", "‘", "“", "”", " "], ["'", "'", '"', '"', ' '], $decoded);
            $image = $posts[$title] ?? '';
            if (!$image) {
                foreach ($posts as $key => $val) {
                    $key_decoded = html_entity_decode($key, ENT_QUOTES, 'UTF-8');
                    $key_normal = str_replace(["’", "‘", "“", "”", " "], ["'", "'", '"', '"', ' '], $key_decoded);
                    if ($key_normal === $normal) { $image = $val; break; }
                }
            }
            if ($image) lawfirmpro_set_featured_image($post_id, $image);
        }
    }
}
function lawfirmpro_import_practice_areas()
{
    $existing = get_posts(['post_type'=>'practice-area','posts_per_page'=>1,'post_status'=>'publish','fields'=>'ids']);
    if (!empty($existing)) return;
    $areas = [
        [
            'title'          => 'Employment Law',
            'content'        => '<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">Navigating employment law can be stressful for both businesses and individuals.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Tailored Legal Advice</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Every employment matter is different. We take time to understand your situation before providing clear, practical advice that aligns with your objectives, whether you&#8217;re an employer or employee.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Efficient &amp; Transparent Process</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">We keep legal matters straightforward with regular updates, transparent pricing where possible, and responsive communication throughout your case.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Trusted Employment Specialists</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">From drafting employment contracts to representing clients before Employment Tribunals, our solicitors have extensive experience handling a broad range of workplace legal issues.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Our Employment Law Process</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Initial Consultation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We discuss your circumstances, assess your legal position, and explain the options available to you.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Case Assessment</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors review contracts, policies, correspondence and evidence to identify strengths, risks and the best legal strategy.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Negotiation &amp; Resolution</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Where appropriate, we negotiate directly with the other party to achieve a fair and cost-effective resolution without court proceedings.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Ongoing Legal Support</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We continue to advise and support you throughout the legal process, ensuring you understand every step and remain informed.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-0ae01d90 wp-block-group-is-layout-constrained" style="padding-top:104px;padding-bottom:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Our employment law solicitors provide practical, strategic advice tailored to your individual or business needs.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading has-text-align-left service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">Employment Law Services</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Whether you&#8217;re an employer managing workplace issues or an employee protecting your rights, we provide practical legal support across all aspects of employment law.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading has-text-align-left service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">Employment Disputes</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Advice and representation for unfair dismissal, wrongful dismissal, workplace grievances, disciplinary proceedings and breach of contract claims.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading has-text-align-left service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">Settlement Agreements</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Independent legal advice on settlement agreements, redundancy packages, exit negotiations and severance arrangements to ensure your interests are protected.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Representing both employers and employees in workplace disputes, unfair dismissal, discrimination claims, redundancy, and settlement agreements.',
            'featured_image' => 'lawyer-client-meeting-scaled.jpg',
        ],
        [
            'title'          => 'Immigration Law',
            'content'        => '<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">Molestie nunc eget tempus a libero curabitur ullamcorper lorem vitae viverra integer tincidunt nulla odio.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Tailored Funding Options</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Donec molestie nunc eget ex tempus fermentum et a libero. Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Seamless Process</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Donec molestie nunc eget ex tempus fermentum et a libero. Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Diversified Portfolio</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Donec molestie nunc eget ex tempus fermentum et a libero. Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Funding Solutions For Growing Businesses</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Planning the case</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Evaluate Situation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Initiate Court Case</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Gather Information</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-0ae01d90 wp-block-group-is-layout-constrained" style="padding-top:104px;padding-bottom:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With &nbsp;Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Suspendisse turpis augue, aliquam eget ligula id, suscipit blandit magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Analysis Case</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">blandit ex tincidunt sed. Sed eu mi ut ligula mattis convallis. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Information List</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">blandit ex tincidunt sed. Sed eu mi ut ligula mattis convallis. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Documentation</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">blandit ex tincidunt sed. Sed eu mi ut ligula mattis convallis. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Visa applications, Skilled Worker visas, spouse visas, British citizenship, indefinite leave to remain, and appeals.',
            'featured_image' => 'visa-application-composition-with-american-flag-2.png',
        ],
        [
            'title'          => 'Real Estate Law',
            'content'        => '<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">Purchasing or selling property can be one of life&#8217;s biggest investments.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Tailored Property Advice</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Every property transaction is different. We provide bespoke legal guidance for homebuyers, landlords, developers, investors, and businesses, helping you make informed decisions with confidence.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Seamless Process</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Our team manages every legal aspect of your transaction, including property searches, contracts, mortgage requirements, and completion, while keeping you updated throughout the process.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Property Expertise</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">From first-time purchases and leasehold properties to commercial acquisitions and portfolio management, we deliver practical legal solutions tailored to your property goals.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Funding Solutions For Growing Businesses</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Residential Conveyancing</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We guide buyers and sellers through every stage of residential property transactions, ensuring contracts, searches, and completion are handled efficiently.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Commercial Property Transactions</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors advise businesses, landlords, and investors on acquisitions, disposals, leases, and commercial property agreements.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Lease &amp; Contract Review</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We carefully review leases, title documents, and contracts to identify legal risks before you commit to a property transaction.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Property Due Diligence</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our team investigates ownership, planning matters, rights of way, restrictive covenants, and other legal issues that may affect your investment.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-dacaebea wp-block-group-is-layout-constrained" style="padding-top:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With &nbsp;Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Whether purchasing your first home or expanding a commercial property portfolio, our real estate solicitors provide thorough legal advice that protects your investment.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Analysis Case</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We conduct comprehensive legal due diligence, reviewing property titles, planning permissions, local authority searches, and any legal restrictions before contracts are exchanged.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Information List</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors explain every stage of the conveyancing process, ensuring you understand your legal obligations, key deadlines, mortgage requirements, and transaction costs.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Documentation</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We prepare and review contracts, transfer deeds, lease agreements, mortgage documents, and Land Registry applications to ensure every legal requirement is completed accurately.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Buying, selling, leasing, or developing property involves significant financial and legal commitments.',
            'featured_image' => 'pexels-thirdman-7993898-scaled.jpg',
        ],
        [
            'title'          => 'Criminal Defence',
            'content'        => '<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">When facing criminal allegations, prompt legal advice can make a significant difference.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Tailored Defence Strategy</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Every criminal case is unique. We carefully assess the evidence, explain your legal options, and develop a defence strategy tailored to your individual circumstances and objectives.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Dedicated Representation</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">From police station interviews to court hearings, we provide consistent legal support, ensuring your rights are protected and your case is presented effectively.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Criminal Law Experience</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">We represent clients facing a wide range of offences, including assault, theft, fraud, drug offences, motoring offences, public order matters, and serious criminal allegations.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Funding Solutions For Growing Businesses</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Police Station Representation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We provide immediate legal advice during police interviews, ensuring your rights are protected before and during questioning.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Crown Court Defence</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors prepare and present strong legal arguments in both Magistrates&#8217; Court and Crown Court proceedings.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Investigation &amp; Evidence Review</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We carefully examine prosecution evidence, identify weaknesses, interview witnesses where appropriate, and build the strongest possible defence.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Sentencing Advice</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Whether challenging a conviction or seeking a fair sentence, we provide practical legal advice and representation throughout the appeals process.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-0ae01d90 wp-block-group-is-layout-constrained" style="padding-top:104px;padding-bottom:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With &nbsp;Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Facing criminal proceedings can be overwhelming, but you do not have to navigate the legal system alone.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Analysis Case</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We conduct a detailed review of police evidence, witness statements, CCTV footage, forensic reports, and disclosure documents to identify weaknesses in the prosecution&#8217;s case.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Information List</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Our team explains every stage of the criminal justice process, helping you understand interviews under caution, bail conditions, court procedures, potential outcomes, and your legal rights.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Documentation</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We prepare legal submissions, defence statements, witness evidence, appeal documents, court applications, and all supporting paperwork required throughout your case.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Being accused of a criminal offence can have serious consequences for your future, reputation, and freedom.',
            'featured_image' => 'pexels-ron-lach-10475170-2.png',
        ],
        [
            'title'          => 'Family Law',
            'content'        => '<p class="wp-block-hidden-desktop wp-block-hidden-mobile wp-block-hidden-tablet wp-block-paragraph">Our experienced family law solicitors provide practical, compassionate advice on divorce, child arrangements, financial settlements</p>

<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">Family disputes require legal advice that is both professional and understanding.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Family Law Advice</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Every family is different. We provide tailored legal guidance based on your unique circumstances, ensuring you receive practical advice that reflects your personal and financial priorities.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Supportive &amp; Efficient Process</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">We guide you through every stage of your matter with clear communication and timely updates, helping to reduce uncertainty and make the legal process as straightforward as possible.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Family Law Expertise</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Our solicitors advise on a wide range of family law matters, including divorce, financial settlements, child arrangements, cohabitation disputes, prenuptial agreements, and domestic abuse protection.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Funding Solutions For Growing Businesses</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Divorce &amp; Separation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We provide expert legal advice throughout the divorce process, helping clients resolve matters efficiently while protecting their legal and financial interests.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Child Arrangements</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors assist parents in reaching agreements regarding where children will live, contact arrangements, parental responsibility, and other child-related matters.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Financial Settlements</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We advise on the fair division of assets, pensions, property, maintenance, and other financial matters following separation or divorce.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Family Mediation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Where appropriate, we help clients resolve disputes through negotiation and mediation, preparing legally binding agreements that reduce the need for court proceedings.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-0ae01d90 wp-block-group-is-layout-constrained" style="padding-top:104px;padding-bottom:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With &nbsp;Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Family law decisions can have lasting effects on your future and the wellbeing of those closest to you.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Analysis Case</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We carefully assess your personal circumstances, financial position, and family arrangements to develop the most appropriate legal strategy for achieving a fair outcome.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Information List</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Our team explains every stage of the legal process, including divorce procedures, financial disclosure, child arrangements, mediation, and court proceedings, so you always understand your options.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Documentation</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We prepare divorce applications, financial consent orders, parenting agreements, court applications, settlement documents, and all supporting legal paperwork with accuracy and attention to detail.</p>
</div>
</div>
</div>
</div>

<p class="wp-block-paragraph"></p>',
            'excerpt'        => 'Supporting individuals and families through divorce, child arrangements, financial settlements, and mediation.',
            'featured_image' => 'young-happy-parents-enjoying-coloring-with-their-small-daughter-home-scaled.jpg',
        ],
        [
            'title'          => 'Divorce Separation',
            'content'        => '<p class="has-text-align-center wp-block-hidden-desktop wp-block-hidden-mobile wp-block-hidden-tablet wp-block-paragraph">Our experienced family law solicitors provide clear advice on divorce, separation, financial settlements, child arrangements</p>

<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">We take the time to understand your priorities and provide practical legal advice that protects your interests while reducing unnecessary conflict.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Family Law Advice</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Whether your case involves divorce, finances, or child arrangements, we develop a legal strategy suited to your circumstances and long-term goals.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Constructive Resolution</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">We encourage negotiation and mediation wherever possible, helping clients reach fair agreements without unnecessary court proceedings.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Court Representation</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">When litigation becomes necessary, our solicitors provide confident representation to protect your rights throughout the legal process.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Funding Solutions For Growing Businesses</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Initial Consultation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We discuss your circumstances, explain your legal options, and identify the best approach for your situation.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Review Your Situation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors assess financial matters, parenting arrangements, and legal documentation to prepare your case.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Negotiate Agreements</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We work toward fair settlements through negotiation or mediation whenever possible.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Court Representation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">If an agreement cannot be reached, we provide experienced representation throughout court proceedings.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-0ae01d90 wp-block-group-is-layout-constrained" style="padding-top:104px;padding-bottom:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With &nbsp;Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Our family law team offers practical legal guidance throughout every stage of separation, helping you make informed decisions for your future.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Analysis Case</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We advise on dividing assets, pensions, savings, investments, and property to achieve fair financial outcomes.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Information List</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors help parents reach practical agreements regarding living arrangements, contact, and parental responsibility.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Documentation</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We prepare and review consent orders, separation agreements, and other legal documents to protect your interests.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Helping clients achieve fair financial settlements, child arrangements, and practical solutions during divorce and separation.',
            'featured_image' => 'breakup-marriage-couple-with-divorce-certification-scaled.jpg',
        ],
        [
            'title'          => 'Child Custody',
            'content'        => '<p class="wp-block-paragraph">We assist parents with child arrangements, parental responsibility, residence, contact agreements, and court proceedings to help achieve practical and lasting solutions.</p>

<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">Child custody matters can be emotionally challenging and legally complex.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Child-Focused Advice</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">We provide clear legal guidance tailored to your family&#8217;s circumstances, ensuring every decision is made with your child&#8217;s best interests in mind.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Practical Solutions</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Whether through negotiation, mediation, or court proceedings, we help parents achieve workable and sustainable custody arrangements.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Legal Representation</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">If court action becomes necessary, we protect your parental rights while advocating for outcomes that support your child&#8217;s welfare.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Funding Solutions For Growing Businesses</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Initial Consultation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We listen carefully to your concerns, explain your legal position, and outline the best options available for your family.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Assess Your Situation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors review your family&#8217;s circumstances, existing arrangements, and any safeguarding concerns before developing a legal strategy.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Negotiate Agreements</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Whenever possible, we help parents reach mutually beneficial agreements through negotiation or mediation.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Court Representation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">If an agreement cannot be reached, we prepare your case thoroughly and represent you confidently throughout family court proceedings.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-0ae01d90 wp-block-group-is-layout-constrained" style="padding-top:104px;padding-bottom:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With &nbsp;Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Suspendisse turpis augue, aliquam eget ligula id, suscipit blandit magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Analysis Case</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We help establish fair living and visitation arrangements that support your child&#8217;s stability and wellbeing.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Information List</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Receive guidance on parental rights, responsibilities, education, healthcare decisions, and long-term parenting matters.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Documentation</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We prepare all required legal documents accurately and ensure your case is presented effectively before the court.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Expert legal advice on child arrangements, parental responsibility, residence, contact agreements, and court proceedings.',
            'featured_image' => 'parent-kid-talking-psychologist-scaled.jpg',
        ],
        [
            'title'          => 'Corporate Law',
            'content'        => '<p class="wp-block-paragraph">Helping startups, SMEs, and established businesses navigate complex legal matters with confidence.</p>

<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">Our corporate lawyers work closely with business owners, directors, and investors to deliver practical legal solutions that protect your interests and help your business succeed.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Tailored Business Advice</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Every business is different. We provide legal strategies tailored to your industry, business structure, and long-term objectives.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Efficient Legal Support</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">From drafting commercial contracts to resolving corporate disputes, we deliver responsive and practical legal advice that keeps your business moving forward.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Long-Term Business Partnership</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">We build lasting relationships with our clients, offering ongoing legal support as your business grows and evolves.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Funding Solutions For Growing Businesses</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Initial Consultation</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We discuss your business goals, legal concerns, and commercial objectives to understand your specific requirements.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Legal Assessment</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our solicitors review your company structure, contracts, and legal obligations to identify potential risks and opportunities.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Strategic Legal Solutions</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We prepare tailored agreements, negotiate transactions, and provide proactive advice to protect your business interests.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Ongoing Corporate Support</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">As your business grows, we continue providing legal guidance on compliance, governance, contracts, and future commercial opportunities.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-0ae01d90 wp-block-group-is-layout-constrained" style="padding-top:104px;padding-bottom:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With &nbsp;Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Our experienced corporate law team delivers comprehensive legal services designed to minimise risk, ensure compliance, and support long-term commercial success.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Commercial Contracts</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">We draft, review, and negotiate contracts that protect your business relationships while reducing legal and financial risks.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Corporate Governance</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Receive expert advice on directors&#8217; duties, shareholder rights, regulatory obligations, and company compliance.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Business Transactions</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Whether buying, selling, restructuring, or expanding your business, we provide strategic legal support throughout every stage of the transaction.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Legal support for startups, SMEs, and established businesses, including contracts, shareholder agreements, mergers, acquisitions',
            'featured_image' => 'lawyers-handshake-agreement-scaled.jpg',
        ],
        [
            'title'          => 'Cyber Law',
            'content'        => '<p class="wp-block-paragraph">In recent years, with the increasing reliance on digital technology, cybercrimes have become a growing concern for individuals and businesses alike.</p>

<div class="wp-block-group service-details-section1 has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-columns are-vertically-aligned-top is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-group service-detail-section1-stack is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left service-detail-section1-heading" style="padding-right:150px;font-weight:800;line-height:1.1">Lawyers Who Put You First</h2>

<p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5">Technology now underpins almost every business, making cyber security and legal compliance more important than ever.</p>
</div>

<div class="wp-block-group service-detail-section1-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Trusted Legal Support</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Cyber incidents can have significant financial, legal and reputational consequences. Our solicitors work alongside businesses</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Incident Response</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">We provide immediate legal guidance following cyber attacks, ransomware incidents, phishing attacks and data breaches, helping clients manage legal obligations from the outset.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Regulatory Compliance</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Our solicitors advise businesses on UK GDPR, Data Protection Act 2018, NIS Regulations and other cyber security obligations to reduce legal and regulatory risk.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color wp-elements-4270ad6594d4e62a0051fc51f86fd3c3 is-layout-flow wp-container-core-column-is-layout-201491d3 wp-block-column-is-layout-flow" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-cover service-detail-cover-img" style="min-height:546px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1154" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:62px;padding-bottom:62px"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-ae4b21d7 wp-block-cover-is-layout-constrained">
<div class="wp-block-group is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-f9faaab3 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Our Cyber Law Advisory Process</h2>
</div>

<div class="wp-block-group alignwide service-detail-section2-grid is-layout-grid wp-container-core-group-is-layout-cb66d748 wp-block-group-is-layout-grid">
<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1162" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-1.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-5.png" alt="" class="wp-image-1164"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Initial Risk Assessment</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We review your circumstances, identify immediate legal risks, and advise on urgent actions following a cyber incident or compliance concern.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1178 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-2.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-6.png" alt="" class="wp-image-1179"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Evidence Review</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Our team works alongside technical experts to assess available evidence, determine legal obligations, and establish an effective response strategy.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1180 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-3.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-7.png" alt="" class="wp-image-1181"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Legal Advice</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">We advise on notification requirements, regulatory reporting, contractual obligations, and communication with affected customers, employees or third parties.</p>
</div>
</div>
</div>

<div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background is-layout-flex wp-container-core-columns-is-layout-04af03da wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px;aspect-ratio:unset;"><img decoding="async" class="wp-block-cover__image-background wp-image-1183 size-full" alt="" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Mask-group-4.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>

<div class="wp-block-column is-vertically-aligned-center service-detail-section2-column is-layout-flow wp-block-column-is-layout-flow">
<figure class="wp-block-image size-full service-detail-section2-icon"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-8.png" alt="" class="wp-image-1184"/></figure>

<div class="wp-block-group service-detail-section2-grid-stack is-vertical is-layout-flex wp-container-core-group-is-layout-e17ee9dd wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left service-detail-section2-subtitle" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.2">Incident Resolution</h2>

<p class="service-detail-section2-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph">Whether negotiating with regulators, managing legal claims or responding to cybercrime investigations, we provide ongoing legal support until the matter is resolved.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-buttons alignwide is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-3e41869c wp-block-buttons-is-layout-flex">
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="/contact" style="padding-top:14px;padding-right:50px;padding-bottom:14px;padding-left:50px;font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔ </a></div>
</div>
</div></div>

<div class="wp-block-group alignwide service-detail-section3 has-global-padding is-layout-constrained wp-container-core-group-is-layout-0ae01d90 wp-block-group-is-layout-constrained" style="padding-top:104px;padding-bottom:104px">
<div class="wp-block-group service-detail-section3-stack is-vertical is-content-justification-center is-layout-flex wp-container-core-group-is-layout-79cf0db0 wp-block-group-is-layout-flex">
<h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:300px;padding-left:300px;font-weight:800;line-height:1.1">Assets With &nbsp;Assurance Of Expert Guidance</h2>

<p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:250px;padding-left:250px;line-height:1.5">Our cyber law solicitors advise businesses, organisations and technology professionals on a wide range of cyber security and digital legal matters.</p>
</div>

<div class="wp-block-columns service-detail-section3-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2138.png" alt="" class="wp-image-1193"/></figure>

<h2 class="wp-block-heading has-text-align-left service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Data Breach</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Immediate legal support following personal data breaches, ransomware attacks, phishing incidents and unauthorised access, including notification obligations and regulatory advice.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2136.png" alt="" class="wp-image-1197"/></figure>

<h2 class="wp-block-heading has-text-align-left service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Data Protection</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Advice on UK GDPR, the Data Protection Act 2018, privacy policies, data processing agreements, international data transfers and organisational compliance programmes.</p>
</div>
</div>

<div class="wp-block-column service-detail-section3-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color is-vertical is-layout-flex wp-container-core-group-is-layout-4fb6e14a wp-block-group-is-layout-flex" style="border-width:1px;padding-top:50px;padding-right:8px;padding-bottom:34px;padding-left:30px">
<figure class="wp-block-image size-full service-detail-section3-icons"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2137.png" alt="" class="wp-image-1198"/></figure>

<h2 class="wp-block-heading has-text-align-left service-detail-section3-subtitle" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800">Cyber Security</h2>

<p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph">Guidance on cyber risk management, information security policies, supplier contracts, incident response planning, regulatory investigations and compliance with industry standards.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'In recent years, with the increasing reliance on digital technology, cybercrimes have become a growing concern for individuals and businesses alike.',
            'featured_image' => 'business-corporate-protection-safety-security-concept-scaled.jpg',
        ],
];
    foreach ($areas as $index => $area) {
        $image = $area['featured_image'] ?? '';
        unset($area['featured_image']);
        $post_id = wp_insert_post([
            'post_title'=>$area['title'],'post_name'=>sanitize_title($area['title']),
            'post_content'=>$area['content'],'post_excerpt'=>$area['excerpt'],
            'post_type'=>'practice-area','post_status'=>'publish','menu_order'=>$index,
        ]);
        if ($post_id && !is_wp_error($post_id) && $image) lawfirmpro_set_featured_image($post_id, $image);
    }
}

function lawfirmpro_import_attorneys()
{
    $existing = get_posts(['post_type'=>'attorney','posts_per_page'=>1,'post_status'=>'publish','fields'=>'ids']);
    if (!empty($existing)) return;
    $attorneys = [
        [
            'title'          => 'James Thornton',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">James Thornton</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Employment Lawyer </p></div>

<p class="wp-block-paragraph">James Carter advises businesses, company directors, investors and private individuals on a broad range of commercial and corporate legal matters. His practice focuses on helping clients minimise legal risk, resolve disputes efficiently and make confident business decisions backed by sound legal advice.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:18px;padding-bottom:18px;line-height:1.5">Known for his approachable manner and attention to detail, James believes every client deserves clear communication, honest advice and legal strategies tailored to their specific objectives. Whether negotiating commercial agreements or representing clients in litigation, he is committed to achieving practical and commercially beneficial outcomes.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#746459"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">1999–2006</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Kings College (1999-2002)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">James completed his Bachelor of Laws degree, developing expertise in commercial law, contract law, company law and dispute resolution while participating in legal advocacy and mooting competitions.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">International Association (2002-2003)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Following his law degree, James completed the Legal Practice Course, receiving practical legal training in commercial transactions, litigation, business law and professional ethics before qualifying as a solicitor.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Alpe Adria (2003-2006)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Throughout the early years of her legal career, james regularly completed accredited Continuing Professional Development programmes covering employment legislation, commercial dispute resolution, mediation, data protection, and corporate governance. This ongoing professional training ensures her legal advice remains current with the evolving UK legal landscape.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-8a28fa10d22d8f7e5a7ca23eae7f3ab8 is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2004-2024</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Associate Solicitor (2004–2009)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">James advised businesses and private clients on commercial contracts, civil disputes and employment matters while gaining extensive experience in litigation and negotiation.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Sterling Legal LLP (2009–2016)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">He expanded his commercial practice, representing SMEs, corporate clients and directors in shareholder disputes, business acquisitions, contractual negotiations and regulatory compliance matters.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Aldervox Law Firm (2016–Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">James now leads the firm&#8217;s Commercial and Corporate Law practice, advising clients across the UK on complex legal matters including commercial litigation.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Employment Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group.png',
        ],
        [
            'title'          => 'Sarah Mitchell',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">Sarah Mitchell</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Commercial Lawyer </p></div>

<p class="wp-block-paragraph">Sarah Mitchell is a Senior Solicitor at Aldervox Law Firm, advising clients across a broad range of employment, commercial and dispute resolution matters. She works closely with business owners, company directors, HR professionals and private individuals, providing practical legal solutions that protect their interests while minimising legal and commercial risk.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Known for her approachable manner and meticulous attention to detail, Sarah Mitchell takes the time to understand each client&#8217;s objectives before developing clear legal strategies tailored to their circumstances. Whether negotiating a settlement, advising on regulatory compliance or representing clients in litigation, she is committed to delivering exceptional legal service from instruction to resolution.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover is-light team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#878283"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-1.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-1.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-1-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">1991-2012</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">King&#8217;s College London (LLB Law), (1998–2001)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Sarah completed her Bachelor of Laws (LLB) at King&#8217;s College London, where she developed a strong foundation in constitutional law, contract law, commercial law and civil litigation.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">The University of Law, London (2001–2002)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Following her undergraduate degree, Sarah successfully completed the Legal Practice Course (LPC), focusing on employment law, commercial litigation, corporate transactions and professional ethics.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Professional Development (2003–2012)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Throughout the early years of her legal career, Sarah regularly completed accredited Continuing Professional Development programmes covering employment legislation, commercial dispute resolution.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-79891e6d0b931a545cd5ed286e4d9b78 is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2013-2020</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Associate Solicitor, Pierce Solicitors (2013–2015)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Sarah began her post-qualification career advising employers, SMEs and private individuals on employment disputes, commercial contracts and civil litigation.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Senior Associate Solicitor (2015–2019)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">After joining Bennett Legal LLP, Sarah expanded her practice to include shareholder disputes, commercial litigation, regulatory compliance and business advisory services.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Senior Solicitor, Aldervox Law Firm (2019–Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">As a Senior Solicitor, Sarah leads the firm&#8217;s Employment and Commercial Law practice, advising businesses, organisations and individuals across the UK.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Commercial Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-1.png',
        ],
        [
            'title'          => 'Daniel Cooper',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">Daniel Cooper</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Criminal Lawyer </p></div>

<p class="wp-block-paragraph">Daniel has built his reputation by providing clear, honest legal advice that helps clients navigate complex legal matters with confidence. He understands that legal issues often arise during significant moments in people’s lives, whether involving family relationships, property, inheritance or commercial disputes.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:18px;padding-bottom:18px;line-height:1.5">By taking the time to understand every client&#8217;s objectives, Daniel develops practical legal strategies focused on achieving the best possible outcome while reducing unnecessary stress and expense. His approachable manner and attention to detail have made him a trusted adviser to clients throughout the UK.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#675a51"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-2.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-2.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-2-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">1990-2002</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">The University of Law, London (1990-1992)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Donec molestie nunc eget ex tempus fermentum et a libero. Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">King&#8217;s College London (1992-1996)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Daniel graduated with honours, specialising in contract law, equity, trusts and civil litigation while actively participating in legal advocacy and mooting competitions.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Professional Qualification (1996-2002)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Donec molestie nunc eget ex tempus fermentum et a libero. Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-b283614b338a8dc5672ec754dc5b8818 is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2003-2012</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Hamilton Legal Services (2003-2006)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Daniel advised clients on family law matters, civil disputes and private client work, gaining valuable courtroom experience while building a strong reputation for client care.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Westbridge Solicitors LLP (2006-2012)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">He expanded his practice to include complex divorce proceedings, estate administration, inheritance disputes and high-value civil litigation while supervising junior solicitors.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Aldervox Law Firm (2012-Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">As a Partner, Daniel leads the firm&#8217;s Family and Private Client departments, advising individuals, families and business owners across the UK.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Criminal Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-2.png',
        ],
        [
            'title'          => 'William Harrison',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">William Harrison</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Managing Partner </p></div>

<p class="wp-block-paragraph">William Harrison is a Partner at Aldervox Law Firm with more than 20 years of experience advising individuals, families, and businesses across England and Wales. He specialises in Family Law, Private Client services, Civil Litigation, and Alternative Dispute Resolution, providing practical legal solutions tailored to each client&#8217;s individual circumstances.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:18px;padding-bottom:18px;line-height:1.5">Throughout his career, William has successfully represented clients in complex divorce proceedings, financial settlements, inheritance disputes, probate matters, and civil litigation. He is recognised for his strategic approach, meticulous preparation, and ability to resolve disputes efficiently through negotiation, mediation, or court proceedings where necessary.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">In addition to advising clients, William mentors junior solicitors within the firm and actively participates in continuing professional development to remain up to date with changes in UK legislation and legal practice. His professionalism, integrity, and client-focused approach have established him as a trusted legal adviser and a respected member of the legal profession.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#746b60"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-1-2.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-1-2.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-1-2-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">1990-2006</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Continuing Professional Development &amp; Specialist (1990–1993)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Throughout the early stages of his legal career, Daniel completed extensive Continuing Professional Development (CPD) in family law, private client services, mediation and civil litigation.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">The University of Law, London (Legal Practice Course), (1993–1994)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Following his law degree, Daniel successfully completed the Legal Practice Course (LPC), receiving practical training in litigation, family law, commercial law.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">King&#8217;s College London (LLB (Hons) Law), (1994–2006)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Daniel completed his Bachelor of Laws (LLB) at King&#8217;s College London, where he developed a strong academic foundation in contract law, tort.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-7c2c921bf6986ebc7846c550cc218bfb is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2006-2020</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Associate Solicitor, Hamilton &amp; Co. Solicitors (2006–2008)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Daniel began his legal career advising private individuals on family law, wills and probate, and civil disputes. He quickly established a reputation for delivering practical legal advice.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Senior Associate Solicitor, Westbridge Legal LLP (2008–2012)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">As a Senior Associate, Daniel managed a diverse caseload involving divorce proceedings, financial settlements, inheritance disputes and civil litigation.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Partner, Aldervox Law Firm (2012–Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Daniel now serves as a Partner at Aldervox Law Firm, leading the Family Law and Private Client departments. He advises individuals, families and business owners across the UK.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Managing Partner',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-1-2.png',
        ],
        [
            'title'          => 'Oliver Bennett',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">Oliver Bennett</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Senior Lawyer </p></div>

<p class="wp-block-paragraph">Oliver Bennett is a Senior Solicitor at Aldervox Law Firm with over 20 years of experience advising individuals, businesses, and organisations across a broad range of legal matters. Renowned for his strategic thinking and client-focused approach, Oliver provides practical legal solutions tailored to each client&#8217;s unique circumstances. He is committed to delivering clear advice, strong representation, and positive outcomes in both complex disputes and everyday legal matters.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:18px;padding-bottom:18px;line-height:1.5">Throughout his career, Oliver has successfully represented clients in commercial litigation, corporate advisory work, property disputes, employment law, and civil matters. His attention to detail, thorough preparation, and dedication to achieving the best possible results have earned him the trust of clients and colleagues alike.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Oliver believes that effective legal representation begins with understanding each client&#8217;s goals. He works collaboratively to develop practical strategies that minimise legal risk while protecting long-term interests, ensuring every client receives professional, transparent, and reliable legal support.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#76665e"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-4.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-4.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-4-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">1991-2005</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">King&#8217;s College London (1991–2001)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Bachelor of Laws (LLB), graduating with honours while developing a strong foundation in commercial, civil, and constitutional law.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Legal Practice Course (2001–2003)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Completed professional legal training with a focus on litigation, advocacy, business law, and client care.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Solicitor Qualification (2003-2005)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Qualified as a Solicitor in England and Wales and began practising in commercial and civil litigation.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-d32c186eeda0bbfdee002ed8a0275a5f is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2005-2018</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Associate Solicitor (2005–2006)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Represented private clients and businesses in commercial disputes, employment matters, and property litigation while building a strong reputation for practical legal advice.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Senior Associate (2006–2010)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Led complex litigation cases, advised corporate clients on contractual and regulatory matters, and mentored junior solicitors within the firm.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5"></p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Aldervox Law Firm (2010–Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Provides strategic legal advice across commercial, corporate, employment, and civil law while leading significant client matters and supporting business growth through proactive legal solutions.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Senior Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-4.png',
        ],
        [
            'title'          => 'Elis Davies',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">Elis Davies</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Family Lawyer </p></div>

<p class="wp-block-paragraph">Elis Davies is a compassionate family lawyer dedicated to helping individuals and families navigate some of life&#8217;s most sensitive legal matters. With extensive experience in divorce, child custody, financial settlements, and mediation, she provides practical advice and strong representation while prioritizing the well-being of every client and their family.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:18px;padding-bottom:18px;line-height:1.5">She understands that family disputes can be emotionally challenging and works closely with clients to achieve fair, constructive, and lasting solutions. Whether negotiating agreements or representing clients in court, Elis combines legal expertise with empathy to protect her clients&#8217; interests.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Known for her calm approach and clear communication, Elis is committed to reducing conflict wherever possible while ensuring every client receives confident legal guidance tailored to their circumstances.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover is-light team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#9c9992"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-2-1.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-2-1.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-2-1-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">1998-2006</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Bachelor of Laws (LLB), (1998-2001)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Built a strong academic foundation in family law, civil litigation, and legal ethics while graduating with distinction.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Legal Practice Course (LPC), (2001-2004)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Donec molestie nunc eget ex tempus fermentum et a libero. Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Family Mediation Council (2004-2006)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Received specialist accreditation in mediation, helping families resolve disputes through constructive negotiation rather than lengthy court proceedings.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-81b18e7279845117a8236913561956dd is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2006-2020</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Senior Family Solicitor (2006-2008)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Managed complex family law cases involving high-value assets, child arrangements, domestic abuse protection orders, and mediation.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Head of Family Law (2008-2010)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Leads the firm&#8217;s family law department, advising clients on complex family matters and mentoring junior solicitors while promoting practical, client-focused legal solutions.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Corporate Law Partner (2012-Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Donec molestie nunc eget ex tempus fermentum et a libero. Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Family Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-2-1.png',
        ],
        [
            'title'          => 'Amelia Turner',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">Amelia Turner</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Employment Lawyer </p></div>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:18px;padding-bottom:18px;line-height:1.5">Amelia Turner is an experienced Employment Lawyer who advises both employers and employees on a broad range of workplace matters. She provides practical legal solutions for contracts, disciplinary procedures, discrimination claims, unfair dismissal, redundancy, and workplace negotiations.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Known for her approachable style and attention to detail, Amelia works closely with clients to understand their unique circumstances and develop strategies that minimize risk while protecting their legal interests. Whether resolving disputes through negotiation or representing clients in employment tribunals, she remains focused on achieving efficient and cost-effective outcomes.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#7f7b79"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-3-1.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-3-1.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-3-1-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2004-2012</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">King&#8217;s College London (2004–2007)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">LLB (Hons) in Law with a focus on Employment Law, Contract Law, and Commercial Litigation.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Legal Practice Course (2007–2008)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Completed professional legal training with distinction, specializing in workplace regulations and dispute resolution.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Continuing Professional Development (2008-2012)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Donec molestie nunc eget ex tempus fermentum et a libero. Curabitur ullamcorper lorem vitae viverra aliquet. Integer tincidunt nulla odio.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-5afde31ba21a022e3d0175b73552787e is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2012-2020</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Employment Law Associate (2012–2016)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Advised employees and businesses on workplace contracts, grievances, disciplinary actions, and redundancy processes.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Senior Employment Solicitor (2016–2018)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Represented clients in employment tribunals involving unfair dismissal, discrimination, whistleblowing, and breach of contract claims.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Employment Law Partner (2018–Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Leads the firm&#8217;s employment law practice, providing strategic legal advice to businesses, executives, HR professionals, and employees while overseeing complex workplace disputes and compliance matters.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Employment Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-3-1.png',
        ],
        [
            'title'          => 'James Carter',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">James Carter</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Property Lawyer </p></div>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:18px;padding-bottom:18px;line-height:1.5">James Carter is an experienced Property Lawyer specializing in residential and commercial real estate matters. He advises clients on property purchases, sales, lease agreements, land development, title investigations, and real estate transactions, ensuring every step is handled efficiently and in full compliance with legal requirements.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">With a detail-oriented and client-focused approach, James helps individuals, investors, landlords, and businesses navigate complex property matters while minimizing legal risks. He is committed to delivering practical advice, resolving disputes effectively, and ensuring smooth transactions from initial negotiations through to completion.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#655651"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-4-1.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-4-1.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-4-1-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">1998-2005</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">University of Bristol (1998–2000)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Bachelor of Laws (LLB) with a concentration in Property Law, Land Law, and Commercial Transactions.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Legal Practice Course (2000–2003)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Completed professional legal training with distinction, focusing on conveyancing, real estate finance, and commercial property law.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Professional Development (2003–2005)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Regularly attends legal seminars and certification programs covering property legislation, landlord and tenant law, construction regulations, and real estate compliance.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-2b98ebe121dc6fa8d1ebf11dfd20c631 is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2005-2009</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Property Law Associate (2005–2007)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Handled residential conveyancing, lease agreements, title investigations, and property documentation for individuals and developers.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Senior Property Solicitor (2007–2009)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Advised clients on commercial acquisitions, property financing, lease negotiations, development projects, and real estate dispute resolution.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Head of Property Law (2009–Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Leads the firm&#8217;s property law practice, representing homeowners, businesses, investors, and developers in high-value real estate transactions while providing strategic legal advice on property investments and regulatory compliance.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Property Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-4-1.png',
        ],
        [
            'title'          => 'Daniel Foster',
            'content'        => '<div class="wp-block-group team-details-main has-global-padding is-content-justification-center is-layout-constrained wp-block-group-is-layout-constrained">
<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-90d47178 wp-block-columns-is-layout-flex" style="padding-top:90px;padding-bottom:90px">
<div class="wp-block-column team-details-content is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
<div class="wp-block-group team-details-stack is-vertical is-layout-flex wp-container-core-group-is-layout-5731f301 wp-block-group-is-layout-flex" style="padding-right:80px"><h2 style="font-size:clamp(27.894px, 1.743rem + ((1vw - 3.2px) * 2.094), 48px);font-style:normal;font-weight:800;line-height:1.1;letter-spacing:0%" class="team-details-heading wp-block-post-title has-plus-jakarta-sans-font-family">Daniel Foster</h2>

<div style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;line-height:1.5;letter-spacing:0%" class="has-link-color team-details-paragraph wp-elements-7776c1f633f8be4c4afb11e17cf131e8 wp-block-post-excerpt has-text-color has-accent-color has-plus-jakarta-sans-font-family"><p class="wp-block-post-excerpt__excerpt">Commercial Lawyer </p></div>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:18px;padding-bottom:18px;line-height:1.5">Daniel Foster is a skilled Commercial Lawyer with extensive experience advising businesses of all sizes on commercial transactions, contract negotiations, corporate governance, and regulatory compliance. He works closely with entrepreneurs, established companies, and investors to provide practical legal solutions that support long-term business success.</p>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Daniel is known for his strategic thinking and commercially focused advice. Whether drafting complex agreements, managing business acquisitions, resolving contractual disputes, or advising on corporate restructuring, he helps clients navigate legal challenges with confidence while minimizing commercial risk.</p>
</div>

<div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color is-layout-grid wp-container-core-group-is-layout-0e2a2dd6 wp-block-group-is-layout-grid" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px">
<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full is-style-default team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2354.png" alt="" class="wp-image-2036"/></figure>

<p><a href="tel:(44) 7956 8221">(44) 7956 8221</a></p>
</div>

<div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-98ecbd7a wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700">
<figure class="wp-block-image size-full team-details-grid-image wp-container-content-1d651e7a"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-2355.png" alt="" class="wp-image-2037"/></figure>

<p><a href="mailto:info@aldervox.uk">info@aldervox.uk</a></p>
</div>

<ul class="wp-block-social-links has-icon-color is-style-logos-only team-details-social-icons is-content-justification-center is-layout-flex wp-container-core-social-links-is-layout-4439efcd wp-block-social-links-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><li style="color:#464646" class="wp-social-link wp-social-link-facebook has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Facebook</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-twitter has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg><span class="wp-block-social-link-label screen-reader-text">Twitter</span></a></li>

<li style="color:#464646" class="wp-social-link wp-social-link-linkedin has-custom-464646-color wp-block-social-link"><a href="https://www.facebook.com/" class="wp-block-social-link-anchor"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg><span class="wp-block-social-link-label screen-reader-text">LinkedIn</span></a></li></ul>
</div>
</div>

<div class="wp-block-column team-details-image is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-cover is-light team-details-post-image" style="min-height:565px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#909090"></span><img loading="lazy" decoding="async" width="389" height="447" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-6.png" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" srcset="https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-6.png 389w, https://lightseagreen-quail-608189.hostingersite.com/wp-content/uploads/2026/07/Mask-group-6-261x300.png 261w" sizes="auto, (max-width: 389px) 100vw, 389px" /><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained">
<p class="has-text-align-center wp-block-paragraph"></p>
</div></div>
</div>
</div>
</div>

<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:120px;padding-right:var(--wp--preset--spacing--0);padding-bottom:120px;padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-74f190e3 wp-block-cover-is-layout-constrained">
<div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background is-layout-flex wp-container-core-columns-is-layout-3abd0b4a wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2006-2012</p>

<h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1">Education</h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">University of Warwick (2006–2009)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Bachelor of Laws (LLB) with a specialization in Commercial Law, Corporate Governance, and Business Transactions.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Legal Practice Course (2009–2010)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Completed advanced legal training focusing on commercial contracts, mergers and acquisitions, and corporate advisory services.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Professional Development (2009–2012)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Regularly participates in continuing legal education programs covering commercial regulations, international trade, corporate compliance, and business risk management.</p>
</div>
</div>
</div>
</div>

<div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-dc1a737b204ae6b2e552bbc74521f5fd is-layout-flow wp-block-column-is-layout-flow" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-54c20102 wp-block-group-is-layout-flex">
<p class="team-details-paragraph has-custom-464646-color has-text-color has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">2012-2018</p>

<h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong>Career</strong></h2>
</div>

<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow" style="margin-top:39px">
<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Commercial Law Associate (2012–2014)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Advised businesses on commercial agreements, contract drafting, supplier negotiations, and regulatory compliance across multiple industries.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Senior Commercial Solicitor (2014–2018)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Managed complex commercial transactions, business acquisitions, shareholder agreements, and corporate restructuring while representing clients in contract negotiations and dispute resolution.</p>
</div>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-3eb4cbb0 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized team-detail-right-image wp-duotone-midnight-glow" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/Group-4.png" alt="" class="wp-image-1140" style="object-fit:cover;width:20px;height:20px"/></figure>

<div class="wp-block-group is-vertical is-nowrap is-layout-flex wp-container-core-group-is-layout-8f06c33c wp-block-group-is-layout-flex" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">
<h2 class="wp-block-heading has-text-align-left team-details-paragraph has-secondary-color has-text-color" style="font-size:clamp(15.747px, 0.984rem + ((1vw - 3.2px) * 0.86), 24px);font-weight:800;line-height:1.3">Commercial Law (2018–Present)</h2>

<p class="team-details-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="margin-right:20px;line-height:1.5">Leads the firm&#8217;s commercial law practice, advising domestic and international businesses on strategic transactions, governance, risk management, and long-term commercial growth initiatives.</p>
</div>
</div>
</div>
</div>
</div>
</div></div>',
            'excerpt'        => 'Commercial Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-6.png',
        ],
];
    foreach ($attorneys as $index => $attorney) {
        $image = $attorney['featured_image'] ?? '';
        unset($attorney['featured_image']);
        $post_id = wp_insert_post([
            'post_title'=>$attorney['title'],'post_name'=>sanitize_title($attorney['title']),
            'post_content'=>$attorney['content'],'post_excerpt'=>$attorney['excerpt'],
            'post_type'=>'attorney','post_status'=>'publish','menu_order'=>$index,
        ]);
        if ($post_id && !is_wp_error($post_id)) {
            if (!empty($attorney['facebook'])) update_post_meta($post_id,'_attorney_facebook',esc_url_raw($attorney['facebook']));
            if (!empty($attorney['twitter'])) update_post_meta($post_id,'_attorney_twitter',esc_url_raw($attorney['twitter']));
            if (!empty($attorney['linkedin'])) update_post_meta($post_id,'_attorney_linkedin',esc_url_raw($attorney['linkedin']));
            if ($image) lawfirmpro_set_featured_image($post_id, $image);
        }
    }
}

function lawfirmpro_import_testimonials()
{
    $existing = get_posts(['post_type'=>'testimonial','posts_per_page'=>1,'post_status'=>'publish','fields'=>'ids']);
    if (!empty($existing)) return;
    $testimonials = [
        ['title'=>'Emma Richardson','content'=>'<p>The team explained every step clearly and made a stressful legal matter much easier to manage. Their professionalism and communication were outstanding.</p>','location'=>'','rating'=>5,'featured_image'=>'ratings-icon.png'],
        ['title'=>'Michael Evans','content'=>'<p>I received excellent advice during my property dispute. The solicitors were responsive, knowledgeable, and achieved a better outcome than I expected.</p>','location'=>'','rating'=>5],
        ['title'=>'Olivia Harris','content'=>'<p>We instructed the firm for our immigration application, and everything was handled efficiently. Highly recommended.</p>','location'=>'London','rating'=>5],
    ];
    foreach ($testimonials as $index => $testimonial) {
        $image = $testimonial['featured_image'] ?? '';
        unset($testimonial['featured_image']);
        $post_id = wp_insert_post(['post_title'=>$testimonial['title'],'post_name'=>sanitize_title($testimonial['title']),'post_content'=>$testimonial['content'],'post_type'=>'testimonial','post_status'=>'publish','menu_order'=>$index]);
        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id,'_testimonial_location',$testimonial['location']);
            update_post_meta($post_id,'_testimonial_rating',$testimonial['rating']);
            if ($image) lawfirmpro_set_featured_image($post_id, $image);
        }
    }
}

function lawfirmpro_import_faqs()
{
    $existing = get_posts(['post_type'=>'faq','posts_per_page'=>1,'post_status'=>'publish','fields'=>'ids']);
    if (!empty($existing)) return;
    $faqs = [
        ['title'=>'How much does an initial consultation cost?','content'=>'<p>We offer fixed-fee initial consultations for many legal services. The fee depends on the type and complexity of your matter.</p>'],
        ['title'=>'Do you offer fixed-fee legal services?','content'=>'<p>Yes. Many of our services are available with transparent fixed pricing, so you know exactly what to expect.</p>'],
        ['title'=>'Can you represent me anywhere in the UK?','content'=>'<p>Yes. We represent clients throughout England and Wales, with many consultations conducted remotely by phone or video call.</p>'],
        ['title'=>'How quickly can I speak to a solicitor?','content'=>'<p>In most cases, we can arrange a consultation within one business day. Urgent criminal defence matters are available 24/7.</p>'],
        ['title'=>'What documents should I bring?','content'=>'<p>Bring any correspondence, contracts, identification, court documents, or other paperwork related to your legal issue.</p>'],
    ];
    foreach ($faqs as $index => $faq) {
        wp_insert_post(['post_title'=>$faq['title'],'post_name'=>sanitize_title($faq['title']),'post_content'=>$faq['content'],'post_type'=>'faq','post_status'=>'publish','menu_order'=>$index]);
    }
}

function lawfirmpro_import_articles()
{
    $existing = get_posts(['post_type'=>'article','posts_per_page'=>1,'post_status'=>'publish','fields'=>'ids']);
    if (!empty($existing)) return;
    $articles = [
        [
            'title'          => 'Understanding the UK Divorce Process in 2026',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Divorce is one of life&#8217;s most significant legal decisions, and understanding the process before taking action can help reduce uncertainty and unnecessary stress. Although the introduction of no-fault divorce has simplified proceedings in England and Wales, important decisions still need to be made regarding finances, property, pensions and arrangements for children.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">How Legal Changes Impact Your Case</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">The UK&#8217;s no-fault divorce legislation has changed the way marriages are legally dissolved, making the process less confrontational while encouraging constructive resolutions.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-4ec84574a89993ec5fb57f23a7efd531">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-495c4b53f5bc8410026b968e15e426a6" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> No requirement to prove fault or unreasonable behaviour</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-fcb90bd25bb227a9db5b9148abc2ba67" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Sole and joint divorce applications available</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-e4bdeb4ba7a8837f52ec9e44688a0942" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Mandatory reflection period before finalising divorce</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-20c9190631f4234181cd303f7e624a47">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-4f9345350dd7480fb3021db308a0e03b" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Financial matters remain separate from divorce proceedings</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-4ddfebf6ad5b1fa858e96a7017cdfcf3" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Child arrangements should prioritise the child&#8217;s welfare</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-a33f6b180c62489c9ef78502d4dd15cd" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Court-approved financial agreements provide greater legal certainty</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Committed to Justice and Client Success</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Every family situation is different, which is why tailored legal advice is essential. Our family law solicitors work closely with clients to resolve disputes efficiently while protecting their financial security, parental rights and future wellbeing.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-872289bada21b17d6d9e17c993ae5838 is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“Effective family law is not about creating conflict-it&#8217;s about protecting your future, preserving what matters most, and helping you move forward with confidence.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">How to Prepare for Your First Court Appearance</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Attending court for the first time can feel overwhelming. Learn what documents you&#8217;ll need, what to expect during the hearing and how proper preparation can help you present your case effectively.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">What to Expect During a Personal Injury Claim</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Understand how property, pensions, savings and other assets are considered during divorce proceedings, and discover why obtaining legal advice can help secure a fair financial settlement for your future.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Everything you need to know about timelines, finances, and child arrangements.',
            'date'           => '2026-07-09',
            'featured_image' => 'article-img-1.png',
        ],
        [
            'title'          => 'First-Time Home Buyers: Legal Checklist Before Completion',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Purchasing your first property involves far more than securing a mortgage and signing contracts. Before completion, it&#8217;s important to ensure that all legal checks have been carried out to protect your investment and avoid unexpected issues after you move in. From reviewing property searches and title documents to understanding your contractual obligations, obtaining professional legal advice can help make the transaction smoother, reduce unnecessary risks, and give you confidence throughout the conveyancing process.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">How Legal Changes Impact Your Case</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">A thorough legal review helps identify potential problems before completion, allowing buyers to make informed decisions and avoid costly surprises.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-9c772c44ffa342d675f73cdf787d1558">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-2b6cb969ee4fcb4c2ea0ea97c6f40c9e" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Verify legal ownership and property title</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-e353b404b3f6d51c19e936ffb4bab738" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Review local authority, drainage and environmental searches</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-722630f8240c84d46c3acf72aea1b754" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Check planning permissions and building regulations</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-c4ca8f495ed0bdd74c54d51b62f17e62">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-a6344cad3d35806b513ffe9b9816da46" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Identify restrictive covenants or rights of way</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-1eedaf22798c0dc0e868ed80dd92ebf1" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Confirm mortgage conditions have been satisfied</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-c102b315de700b7ca1d2b7aeef7de153" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Ensure completion documents are accurate and legally binding</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Protecting Your Investment with Expert Legal Advice</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Buying your first home is one of the largest financial commitments you&#8217;ll ever make. Our experienced property solicitors guide first-time buyers through every stage of the conveyancing process, providing clear legal advice, reviewing documentation thoroughly, and ensuring your interests remain protected from instruction through to completion.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-8f6a5fecac94ec5d2f94b3a7dd23ec40 is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“Buying your first home isn&#8217;t just about receiving the keys-it&#8217;s about ensuring every legal detail has been carefully reviewed to protect your investment for years to come.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Understanding Property Searches: What Every Home Buyer Should Know</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Learn why local authority, environmental and drainage searches are an essential part of the conveyancing process and how they can reveal issues that may affect your property purchase.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Common Conveyancing Delays and How to Avoid Them</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Delays can occur for many reasons during a property transaction. Discover the most common causes and practical steps buyers can take to keep their purchase progressing smoothly.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Key legal checks every property buyer should understand.',
            'date'           => '2026-07-09',
            'featured_image' => 'article-img-2.png',
        ],
        [
            'title'          => 'Changes to UK Employment Law Every Employer Should Know',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Employment law continues to evolve, requiring employers to regularly review workplace policies, employment contracts and internal procedures. Failing to keep pace with legislative changes can expose businesses to costly disputes, regulatory action and reputational damage. Understanding the latest legal developments enables employers to maintain compliance, protect employee rights and create a fair, legally compliant working environment.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">How Employment Law Changes Affect Your Business</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">Changes to employment legislation can impact every stage of the employment relationship, from recruitment and contracts to disciplinary procedures and employee dismissal.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-fc827ff6948bff8922342b33aa508c82">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-d30750b7cba3732653d58138b0be65d1" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Review employment contracts and workplace policies regularly</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-31877076a38d24beb4544fe5b071aa91" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Ensure disciplinary and grievance procedures comply with current legislation</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-ee6136a1cd8498ceb0bbdc7334b759e7" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Understand changes affecting flexible working and employee rights</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-6eac2a22c1f7f85d9ad4e083fd3bba3b">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-b19fb30ad29e363e5650309eae4fbeda" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Maintain accurate employee records and documentation</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-b07078d3f1dfc21f47a19041468bb009" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Provide managers with up-to-date employment law training</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-88aadf14dba2b06d903ac1b710388343" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Seek legal advice before making significant employment decisions</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Supporting Employers Through Legal Change</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Our employment law solicitors advise businesses of all sizes on legislative updates, workplace compliance and employment disputes.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-84e4482a02c1a09b3a596ab1e30a3970 is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“Keeping your business compliant isn&#8217;t just about following the law-it&#8217;s about creating a fair workplace, protecting your organisation and building lasting employee trust.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Managing Workplace Disciplinary Procedures Fairly</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Learn the essential steps employers should follow when handling disciplinary matters to ensure fairness, consistency and compliance with UK employment law.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Redundancy Procedures: A Guide for UK Employers</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Understand your legal responsibilities when making redundancies, including consultation requirements, employee rights and best practices for reducing the risk of Employment Tribunal claims.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Recent legislation affecting businesses and employees.',
            'date'           => '2026-07-09',
            'featured_image' => 'article-img-3.png',
        ],
        [
            'title'          => 'Essential Legal Checks Before Buying a Business',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Buying an existing business can offer exciting opportunities, but it also comes with legal and financial responsibilities. Before signing any agreement, it is essential to conduct thorough legal due diligence to identify potential risks, liabilities and contractual obligations.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">How Legal Due Diligence Protects Your Investment</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">A comprehensive legal review enables buyers to assess the true value of a business while identifying potential legal, commercial and operational risks.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-fdc77b3273b64809d3fa001d3accc2cd">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-b65b3e5baedf184d428107a455862690" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Verify the business ownership and legal structure</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-4b884ce9a0e87154b0683bc50520624c" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Review existing commercial contracts and supplier agreements</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-52b9fb8395eca469d6c5e0126e81308a" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Identify outstanding debts, liabilities and ongoing disputes</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-bef52ce11588cabcf1b406482990bf16">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-81dbcf30b66ad8b1a35cc508a0d92c3c" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Assess employment contracts and staff obligations</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-679095059b3f17d45fd01c209fddd46f" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Confirm regulatory licences, permits and legal compliance</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-f830c71952b10ad190e6df9809ace04a" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Negotiate warranties, indemnities and purchase terms</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Supporting Business Buyers with Confidence</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Acquiring a business is one of the most important commercial decisions you can make. Our commercial law solicitors guide buyers through every stage of the acquisition process, providing practical legal advice, conducting detailed due diligence and negotiating robust agreements that safeguard your investment and support long-term success.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-e211515e6b1f192889dd669b158fb42d is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“Successful business acquisitions begin with thorough legal due diligence-understanding the risks today helps protect your investment tomorrow.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Share Purchase vs Asset Purchase: Understanding the Difference</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Learn the key legal differences between purchasing company shares and buying business assets, and discover which option may be more appropriate for your commercial objectives.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Avoiding Common Mistakes During Business Acquisitions</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">From incomplete due diligence to poorly negotiated contracts, explore the most common pitfalls buyers face and how experienced legal advice can help avoid them.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Discover the legal due diligence every buyer should complete before purchasing or investing in a business.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-1-3.png',
        ],
        [
            'title'          => 'A First-Time Buyer’s Guide to Residential Conveyancing',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Residential conveyancing is the legal process of transferring ownership of a property from the seller to the buyer. While the process may seem straightforward, it involves detailed legal checks, contract reviews and communication between solicitors, mortgage lenders and other parties. Understanding each stage of the transaction can help first-time buyers avoid unnecessary delays, make informed decisions and complete their purchase with confidence.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">Understanding the Conveyancing Process</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">Conveyancing involves a series of important legal steps designed to ensure the property can be transferred safely and without unexpected legal issues.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-4db3bfcce745a9ecd0f40d06c9228248">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-5ec3074822c52975a969e33fc7fa6360" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Review the draft contract and property title</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-12d695a0b77191bbce2e410a942ae06d" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Carry out local authority and environmental searches</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-98b067f379de85e1dbe399c91ad38dcf" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Raise enquiries with the seller&#8217;s solicitor</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-9b3c1ce5b9e5a5e33ae7ad43b82e9f84">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-1eedaf22798c0dc0e868ed80dd92ebf1" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Confirm mortgage conditions have been satisfied</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-c4c0e37b22f6be6475c224efcb54371a" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Exchange contracts and agree a completion date</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-11fc4a16787a09054d4fc64ad82ce114" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Complete the purchase and register ownership with HM Land Registry</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Supporting Buyers Every Step of the Way</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Buying your first home can feel overwhelming, but experienced legal guidance makes the process significantly easier. Our conveyancing solicitors provide clear advice throughout every stage of the transaction, helping you understand legal documents, resolve issues quickly and complete your purchase as efficiently as possible while protecting your interests.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-d4a8e342c37ef5e5b3a37d544b385460 is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“A successful property purchase begins with careful legal preparation-understanding the conveyancing process today helps prevent costly problems tomorrow.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Understanding Property Searches Before You Buy</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Discover why local authority, environmental and drainage searches are essential during conveyancing and how they can identify legal issues that may affect your property purchase.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Exchange and Completion: What Every Buyer Should Expect</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Learn what happens when contracts are exchanged, what takes place on completion day, and the final legal steps before you receive the keys to your new home.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Understand the conveyancing process, legal searches, contracts, and what to expect before completing your property purchase.',
            'date'           => '2026-07-10',
            'featured_image' => '',
        ],
        [
            'title'          => 'Your Rights After Unfair Dismissal',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Losing your job unexpectedly can be both financially and emotionally challenging. However, not every dismissal is lawful. UK employment law provides important protections for employees who have been dismissed unfairly or without following the correct procedures. Understanding your legal rights and acting promptly can make a significant difference to the outcome of your claim.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">Understanding Your Rights After Dismissal</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">Employers must follow a fair and reasonable process before dismissing an employee. If the correct procedures are not followed.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-c87019ba301ba0d988db00fc4cb5db03">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-d72513f30a94b456212f0ad7c237456c" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Understand what qualifies as unfair dismissal</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-e37d148df423bcd9a5dd1f3760b730da" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Review your employment contract and dismissal procedure</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-de20befc9e46db05b2823bd45e1992c3" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Gather relevant evidence and employment records</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-965af7e970024dfbaf4a56d439858988">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-af201a88eb59cf74ffe40547bf8240db" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Follow your employer&#8217;s internal appeal process where appropriate</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-03414b5ea5b15090dd4679aadc0c76d5" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Be aware of Employment Tribunal time limits</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-6fb5c2d4cbada0c2b6cc4da4679b5448" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Seek specialist legal advice before pursuing a claim</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Protecting Employees Through Expert Legal Advice</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Our employment law solicitors provide clear, practical advice to employees facing unfair dismissal, workplace disputes and disciplinary action. We assess your circumstances, explain your legal rights and work to achieve the best possible outcome through negotiation.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-9de81fac946d066051c5f47aad786cab is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“Every employee deserves to be treated fairly. Understanding your legal rights is the first step towards protecting your career, reputation and future.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Understanding Workplace Grievance and Disciplinary Procedures</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Learn how employers should handle workplace grievances and disciplinary matters, and what employees can do if the correct procedures are not followed.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Constructive Dismissal: When Can You Make a Claim?</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Discover what constructive dismissal means under UK employment law and the circumstances in which an employee may be entitled to bring a legal claim after resigning.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Learn what qualifies as unfair dismissal, the steps to take, and how an employment solicitor can help protect your rights.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-2-2.png',
        ],
        [
            'title'          => 'Five Legal Mistakes Small Businesses Should Avoid',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Running a successful business requires more than delivering excellent products or services—it also means understanding your legal responsibilities. Many small businesses encounter avoidable legal issues because contracts are poorly drafted, compliance obligations are overlooked or employment matters are handled incorrectly.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">Common Legal Risks Every Business Should Understand</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">Many business disputes arise from issues that could have been prevented with proper planning and legal guidance.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-ee3d93a309e085cad45bd753cb9d7acb">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-c9f3c37ef0218d7880447ef537b8241b" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Use professionally drafted contracts for customers and suppliers</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-edc99ac0a265846b7aa82739c456b791" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Keep employment contracts and workplace policies up to date</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-ff02f7edc0054daf25652c696c3a1775" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Protect your trademarks, intellectual property and confidential information</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-b94cf95dfb4b8bab2d0ea668667b9935">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-239ebea20549c9e829aa7417a1064ae3" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Ensure compliance with data protection and privacy regulations</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-47294719eb7070513090017768f0b7b0" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Maintain accurate business records and regulatory filings</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-d3c2312fd6d334ab79605182d0654fd2" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Seek legal advice before entering significant commercial agreements</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Helping Businesses Stay Legally Protected</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Our commercial solicitors work closely with entrepreneurs, start-ups and established businesses to identify legal risks before they become costly disputes.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-9e00e3ec68a9975b647f853d8aa35b1a is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“The strongest businesses are built on sound legal foundations. Proactive legal advice today can prevent expensive disputes tomorrow.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Why Every Business Needs Well-Drafted Commercial Contracts</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Discover how professionally prepared contracts reduce disputes, clarify obligations and provide greater legal protection when doing business with customers, suppliers and partners.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Understanding Directors&#8217; Legal Responsibilities in the UK</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Learn about the key legal duties of company directors and the importance of good corporate governance to protect both your business and personal position.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Avoid costly legal issues by understanding contracts, compliance, employment obligations, and intellectual property protection.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-4-3.png',
        ],
        [
            'title'          => 'Why Every Family Should Have an Up-to-Date Will',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Creating a Will is one of the most important steps you can take to protect your family and ensure your estate is distributed according to your wishes. However, a Will should not remain unchanged throughout your lifetime. Major life events such as marriage, divorce, the birth of children, purchasing property or changes in financial circumstances may all require your Will to be reviewed.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">Why Keeping Your Will Updated Matters</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">An outdated Will may no longer reflect your personal or financial circumstances, potentially creating uncertainty for your beneficiaries.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-596a7fd64c6160ece7954d89e2414966">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-3659411a955cf380adf38f8e8612cebb" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Ensure your estate is distributed according to your current wishes</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-13df50f23928c2ccca6e4e305506f5ee" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Appoint suitable executors and guardians for minor children</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-1c906546f7cd702dca5485f0049ee631" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Reflect changes in family relationships and financial circumstances</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-d7709a08d98d187dfc4d23c968665581">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-94b65cef46a678fa810ee15e5c4a9332" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Reduce the likelihood of inheritance disputes</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-9f1a61efe672a29fcdf0eb5e8ece5e34" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Help minimise delays during the probate process</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-501f3aa8d39cb1991ee9b913ffa7f3fa" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Review your Will following major life events or legislative changes</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Protecting Your Family&#8217;s Future</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Our experienced Wills and Probate solicitors provide practical, straightforward advice to help individuals and families prepare legally valid Wills tailored to their circumstances.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-1d265a9d012171a1dc43c86956430241 is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“A carefully prepared Will is one of the greatest gifts you can leave your family-it provides clarity, security and peace of mind when they need it most.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Choosing the Right Executor for Your Will</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Understand the responsibilities of an executor, what qualities to look for and why selecting the right person is essential to administering your estate efficiently.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Estate Planning: Protecting Your Family&#8217;s Future</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Discover how effective estate planning, including Wills, trusts and inheritance tax planning, can help preserve your assets and provide long-term financial security for your loved ones.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Find out how a professionally drafted will can protect your loved ones and ensure your wishes are carried out.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-5-1.png',
        ],
        [
            'title'          => 'What to Do If You’re Asked to Attend a Police Interview',
            'content'        => '<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">A police interview is a formal part of a criminal investigation, and anything you say may be used as evidence. While cooperation is important, you are not expected to face questioning without understanding your rights. A solicitor can explain the allegations, advise whether to answer questions, and ensure the interview is conducted fairly.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">How Legal Advice Protects You During a Police Interview</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">Facing a police interview without preparation can expose you to unnecessary legal risks.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-1e7f5f0552fddad81c7b2b23191da021">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-585c7b39fa18468d1d25fa618ef4f862" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Understanding the allegations before questioning begins.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-0fd52e313880d44b6f52703d9d426cb6" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Receiving independent legal advice free of charge at the police station.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-bbabd5835a039b497f6e9872f30cb400" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Deciding whether to answer questions, provide a prepared statement</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-42f9c33b682d8bc441f44cee0731c058">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-f0058d46e074ec4f3f5c8950760d57ad" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Ensuring police procedures are followed correctly.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-8ca483d93825b85209749df95968fb29" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Protecting your legal rights throughout the investigation.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-243cf7e51dc7739b5267605b28ec3a81" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Preparing an effective defence if charges are brought.</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Committed to Protecting Your Rights</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Whether you are a suspect, witness, or attending a voluntary interview, our solicitors provide calm, practical legal advice from the outset.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-e54b72cd2c82061d84e03ce9e9c919c2 is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“The right legal advice before a police interview can protect your future. Never attend questioning without understanding your rights and the potential consequences.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">What Happens During a Police Interview?</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Police interviews usually begin with officers explaining the reason for the interview and cautioning the individual.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Your Right to Free Legal Representation</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Everyone interviewed by the police in England and Wales has the right to independent legal advice. Whether the interview is voluntary or follows an arrest.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Essential Legal Guidance Before Taking Action A police interview is a formal part of a criminal investigation, and anything you say may be used as evidence. While cooperation is important, you are not expected to face questioning without understanding your rights. A solicitor can explain the allegations, advise whether to answer questions, and ensure the […]',
            'date'           => '2026-07-10',
            'featured_image' => '',
        ],
        [
            'title'          => 'Child Arrangements After Separation Explained',
            'content'        => '<p class="wp-block-paragraph">Understand how UK courts determine child arrangements and what parents should know before making an application.</p>

<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">When parents separate, making arrangements for children is often the most important and emotional aspect of the process. While many families can agree on living arrangements and contact schedules independently, others require legal guidance to resolve disputes.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">How Legal Changes Impact Your Case</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">Family law focuses on ensuring that every decision made is in the best interests of the child.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-744913e3bc6d390c043e8683e8b4ee2a">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-a3ffa966a761238cc1bf7d3d465c5ec5" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Child welfare is always the court&#8217;s highest priority.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-819a85a357f0662c91d3fe91706a848b" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Parents are encouraged to resolve disputes through mediation.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-5018dddc883fa6f6b40e4e6fa5cf7a0f" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Child Arrangement Orders determine where a child lives and spends time.</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-ebb5074bedb7bad55ce08e92d6811b03">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-0fb290e7ae748ba11dda0018c113ba22" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> The child&#8217;s wishes may be considered depending on their age and maturity.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-ea97a6a8eef9abe2592ce892a1389338" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Courts assess each family&#8217;s circumstances individually.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-1b770b989cfdfb6c64007b697679776e" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Legal advice helps protect parental rights and avoid unnecessary conflict.</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Committed to Justice and Client Success</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">Our family law solicitors work with parents to achieve practical and compassionate solutions during child arrangement disputes.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-329fd777133a8d5c7e3e8ba0e25369b6 is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“The best child arrangement is one that provides stability, protects relationships, and always places the child&#8217;s wellbeing first.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">How to Prepare for Your First Family Court Hearing</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Learn what documents to bring, what to expect during proceedings, and how to present your case effectively in family court.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Understanding Child Arrangement Orders</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Explore how Child Arrangement Orders work, when they are needed, and how courts decide where children should live and spend time.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Understand how UK courts determine child arrangements and what parents should know before making an application.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group2-1.png',
        ],
        [
            'title'          => 'Making a Personal Injury Claim: A Step-by-Step Guide',
            'content'        => '<p>Learn how compensation claims work, important deadlines, and the evidence needed to support your case.</p>

<div class="wp-block-group alignwide blog-detail-main has-global-padding is-layout-constrained wp-container-core-group-is-layout-fcb693ae wp-block-group-is-layout-constrained" style="padding-top:104px;padding-right:135px;padding-left:135px">
<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-2c90304e wp-block-group-is-layout-flex">
<h2 class="wp-block-heading alignwide blog-detail-heading" style="padding-right:129px;padding-left:129px;font-weight:800;line-height:1.1">Essential Legal Guidance Before Taking Action</h2>

<p class="has-text-align-center alignwide blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:105px;padding-left:105px;font-weight:500;line-height:1.5">Making a personal injury claim can feel overwhelming, especially while recovering from an accident. Understanding the claims process early helps protect your legal rights and improves your chances of receiving fair compensation.</p>
</div>

<hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide"/>

<div class="wp-block-group blog-detail-stack is-vertical is-layout-flex wp-container-core-group-is-layout-44c2545a wp-block-group-is-layout-flex">
<h2 class="wp-block-heading has-text-align-left alignwide blog-detail-heading" style="font-weight:800;line-height:1.1">How the Personal Injury Claims Process Works</h2>

<p class="blog-detail-paragraph-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-top:9px;padding-right:27px;font-weight:500;line-height:1.5">Every injury claim is unique, but most follow a structured legal process. Knowing each stage helps you prepare and avoid common mistakes.</p>

<div class="wp-block-columns blog-details-columns is-layout-flex wp-container-core-columns-is-layout-d309887a wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:335px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-fe1bc1c607e042905dc9057fa269be56">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-7cbf09efbbb69c6950de3c8af07ae023" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Obtain medical treatment and keep all medical records.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-8787e91f6505878b565dae1b38e7c69e" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Collect evidence, including photographs and witness details.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-144be061b2894db7492613636f254692" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Report the incident where required.</li>
</ul>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:333px">
<ul class="wp-block-list has-accent-color has-text-color has-link-color wp-elements-4b8de4bce0577716a82a985ff75caad0">
<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-8693ecb72fafce60d48336234fd7aae9" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Keep records of financial losses and expenses.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-ab5dd11f2185ecbbcb2b740e87e9e086" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Seek legal advice before accepting any settlement.</li>

<li class="has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family wp-elements-ab6605e5fa37ac5ab84e8dbe2d288957" style="font-size:clamp(14px, 0.875rem + ((1vw - 3.2px) * 0.208), 16px);font-style:normal;font-weight:400;letter-spacing:0%;line-height:1.5"><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">✓</mark></strong> Submit your claim within the legal limitation period.</li>
</ul>
</div>
</div>
</div>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-7387b849 wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:592px">
<figure class="wp-block-image size-full blog-detail-committed-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/blog-detail.png" alt="" class="wp-image-999"/></figure>
</div>

<div class="wp-block-column is-vertically-aligned-center is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:421px">
<h2 class="wp-block-heading has-text-align-left practice-area-heading" style="font-size:clamp(24.034px, 1.502rem + ((1vw - 3.2px) * 1.663), 40px);font-weight:800;line-height:1.2">Committed to Securing the Compensation You Deserve</h2>

<p class="blog-detail-paragraph extra-para has-plus-jakarta-sans-font-family wp-block-paragraph" style="line-height:1.5">An experienced personal injury solicitor works to recover compensation for medical expenses, lost income, rehabilitation costs, and the impact the injury has had on your daily life.</p>
</div>
</div>

<div class="wp-block-group blog-detail-cover-heading has-secondary-color has-primary-background-color has-text-color has-background has-link-color wp-elements-7acad983ec58b10d5a50908d36b13b57 is-vertical is-layout-flex wp-container-core-group-is-layout-b93516a3 wp-block-group-is-layout-flex" style="margin-top:104px;margin-bottom:104px;padding-top:72px;padding-right:106px;padding-bottom:72px;padding-left:106px">
<h2 class="wp-block-heading blog-black-heading has-secondary-color has-text-color" style="font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.1">“A successful personal injury claim isn&#8217;t just about compensation-it&#8217;s about helping you recover, rebuild, and move forward with confidence.”</h2>
</div>

<div class="wp-block-columns is-not-stacked-on-mobile is-layout-flex wp-container-core-columns-is-layout-99a3b71c wp-block-columns-is-layout-flex">
<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-content-justification-left is-layout-flex wp-container-core-group-is-layout-1ae830b2 wp-block-group-is-layout-flex">
<figure class="wp-block-image size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/appereance.png" alt="" class="wp-image-1013" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Preparing for Your First Personal Injury Consultation</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Discover which documents, medical records, and evidence to bring to your first meeting with a solicitor to help your claim progress efficiently.</p>
</div>
</div>

<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
<div class="wp-block-group blog-detail-column-stack is-vertical is-layout-flex wp-container-core-group-is-layout-ab4dc897 wp-block-group-is-layout-flex">
<figure class="wp-block-image alignleft size-full is-resized blog-detail-img"><img decoding="async" src="https://lightseagreen-quail-608189.hostingersite.com/wp-content/themes/theme/assets/images/personal-injuryclaim.png" alt="" class="wp-image-1001" style="object-fit:cover;width:700px;height:408px"/></figure>

<h2 class="wp-block-heading has-text-align-left blog-detail-paragraph" style="padding-top:18px;padding-right:50px;font-size:clamp(20px, 1.25rem + ((1vw - 3.2px) * 1.25), 32px);font-weight:800;line-height:1.2">Common Mistakes That Can Reduce Injury Compensation</h2>

<p class="blog-detail-paragraph has-plus-jakarta-sans-font-family wp-block-paragraph" style="padding-right:40px;line-height:1.5">Learn the most common errors claimants make after an accident and how avoiding them can strengthen your personal injury claim.</p>
</div>
</div>
</div>
</div>',
            'excerpt'        => 'Learn how compensation claims work, important deadlines, and the evidence needed to support your case. Essential Legal Guidance Before Taking Action Making a personal injury claim can feel overwhelming, especially while recovering from an accident. Understanding the claims process early helps protect your legal rights and improves your chances of receiving fair compensation. How the […]',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group1-1.png',
        ],
];
    foreach ($articles as $index => $article) {
        $image = $article['featured_image'] ?? '';
        unset($article['featured_image']);
        $post_id = wp_insert_post([
            'post_title'=>$article['title'],'post_name'=>sanitize_title($article['title']),
            'post_content'=>$article['content'],'post_excerpt'=>$article['excerpt'],
            'post_type'=>'article','post_status'=>'publish',
            'post_date'=>$article['date'].' 10:00:00','post_date_gmt'=>$article['date'].' 10:00:00',
            'menu_order'=>$index,'comment_status'=>'open',
        ]);
        if ($post_id && !is_wp_error($post_id) && $image) lawfirmpro_set_featured_image($post_id, $image);
    }
}

function lawfirmpro_import_offers()
{
    $existing = get_posts(['post_type'=>'offer','posts_per_page'=>1,'post_status'=>'publish','fields'=>'ids']);
    if (!empty($existing)) return;
    $offers = [
        ['title'=>'Criminal Defence','content'=>'<p>24/7 police station representation, court advocacy, fraud investigations, motoring offences, assault, and criminal appeals.</p>','excerpt'=>'24/7 police station representation, court advocacy, fraud investigations, motoring offences, assault, and criminal appeals.','featured_image'=>'image-75-1.png'],
        ['title'=>'Family Law','content'=>'<p>Helping families through divorce, child arrangements, financial settlements, domestic abuse protection, and mediation.</p>','excerpt'=>'Helping families through divorce, child arrangements, financial settlements, domestic abuse protection, and mediation.','featured_image'=>'pexels-august-de-richelieu-4427429-1.png'],
        ['title'=>'Civil Litigation','content'=>'<p>Resolving contract disputes, landlord &amp; tenant matters, professional negligence, debt recovery, and commercial disagreements.</p>','excerpt'=>'Resolving contract disputes, landlord &amp; tenant matters, professional negligence, debt recovery, and commercial disagreements.','featured_image'=>'image-76.jpg'],
    ];
    foreach ($offers as $index => $offer) {
        $image = $offer['featured_image'] ?? '';
        unset($offer['featured_image']);
        $post_id = wp_insert_post(['post_title'=>$offer['title'],'post_name'=>sanitize_title($offer['title']),'post_content'=>$offer['content'],'post_excerpt'=>$offer['excerpt'],'post_type'=>'offer','post_status'=>'publish','menu_order'=>$index]);
        if ($post_id && !is_wp_error($post_id) && $image) lawfirmpro_set_featured_image($post_id, $image);
    }
}

function lawfirmpro_import_about_firm()
{
    $existing = get_posts(['post_type'=>'about_firm','posts_per_page'=>1,'post_status'=>'publish','fields'=>'ids']);
    if (!empty($existing)) return;
    $entries = [
        ['title'=>'Trusted by Clients','content'=>'<p>For over 25 years, we\'ve helped individuals, families, and businesses navigate legal challenges with confidence. Our commitment is simple — provide honest advice, practical solutions, and dedicated representation from start to finish.</p><p>From first consultations to courtroom advocacy, our solicitors are known for professionalism, integrity, and achieving the best possible outcomes for every client.</p>','excerpt'=>'For over 25 years, we\'ve helped individuals, families, and businesses navigate legal challenges with confidence.'],
        ['title'=>'Across England & Wales','content'=>'<p>Our team brings together specialists across multiple areas of law, offering tailored legal solutions for individuals and businesses. We take time to understand your circumstances before developing practical strategies focused on achieving the best possible outcome.</p>','excerpt'=>'Specialists across multiple areas of law offering tailored legal solutions.'],
    ];
    foreach ($entries as $index => $entry) {
        wp_insert_post(['post_title'=>$entry['title'],'post_name'=>sanitize_title($entry['title']),'post_content'=>$entry['content'],'post_excerpt'=>$entry['excerpt'],'post_type'=>'about_firm','post_status'=>'publish','menu_order'=>$index]);
    }
}

function lawfirmpro_set_default_options()
{
    $defaults = [
        'phone'=>'(44) 7956 8221','another_phone'=>'','email'=>'info@aldervox.uk',
        'address'=>'125 Holborn, London EC1N 2TD','whatsapp'=>'','map_url'=>'',
        'copyright_text'=>'© 2026 Aldervox Law Firm. All rights reserved.',
        'facebook_url'=>'','instagram_url'=>'','twitter_url'=>'','linkedin_url'=>'','youtube_url'=>'',
        'stat_1_number'=>'100+','stat_1_label'=>'Successful Cases',
        'stat_2_number'=>'30+','stat_2_label'=>'Years of Legal Experience',
        'stat_3_number'=>'4.9/5','stat_3_label'=>'Average Client Rating',
        'stat_4_number'=>'1.4K+','stat_4_label'=>'Happy Customers',
        'heading_hero_v1'=>'Trusted Legal Advice When You Need It Most',
        'heading_hero_v2'=>'Reliable Legal Help from Expert Lawyers',
        'heading_offers'=>'How Can I Help You?',
        'heading_practice'=>'Our Expertise Practice Areas',
        'heading_attorneys'=>'Meet Our Experienced Attorneys',
        'heading_articles'=>'Latest Articles',
        'heading_testimonials'=>'Real Stories from Real Clients',
        'heading_faq'=>'Frequently Asked Questions',
        'heading_contact'=>'Get In Touch',
        'heading_contact_hero'=>'Speak With Our Legal Experts',
        'heading_about_hero'=>'Legal Excellence Built on Trust and Experience',
        'heading_about_results'=>'Experienced Solicitors. Proven Results.',
        'heading_about_lawyers'=>'Supporting You Every Step of the Way',
        'heading_about_contact'=>'Speak to an Experienced Solicitor Today',
        'label_call_today'=>'Call us today','label_location'=>'Location',
        'label_phone_number'=>'Phone Number','label_support_email'=>'Support Email',
        'label_quick_links'=>'Quick links','label_contact_info'=>'Contact Info',
        'text_footer_about'=>'Our experienced lawyers provide clear, effective legal solutions tailored to your needs.',
        'text_choose_firm'=>'How to Choose the Right Lawyer for Your Case',
    ];
    $existing = get_option('lawfirmpro_contact', []);
    foreach ($defaults as $key => $value) {
        if (!isset($existing[$key]) || $existing[$key] === '') $existing[$key] = $value;
    }
    update_option('lawfirmpro_contact', $existing);
}
