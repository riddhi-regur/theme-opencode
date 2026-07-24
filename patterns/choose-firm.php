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
<!-- wp:group {"className":"section-spacing-top","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top"><!-- wp:group {"className":"stack-overflow","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group stack-overflow"><!-- wp:heading {"align":"wide","className":"paragraph-padding","style":{"typography":{"fontWeight":"800","lineHeight":"1.1","textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center alignwide paragraph-padding" style="font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_choose_firm', 'How to Choose the Right Lawyer for Your Case')); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"wide","className":"paragraph-padding","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"textAlign":"center"}},"textColor":"accent"} -->
<p class="has-text-align-center alignwide paragraph-padding has-accent-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_text('text_choose_firm', 'Choosing the right solicitor is essential to achieving the best outcome for your case. Our experienced team provides honest, transparent advice to help you make informed decisions.')); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":63,"query":{"perPage":6,"pages":0,"offset":0,"postType":"about_firm","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"},"align":"wide"} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"className":"stack-overflow","style":{"spacing":{"margin":{"top":"34px"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"width":"2px"}},"borderColor":"accent-5","layout":{"inherit":false}} -->
<div class="wp-block-group has-border-color has-accent-5-border-color" style="border-width:2px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- wp:post-featured-image {"width":"50px","height":"50px"} /-->

<!-- wp:post-title {"className":"blog-detail-heading","style":{"typography":{"fontSize":"32px","fontStyle":"normal","fontWeight":"800"}},"fontFamily":"plus-jakarta-sans"} /-->

<!-- wp:post-excerpt {"showMoreOnNewLine":false,"className":"practice-area-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"}},"textColor":"accent","fontFamily":"plus-jakarta-sans"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->