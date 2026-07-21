<?php

/**
 * Title: FAQ
 * Slug: lawfirmpro/home-faq
 * Categories: featured
 * Description: Dynamic FAQ section.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"backgroundColor":"accent-5","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top has-accent-5-background-color has-background" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0)"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}}} -->
    <div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:column {"verticalAlignment":"center","className":"faq-column","layout":{"type":"constrained"}} -->
        <div class="wp-block-column is-vertically-aligned-center faq-column"><!-- wp:heading {"className":"faq-heading","style":{"typography":{"textAlign":"left"},"spacing":{"padding":{"bottom":"var:preset|spacing|lg"}}}} -->
            <h2 class="wp-block-heading has-text-align-left faq-heading" style="padding-bottom:var(--wp--preset--spacing--lg)"><?php echo esc_html(lawfirmpro_get_heading('heading_faq', 'Frequently Asked Questions')); ?></h2>
            <!-- /wp:heading -->

            <!-- wp:group {"layout":{"type":"default"}} -->
            <div class="wp-block-group"><!-- wp:query {"queryId":64,"query":{"perPage":10,"pages":0,"offset":0,"postType":"faq","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-standard-posts","name":"Standard"}} -->
                <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}}} -->
                    <!-- wp:group {"className":"faq-item active","style":{"border":{"radius":{"topLeft":"6px","topRight":"6px","bottomLeft":"6px","bottomRight":"6px"},"width":"1px"},"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"},"blockGap":"var:preset|spacing|0"}},"borderColor":"accent-9","layout":{"type":"default"}} -->
                    <div class="wp-block-group faq-item active has-border-color has-accent-9-border-color" style="border-width:1px;border-top-left-radius:6px;border-top-right-radius:6px;border-bottom-left-radius:6px;border-bottom-right-radius:6px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:group {"className":"faq-header","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                        <div class="wp-block-group faq-header"><!-- wp:post-title {"style":{"typography":{"fontStyle":"normal","fontWeight":"500"}}} /-->

                            <!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"lawfirmpro-faq-item faq-icon","style":{"layout":{"selfStretch":"fixed","flexSize":"22px"}}} -->
                            <figure class="wp-block-image size-full lawfirmpro-faq-item faq-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group.png')); ?>" alt="" /></figure>
                            <!-- /wp:image -->
                        </div>
                        <!-- /wp:group -->

                        <!-- wp:post-excerpt {"showMoreOnNewLine":false,"className":"faq-content","style":{"color":{"text":"var:preset|color|accent-10"},"typography":{"fontSize":"16px","fontWeight":"400","lineHeight":"24px"},"elements":{"link":{"color":{"text":"var:preset|color|accent-10"}}}},"textColor":"accent-10","fontFamily":"mulish"} /-->
                    </div>
                    <!-- /wp:group -->
                    <!-- /wp:post-template -->
                </div>
                <!-- /wp:query -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"faq-cover-column","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}}} -->
        <div class="wp-block-column faq-cover-column" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/faq.png')); ?>","dimRatio":0,"isUserOverlayColor":true,"sizeSlug":"full","className":"faq-img","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
            <div class="wp-block-cover faq-img" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/faq.png')) ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
                <div class="wp-block-cover__inner-container"></div>
            </div>
            <!-- /wp:cover -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->