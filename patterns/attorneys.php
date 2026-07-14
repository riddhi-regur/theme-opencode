<?php

/**
 * Title: Attorneys
 * Slug: lawfirmpro/attorneys
 * Categories: featured
 * Description: Dynamic attoreys grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"attorneys-main","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group attorneys-main"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5">Team</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"attorney-heading-group","style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group attorney-heading-group"><!-- wp:heading {"className":"attorneys-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1","fontSize":"56px"},"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
        <h2 class="wp-block-heading attorneys-heading" style="padding-right:20px;padding-left:20px;font-size:56px;font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_attorneys', 'Meet Our Experienced Attorneys')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"attorneys-paragraph","style":{"typography":{"fontWeight":"500","lineHeight":"1.5","textAlign":"center"},"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"padding":{"right":"20px","left":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <p class="has-text-align-center attorneys-paragraph has-plus-jakarta-sans-font-family" style="padding-right:20px;padding-left:20px;font-weight:500;line-height:1.5">Our experienced solicitors are committed to providing expert legal advice tailored to your individual needs. Get to know the team behind your success.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"custom-posts-grid attorney-posts-grid","style":{"spacing":{"margin":{"top":"48px","bottom":"48px"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group custom-posts-grid attorney-posts-grid" style="margin-top:48px;margin-bottom:48px;padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":9,"pages":0,"offset":0,"postType":"attorney","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
        <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"grid","columnCount":3}} -->
            <!-- wp:group {"className":"attorney-posts-group","style":{"spacing":{"blockGap":"var:preset|spacing|md","margin":{"bottom":"51px"}}},"layout":{"inherit":false}} -->
            <div class="wp-block-group attorney-posts-group" style="margin-bottom:51px"><!-- wp:post-featured-image {"height":"430px","className":"attorneys-post-image"} /-->

                <!-- wp:group {"className":"attorney-data-group","style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
                <div class="wp-block-group attorney-data-group"><!-- wp:post-title {"textAlign":"center","isLink":true,"className":"attorneys-post-tile","style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0%","fontSize":"24px","lineHeight":"1.3"}},"fontFamily":"plus-jakarta-sans"} /-->

                    <!-- wp:post-excerpt {"textAlign":"center","showMoreOnNewLine":false,"className":"attorneys-post-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","letterSpacing":"0%","lineHeight":"1.5"}},"textColor":"accent","fontFamily":"plus-jakarta-sans"} /-->

                    <!-- wp:shortcode -->
                    <?php echo do_shortcode('[attorney_social_links]'); ?>
                    <!-- /wp:shortcode -->
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

    <!-- wp:buttons {"className":"attorney-btn","style":{"spacing":{"blockGap":{"left":"8px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons attorney-btn"><!-- wp:button {"textColor":"background","className":"offers-request-a-quote-btn is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"},"spacing":{"padding":{"top":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button offers-request-a-quote-btn is-style-fill"><a class="wp-block-button__link has-background-color has-text-color has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('attorneys_page_id', '/attorneys/')); ?>" style="padding-top:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase">Meet Our team➔</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->