<?php

/**
 * Title: Home Practice Area
 * Slug: lawfirmpro/home-v2-practice-area
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:group {"className":"practice-areas-main","style":{"spacing":{"blockGap":"10px","padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|2xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group practice-areas-main" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--2xl)"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5">Services</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"practice-area-heading-group","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group practice-area-heading-group"><!-- wp:heading {"textAlign":"center"} -->
        <h2 class="wp-block-heading has-text-align-center"><?php echo esc_html(lawfirmpro_get_heading('heading_practice', 'Our Expertise Practice Areas')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"practice-areas-paragraph","style":{"typography":{"textAlign":"center"},"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
        <p class="has-text-align-center practice-areas-paragraph" style="padding-right:20px;padding-left:20px">Tempor ipsum efficitur posuere rutrum uspendisse mollis neque sed orci dignissim, in convallis dui molestie.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"custom-posts-grid practice-area-posts-grid custom-post-slider","style":{"spacing":{"margin":{"top":"var:preset|spacing|md","bottom":"60px"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group custom-posts-grid practice-area-posts-grid custom-post-slider" style="margin-top:var(--wp--preset--spacing--md);margin-bottom:60px;padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"practice-area","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"grid","columnCount":2}} -->
            <!-- wp:group {"className":"practice-area-posts-group","style":{"spacing":{"blockGap":"20px"}},"layout":{"inherit":false}} -->
            <div class="wp-block-group practice-area-posts-group"><!-- wp:post-featured-image {"height":"614px","className":"homepage-practice-areas-post-image "} /-->

                <!-- wp:group {"className":"practice-area-data-group","style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
                <div class="wp-block-group practice-area-data-group"><!-- wp:post-title {"textAlign":"left","isLink":true,"className":"practice-areas-post-tile","style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0%","lineHeight":"1.3","fontSize":"24px"}},"fontFamily":"plus-jakarta-sans"} /-->

                    <!-- wp:post-excerpt {"textAlign":"left","showMoreOnNewLine":false,"excerptLength":46,"className":"practice-areas-post-paragraph","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","letterSpacing":"0%","lineHeight":"1.5"},"spacing":{"padding":{"right":"10px"}}},"fontFamily":"plus-jakarta-sans"} /-->

                    <!-- wp:paragraph {"className":"button-link","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"top":"var:preset|spacing|md","bottom":"40px"}}},"fontFamily":"plus-jakarta-sans"} -->
                    <p class="button-link has-plus-jakarta-sans-font-family" style="padding-top:var(--wp--preset--spacing--md);padding-bottom:40px;font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase">View Service ➔</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->
            <!-- /wp:post-template -->

            <!-- wp:query-pagination {"paginationArrow":"chevron","showLabel":false,"metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"layout":{"type":"flex","justifyContent":"center"}} -->
            <!-- wp:query-pagination-previous /-->

            <!-- wp:query-pagination-numbers /-->

            <!-- wp:query-pagination-next /-->
            <!-- /wp:query-pagination -->
        </div>
        <!-- /wp:query -->
    </div>
    <!-- /wp:group -->

    <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"60px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons" style="margin-top:60px"><!-- wp:button {"backgroundColor":"secondary","textColor":"primary","className":"is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"left":"35px","right":"35px","top":"14px","bottom":"14px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-primary-color has-secondary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('practice_areas_page_id', '/practice-areas/')); ?>" style="padding-top:14px;padding-right:35px;padding-bottom:14px;padding-left:35px;font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase">View All Services ➔</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"backgroundColor":"primary","textColor":"secondary","className":"is-style-outline","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"left":"var:preset|spacing|lg","right":"var:preset|spacing|lg"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-right:var(--wp--preset--spacing--lg);padding-left:var(--wp--preset--spacing--lg);font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase">request a quote ➔</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->