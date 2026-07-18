<?php

/**
 * Title: Home Practice Area
 * Slug: lawfirmpro/home-practice-area
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:group {"className":"practice-areas-main","style":{"spacing":{"blockGap":"10px","padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|2xl"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"backgroundColor":"primary","textColor":"secondary","layout":{"type":"constrained"}} -->
<div class="wp-block-group practice-areas-main has-secondary-color has-primary-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--2-xl)"><!-- wp:group {"className":"practice-area-heading-group","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group practice-area-heading-group"><!-- wp:heading {"className":"wp-block-heading has-text-align-center has-secondary-color has-text-color"} -->
        <h2 class="wp-block-heading has-text-align-center has-secondary-color has-text-color"><?php echo esc_html(lawfirmpro_get_heading('heading_practice', 'Our Expertise Practice Areas')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"has-text-align-center  has-secondary-color has-text-color","style":{"typography":{"textAlign":"center"},"layout":{"selfStretch":"fit","flexSize":null}},"textColor":"secondary"} -->
        <p class="has-text-align-center has-secondary-color has-text-color"><?php echo esc_html(lawfirmpro_get_text('text_practice_sub', 'Expert legal solutions tailored to protect your rights, interests, and future with confidence.')); ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"custom-posts-grid practice-area-posts-grid custom-post-slider","style":{"spacing":{"margin":{"top":"var:preset|spacing|md","bottom":"60px"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group custom-posts-grid practice-area-posts-grid custom-post-slider" style="margin-top:var(--wp--preset--spacing--md);margin-bottom:var(--wp--preset--spacing--lg);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"practice-area","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"grid","columnCount":3}} -->
            <!-- wp:group {"className":"practice-area-posts-group","style":{"spacing":{"blockGap":"20px","margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"backgroundColor":"accent-4","layout":{"type":"constrained"}} -->
            <div class="wp-block-group practice-area-posts-group has-accent-4-background-color has-background" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:post-featured-image {"height":"270px","className":"homepage-practice-areas-post-image "} /-->

                <!-- wp:group {"className":"practice-area-data-group","style":{"spacing":{"blockGap":"8px","padding":{"right":"21px","left":"21px"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
                <div class="wp-block-group practice-area-data-group" style="padding-right:21px;padding-left:21px"><!-- wp:post-title {"textAlign":"left","isLink":true,"className":"practice-areas-post-tile","style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0%","lineHeight":"1.3","fontSize":"24px"}},"fontFamily":"plus-jakarta-sans"} /-->

                    <!-- wp:post-excerpt {"textAlign":"left","showMoreOnNewLine":false,"excerptLength":25,"className":"practice-areas-post-paragraph","style":{"color":{"text":"var:preset|color|secondary"},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","letterSpacing":"0%","lineHeight":"1.5"},"spacing":{"padding":{"right":"10px"}}},"textColor":"secondary","fontFamily":"plus-jakarta-sans"} /-->

                    <!-- wp:paragraph {"className":"button-link","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"top":"var:preset|spacing|md","bottom":"40px"}}},"textColor":"secondary","fontFamily":"plus-jakarta-sans"} -->
                    <p class="button-link has-secondary-color has-text-color has-plus-jakarta-sans-font-family" style="padding-top:var(--wp--preset--spacing--md);padding-bottom:40px;font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_view_service', 'View Service')); ?> ➔</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->
            <!-- /wp:post-template -->
        </div>
        <!-- /wp:query -->
    </div>
    <!-- /wp:group -->

    <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|lg"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--lg)"><!-- wp:button {"backgroundColor":"secondary","textColor":"primary","className":"is-style-fill transparent-text-white","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"left":"35px","right":"35px","top":"14px","bottom":"14px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-fill transparent-text-white"><a class="wp-block-button__link has-primary-color has-secondary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('practice_areas_page_id', '/practice-areas/')); ?>" style="padding-top:14px;padding-right:35px;padding-bottom:14px;padding-left:35px;font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_view_all_services', 'View All Services')); ?> ➔</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"className":"is-style-outline white-background","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"left":"var:preset|spacing|lg","right":"var:preset|spacing|lg"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline white-background"><a class="wp-block-button__link has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-right:var(--wp--preset--spacing--lg);padding-left:var(--wp--preset--spacing--lg);font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_request_quote', 'Request a Quote')); ?> ➔</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->