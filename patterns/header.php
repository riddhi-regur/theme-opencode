<?php

/**
 * Title: Header
 * Slug: lawfirmpro/header
 * Categories: theme
 */
?>
<!-- wp:group {"tagName":"header","style":{"dimensions":{"minHeight":"89px"}},"layout":{"type":"constrained"}} -->
<header class="wp-block-group" style="min-height:89px"><!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"spacing":{"padding":{"top":"var:preset|spacing|sm"}}},"textColor":"secondary","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center","orientation":"horizontal"}} -->
    <div class="wp-block-group has-secondary-color has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--md)"><!-- wp:site-logo {"width":178,"className":"header-logo"} /-->

        <?php
        $header_nav = get_posts(array('post_type' => 'wp_navigation', 'name' => 'navigation', 'numberposts' => 1));
        $header_nav_id = $header_nav ? $header_nav[0]->ID : 0;
        ?>
        <!-- wp:navigation {"ref":<?php echo (int) $header_nav_id; ?>,"showSubmenuIcon":false,"overlay":"navigation-overlay","icon":"menu","className":"header-menu","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600","letterSpacing":"0px"}},"fontFamily":"plus-jakarta-sans"} /-->

        <!-- wp:group {"className":"header-contact","style":{"spacing":{"blockGap":"5px"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"}},"textColor":"secondary","fontFamily":"plus-jakarta-sans","layout":{"type":"flex","flexWrap":"nowrap"}} -->
        <div class="wp-block-group header-contact has-secondary-color has-text-color has-link-color has-plus-jakarta-sans-font-family" style="font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"20px"}}} -->
            <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/call-header-1.png')); ?>" alt="" /></figure>
            <!-- /wp:image -->

            <!-- wp:shortcode -->
            <?php echo do_shortcode('[lawfirmpro_another_phone]'); ?>
            <!-- /wp:shortcode -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
</header>
<!-- /wp:group -->