<?php

/**
 * Title: About Contact
 * Slug: lawfirmpro/about-contact
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/about-contact.png')); ?>","dimRatio":40,"isUserOverlayColor":true,"sizeSlug":"large","style":{"spacing":{"margin":{"top":"var:preset|spacing|xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover" style="margin-top:var(--wp--preset--spacing--xl)"><img class="wp-block-cover__image-background size-large" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/about-contact.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-40 has-background-dim"></span>
    <div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
        <div class="wp-block-group"><!-- wp:heading {"textAlign":"center","align":"wide","className":"about-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1"},"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
            <h2 class="wp-block-heading alignwide about-heading" style="padding-right:20px;padding-left:20px;font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_about_contact', 'Speak to an Experienced Solicitor Today')); ?></h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"wide","className":"about-paragraph","style":{"typography":{"textAlign":"center","lineHeight":"1.5"}},"fontFamily":"plus-jakarta-sans"} -->
            <p class="has-text-align-center alignwide about-paragraph has-plus-jakarta-sans-font-family" style="line-height:1.5"><?php echo esc_html(lawfirmpro_get_text('text_about_contact', 'Whether you need immediate legal advice or want to discuss your options, our friendly team is here to help.')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:columns -->
        <div class="wp-block-columns"><!-- wp:column -->
            <div class="wp-block-column"><!-- wp:buttons {"className":"about-contact-btn","layout":{"type":"flex","justifyContent":"right"}} -->
                <div class="wp-block-buttons about-contact-btn"><!-- wp:button {"backgroundColor":"secondary","textColor":"primary","className":"is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase","lineHeight":"1.5","letterSpacing":"-0.1%"},"spacing":{"padding":{"left":"20px","right":"20px","top":"12px","bottom":"12px"}}},"fontFamily":"plus-jakarta-sans"} -->
                    <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-primary-color has-secondary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-top:12px;padding-right:20px;padding-bottom:12px;padding-left:20px;font-size:16px;font-style:normal;font-weight:800;letter-spacing:-0.1%;line-height:1.5;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_request_quote', 'Request a Quote')); ?> ➔</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:buttons -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column {"verticalAlignment":"center"} -->
            <div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"about-contact","style":{"spacing":{"blockGap":"7px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group about-contact"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"20px"},"css":"transform: rotate(7.97deg);"}} -->
                    <figure class="wp-block-image size-full has-custom-css"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/call-header-1.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"style":{"spacing":{"blockGap":"7px"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center"}} -->
                    <div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontSize":"12px","fontStyle":"normal","fontWeight":"500","lineHeight":"0","letterSpacing":"0%"},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"fontFamily":"plus-jakarta-sans"} -->
                        <p class="has-plus-jakarta-sans-font-family" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);font-size:12px;font-style:normal;font-weight:500;letter-spacing:0%;line-height:0"><?php echo esc_html(lawfirmpro_get_label('label_call_today', 'Call us today')); ?></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph {"className":"about-contact-number","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"700","lineHeight":"1"},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"fontFamily":"plus-jakarta-sans"} -->
                        <p class="about-contact-number has-plus-jakarta-sans-font-family" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);font-size:16px;font-style:normal;font-weight:700;line-height:1"><?php echo do_shortcode('[lawfirmpro_another_phone]'); ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
    </div>
</div>
<!-- /wp:cover -->