<?php

/**
 * Title: Blog Detail Hero
 * Slug: lawfirmpro/blog-detail-hero
 * Categories: featured
 * Description: Dynamic articles grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"blogs-detail-main","style":{"spacing":{"blockGap":"10px","padding":{"top":"var:preset|spacing|lg"}},"border":{"top":{"color":"var:preset|color|accent-8","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group blogs-detail-main" style="border-top-color:var(--wp--preset--color--accent-8);border-top-width:1px;padding-top:var(--wp--preset--spacing--lg)"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5">Blog</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:group {"className":"stack-overflow","style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group stack-overflow"><!-- wp:post-title {"textAlign":"center","className":"blog-detail-title paragraph-padding"} /-->

<!-- wp:group {"className":"blog-excerpt-row","style":{"spacing":{"blockGap":"3px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group blog-excerpt-row"><!-- wp:icon {"icon":"core/tag","className":"blog-detail-icons","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}},"css":"transform: rotate(90deg);"},"textColor":"accent-6"} /-->

<!-- wp:paragraph {"className":"blog-detail-post-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}},"typography":{"fontSize":"14px"}},"textColor":"accent-6"} -->
<p class="blog-detail-post-paragraph has-accent-6-color has-text-color has-link-color" style="font-size:14px">Commercial</p>
<!-- /wp:paragraph -->

<!-- wp:icon {"icon":"core/calendar","className":"blog-detail-icons","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}}},"textColor":"accent-6"} /-->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"className":"blogs-detail-post-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-6"}}},"typography":{"fontSize":"14px","lineHeight":"1.5","letterSpacing":"0%"}},"textColor":"accent-6","fontFamily":"plus-jakarta-sans"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"customOverlayColor":"#FFF","isUserOverlayColor":false,"minHeight":322,"isDark":false,"align":"full","className":"blog-detail-cover","style":{"spacing":{"margin":{"top":"var:preset|spacing|lg"}}},"layout":{"type":"default"}} -->
<div class="wp-block-cover alignfull is-light blog-detail-cover" style="margin-top:var(--wp--preset--spacing--lg);min-height:322px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#FFF"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center"></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->