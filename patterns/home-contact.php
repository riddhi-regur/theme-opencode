<?php

/**
 * Title: Contact
 * Slug: lawfirmpro/home-contact
 * Categories: featured
 * Description: Dynamic contact section.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"consultation-main","layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="wp-block-group consultation-main"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|0","left":"var:preset|spacing|0"}}}} -->
    <div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"","style":{"spacing":{"padding":{"right":"20px"},"blockGap":"16px"}},"layout":{"type":"default"}} -->
        <div class="wp-block-column is-vertically-aligned-center" style="padding-right:var(--wp--preset--spacing--sm)">        <!-- wp:heading {"className":"consultation-heading","style":{"typography":{"textAlign":"left","lineHeight":"1.1"}}} -->
            <h2 class="wp-block-heading has-text-align-left consultation-heading" style="line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_consultation', 'Book a Free Consultation')); ?></h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"consultation-paragraph","style":{"typography":{"lineHeight":"1.2"},"spacing":{"padding":{"right":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
            <p class="consultation-paragraph has-text-color has-plus-jakarta-sans-font-family" style="padding-right:var(--wp--preset--spacing--sm);line-height:1.2"><?php echo esc_html(lawfirmpro_get_text('text_consultation', 'Ready to discuss your legal needs? Contact us today for a free initial consultation with our experienced team.')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:group {"style":{"spacing":{"padding":{"right":"50px","top":"48px"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
            <div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--lg);padding-right:var(--wp--preset--spacing--lg)"><!-- wp:group {"style":{"border":{"width":"1px","color":"#8F8F8F"},"dimensions":{"minHeight":"0px"},"layout":{"selfStretch":"fit","flexSize":""},"spacing":{"padding":{"top":"14px","bottom":"14px","left":"var:preset|spacing|md","right":"var:preset|spacing|md"},"blockGap":"10px"}},"borderColor":"accent-6","layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group has-border-color has-accent-6-border-color" style="border-color:#8F8F8F;border-width:1px;min-height:0px;padding-top:14px;padding-right:var(--wp--preset--spacing--md);padding-bottom:14px;padding-left:var(--wp--preset--spacing--md)"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"color":{"duotone":"var:preset|duotone|midnight-glow"},"layout":{"selfStretch":"fixed","flexSize":"24px"}}} -->
                    <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/call-header.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"textColor":"primary","style":{"layout":{"selfStretch":"fixed","flexSize":"155px"},"spacing":{"blockGap":"5px"},"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"700","lineHeight":"1","letterSpacing":"0%"}},"fontFamily":"plus-jakarta-sans","layout":{"type":"flex","orientation":"vertical","verticalAlignment":"bottom","justifyContent":"left","flexWrap":"wrap"}} -->
                    <div class="wp-block-group has-primary-color has-text-color has-plus-jakarta-sans-font-family" style="font-size:18px;font-style:normal;font-weight:700;letter-spacing:0%;line-height:1"><!-- wp:paragraph {"className":"contact-para","style":{"typography":{"fontSize":"12px","fontWeight":"500","lineHeight":"1"},"layout":{"selfStretch":"fit"}},"fontFamily":"plus-jakarta-sans"} -->
                        <p class="contact-para has-plus-jakarta-sans-font-family" style="font-size:12px;font-weight:500;line-height:1"><?php echo esc_html(lawfirmpro_get_label('label_call_today', 'Call us today')); ?></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:shortcode -->
                        <?php echo do_shortcode('[lawfirmpro_another_phone]'); ?>
                        <!-- /wp:shortcode -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"center","backgroundColor":"accent-5"} -->
        <div class="wp-block-column is-vertically-aligned-center has-accent-5-background-color has-background"><!-- wp:group {"metadata":{"categories":["featured"],"patternName":"lawfirmpro/contact-form","name":"Contact-Form"},"className":"contact-form-main","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"backgroundColor":"accent-5","layout":{"type":"default"}} -->
            <div class="wp-block-group contact-form-main has-accent-5-background-color has-background" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:group {"align":"wide","className":"contact-form-stack","style":{"spacing":{"padding":{"top":"33px","bottom":"33px"},"blockGap":"27px","margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}},"dimensions":{"minHeight":"auto"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top","justifyContent":"center"}} -->
                <div class="wp-block-group alignwide contact-form-stack" style="min-height:auto;margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:33px;padding-bottom:33px">                        <!-- wp:heading {"className":"contact-form-heading","style":{"typography":{"lineHeight":"1.1"}}} -->
                    <h2 class="wp-block-heading contact-form-heading" style="line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_contact', 'Get In Touch')); ?></h2>
                    <!-- /wp:heading -->

                    <!-- wp:group {"className":"contact-form-row","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                    <div class="wp-block-group contact-form-row" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:shortcode -->
                        [lawfirmpro_cf7]
                        <!-- /wp:shortcode -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->