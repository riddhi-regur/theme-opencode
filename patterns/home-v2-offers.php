<?php

/**
 * Title: Offers
 * Slug: lawfirmpro/home-v2-offers
 * Categories: featured
 * Description: Dynamic offers grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"offers-main","style":{"spacing":{"blockGap":"10px","padding":{"top":"67px","bottom":"67px"}}},"backgroundColor":"accent-5","layout":{"type":"constrained"}} -->
<div class="wp-block-group offers-main has-accent-5-background-color has-background" style="padding-top:67px;padding-bottom:67px"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5">Need Help?</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"offer-heading-group","style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group offer-heading-group"><!-- wp:heading {"textAlign":"center","className":"offers-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1","fontSize":"56px"},"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
        <h2 class="wp-block-heading offers-heading" style="padding-right:20px;padding-left:20px;font-size:56px;font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_offers', 'Let me know how I can make your experience better')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"className":"offers-paragraph","style":{"typography":{"fontWeight":"500","lineHeight":"1.5","textAlign":"center"},"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"padding":{"right":"20px","left":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <p class="has-text-align-center offers-paragraph has-text-color has-plus-jakarta-sans-font-family" style="padding-right:20px;padding-left:20px;font-weight:500;line-height:1.5">Tempor ipsum efficitur posuere rutrum uspendisse mollis neque sed orci dignissim, in convallis dui molestie.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"custom-posts-grid offer-posts-grid custom-post-slider","style":{"spacing":{"margin":{"top":"60px"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group custom-posts-grid offer-posts-grid custom-post-slider" style="margin-top:60px;padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"offer","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"grid","columnCount":3}} -->
            <!-- wp:group {"className":"offer-posts-group","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"inherit":false}} -->
            <div class="wp-block-group offer-posts-group"><!-- wp:post-featured-image {"height":"478px","className":"homepage-v2-offer-img"} /-->

                <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|0","padding":{"top":"14px","bottom":"14px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                <div class="wp-block-group" style="padding-top:14px;padding-bottom:14px"><!-- wp:group {"className":"offers-stack","style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"wrap"}} -->
                    <div class="wp-block-group offers-stack"><!-- wp:post-title {"style":{"typography":{"fontSize":"24px","fontStyle":"normal","fontWeight":"600","letterSpacing":"0px","lineHeight":"1.3"}},"fontFamily":"plus-jakarta-sans"} /-->

                        <!-- wp:post-excerpt {"moreText":"","showMoreOnNewLine":false,"excerptLength":30,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.5","letterSpacing":"0px"},"layout":{"selfStretch":"fit","flexSize":""}},"fontFamily":"plus-jakarta-sans"} /-->
                    </div>
                    <!-- /wp:group -->

                    <!-- wp:image {"sizeSlug":"full","linkDestination":"none","metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"className":"arrow-image button-link","style":{"layout":{"selfStretch":"fixed","flexSize":"40px"}}} -->
                    <figure class="wp-block-image size-full arrow-image button-link"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/up-arrow.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->
                </div>
                <!-- /wp:group -->
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

    <!-- wp:buttons {"className":"offer-btn","style":{"spacing":{"blockGap":{"left":"8px"},"margin":{"top":"78px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons offer-btn" style="margin-top:78px"><!-- wp:button {"backgroundColor":"primary","textColor":"background","className":"offers-request-a-quote-btn is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"},"spacing":{"padding":{"top":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button offers-request-a-quote-btn is-style-fill"><a class="wp-block-button__link has-background-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-top:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase">request a quote ➔</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->
