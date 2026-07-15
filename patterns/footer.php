<?php

/**
 * Title: Footer
 * Slug: lawfirmpro/footer
 * Categories: theme
 */
?>
<!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"backgroundColor":"primary","textColor":"secondary","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-secondary-color has-primary-background-color has-text-color has-background has-link-color"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"var:preset|spacing|lg","bottom":"var:preset|spacing|lg"}}}} -->
    <div class="wp-block-columns" style="padding-top:var(--wp--preset--spacing--lg);padding-bottom:var(--wp--preset--spacing--lg)"><!-- wp:column -->
        <div class="wp-block-column"><!-- wp:site-logo {"width":178} /-->

            <!-- wp:paragraph {"className":"footer-paragraph","textColor":"secondary","style":{"typography":{"fontWeight":"500","lineHeight":"1.5"},"layout":{"selfStretch":"fixed","flexSize":""},"spacing":{"padding":{"right":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
            <p class="footer-paragraph has-secondary-color has-text-color has-plus-jakarta-sans-font-family" style="padding-right:20px;font-weight:500;line-height:1.5"><?php echo esc_html(lawfirmpro_get_heading('text_footer_about', 'Our experienced lawyers provide clear, effective legal solutions tailored to your needs.')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:shortcode -->
            <?php echo do_shortcode('[lawfirmpro_social]'); ?>
            <!-- /wp:shortcode -->

            <!-- wp:paragraph {"textColor":"secondary","style":{"typography":{"fontSize":"14px","fontWeight":"500","lineHeight":"1"}},"fontFamily":"plus-jakarta-sans"} -->
            <p class="has-secondary-color has-text-color has-plus-jakarta-sans-font-family" style="font-size:14px;font-weight:500;line-height:1"><?php
                $copyright = lawfirmpro_get_contact('copyright_text');
                if (!$copyright) {
                    $copyright = '© ' . gmdate('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.';
                }
                echo esc_html($copyright);
            ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column"><!-- wp:columns {"className":"footer-links-contact"} -->
            <div class="wp-block-columns footer-links-contact"><!-- wp:column -->
                <div class="wp-block-column"><!-- wp:paragraph {"textColor":"secondary","style":{"typography":{"fontSize":"24px","fontWeight":"700","lineHeight":"1","textAlign":"left"}},"fontFamily":"plus-jakarta-sans"} -->
                    <p class="has-text-align-left has-secondary-color has-text-color has-plus-jakarta-sans-font-family" style="font-size:24px;font-weight:700;line-height:1"><?php echo esc_html(lawfirmpro_get_label('label_quick_links', 'Quick links')); ?></p>
                    <!-- /wp:paragraph -->

                    <?php
                    $ft_nav = get_posts(array('post_type' => 'wp_navigation', 'name' => 'footer-menu', 'numberposts' => 1));
                    $ft_nav_id = $ft_nav ? $ft_nav[0]->ID : 0;
                    ?>
                    <!-- wp:navigation {"ref":<?php echo (int) $ft_nav_id; ?>,"showSubmenuIcon":false,"overlayMenu":"never","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500","letterSpacing":"0px","lineHeight":"2"},"spacing":{"blockGap":"var:preset|spacing|0"}},"fontFamily":"plus-jakarta-sans","layout":{"type":"flex","orientation":"vertical"}} /-->
                </div>
                <!-- /wp:column -->

                <!-- wp:column -->
                <div class="wp-block-column"><!-- wp:paragraph {"textColor":"secondary","style":{"typography":{"fontSize":"24px","fontWeight":"700","lineHeight":"1","textAlign":"left"}},"fontFamily":"plus-jakarta-sans"} -->
                    <p class="has-text-align-left has-secondary-color has-text-color has-plus-jakarta-sans-font-family" style="font-size:24px;font-weight:700;line-height:1"><?php echo esc_html(lawfirmpro_get_label('label_contact_info', 'Contact Info')); ?></p>
                    <!-- /wp:paragraph -->

                    <!-- wp:group {"textColor":"secondary","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500"}},"fontFamily":"plus-jakarta-sans","layout":{"type":"flex","orientation":"vertical"}} -->
                    <div class="wp-block-group has-secondary-color has-text-color has-plus-jakarta-sans-font-family" style="font-size:16px;font-style:normal;font-weight:500"><!-- wp:group {"className":"footer-location","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                        <div class="wp-block-group footer-location"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"16px"},"spacing":{"margin":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs"}}}} -->
                            <figure class="wp-block-image size-full" style="margin-top:var(--wp--preset--spacing--xs);margin-bottom:var(--wp--preset--spacing--xs)"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/site-pin.png')); ?>" alt="" /></figure>
                            <!-- /wp:image -->

                            <!-- wp:shortcode -->
                            <?php echo do_shortcode('[lawfirmpro_address]'); ?>
                            <!-- /wp:shortcode -->
                        </div>
                        <!-- /wp:group -->

                        <!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
                        <div class="wp-block-group"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"16px"}}} -->
                            <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/mail.png')); ?>" alt="" /></figure>
                            <!-- /wp:image -->

                            <!-- wp:shortcode -->
                            <?php echo do_shortcode('[lawfirmpro_email]'); ?>
                            <!-- /wp:shortcode -->
                        </div>
                        <!-- /wp:group -->

                        <!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
                        <div class="wp-block-group"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"16px"}}} -->
                            <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/call.png')); ?>" alt="" /></figure>
                            <!-- /wp:image -->

                            <!-- wp:shortcode -->
                            <?php echo do_shortcode('[lawfirmpro_phone]'); ?>
                            <!-- /wp:shortcode -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->
