<?php

/**
 * Title: Articles
 * Slug: lawfirmpro/home-v2-article
 * Categories: featured
 * Description: Dynamic articles grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top section-spacing-bottom","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top section-spacing-bottom"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5"><?php echo esc_html(lawfirmpro_get_label('label_blog', 'Blog')); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:group {"className":"stack-overflow","style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group stack-overflow"><!-- wp:heading {"className":"attorneys-heading"} -->
<h2 class="wp-block-heading attorneys-heading"><?php echo esc_html(lawfirmpro_get_heading('heading_articles', 'Latest Articles')); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"custom-posts-grid blog-posts-grid custom-post-slider","style":{"spacing":{"margin":{"top":"48px","bottom":"var:preset|spacing|0"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group custom-posts-grid blog-posts-grid custom-post-slider" style="margin-top:48px;margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":100,"pages":0,"offset":0,"postType":"article","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"blog-posts-group","style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"inherit":false}} -->
<div class="wp-block-group blog-posts-group"><!-- wp:post-featured-image {"height":"179px","className":"blogs-post-image-homepage"} /-->

<!-- wp:group {"className":"blog-data-group","style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
<div class="wp-block-group blog-data-group"><!-- wp:group {"metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"className":"blog-excerpt-row","style":{"spacing":{"blockGap":"3px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group blog-excerpt-row"><!-- wp:icon {"icon":"core/tag","className":"blog-icons","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}},"css":"transform: rotate(90deg);"},"textColor":"accent-6"} /-->

<!-- wp:post-excerpt {"textAlign":"left","showMoreOnNewLine":false,"excerptLength":46,"className":"blogs-post-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400","letterSpacing":"0%","lineHeight":"1.5"},"spacing":{"padding":{"right":"10px"}}},"textColor":"accent-6","fontFamily":"plus-jakarta-sans"} /-->

<!-- wp:icon {"icon":"core/calendar","className":"blog-icons","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}}},"textColor":"accent-6"} /-->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"className":"blogs-post-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}},"typography":{"fontSize":"14px","lineHeight":"1.5","letterSpacing":"0%"}},"textColor":"accent-6","fontFamily":"plus-jakarta-sans"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"textAlign":"left","isLink":true,"className":"blogs-post-tile","style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0%","fontSize":"24px","lineHeight":"1.3"}},"fontFamily":"plus-jakarta-sans"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"chevron","showLabel":false,"metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->