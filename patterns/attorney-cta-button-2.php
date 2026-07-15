<?php
/**
 * Title: Attorney CTA Button 2
 * Categories: lawfirmpro
 * Keywords: attorney, button, cta
 */
?>
<!-- wp:buttons {"className":"attorney-btn","style":{"spacing":{"blockGap":{"left":"8px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons attorney-btn"><!-- wp:button {"backgroundColor":"primary","textColor":"background","className":"offers-request-a-quote-btn is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"},"spacing":{"padding":{"top":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
<div class="wp-block-button offers-request-a-quote-btn is-style-fill"><a class="wp-block-button__link has-background-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('attorneys_page_id', '/attorneys/')); ?>" style="padding-top:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_meet_team', 'Meet Our team')); ?> ➔</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
