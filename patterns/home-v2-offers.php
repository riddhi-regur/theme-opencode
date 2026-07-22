<?php

/**
 * Title: Offers
 * Slug: lawfirmpro/home-v2-offers
 * Categories: featured
 * Description: Dynamic offers grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top","style":{"spacing":{"blockGap":"10px","padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"}}},"backgroundColor":"accent-5","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top has-accent-5-background-color has-background" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5"><?php echo esc_html(lawfirmpro_get_label('label_need_help', 'Need Help?')); ?></a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"stack-overflow","style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group stack-overflow"><!-- wp:heading {"className":"paragraph-padding","style":{"typography":{"textAlign":"center"}}} -->
        <h2 class="wp-block-heading has-text-align-center paragraph-padding"><?php echo esc_html(lawfirmpro_get_heading('heading_offers', 'Let me know how I can make your experience better')); ?></h2>
        <!-- /wp:heading -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"custom-posts-grid offer-posts-grid custom-post-slider","style":{"spacing":{"margin":{"top":"60px"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group custom-posts-grid offer-posts-grid custom-post-slider" style="margin-top:60px;padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"offer","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"grid","columnCount":3}} -->
            <!-- wp:group {"className":"offer-posts-group","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"inherit":false}} -->
            <div class="wp-block-group offer-posts-group"><!-- wp:post-featured-image {"height":"349px","className":"homepage-v2-offer-img"} /-->

                <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|0","padding":{"top":"14px","bottom":"14px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                <div class="wp-block-group" style="padding-top:14px;padding-bottom:14px"><!-- wp:group {"className":"offers-stack","style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"wrap"}} -->
                    <div class="wp-block-group offers-stack"><!-- wp:post-title {"style":{"typography":{"fontSize":"24px","fontStyle":"normal","fontWeight":"600","letterSpacing":"0px","lineHeight":"1.3"}},"fontFamily":"plus-jakarta-sans"} /-->

                        <!-- wp:post-excerpt {"moreText":"","showMoreOnNewLine":false,"excerptLength":30,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.5","letterSpacing":"0px"},"layout":{"selfStretch":"fit","flexSize":""},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent","fontFamily":"plus-jakarta-sans"} /-->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->
            <!-- /wp:post-template -->
        </div>
        <!-- /wp:query -->
    </div>
    <!-- /wp:group -->

    <!-- wp:buttons {"className":"button-gaps","style":{"spacing":{"blockGap":"16px","padding":{"top":"var:preset|spacing|lg"}}},"layout":{"type":"flex","justifyContent":"center","flexWrap":"nowrap"}} -->
    <div class="wp-block-buttons button-gaps" style="padding-top:var(--wp--preset--spacing--lg)"><!-- wp:button {"className":"transparent-text-black is-style-fill","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button transparent-text-black is-style-fill"><a class="wp-block-button__link has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_request_quote', 'Request a Quote')); ?> ➔</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->