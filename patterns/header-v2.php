<?php

/**
 * Title: Header V2
 * Slug: lawfirmpro/header-v2
 * Categories: theme
 */
?>
<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0","padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}},"border":{"bottom":{"color":"var:preset|color|accent-8","width":"1px"},"top":{},"right":{},"left":{}}},"backgroundColor":"secondary","layout":{"type":"default"}} -->
<div class="wp-block-group has-secondary-background-color has-background" style="border-bottom-color:var(--wp--preset--color--accent-8);border-bottom-width:1px;margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:group {"tagName":"header","className":"header-v2-row","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"22px","bottom":"24px"}}},"backgroundColor":"secondary","textColor":"primary","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
    <header class="wp-block-group header-v2-row has-primary-color has-secondary-background-color has-text-color has-background has-link-color" style="margin-top:22px;margin-bottom:24px;padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:site-logo {"width":178,"className":"header1-logo","style":{"color":{"duotone":"var:preset|duotone|midnight-glow"}}} /-->

        <?php
        $hnav = get_posts(array('post_type' => 'wp_navigation', 'name' => 'navigation', 'numberposts' => 1));
        $hnav_id = $hnav ? $hnav[0]->ID : 0;
        ?>
        <!-- wp:navigation {"ref":<?php echo (int) $hnav_id; ?>,"showSubmenuIcon":false,"overlay":"navigation-overlay","icon":"menu","className":"header1-menu","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600","letterSpacing":"0px"}},"fontFamily":"plus-jakarta-sans"} /-->

        <!-- wp:group {"className":"header-contact","style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
        <div class="wp-block-group header-contact"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"20px"},"color":{"duotone":"var:preset|duotone|midnight-glow"}}} -->
            <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/call-header-1.png')); ?>" alt="" class="" /></figure>
            <!-- /wp:image -->

            <!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","lineHeight":"1"}},"textColor":"primary","fontFamily":"plus-jakarta-sans"} -->
            <p class="has-primary-color has-text-color has-plus-jakarta-sans-font-family" style="font-weight:600;line-height:1"><?php echo do_shortcode('[lawfirmpro_another_phone]'); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    </header>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->