<?php

/**
 * Title: Contact Hero
 * Slug: lawfirmpro/contact-hero
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:group {"className":"contact-main","style":{"spacing":{"blockGap":"10px","padding":{"top":"40px"}},"border":{"top":{"color":"var:preset|color|accent-8","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group contact-main" style="border-top-color:var(--wp--preset--color--accent-8);border-top-width:1px;padding-top:40px"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5">Contact</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"contact-heading-group","style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group contact-heading-group"><!-- wp:heading {"textAlign":"center","className":"contact-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1","fontSize":"56px"},"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
        <h2 class="wp-block-heading contact-heading" style="padding-right:20px;padding-left:20px;font-size:56px;font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_contact_hero', 'Speak With Our Legal Experts')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"contact-paragraph","style":{"typography":{"fontWeight":"500","lineHeight":"1.5","textAlign":"center"},"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"padding":{"right":"20px","left":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <p class="has-text-align-center contact-paragraph has-plus-jakarta-sans-font-family" style="padding-right:20px;padding-left:20px;font-weight:500;line-height:1.5">Whether you need legal advice, want to schedule a consultation, or have questions about our services. Get in touch today for clear, practical legal guidance.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"contact-details","style":{"spacing":{"padding":{"top":"46px"}}},"layout":{"type":"grid","columnCount":3}} -->
    <div class="wp-block-group contact-details" style="padding-top:46px"><!-- wp:group {"className":"contact-details-group","style":{"border":{"width":"2px"},"spacing":{"padding":{"right":"108px","left":"29px","top":"41px","bottom":"35px"},"blockGap":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500"}},"textColor":"accent","fontFamily":"plus-jakarta-sans","borderColor":"accent-8","layout":{"type":"default"}} -->
        <div class="wp-block-group contact-details-group has-border-color has-accent-8-border-color has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family" style="border-width:2px;padding-top:41px;padding-right:108px;padding-bottom:35px;padding-left:29px;font-size:16px;font-style:normal;font-weight:500"><!-- wp:image {"width":"28px","height":"38px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"contact-details-icon"} -->
            <figure class="wp-block-image size-full is-resized contact-details-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-9.png')); ?>" alt="" class="" style="object-fit:cover;width:28px;height:38px" /></figure>
            <!-- /wp:image -->

            <!-- wp:paragraph {"className":"contact-details-title","style":{"typography":{"fontSize":"24px","fontWeight":"800"},"spacing":{"margin":{"top":"19px"}}},"textColor":"primary","fontFamily":"plus-jakarta-sans"} -->
            <p class="contact-details-title has-primary-color has-text-color has-plus-jakarta-sans-font-family" style="margin-top:19px;font-size:24px;font-weight:800"><?php echo esc_html(lawfirmpro_get_label('label_location', 'Location')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:shortcode -->
            <?php echo do_shortcode('[lawfirmpro_address]'); ?>
            <!-- /wp:shortcode -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"className":"contact-details-group","style":{"border":{"width":"2px"},"spacing":{"padding":{"right":"108px","left":"29px","top":"41px","bottom":"35px"},"blockGap":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500"}},"textColor":"accent","fontFamily":"plus-jakarta-sans","borderColor":"accent-8","layout":{"type":"default"}} -->
        <div class="wp-block-group contact-details-group has-border-color has-accent-8-border-color has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family" style="border-width:2px;padding-top:41px;padding-right:108px;padding-bottom:35px;padding-left:29px;font-size:16px;font-style:normal;font-weight:500"><!-- wp:image {"width":"36px","height":"36px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"contact-details-icon"} -->
            <figure class="wp-block-image size-full is-resized contact-details-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Vector.png')); ?>" alt="" class="" style="object-fit:cover;width:36px;height:36px" /></figure>
            <!-- /wp:image -->

            <!-- wp:paragraph {"className":"contact-details-title","style":{"typography":{"fontSize":"24px","fontWeight":"800"},"spacing":{"margin":{"top":"19px"}}},"textColor":"primary","fontFamily":"plus-jakarta-sans"} -->
            <p class="contact-details-title has-primary-color has-text-color has-plus-jakarta-sans-font-family" style="margin-top:19px;font-size:24px;font-weight:800"><?php echo esc_html(lawfirmpro_get_label('label_phone_number', 'Phone Number')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:shortcode -->
            <?php echo do_shortcode('[lawfirmpro_phone]'); ?>
            <!-- /wp:shortcode -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"className":"contact-details-group","style":{"border":{"width":"2px"},"spacing":{"padding":{"right":"108px","left":"29px","top":"41px","bottom":"35px"},"blockGap":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500"}},"textColor":"accent","fontFamily":"plus-jakarta-sans","borderColor":"accent-8","layout":{"type":"default"}} -->
        <div class="wp-block-group contact-details-group has-border-color has-accent-8-border-color has-accent-color has-text-color has-link-color has-plus-jakarta-sans-font-family" style="border-width:2px;padding-top:41px;padding-right:108px;padding-bottom:35px;padding-left:29px;font-size:16px;font-style:normal;font-weight:500"><!-- wp:image {"width":"38px","height":"38px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"contact-details-icon"} -->
            <figure class="wp-block-image size-full is-resized contact-details-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-2084.png')); ?>" alt="" class="" style="object-fit:cover;width:38px;height:38px" /></figure>
            <!-- /wp:image -->

            <!-- wp:paragraph {"className":"contact-details-title","style":{"typography":{"fontSize":"24px","fontWeight":"800"},"spacing":{"margin":{"top":"16px"}}},"textColor":"primary","fontFamily":"plus-jakarta-sans"} -->
            <p class="contact-details-title has-primary-color has-text-color has-plus-jakarta-sans-font-family" style="margin-top:16px;font-size:24px;font-weight:800"><?php echo esc_html(lawfirmpro_get_label('label_support_email', 'Support Email')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:shortcode -->
            <?php echo do_shortcode('[lawfirmpro_email]'); ?>
            <!-- /wp:shortcode -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->