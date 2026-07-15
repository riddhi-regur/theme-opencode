<?php
/**
 * Title: Practice Area CTA Buttons
 * Categories: lawfirmpro
 * Keywords: practice area, button, cta
 */
?>
<!-- wp:buttons {"metadata":{"blockVisibility":{"viewport":{"desktop":false,"tablet":false,"mobile":false}}},"style":{"spacing":{"margin":{"top":"60px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:60px"><!-- wp:button {"backgroundColor":"secondary","textColor":"primary","className":"is-style-outline","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"left":"35px","right":"35px","top":"14px","bottom":"14px"}}},"fontFamily":"plus-jakarta-sans"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-primary-color has-secondary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('practice_areas_page_id', '/practice-areas/')); ?>" style="padding-top:14px;padding-right:35px;padding-bottom:14px;padding-left:35px;font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_view_all_services', 'View All Services')); ?> →</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"spacing":{"padding":{"left":"var:preset|spacing|lg","right":"var:preset|spacing|lg"}}},"fontFamily":"plus-jakarta-sans"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-right:var(--wp--preset--spacing--lg);padding-left:var(--wp--preset--spacing--lg);font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_request_quote', 'Request a Quote')); ?> →</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
