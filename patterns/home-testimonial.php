<?php

/**
 * Title: Testimonials
 * Slug: lawfirmpro/home-testimonial
 * Categories: featured
 * Description: Dynamic testimonials grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-calculations","style":{"spacing":{"margin":{"top":"64px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group section-spacing-calculations" style="margin-top:64px">

    <!-- wp:group {"align":"full","style":{"spacing":{"margin":{"top":"50px"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignfull" style="margin-top:50px"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","flexWrap":"wrap","justifyContent":"center"}} -->
        <div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"margin":{"bottom":"20px"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
            <div class="wp-block-group" style="margin-bottom:20px"><!-- wp:heading {"className":"practice-area-heading"} -->
                <h2 class="wp-block-heading has-text-align-center practice-area-heading"><?php echo esc_html(lawfirmpro_get_heading('heading_testimonials', 'Real Stories from Real Clients')); ?></h2>
                <!-- /wp:heading -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"custom-posts-grid custom-post-slider","layout":{"type":"default"}} -->
            <div class="wp-block-group custom-posts-grid custom-post-slider"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"testimonial","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
                <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"grid","columnCount":3}} -->
                    <!-- wp:group {"className":"testimonial-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|md","bottom":"44px","left":"var:preset|spacing|md","right":"var:preset|spacing|md"},"blockGap":"21px"},"border":{"width":"1px","color":"#EBEBEB","radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}},"layout":{"inherit":false}} -->
                    <div class="wp-block-group testimonial-card has-border-color" style="border-color:#EBEBEB;border-width:1px;border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:var(--wp--preset--spacing--md);padding-right:var(--wp--preset--spacing--md);padding-bottom:44px;padding-left:var(--wp--preset--spacing--md)"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
                        <div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
                            <div class="wp-block-group"><!-- wp:post-title {"textAlign":"left","isLink":true,"className":"practice-area-post-tile","style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"1.3","letterSpacing":"0px","fontSize":"24px","textTransform":"uppercase"}},"fontFamily":"plus-jakarta-sans"} /-->

                                <!-- wp:lawfirmpro/testimonial-location /-->
                            </div>
                            <!-- /wp:group -->

                            <!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"31px"}}} -->
                            <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/google-icon.png')); ?>" alt="" class="wp-image-296" /></figure>
                            <!-- /wp:image -->
                        </div>
                        <!-- /wp:group -->

                        <!-- wp:group {"style":{"spacing":{"blockGap":"11px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
                        <div class="wp-block-group"><!-- wp:lawfirmpro/testimonial-rating /-->

                            <!-- wp:post-excerpt {"textAlign":"left","showMoreOnNewLine":false,"className":"practice-area-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","letterSpacing":"0px"},"spacing":{"padding":{"right":"30px"}}},"textColor":"accent","fontFamily":"plus-jakarta-sans"} /-->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->
                    <!-- /wp:post-template -->

                    <!-- wp:query-pagination {"paginationArrow":"arrow","showLabel":false,"layout":{"type":"flex","justifyContent":"center"}} -->
                    <!-- wp:query-pagination-previous /-->

                    <!-- wp:query-pagination-numbers /-->

                    <!-- wp:query-pagination-next /-->
                    <!-- /wp:query-pagination -->
                </div>
                <!-- /wp:query -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->