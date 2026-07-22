<?php

/**
 * Title: Header V2
 * Slug: lawfirmpro/header-v2
 * Categories: theme
 */
?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<header class="wp-block-group"><!-- wp:group {"className":"haeder-v2-row","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"backgroundColor":"secondary","textColor":"primary","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center","orientation":"horizontal"}} -->
        <div class="wp-block-group header-v2-row has-primary-color has-secondary-background-color has-text-color has-background has-link-color"><!-- wp:site-logo {"width":178,"className":"header-logo","style":{"color":{"duotone":"var:preset|duotone|midnight-glow"}}} /-->

                <!-- wp:group {"className":"header-contact","style":{"spacing":{"blockGap":"5px"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"}},"textColor":"primary","fontFamily":"plus-jakarta-sans","layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group header-contact has-primary-color has-text-color has-link-color has-plus-jakarta-sans-font-family" style="font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5"><!-- wp:image {"id":117,"className":"size-full","style":{"layout":{"selfStretch":"fixed","flexSize":"20px"},"color":{"duotone":"var:preset|duotone|midnight-glow"}}} -->
                        <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/call-header-1.png')); ?>" alt="" /></figure>
                        <!-- /wp:image -->

                        <!-- wp:shortcode -->
                        <?php echo do_shortcode('[lawfirmpro_another_phone]'); ?>
                        <!-- /wp:shortcode -->
                </div>
                <!-- /wp:group -->

                <?php
                $header_nav = get_posts(array('post_type' => 'wp_navigation', 'name' => 'navigation', 'numberposts' => 1));
                $header_nav_id = $header_nav ? $header_nav[0]->ID : 0;
                ?>
                <!-- wp:navigation {"ref":<?php echo (int) $header_nav_id; ?>,"showSubmenuIcon":false,"overlay":"navigation-overlay","icon":"menu","overlayBackgroundColor":"primary","overlayTextColor":"secondary","className":"header-menu-v2 "} /-->
        </div>

        </div>
        <!-- /wp:group -->
</header>
<!-- /wp:group -->