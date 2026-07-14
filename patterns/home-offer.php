<?php

/**
 * Title: Offer
 * Slug: lawfirmpro/home-offer
 * Categories: featured
 * Description: Dynamic offers grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"offers-main","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group offers-main"><!-- wp:buttons {"metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5">Need Help?</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"offer-heading-group","style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group offer-heading-group"><!-- wp:heading {"textAlign":"center","className":"offers-heading","style":{"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
        <h2 class="wp-block-heading has-text-align-center offers-heading" style="padding-right:20px;padding-left:20px"><?php echo esc_html(lawfirmpro_get_heading('heading_offers', 'How Can I Help You?')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"offers-paragraph","style":{"typography":{"textAlign":"center"},"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"right":"20px","left":"20px"}}},"textColor":"accent"} -->
        <p class="has-text-align-center offers-paragraph has-accent-color has-text-color has-link-color" style="padding-right:20px;padding-left:20px">Tempor ipsum efficitur posuere rutrum uspendisse mollis neque sed orci dignissim, in convallis dui molestie.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"custom-posts-grid offer-posts-grid custom-post-slider","style":{"spacing":{"margin":{"top":"33px","bottom":"var:preset|spacing|0"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group custom-posts-grid offer-posts-grid custom-post-slider" style="margin-top:33px;margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"offer","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"grid","columnCount":3}} -->
            <!-- wp:group {"className":"offer-posts-group","style":{"spacing":{"blockGap":"var:preset|spacing|md","margin":{"bottom":"51px"}}},"layout":{"inherit":false}} -->
            <div class="wp-block-group offer-posts-group" style="margin-bottom:51px"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"customOverlayColor":"#6d655b","isUserOverlayColor":false,"minHeight":478,"contentPosition":"bottom center","className":"offers-cover-img","layout":{"type":"default"}} -->
                <div class="wp-block-cover has-custom-content-position is-position-bottom-center offers-cover-img" style="min-height:478px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#6d655b"></span>
                    <div class="wp-block-cover__inner-container"><!-- wp:group {"className":"frosted-card","style":{"spacing":{"blockGap":"var:preset|spacing|0","padding":{"top":"14px","bottom":"14px","left":"20px","right":"20px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                        <div class="wp-block-group frosted-card" style="padding-top:14px;padding-right:20px;padding-bottom:14px;padding-left:20px"><!-- wp:group {"className":"offers-stack","style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"wrap"}} -->
                            <div class="wp-block-group offers-stack"><!-- wp:post-title {"style":{"typography":{"fontSize":"24px","fontStyle":"normal","fontWeight":"600","letterSpacing":"0px","lineHeight":"1.3"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"plus-jakarta-sans"} /-->

                                <!-- wp:post-excerpt {"moreText":"","showMoreOnNewLine":false,"excerptLength":30,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.5","letterSpacing":"0px"},"layout":{"selfStretch":"fit","flexSize":""},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"plus-jakarta-sans"} /-->
                            </div>
                            <!-- /wp:group -->

                            <!-- wp:image {"sizeSlug":"full","linkDestination":"none","metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"className":"arrow-image button-link","style":{"layout":{"selfStretch":"fixed","flexSize":"40px"}}} -->
                            <figure class="wp-block-image size-full arrow-image button-link"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/up-arrow.png')); ?>" alt="" class="wp-image-246" /></figure>
                            <!-- /wp:image -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                </div>
                <!-- /wp:cover -->
            </div>
            <!-- /wp:group -->
            <!-- /wp:post-template -->

            <!-- wp:query-pagination {"paginationArrow":"arrow","showLabel":false,"metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"layout":{"type":"flex","justifyContent":"center"}} -->
            <!-- wp:query-pagination-previous /-->

            <!-- wp:query-pagination-numbers /-->

            <!-- wp:query-pagination-next /-->
            <!-- /wp:query-pagination -->
        </div>
        <!-- /wp:query -->
    </div>
    <!-- /wp:group -->

    <!-- wp:buttons {"className":"offer-btn","style":{"spacing":{"blockGap":{"left":"8px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons offer-btn"><!-- wp:button {"backgroundColor":"primary","textColor":"background","className":"offers-request-a-quote-btn is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"},"spacing":{"padding":{"top":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button offers-request-a-quote-btn is-style-fill"><a class="wp-block-button__link has-background-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-top:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase">request a quote ➔</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->