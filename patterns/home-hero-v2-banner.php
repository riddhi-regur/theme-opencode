<?php

/**
 * Title: Hero V2
 * Slug: lawfirmpro/home-hero-v2-banner
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/hero-v2.png')); ?>","dimRatio":0,"customOverlayColor":"#312c2b","isUserOverlayColor":false,"minHeight":550,"minHeightUnit":"px","contentPosition":"top center","sizeSlug":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-top-center" style="min-height:550px"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/hero-v2.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#312c2b"></span>
    <div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","className":"hero1-content-stack ","style":{"spacing":{"padding":{"top":"80px"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
        <div class="wp-block-group alignwide hero1-content-stack" style="padding-top:80px"><!-- wp:heading {"textAlign":"center","level":1,"className":"hero1-content-heading","style":{"spacing":{"padding":{"right":"20px","left":"20px"}}},"textColor":"secondary"} -->
            <h1 class="wp-block-heading hero1-content-heading has-secondary-color has-text-color" style="padding-right:20px;padding-left:20px"><?php echo esc_html(lawfirmpro_get_heading('heading_hero_v2', 'Reliable Legal Help from Expert Lawyers')); ?></h1>
            <!-- /wp:heading -->

            <!-- wp:buttons {"style":{"spacing":{"padding":{"top":"40px","bottom":"40px"},"blockGap":"16px"}},"layout":{"type":"flex","justifyContent":"center","flexWrap":"nowrap"}} -->
            <div class="wp-block-buttons" style="padding-top:40px;padding-bottom:40px"><!-- wp:button {"backgroundColor":"background","textColor":"primary","className":"explore-services-btn ","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"}},"fontFamily":"plus-jakarta-sans"} -->
                <div class="wp-block-button explore-services-btn"><a class="wp-block-button__link has-primary-color has-background-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('practice_areas_page_id', '/practice-areas/')); ?>" style="font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_explore_services', 'Explore Services')); ?> ➔</a></div>
                <!-- /wp:button -->

                <!-- wp:button {"textColor":"background","className":"is-style-outline request-a-quote-btn","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"},"spacing":{"padding":{"left":"60px","right":"60px","top":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
                <div class="wp-block-button is-style-outline request-a-quote-btn"><a class="wp-block-button__link has-background-color has-text-color has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-top:var(--wp--preset--spacing--sm);padding-right:60px;padding-bottom:var(--wp--preset--spacing--sm);padding-left:60px;font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_request_quote', 'Request a Quote')); ?> ➔</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:group -->
    </div>
</div>
<!-- /wp:cover -->