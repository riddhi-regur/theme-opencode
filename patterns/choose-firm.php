<?php

/**
 * Title: Choose Firm
 * Slug: lawfirmpro/choose-firm
 * Categories: featured
 * Description: Law firm introduction section.
 * Keywords: law, legal, attorney, about
 * Inserter: true
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"50px","bottom":"50px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:50px;padding-bottom:50px"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group"><!-- wp:heading {"textAlign":"center","align":"wide","className":"about-heading ","style":{"typography":{"fontWeight":"800","lineHeight":"1.1"},"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
        <h2 class="wp-block-heading alignwide about-heading" style="padding-right:20px;padding-left:20px;font-weight:800;line-height:1.1">How to Choose the Right Lawyer for Your Case</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"wide","className":"about-paragraph ","style":{"typography":{"textAlign":"center"},"spacing":{"padding":{"right":"20px","left":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <p class="has-text-align-center alignwide about-paragraph has-plus-jakarta-sans-font-family" style="padding-right:20px;padding-left:20px">Choosing the right solicitor is essential to achieving the best outcome for your case. Our experienced team provides honest, transparent advice to help you make informed decisions.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:query {"queryId":63,"query":{"perPage":6,"pages":0,"offset":0,"postType":"about_firm","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"},"align":"wide"} -->
    <div class="wp-block-query alignwide"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
        <!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"width":"2px"}},"borderColor":"accent-5","layout":{"inherit":false}} -->
        <div class="wp-block-group has-border-color has-accent-5-border-color" style="border-width:2px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- wp:post-featured-image {"width":"50px","height":"50px"} /-->

            <!-- wp:post-title {"className":"blog-detail-heading","style":{"typography":{"fontSize":"32px","fontStyle":"normal","fontWeight":"800"}},"fontFamily":"plus-jakarta-sans"} /-->

            <!-- wp:post-excerpt {"showMoreOnNewLine":false,"className":"practice-area-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"}},"textColor":"accent","fontFamily":"plus-jakarta-sans"} /-->
        </div>
        <!-- /wp:group -->
        <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->
</div>
<!-- /wp:group -->