<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Import CPT data from live site on theme activation.
 * Hooked to after_switch_theme with priority 20 (runs after activation.php page creation).
 * Idempotent: checks if posts exist before creating.
 */
function lawfirmpro_import_cpt_data()
{
    lawfirmpro_import_practice_areas();
    lawfirmpro_import_attorneys();
    lawfirmpro_import_testimonials();
    lawfirmpro_import_faqs();
    lawfirmpro_import_articles();
    lawfirmpro_import_offers();
    lawfirmpro_import_about_firm();
    lawfirmpro_set_default_options();
    lawfirmpro_set_all_featured_images();
}
add_action('after_switch_theme', 'lawfirmpro_import_cpt_data', 20);

/**
 * Set a featured image for a post from a bundled theme image.
 *
 * @param int    $post_id       Post ID to attach the image to.
 * @param string $image_filename Filename relative to assets/images/.
 */
function lawfirmpro_set_featured_image($post_id, $image_filename)
{
    $image_path = get_theme_file_path('assets/images/' . $image_filename);
    if (!file_exists($image_path)) {
        return false;
    }

    $upload_dir = wp_upload_dir();

    if (!empty($upload_dir['error'])) {
        return false;
    }

    wp_mkdir_p($upload_dir['path']);

    $target = $upload_dir['path'] . '/' . $image_filename;

    if (!copy($image_path, $target)) {
        return false;
    }

    $file_type  = wp_check_filetype($image_filename, null);
    $attachment = [
        'post_title'     => sanitize_file_name($image_filename),
        'post_mime_type' => $file_type['type'] ?: 'image/png',
        'post_status'    => 'inherit',
        'guid'           => $upload_dir['url'] . '/' . $image_filename,
    ];

    $attach_id = wp_insert_attachment($attachment, $target);
    if (is_wp_error($attach_id) || !$attach_id) {
        return false;
    }

    if (!function_exists('wp_generate_attachment_metadata')) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    $metadata = wp_generate_attachment_metadata($attach_id, $target);
    wp_update_attachment_metadata($attach_id, $metadata);

    set_post_thumbnail($post_id, $attach_id);
    return true;
}

/**
 * Set featured images on existing CPT posts that don't have one.
 * Maps post titles to bundled image filenames.
 */
function lawfirmpro_set_all_featured_images()
{
    $image_map = [
        'practice-area' => [
            'Employment Law'          => 'pexels-ron-lach-10475170-2.png',
            'Immigration Law'         => 'visa-application-composition-with-american-flag-2.png',
            'Real Estate Law'         => 'Mask-group4.png',
            'Criminal Defence'        => 'pexels-ron-lach-10475170-2.png',
            'Family Law'              => 'Mask-group3.png',
            'Divorce & Separation'    => 'Mask-group1.png',
            'Divorce &amp; Separation' => 'Mask-group1.png',
            'Child Custody'           => 'Mask-group-3.png',
            'Corporate Law'           => 'Mask-group-1-1.png',
            'Cyber Law'               => 'Mask-group2.png',
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
            'A First-Time Buyer\'s Guide to Residential Conveyancing'            => 'Mask-group-5.png',
            'Your Rights After Unfair Dismissal'                                 => 'Mask-group-2-2.png',
            'Five Legal Mistakes Small Businesses Should Avoid'                  => 'Mask-group-4-3.png',
            'Why Every Family Should Have an Up-to-Date Will'                    => 'Mask-group-5-1.png',
            'What to Do If You\'re Asked to Attend a Police Interview'           => 'Mask-group-6-1.png',
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
            if (has_post_thumbnail($post_id)) {
                continue;
            }

            $title   = get_the_title($post_id);
            $decoded = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
            $normal  = str_replace(["\xE2\x80\x99", "\xE2\x80\x98", "\xE2\x80\x9C", "\xE2\x80\x9D", "\xC2\xA0"], ["'", "'", '"', '"', ' '], $decoded);
            $image   = $posts[$title] ?? '';

            if (!$image) {
                foreach ($posts as $key => $val) {
                    $key_decoded = html_entity_decode($key, ENT_QUOTES, 'UTF-8');
                    $key_normal  = str_replace(["\xE2\x80\x99", "\xE2\x80\x98", "\xE2\x80\x9C", "\xE2\x80\x9D", "\xC2\xA0"], ["'", "'", '"', '"', ' '], $key_decoded);
                    if ($key_normal === $normal) {
                        $image = $val;
                        break;
                    }
                }
            }

            if ($image) {
                lawfirmpro_set_featured_image($post_id, $image);
            }
        }
    }
}

