<?php

/**
 * Title: Articles
 * Slug: lawfirmpro/articles
 * Categories: featured
 * Description: Dynamic articles grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-bottom","style":{"spacing":{"blockGap":"10px","padding":{"top":"40px"}},"border":{"top":{"color":"var:preset|color|accent-8","width":"1px"},"right":[],"bottom":[],"left":[]}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-bottom" style="border-top-color:var(--wp--preset--color--accent-8);border-top-width:1px;padding-top:40px"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5"><?php echo esc_html(lawfirmpro_get_label('label_blog', 'Blog')); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:group {"className":"stack-overflow","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group stack-overflow"><!-- wp:heading {"className":"paragraph-padding","style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center paragraph-padding"><?php echo esc_html(lawfirmpro_get_heading('heading_articles', 'Your Guide to Understanding the Law')); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"pragraph-padding","style":{"layout":{"selfStretch":"fit","flexSize":null},"typography":{"textAlign":"center"},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
<p class="has-text-align-center pragraph-padding has-accent-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_text('text_articles', 'Stay informed with the latest legal insights, guides, and updates from our expert solicitors.')); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"custom-posts-grid blog-posts-grid","style":{"spacing":{"margin":{"top":"var:preset|spacing|lg","bottom":"var:preset|spacing|lg"},"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group custom-posts-grid blog-posts-grid" style="margin-top:var(--wp--preset--spacing--lg);margin-bottom:var(--wp--preset--spacing--lg);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:query {"queryId":78,"query":{"perPage":9,"pages":0,"offset":0,"postType":"article","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"className":"blog-posts-group","style":{"spacing":{"blockGap":"var:preset|spacing|md","margin":{"bottom":"48px"}}},"layout":{"inherit":false}} -->
<div class="wp-block-group blog-posts-group" style="margin-bottom:48px"><!-- wp:post-featured-image {"height":"108px","className":"blogs-post-image"} /-->

<!-- wp:group {"className":"blog-data-group","style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
<div class="wp-block-group blog-data-group"><!-- wp:group {"className":"blog-excerpt-row","style":{"spacing":{"blockGap":"3px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group blog-excerpt-row"><!-- wp:icon {"icon":"core/tag","className":"blog-icons","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}},"css":"transform: rotate(90deg);"},"textColor":"accent-6"} /-->

<!-- wp:paragraph {"className":"blogs-post-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}}},"textColor":"accent-6"} -->
<p class="has-accent-6-color has-text-color has-link-color blogs-post-paragraph">Commercial</p>
<!-- /wp:paragraph -->

<!-- wp:icon {"icon":"core/calendar","className":"blog-icons","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}}},"textColor":"accent-6"} /-->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"className":"blogs-post-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}},"typography":{"fontSize":"14px","lineHeight":"1.5","letterSpacing":"0%"}},"textColor":"accent-6","fontFamily":"plus-jakarta-sans"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"textAlign":"left","isLink":true,"className":"blogs-post-tile","style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0%","fontSize":"24px","lineHeight":"1.3"}},"fontFamily":"plus-jakarta-sans"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"chevron","showLabel":false,"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->