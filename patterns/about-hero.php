<?php

/**
 * Title: About Hero
 * Slug: lawfirmpro/about-hero
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"38px"}},"border":{"top":{"color":"var:preset|color|accent-8","width":"1px"},"right":{},"bottom":{},"left":{}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--accent-8);border-top-width:1px;padding-top:38px"><!-- wp:buttons {"align":"wide","layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons alignwide"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600">About Us</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group"><!-- wp:heading {"textAlign":"center","align":"wide","className":"about-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1"},"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
        <h2 class="wp-block-heading alignwide about-heading" style="padding-right:20px;padding-left:20px;font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_about_hero', 'Legal Excellence Built on Trust and Experience')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"wide","className":"about-paragraph","style":{"typography":{"textAlign":"center","fontWeight":"500"},"spacing":{"padding":{"right":"20px","left":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <p class="has-text-align-center alignwide about-paragraph has-plus-jakarta-sans-font-family" style="padding-right:20px;padding-left:20px;font-weight:500">For over 25 years, we've provided trusted legal advice to individuals, families, and businesses across England & Wales with expertise, integrity, and practical solutions.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:image {"sizeSlug":"large","linkDestination":"none","align":"full","className":"about-main-img"} -->
    <figure class="wp-block-image alignfull size-large about-main-img"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/About-Hero.png')); ?>" alt="" class="wp-image-754" /></figure>
    <!-- /wp:image -->
</div>
<!-- /wp:group -->