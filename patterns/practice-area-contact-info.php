<?php
/**
 * Title: Practice Area Contact Info
 * Categories: lawfirmpro
 * Keywords: practice area, contact, phone
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"right":"50px","top":"48px"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="padding-top:48px;padding-right:20px"><!-- wp:group {"style":{"border":{"width":"1px"},"dimensions":{"minHeight":"0px"},"layout":{"selfStretch":"fit","flexSize":""},"spacing":{"padding":{"top":"14px","bottom":"14px","left":"var:preset|spacing|md","right":"var:preset|spacing|md"},"blockGap":"10px"}},"borderColor":"accent-6","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group has-border-color has-accent-6-border-color" style="border-width:1px;min-height:0px;padding-top:14px;padding-right:var(--wp--preset--spacing--md);padding-bottom:14px;padding-left:var(--wp--preset--spacing--md)"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"practice-area-cta-img"} -->
<figure class="wp-block-image size-full practice-area-cta-img"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/call-header.png')); ?>" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"155px"},"spacing":{"blockGap":"5px"},"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"700","lineHeight":"1","letterSpacing":"0%"}},"fontFamily":"plus-jakarta-sans","layout":{"type":"flex","orientation":"vertical","verticalAlignment":"bottom","justifyContent":"left","flexWrap":"wrap"}} -->
<div class="wp-block-group has-plus-jakarta-sans-font-family" style="font-size:18px;font-style:normal;font-weight:700;letter-spacing:0%;line-height:1"><!-- wp:paragraph {"className":"contact-para","style":{"typography":{"fontSize":"12px","fontWeight":"500","lineHeight":"1"},"layout":{"selfStretch":"fit"}},"fontFamily":"plus-jakarta-sans"} -->
<p class="contact-para has-plus-jakarta-sans-font-family" style="font-size:12px;font-weight:500;line-height:1"><?php echo esc_html(lawfirmpro_get_label('label_call_today', 'Call us today')); ?></p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[lawfirmpro_another_phone]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
