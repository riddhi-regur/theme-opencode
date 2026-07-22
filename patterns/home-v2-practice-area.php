<?php

/**
 * Title: Home Practice Area
 * Slug: lawfirmpro/home-v2-practice-area
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5"><?php echo esc_html(lawfirmpro_get_label('label_services', 'Services')); ?></a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"practice-area-heading-group","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group practice-area-heading-group"><!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
        <h2 class="wp-block-heading has-text-align-center"><?php echo esc_html(lawfirmpro_get_heading('heading_practice', 'Our Expertise Practice Areas')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"paragraph-padding","style":{"typography":{"textAlign":"center"},"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
        <p class="has-text-align-center paragraph-padding has-accent-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_text('text_practice_sub_v2', 'Expert legal solutions tailored to protect your rights and secure your future. Our dedicated team provides comprehensive legal services across a wide range of practice areas.')); ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"custom-posts-grid practice-area-posts-grid custom-post-slider","style":{"spacing":{"margin":{"top":"var:preset|spacing|md","bottom":"60px"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group custom-posts-grid practice-area-posts-grid custom-post-slider" style="margin-top:var(--wp--preset--spacing--md);margin-bottom:60px;padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"practice-area","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"grid","columnCount":2}} -->
            <!-- wp:group {"className":"practice-area-posts-group","style":{"spacing":{"blockGap":"20px"}},"layout":{"inherit":false}} -->
            <div class="wp-block-group practice-area-posts-group"><!-- wp:post-featured-image {"height":"322px","className":"homepage-practice-areas-post-image "} /-->

                <!-- wp:group {"className":"practice-area-v2-data-group","style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
                <div class="wp-block-group practice-area-v2-data-group"><!-- wp:post-title {"textAlign":"left","isLink":true,"className":"practice-area-v2-title","style":{"typography":{"fontSize":"24px"}}} /-->

                    <!-- wp:post-excerpt {"textAlign":"left","showMoreOnNewLine":false,"excerptLength":46,"style":{"spacing":{"padding":{"right":"10px"}}}} /-->

                    <!-- wp:paragraph {"className":"button-link","style":{"spacing":{"padding":{"top":"var:preset|spacing|md","bottom":"var:preset|spacing|md"}},"typography":{"fontStyle":"normal","fontWeight":"800"}}} -->
                    <p class="button-link" style="padding-top:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--md);font-style:normal;font-weight:800"><?php echo esc_html(lawfirmpro_get_label('btn_view_service', 'View Service')); ?> ➔</p>
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
    <div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--lg)"><!-- wp:button {"className":"is-style-fill transparent-text-black","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"left":"35px","right":"35px","top":"14px","bottom":"14px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-fill transparent-text-black"><a class="wp-block-button__link has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('practice_areas_page_id', '/practice-areas/')); ?>" style="padding-top:14px;padding-right:35px;padding-bottom:14px;padding-left:35px;font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_view_all_services', 'View All Services')); ?> ➔</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"className":"is-style-outline black-background","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"left":"var:preset|spacing|lg","right":"var:preset|spacing|lg"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline black-background"><a class="wp-block-button__link has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-right:var(--wp--preset--spacing--lg);padding-left:var(--wp--preset--spacing--lg);font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_request_quote', 'Request a Quote')); ?> ➔</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->