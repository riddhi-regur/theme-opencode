<?php

/**
 * Title: Testimonials V2
 * Slug: lawfirmpro/home-v2-testimonial
 * Categories: featured
 * Description: Dynamic testimonials v2 grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top section-spacing-bottom","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group section-spacing-top section-spacing-bottom"><!-- wp:buttons {"align":"full","layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons alignfull"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600"><?php echo esc_html(lawfirmpro_get_label('label_testimonials', 'Testimonials')); ?></a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignfull"><!-- wp:group {"className":"stack-overflow","style":{"spacing":{"margin":{"bottom":"20px"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
        <div class="wp-block-group stack-overflow" style="margin-bottom:20px"><!-- wp:heading {"className":"practice-area-heading"} -->
            <h2 class="wp-block-heading practice-area-heading"><?php echo esc_html(lawfirmpro_get_heading('heading_testimonials', 'Real Stories from Real Clients')); ?></h2>
            <!-- /wp:heading -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"className":"custom-posts-grid testimonial-slider home-v2-testimonial","style":{"spacing":{"margin":{"top":"70px"}}},"layout":{"type":"default"}} -->
        <div class="wp-block-group custom-posts-grid testimonial-slider home-v2-testimonial" style="margin-top:70px"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"testimonial","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
            <div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
                <!-- wp:group {"className":"testimonial-card","style":{"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"},"margin":{"top":"var:preset|spacing|0","bottom":"5px"}},"border":{"width":"1px","color":"#EBEBEB","radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}},"layout":{"inherit":false}} -->
                <div class="wp-block-group testimonial-card has-border-color" style="border-color:#EBEBEB;border-width:1px;border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;margin-top:var(--wp--preset--spacing--0);margin-bottom:5px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:lawfirmpro/testimonial-rating {"className":"testimonial-stars-v2"} /-->

                    <!-- wp:post-excerpt {"textAlign":"center","showMoreOnNewLine":false,"className":"practice-area-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","letterSpacing":"0px"},"spacing":{"padding":{"right":"30px"}}},"textColor":"accent","fontFamily":"plus-jakarta-sans"} /-->

                    <!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
                    <div class="wp-block-group"><!-- wp:post-featured-image /-->

                        <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center"}} -->
                        <div class="wp-block-group"><!-- wp:post-title {"textAlign":"left","isLink":true,"className":"practice-area-post-tile","style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"1.3","letterSpacing":"0px","fontSize":"16px"}},"fontFamily":"plus-jakarta-sans"} /-->

                            <!-- wp:lawfirmpro/testimonial-location {"className":"testimonial-location-v2"} /-->
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
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->