<?php

/**
 * Title: Home Hero Banner
 * Slug: lawfirmpro/home-hero-banner
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/background.png')); ?>","dimRatio":0,"customOverlayColor":"#2e2922","isUserOverlayColor":false,"minHeight":717,"minHeightUnit":"px","contentPosition":"center center","sizeSlug":"full","className":"hero-cover","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover hero-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);min-height:717px"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/background.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#2e2922"></span>
    <div class="wp-block-cover__inner-container"><!-- wp:columns -->
        <div class="wp-block-columns"><!-- wp:column -->
            <div class="wp-block-column"><!-- wp:group {"className":"hero-content-stack","style":{"spacing":{"padding":{"top":"var:preset|spacing|lg","right":"var:preset|spacing|sm"}}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center"}} -->
                <div class="wp-block-group hero-content-stack" style="padding-top:var(--wp--preset--spacing--lg);padding-right:var(--wp--preset--spacing--sm)"><!-- wp:heading {"level":1,"className":"wp-block-heading hero-content-heading","style":{"typography":{"textAlign":"left"}},"textColor":"secondary"} -->
                    <h1 class="wp-block-heading has-text-align-left hero-content-heading has-secondary-color has-text-color"><?php echo esc_html(lawfirmpro_get_heading('heading_hero_v1', 'Trusted Legal Advice When You Need It Most')); ?></h1>
                    <!-- /wp:heading -->

                    <!-- wp:buttons {"className":"button-gaps","style":{"spacing":{"padding":{"top":"var:preset|spacing|lg","bottom":"var:preset|spacing|lg"},"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"flex","justifyContent":"center","flexWrap":"nowrap"}} -->
                    <div class="wp-block-buttons button-gaps" style="padding-top:var(--wp--preset--spacing--lg);padding-bottom:var(--wp--preset--spacing--lg)"><!-- wp:button {"backgroundColor":"secondary","textColor":"primary","className":"transparent-text-white is-style-fill","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"fontFamily":"plus-jakarta-sans"} -->
                        <div class="wp-block-button transparent-text-white is-style-fill"><a class="wp-block-button__link has-primary-color has-secondary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('practice_areas_page_id', '/practice-areas/')); ?>" style="font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_explore_services', 'Explore Services')); ?> ➔</a></div>
                        <!-- /wp:button -->

                        <!-- wp:button {"textColor":"background","className":"is-style-outline white-background","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"},"spacing":{"padding":{"top":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
                        <div class="wp-block-button is-style-outline white-background"><a class="wp-block-button__link has-background-color has-text-color has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-top:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_request_quote', 'Request a Quote')); ?> ➔</a></div>
                        <!-- /wp:button -->
                    </div>
                    <!-- /wp:buttons -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column"></div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
    </div>
</div>
<!-- /wp:cover -->