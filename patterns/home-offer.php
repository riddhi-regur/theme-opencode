<?php

/**
 * Title: Offer
 * Slug: lawfirmpro/home-offer
 * Categories: featured
 * Description: Dynamic offers grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top"><!-- wp:group {"className":"stack-overflow","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group stack-overflow"><!-- wp:heading {"level":2,"style":{"typography":{"textAlign":"center"}}} -->
        <h2 class="wp-block-heading has-text-align-center"><?php echo esc_html(lawfirmpro_get_heading('heading_offers', 'How Can I Help You?')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"paragraph-padding","style":{"typography":{"textAlign":"center"}}} -->
        <p class="has-text-align-center paragraph-padding"><?php echo esc_html(lawfirmpro_get_text('text_offers_sub', 'Our specialist legal teams provide expert advice across a wide range of personal and business legal services.')); ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"custom-posts-grid custom-post-slider","style":{"spacing":{"margin":{"top":"33px","bottom":"var:preset|spacing|0"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group custom-posts-grid custom-post-slider" style="margin-top:33px;margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"offer","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"grid","columnCount":3}} -->
            <!-- wp:group {"className":"offer-posts-group","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"inherit":false}} -->
            <div class="wp-block-group offer-posts-group"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"customOverlayColor":"#6d655b","isUserOverlayColor":false,"minHeightUnit":"px","contentPosition":"bottom center","className":"offers-cover-img","layout":{"type":"default"}} -->
                <div class="wp-block-cover has-custom-content-position is-position-bottom-center offers-cover-img"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#6d655b"></span>
                    <div class="wp-block-cover__inner-container"><!-- wp:group {"className":"frosted-card","style":{"spacing":{"blockGap":"var:preset|spacing|0","padding":{"top":"14px","bottom":"14px","left":"20px","right":"20px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                        <div class="wp-block-group frosted-card" style="padding-top:14px;padding-right:20px;padding-bottom:14px;padding-left:20px"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"wrap"}} -->
                            <div class="wp-block-group"><!-- wp:post-title {"style":{"typography":{"fontSize":"24px","fontStyle":"normal","fontWeight":"600","letterSpacing":"0px","lineHeight":"1.3"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"plus-jakarta-sans"} /-->

                                <!-- wp:post-excerpt {"moreText":"","showMoreOnNewLine":false,"excerptLength":12,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.5","letterSpacing":"0px"},"layout":{"selfStretch":"fit","flexSize":""},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"plus-jakarta-sans"} /-->
                            </div>
                            <!-- /wp:group -->

                            <!-- wp:image {"sizeSlug":"full","linkDestination":"none","metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"className":"arrow-image button-link","style":{"layout":{"selfStretch":"fixed","flexSize":"40px"}}} -->
                            <figure class="wp-block-image size-full arrow-image button-link"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/up-arrow.png')); ?>" alt="" /></figure>
                            <!-- /wp:image -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                </div>
                <!-- /wp:cover -->
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