<?php

/**
 * Title: FAQ
 * Slug: lawfirmpro/home-v2-faq
 * Categories: featured
 * Description: Dynamic FAQ section.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"homepage-v2-faq-main","style":{"spacing":{"margin":{"top":"64px","bottom":"64px"}}},"layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="wp-block-group homepage-v2-faq-main" style="margin-top:64px;margin-bottom:64px"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5">FAQs</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:heading {"textAlign":"center","className":"faq-heading-v2","style":{"typography":{"lineHeight":"1.1"},"spacing":{"padding":{"bottom":"20px"}}}} -->
    <h2 class="wp-block-heading faq-heading-v2" style="padding-bottom:20px;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_faq', 'Frequently Asked Questions')); ?></h2>
    <!-- /wp:heading -->

    <!-- wp:group {"className":"homepage-v2-faq-maingroup","style":{"spacing":{"padding":{"right":"20px","left":"20px"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group homepage-v2-faq-maingroup" style="padding-right:20px;padding-left:20px"><!-- wp:query {"queryId":64,"query":{"perPage":10,"pages":0,"offset":0,"postType":"faq","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-standard-posts","name":"Standard"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}}} -->
            <!-- wp:group {"className":"faq-item active","style":{"border":{"radius":{"topLeft":"6px","topRight":"6px","bottomLeft":"6px","bottomRight":"6px"},"width":"1px"},"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"},"blockGap":"var:preset|spacing|0"}},"borderColor":"accent-8","layout":{"type":"default"}} -->
            <div class="wp-block-group faq-item active has-border-color has-accent-8-border-color" style="border-width:1px;border-top-left-radius:6px;border-top-right-radius:6px;border-bottom-left-radius:6px;border-bottom-right-radius:6px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:group {"className":"faq-header","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                <div class="wp-block-group faq-header"><!-- wp:post-title {"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"500"}},"fontFamily":"plus-jakarta-sans"} /-->

                    <!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"lawfirmpro-faq-item faq-icon","style":{"layout":{"selfStretch":"fixed","flexSize":"22px"}}} -->
                    <figure class="wp-block-image size-full lawfirmpro-faq-item faq-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->
                </div>
                <!-- /wp:group -->

                <!-- wp:post-excerpt {"showMoreOnNewLine":false,"className":"faq-content","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|accent-10"}}}},"textColor":"accent-10","fontFamily":"plus-jakarta-sans"} /-->
            </div>
            <!-- /wp:group -->
            <!-- /wp:post-template -->
        </div>
        <!-- /wp:query -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