// ============================================================
// Practice Areas
// ============================================================
function lawfirmpro_import_practice_areas()
{
    $existing = get_posts([
        'post_type'      => 'practice-area',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    if (!empty($existing)) {
        return;
    }

    $areas = [
        [
            'title'          => 'Employment Law',
            'content'        => '<p>Representing both employers and employees in workplace disputes, unfair dismissal, discrimination claims, redundancy, and settlement agreements.</p><p>Employment law continues to evolve, requiring employers to regularly review workplace policies, employment contracts and internal procedures. Failing to keep pace with legislative changes can expose businesses to costly disputes, regulatory action and reputational damage.</p><p>Our employment solicitors provide practical legal advice on all aspects of the employment relationship, from drafting contracts and policies to managing disputes and tribunal claims. We work closely with business owners, HR professionals and private individuals to resolve workplace issues efficiently and cost-effectively.</p><h3>Our Employment Law Services</h3><ul><li>Unfair and wrongful dismissal claims</li><li>Discrimination and harassment complaints</li><li>Redundancy consultation andTUPE transfers</li><li>Settlement agreements and compromise agreements</li><li>Employment contracts and handbook drafting</li><li>Restrictive covenants and bonus disputes</li></ul>',
            'excerpt'        => 'Representing both employers and employees in workplace disputes, unfair dismissal, discrimination claims, redundancy, and settlement agreements.',
            'featured_image' => 'pexels-ron-lach-10475170-2.png',
        ],
        [
            'title'          => 'Immigration Law',
            'content'        => '<p>Visa applications, Skilled Worker visas, spouse visas, British citizenship, indefinite leave to remain, and appeals.</p><p>Immigration law is complex and constantly changing. Our immigration solicitors provide expert legal advice and guidance on all types of UK immigration applications, helping individuals, families and businesses navigate the immigration system with confidence.</p><p>Whether you are applying for a visa, seeking to settle permanently in the UK, or facing immigration enforcement action, our team will assess your circumstances, explain your options clearly and manage your application from start to finish.</p><h3>Our Immigration Law Services</h3><ul><li>Skilled Worker and Tier 2 visa applications</li><li>Spouse and family visa applications</li><li>British citizenship and naturalisation</li><li>Indefinite leave to remain (ILR)</li><li>Visitor visas and student visas</li><li>Immigration appeals and judicial review</li></ul>',
            'excerpt'        => 'Visa applications, Skilled Worker visas, spouse visas, British citizenship, indefinite leave to remain, and appeals.',
            'featured_image' => 'visa-application-composition-with-american-flag-2.png',
        ],
        [
            'title'          => 'Real Estate Law',
            'content'        => '<p>Buying, selling, leasing, or developing property involves significant financial and legal commitments.</p><p>Purchasing or selling property can be one of life\'s biggest investments. Every property transaction is different, and we provide bespoke legal guidance for homebuyers, landlords, developers, investors, and commercial clients across England and Wales.</p><p>Our property solicitors handle all aspects of residential and commercial conveyancing, ensuring transactions progress smoothly and your interests are protected at every stage. We pride ourselves on clear communication, competitive fixed fees and prompt responses.</p><h3>Our Property Law Services</h3><ul><li>Residential conveyancing (buying and selling)</li><li>Commercial property transactions</li><li>Lease negotiation and preparation</li><li>Property development and planning</li><li>Mortgage and remortgage work</li><li>Landlord and tenant disputes</li></ul>',
            'excerpt'        => 'Buying, selling, leasing, or developing property involves significant financial and legal commitments.',
            'featured_image' => 'Mask-group4.png',
        ],
        [
            'title'          => 'Criminal Defence',
            'content'        => '<p>Being accused of a criminal offence can have serious consequences for your future, reputation, and freedom.</p><p>When facing criminal allegations, prompt legal advice can make a significant difference. Every criminal case is unique. We carefully assess the evidence, explain your legal options, and develop a defence strategy tailored to your individual circumstances and objectives.</p><p>From police station interviews to court hearings, we provide consistent legal support, ensuring your rights are protected and your case is presented effectively. We represent clients facing a wide range of offences, including assault, theft, fraud, drug offences, motoring offences, public order matters, and serious criminal allegations.</p><h3>Our Criminal Defence Services</h3><ul><li>Police station representation</li><li>Magistrates\' Court and Crown Court defence</li><li>Investigation and evidence review</li><li>Sentencing advice and mitigation</li><li>Criminal appeals</li><li>Motoring offences and drink driving</li></ul>',
            'excerpt'        => 'Being accused of a criminal offence can have serious consequences for your future, reputation, and freedom.',
            'featured_image' => 'pexels-ron-lach-10475170-2.png',
        ],
        [
            'title'          => 'Family Law',
            'content'        => '<p>Supporting individuals and families through divorce, child arrangements, financial settlements, and mediation.</p><p>Family law matters are often emotionally charged and deeply personal. Our family law solicitors provide sensitive, practical legal advice to help you resolve family disputes with minimal conflict and the best possible outcomes for you and your children.</p><p>We handle all aspects of family law, from negotiating financial settlements to representing parents in child arrangement proceedings. Our goal is to provide clear guidance and dedicated support throughout your legal journey.</p><h3>Our Family Law Services</h3><ul><li>Divorce and separation</li><li>Child arrangement orders</li><li>Financial settlements</li><li>Cohabitation disputes</li><li>Domestic abuse protection</li><li>Family mediation</li></ul>',
            'excerpt'        => 'Supporting individuals and families through divorce, child arrangements, financial settlements, and mediation.',
            'featured_image' => 'Mask-group3.png',
        ],
        [
            'title'          => 'Divorce & Separation',
            'content'        => '<p>Helping clients achieve fair financial settlements, child arrangements, and practical solutions during divorce and separation.</p><p>Divorce is one of life\'s most significant legal decisions, and understanding the process before taking action can help reduce uncertainty and unnecessary stress. Although the introduction of no-fault divorce has simplified the legal process, it remains essential to seek expert legal advice to protect your financial interests and ensure suitable arrangements are made for your children.</p><p>Our divorce solicitors guide you through every stage of the process, from the initial application to final order, providing clear advice on financial matters, property division, pension sharing and child arrangements.</p>',
            'excerpt'        => 'Helping clients achieve fair financial settlements, child arrangements, and practical solutions during divorce and separation.',
            'featured_image' => 'Mask-group1.png',
        ],
        [
            'title'          => 'Child Custody',
            'content'        => '<p>Expert legal advice on child arrangements, parental responsibility, residence, contact agreements, and court proceedings.</p><p>When parents separate, deciding where children will live and how much time they spend with each parent can be difficult. Our child custody solicitors help parents reach agreements that are in the best interests of their children, whether through negotiation, mediation or court proceedings.</p><p>We understand that child arrangements are often the most sensitive aspect of family separation. Our solicitors provide compassionate, practical advice focused on minimising the impact on children while protecting your rights as a parent.</p>',
            'excerpt'        => 'Expert legal advice on child arrangements, parental responsibility, residence, contact agreements, and court proceedings.',
            'featured_image' => 'Mask-group-3.png',
        ],
        [
            'title'          => 'Corporate Law',
            'content'        => '<p>Legal support for startups, SMEs, and established businesses, including contracts, shareholder agreements, mergers, acquisitions.</p><p>Our corporate law team advises businesses at every stage of their lifecycle, from startup formation to growth, restructuring and succession planning. We provide practical, commercially minded legal advice that helps you make informed decisions and achieve your business objectives.</p><p>Whether you need help with a company formation, commercial contract, shareholder agreement or complex transaction, our solicitors have the expertise to guide you through every legal challenge.</p>',
            'excerpt'        => 'Legal support for startups, SMEs, and established businesses, including contracts, shareholder agreements, mergers, acquisitions.',
            'featured_image' => 'Mask-group-1-1.png',
        ],
        [
            'title'          => 'Cyber Law',
            'content'        => '<p>In recent years, with the increasing reliance on digital technology, cybercrimes have become a growing concern for individuals and businesses alike.</p><p>Our cyber law team provides expert legal advice on data protection, cyber security compliance, breach notification, privacy regulations and digital disputes. We help businesses understand their legal obligations under UK GDPR and the Data Protection Act 2018, and respond effectively when incidents occur.</p><p>Whether you need help with a data breach, regulatory investigation, privacy claim or cyber security policy, our solicitors have the specialist knowledge to protect your interests in the digital environment.</p>',
            'excerpt'        => 'In recent years, with the increasing reliance on digital technology, cybercrimes have become a growing concern for individuals and businesses alike.',
            'featured_image' => 'Mask-group2.png',
        ],
    ];

    foreach ($areas as $index => $area) {
        $image = $area['featured_image'] ?? '';
        unset($area['featured_image']);

        $post_id = wp_insert_post([
            'post_title'   => $area['title'],
            'post_name'    => sanitize_title($area['title']),
            'post_content' => $area['content'],
            'post_excerpt' => $area['excerpt'],
            'post_type'    => 'practice-area',
            'post_status'  => 'publish',
            'menu_order'   => $index,
        ]);

        if ($post_id && !is_wp_error($post_id) && $image) {
            lawfirmpro_set_featured_image($post_id, $image);
        }
    }
}

// ============================================================
// Attorneys
// ============================================================
function lawfirmpro_import_attorneys()
{
    $existing = get_posts([
        'post_type'      => 'attorney',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    if (!empty($existing)) {
        return;
    }

    $attorneys = [
        [
            'title'          => 'James Thornton',
            'content'        => '<p>James Carter advises businesses, company directors, investors and private individuals on a broad range of commercial and corporate legal matters. His practice focuses on helping clients minimise legal risk, resolve disputes efficiently and make confident business decisions backed by sound legal advice.</p>',
            'excerpt'        => 'Commercial & Corporate Law Specialist',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group.png',
        ],
        [
            'title'          => 'Sarah Mitchell',
            'content'        => '<p>Sarah Mitchell is a Senior Solicitor at Aldervox Law Firm, advising clients across a broad range of employment, commercial and dispute resolution matters. She works closely with business owners, company directors, HR professionals and private individuals, providing practical legal solutions that protect their interests while minimising legal and commercial risk.</p>',
            'excerpt'        => 'Employment & Dispute Resolution Specialist',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-1.png',
        ],
        [
            'title'          => 'Daniel Cooper',
            'content'        => '<p>Daniel has built his reputation by providing clear, honest legal advice that helps clients navigate complex legal matters with confidence. He understands that legal issues often arise during significant moments in people\'s lives, whether involving family relationships, property, inheritance or commercial disputes.</p>',
            'excerpt'        => 'Multi-Practice Legal Specialist',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-2.png',
        ],
        [
            'title'          => 'William Harrison',
            'content'        => '<p>William Harrison is a Partner at Aldervox Law Firm with more than 20 years of experience advising individuals, families, and businesses across England and Wales. He specialises in Family Law, Private Client services, Civil Litigation, and Alternative Dispute Resolution, providing practical legal solutions tailored to each client\'s individual circumstances.</p>',
            'excerpt'        => 'Family Law & Private Client Partner',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-1-2.png',
        ],
        [
            'title'          => 'Oliver Bennett',
            'content'        => '<p>Senior Lawyer at Aldervox Law Firm with extensive experience across multiple areas of law.</p>',
            'excerpt'        => 'Senior Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-4.png',
        ],
        [
            'title'          => 'Elis Davies',
            'content'        => '<p>Family Lawyer at Aldervox Law Firm, providing sensitive and practical legal advice on all family law matters.</p>',
            'excerpt'        => 'Family Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-2-1.png',
        ],
        [
            'title'          => 'Amelia Turner',
            'content'        => '<p>Employment Lawyer at Aldervox Law Firm, advising employers and employees on workplace legal matters.</p>',
            'excerpt'        => 'Employment Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-3-1.png',
        ],
        [
            'title'          => 'James Carter',
            'content'        => '<p>Property Lawyer at Aldervox Law Firm, handling residential and commercial conveyancing matters.</p>',
            'excerpt'        => 'Property Lawyer',
            'facebook'       => '',
            'twitter'        => '',
            'linkedin'       => '',
            'featured_image' => 'Mask-group-4-1.png',
        ],
        [
            'title'          => 'Daniel Foster',
            'content'        => '<p>Commercial Lawyer at Aldervox Law Firm, providing legal advice on business and commercial matters.</p>',
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
            'post_title'   => $attorney['title'],
            'post_name'    => sanitize_title($attorney['title']),
            'post_content' => $attorney['content'],
            'post_excerpt' => $attorney['excerpt'],
            'post_type'    => 'attorney',
            'post_status'  => 'publish',
            'menu_order'   => $index,
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            if (!empty($attorney['facebook'])) {
                update_post_meta($post_id, '_attorney_facebook', esc_url_raw($attorney['facebook']));
            }
            if (!empty($attorney['twitter'])) {
                update_post_meta($post_id, '_attorney_twitter', esc_url_raw($attorney['twitter']));
            }
            if (!empty($attorney['linkedin'])) {
                update_post_meta($post_id, '_attorney_linkedin', esc_url_raw($attorney['linkedin']));
            }
            if ($image) {
                lawfirmpro_set_featured_image($post_id, $image);
            }
        }
    }
}

// ============================================================
// Testimonials
// ============================================================
function lawfirmpro_import_testimonials()
{
    $existing = get_posts([
        'post_type'      => 'testimonial',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    if (!empty($existing)) {
        return;
    }

    $testimonials = [
        [
            'title'          => 'Emma Richardson',
            'content'        => '<p>The team explained every step clearly and made a stressful legal matter much easier to manage. Their professionalism and communication were outstanding.</p>',
            'location'       => 'USA',
            'rating'         => 5,
            'featured_image' => 'ratings-icon.png',
        ],
        [
            'title'    => 'Michael Evans',
            'content'  => '<p>I received excellent advice during my property dispute. The solicitors were responsive, knowledgeable, and achieved a better outcome than I expected.</p>',
            'location' => 'USA',
            'rating'   => 5,
        ],
        [
            'title'    => 'Olivia Harris',
            'content'  => '<p>We instructed the firm for our immigration application, and everything was handled efficiently. Highly recommended.</p>',
            'location' => 'London',
            'rating'   => 5,
        ],
    ];

    foreach ($testimonials as $index => $testimonial) {
        $image = $testimonial['featured_image'] ?? '';
        unset($testimonial['featured_image']);

        $post_id = wp_insert_post([
            'post_title'   => $testimonial['title'],
            'post_name'    => sanitize_title($testimonial['title']),
            'post_content' => $testimonial['content'],
            'post_type'    => 'testimonial',
            'post_status'  => 'publish',
            'menu_order'   => $index,
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_testimonial_location', $testimonial['location']);
            update_post_meta($post_id, '_testimonial_rating', $testimonial['rating']);
            if ($image) {
                lawfirmpro_set_featured_image($post_id, $image);
            }
        }
    }
}

// ============================================================
// FAQs
// ============================================================
function lawfirmpro_import_faqs()
{
    $existing = get_posts([
        'post_type'      => 'faq',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    if (!empty($existing)) {
        return;
    }

    $faqs = [
        [
            'title'   => 'How much does an initial consultation cost?',
            'content' => '<p>We offer fixed-fee initial consultations for many legal services. The fee depends on the type and complexity of your matter.</p>',
        ],
        [
            'title'   => 'Do you offer fixed-fee legal services?',
            'content' => '<p>Yes. Many of our services are available with transparent fixed pricing, so you know exactly what to expect.</p>',
        ],
        [
            'title'   => 'Can you represent me anywhere in the UK?',
            'content' => '<p>Yes. We represent clients throughout England and Wales, with many consultations conducted remotely by phone or video call.</p>',
        ],
        [
            'title'   => 'How quickly can I speak to a solicitor?',
            'content' => '<p>In most cases, we can arrange a consultation within one business day. Urgent criminal defence matters are available 24/7.</p>',
        ],
        [
            'title'   => 'What documents should I bring?',
            'content' => '<p>Bring any correspondence, contracts, identification, court documents, or other paperwork related to your legal issue.</p>',
        ],
    ];

    foreach ($faqs as $index => $faq) {
        wp_insert_post([
            'post_title'   => $faq['title'],
            'post_name'    => sanitize_title($faq['title']),
            'post_content' => $faq['content'],
            'post_type'    => 'faq',
            'post_status'  => 'publish',
            'menu_order'   => $index,
        ]);
    }
}

// ============================================================
// Articles
// ============================================================
function lawfirmpro_import_articles()
{
    $existing = get_posts([
        'post_type'      => 'article',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    if (!empty($existing)) {
        return;
    }

    $articles = [
        [
            'title'          => 'Understanding the UK Divorce Process in 2026',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>Divorce is one of life\'s most significant legal decisions, and understanding the process before taking action can help reduce uncertainty and unnecessary stress. Although the introduction of no-fault divorce has simplified the legal process, it remains essential to seek expert legal advice to protect your financial interests and ensure suitable arrangements are made for your children.</p><p>This guide explains the key steps involved in the UK divorce process, from filing the application to obtaining the final order, as well as important considerations regarding finances and children.</p>',
            'excerpt'        => 'Everything you need to know about timelines, finances, and child arrangements.',
            'date'           => '2026-07-09',
            'featured_image' => 'article-img-1.png',
        ],
        [
            'title'          => 'First-Time Home Buyers: Legal Checklist Before Completion',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>Purchasing your first property involves far more than securing a mortgage and signing contracts. Before completion, it\'s important to ensure that all legal checks have been carried out to protect your investment and avoid costly surprises.</p><p>This checklist covers the essential legal steps every first-time buyer should understand before completing their property purchase.</p>',
            'excerpt'        => 'Key legal checks every property buyer should understand.',
            'date'           => '2026-07-09',
            'featured_image' => 'article-img-2.png',
        ],
        [
            'title'          => 'Changes to UK Employment Law Every Employer Should Know',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>Employment law continues to evolve, requiring employers to regularly review workplace policies, employment contracts and internal procedures. Failing to keep pace with legislative changes can expose businesses to costly disputes, regulatory action and reputational damage.</p><p>This article highlights the most important recent changes to UK employment law and explains what employers need to do to remain compliant.</p>',
            'excerpt'        => 'Recent legislation affecting businesses and employees.',
            'date'           => '2026-07-09',
            'featured_image' => 'article-img-3.png',
        ],
        [
            'title'          => 'Essential Legal Checks Before Buying a Business',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>Buying an existing business can offer exciting opportunities, but it also comes with legal and financial responsibilities. Before signing any agreement, it is essential to conduct thorough legal due diligence to ensure you understand exactly what you are purchasing and any liabilities that may transfer with the business.</p><p>This guide explains the key legal checks every buyer should complete before purchasing or investing in a business.</p>',
            'excerpt'        => 'Discover the legal due diligence every buyer should complete before purchasing or investing in a business.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-1-3.png',
        ],
        [
            'title'          => 'A First-Time Buyer\'s Guide to Residential Conveyancing',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>Residential conveyancing is the legal process of transferring ownership of a property from the seller to the buyer. While the process may seem straightforward, it involves a number of important legal steps that protect both parties.</p><p>This guide explains the conveyancing process from offer acceptance to completion, including legal searches, contract exchange and what to expect on completion day.</p>',
            'excerpt'        => 'Understand the conveyancing process, legal searches, contracts, and what to expect before completing your property purchase.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-5.png',
        ],
        [
            'title'          => 'Your Rights After Unfair Dismissal',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>Losing your job unexpectedly can be both financially and emotionally challenging. However, not every dismissal is lawful. UK employment law provides important protections for employees who have been unfairly dismissed, and understanding your rights is the first step towards securing the compensation and justice you deserve.</p><p>This article explains what qualifies as unfair dismissal, the steps you should take, and how an employment solicitor can help protect your rights.</p>',
            'excerpt'        => 'Learn what qualifies as unfair dismissal, the steps to take, and how an employment solicitor can help protect your rights.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-2-2.png',
        ],
        [
            'title'          => 'Five Legal Mistakes Small Businesses Should Avoid',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>Running a successful business requires more than delivering excellent products or services — it also means understanding your legal responsibilities. Many small businesses encounter avoidable legal issues because they overlook important obligations during their early growth stages.</p><p>This article highlights five common legal mistakes small businesses make and explains how to avoid them.</p>',
            'excerpt'        => 'Avoid costly legal issues by understanding contracts, compliance, employment obligations, and intellectual property protection.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-4-3.png',
        ],
        [
            'title'          => 'Why Every Family Should Have an Up-to-Date Will',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>Creating a Will is one of the most important steps you can take to protect your family and ensure your estate is distributed according to your wishes. Without a valid Will, the rules of intestacy determine how your assets are divided, which may not reflect your intentions.</p><p>This article explains why having a professionally drafted Will is essential and what key elements it should include.</p>',
            'excerpt'        => 'Find out how a professionally drafted will can protect your loved ones and ensure your wishes are carried out.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-5-1.png',
        ],
        [
            'title'          => 'What to Do If You\'re Asked to Attend a Police Interview',
            'content'        => '<p>Essential Legal Guidance Before Taking Action</p><p>A police interview is a formal part of a criminal investigation, and anything you say may be used as evidence. While cooperation is important, you are not expected to face questioning without understanding your rights. A solicitor can explain the process, protect your interests and ensure you make informed decisions throughout the interview.</p><p>This article explains what to expect during a police interview, your legal rights, and why having a solicitor present is essential.</p>',
            'excerpt'        => 'Essential Legal Guidance Before Taking Action.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group-6-1.png',
        ],
        [
            'title'          => 'Child Arrangements After Separation Explained',
            'content'        => '<p>Understand how UK courts determine child arrangements and what parents should know before making an application.</p><p>When parents separate, deciding where children will live and how much time they spend with each parent can be one of the most difficult aspects of the process. The UK family courts always put the best interests of the child first, and there are several options available to help parents reach agreement without going to court.</p><p>This guide explains the child arrangements process, including mediation, child arrangement orders and what the court considers when making decisions.</p>',
            'excerpt'        => 'Understand how UK courts determine child arrangements and what parents should know before making an application.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group2-1.png',
        ],
        [
            'title'          => 'Making a Personal Injury Claim: A Step-by-Step Guide',
            'content'        => '<p>Learn how compensation claims work, important deadlines, and the evidence needed to support your case.</p><p>If you have been injured in an accident that was not your fault, you may be entitled to compensation. Personal injury claims can help you recover damages for medical expenses, lost earnings, and pain and suffering.</p><p>This step-by-step guide explains the personal injury claims process, from reporting the accident to negotiating a settlement or proceeding to court.</p>',
            'excerpt'        => 'Learn how compensation claims work, important deadlines, and the evidence needed to support your case.',
            'date'           => '2026-07-10',
            'featured_image' => 'Mask-group1-1.png',
        ],
    ];

    foreach ($articles as $index => $article) {
        $image = $article['featured_image'] ?? '';
        unset($article['featured_image']);

        $post_id = wp_insert_post([
            'post_title'     => $article['title'],
            'post_name'      => sanitize_title($article['title']),
            'post_content'   => $article['content'],
            'post_excerpt'   => $article['excerpt'],
            'post_type'      => 'article',
            'post_status'    => 'publish',
            'post_date'      => $article['date'] . ' 10:00:00',
            'post_date_gmt'  => $article['date'] . ' 10:00:00',
            'menu_order'     => $index,
            'comment_status' => 'open',
        ]);

        if ($post_id && !is_wp_error($post_id) && $image) {
            lawfirmpro_set_featured_image($post_id, $image);
        }
    }
}

// ============================================================
// Offers
// ============================================================
function lawfirmpro_import_offers()
{
    $existing = get_posts([
        'post_type'      => 'offer',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    if (!empty($existing)) {
        return;
    }

    $offers = [
        [
            'title'          => 'Criminal Defence',
            'content'        => '<p>24/7 police station representation, court advocacy, fraud investigations, motoring offences, assault, and criminal appeals.</p>',
            'excerpt'        => '24/7 police station representation, court advocacy, fraud investigations, motoring offences, assault, and criminal appeals.',
            'featured_image' => 'image-75-1.png',
        ],
        [
            'title'          => 'Family Law',
            'content'        => '<p>Helping families through divorce, child arrangements, financial settlements, domestic abuse protection, and mediation.</p>',
            'excerpt'        => 'Helping families through divorce, child arrangements, financial settlements, domestic abuse protection, and mediation.',
            'featured_image' => 'pexels-august-de-richelieu-4427429-1.png',
        ],
        [
            'title'          => 'Civil Litigation',
            'content'        => '<p>Resolving contract disputes, landlord &amp; tenant matters, professional negligence, debt recovery, and commercial disagreements.</p>',
            'excerpt'        => 'Resolving contract disputes, landlord &amp; tenant matters, professional negligence, debt recovery, and commercial disagreements.',
            'featured_image' => 'image-76.jpg',
        ],
    ];

    foreach ($offers as $index => $offer) {
        $image = $offer['featured_image'] ?? '';
        unset($offer['featured_image']);

        $post_id = wp_insert_post([
            'post_title'   => $offer['title'],
            'post_name'    => sanitize_title($offer['title']),
            'post_content' => $offer['content'],
            'post_excerpt' => $offer['excerpt'],
            'post_type'    => 'offer',
            'post_status'  => 'publish',
            'menu_order'   => $index,
        ]);

        if ($post_id && !is_wp_error($post_id) && $image) {
            lawfirmpro_set_featured_image($post_id, $image);
        }
    }
}

// ============================================================
// About Firm
// ============================================================
function lawfirmpro_import_about_firm()
{
    $existing = get_posts([
        'post_type'      => 'about_firm',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    if (!empty($existing)) {
        return;
    }

    $entries = [
        [
            'title'   => 'Trusted by Clients',
            'content' => '<p>For over 25 years, we\'ve helped individuals, families, and businesses navigate legal challenges with confidence. Our commitment is simple — provide honest advice, practical solutions, and dedicated representation from start to finish.</p><p>From first consultations to courtroom advocacy, our solicitors are known for professionalism, integrity, and achieving the best possible outcomes for every client.</p>',
            'excerpt' => 'For over 25 years, we\'ve helped individuals, families, and businesses navigate legal challenges with confidence.',
        ],
        [
            'title'   => 'Across England & Wales',
            'content' => '<p>Our team brings together specialists across multiple areas of law, offering tailored legal solutions for individuals and businesses. We take time to understand your circumstances before developing practical strategies focused on achieving the best possible outcome.</p>',
            'excerpt' => 'Specialists across multiple areas of law offering tailored legal solutions.',
        ],
    ];

    foreach ($entries as $index => $entry) {
        wp_insert_post([
            'post_title'   => $entry['title'],
            'post_name'    => sanitize_title($entry['title']),
            'post_content' => $entry['content'],
            'post_excerpt' => $entry['excerpt'],
            'post_type'    => 'about_firm',
            'post_status'  => 'publish',
            'menu_order'   => $index,
        ]);
    }
}

// ============================================================
// Theme Options Defaults
// ============================================================
function lawfirmpro_set_default_options()
{
    $defaults = [
        // General
        'phone'          => '(44) 7956 8221',
        'another_phone'  => '',
        'email'          => 'info@aldervox.uk',
        'address'        => "125 Holborn, London EC1N 2TD",
        'whatsapp'       => '',
        'map_url'        => '',
        'copyright_text' => '© 2026 Aldervox Law Firm. All rights reserved.',

        // Social Media (empty — to be filled by admin)
        'facebook_url'   => '',
        'instagram_url'  => '',
        'twitter_url'    => '',
        'linkedin_url'   => '',
        'youtube_url'    => '',

        // Statistics
        'stat_1_number'  => '100+',
        'stat_1_label'   => 'Successful Cases',
        'stat_2_number'  => '30+',
        'stat_2_label'   => 'Years of Legal Experience',
        'stat_3_number'  => '4.9/5',
        'stat_3_label'   => 'Average Client Rating',
        'stat_4_number'  => '1.4K+',
        'stat_4_label'   => 'Happy Customers',

        // Headings — Homepage
        'heading_hero_v1'        => 'Trusted Legal Advice When You Need It Most',
        'heading_hero_v2'        => 'Reliable Legal Help from Expert Lawyers',
        'heading_offers'         => 'How Can I Help You?',
        'heading_practice'       => 'Our Expertise Practice Areas',
        'heading_attorneys'      => 'Meet Our Experienced Attorneys',
        'heading_articles'       => 'Latest Articles',

        // Headings — Other Sections
        'heading_testimonials'   => 'Real Stories from Real Clients',
        'heading_faq'            => 'Frequently Asked Questions',
        'heading_contact'        => 'Get In Touch',
        'heading_contact_hero'   => 'Speak With Our Legal Experts',

        // Headings — About Page
        'heading_about_hero'     => 'Legal Excellence Built on Trust and Experience',
        'heading_about_results'  => 'Experienced Solicitors. Proven Results.',
        'heading_about_lawyers'  => 'Supporting You Every Step of the Way',
        'heading_about_contact'  => 'Speak to an Experienced Solicitor Today',

        // Labels
        'label_call_today'       => 'Call us today',
        'label_location'         => 'Location',
        'label_phone_number'     => 'Phone Number',
        'label_support_email'    => 'Support Email',
        'label_quick_links'      => 'Quick links',
        'label_contact_info'     => 'Contact Info',

        // Paragraph Texts
        'text_footer_about'      => 'Our experienced lawyers provide clear, effective legal solutions tailored to your needs.',
        'text_choose_firm'       => 'How to Choose the Right Lawyer for Your Case',
    ];

    // Only set defaults — never overwrite existing admin-saved values
    $existing = get_option('lawfirmpro_contact', []);

    foreach ($defaults as $key => $value) {
        if (!isset($existing[$key]) || $existing[$key] === '') {
            $existing[$key] = $value;
        }
    }

    update_option('lawfirmpro_contact', $existing);
}
