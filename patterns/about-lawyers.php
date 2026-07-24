<?php

/**
 * Title: About Lawyers
 * Slug: lawfirmpro/about-lawyers
 * Categories: featured
 * Description: Law firm introduction section.
 * Keywords: law, legal, attorney, about
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-bottom","style":{"spacing":{"margin":{"top":"40px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-bottom" style="margin-top:40px"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|md","left":"65px"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"verticalAlignment":"center","className":"contact-map"} -->
<div class="wp-block-column is-vertically-aligned-center contact-map"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:heading {"className":"practice-area-heading "} -->
<h2 class="wp-block-heading practice-area-heading"><?php echo esc_html(lawfirmpro_get_heading('heading_about_lawyers', 'Supporting You Every Step of the Way')); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"practice-area-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
<p class="practice-area-paragraph has-accent-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_text('text_about_lawyers', 'Legal matters can be stressful, but you don\'t have to face them alone. From your first consultation to the final resolution, our solicitors provide clear communication, honest advice, and dedicated support throughout your legal journey.')); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"contact-form"} -->
<div class="wp-block-column contact-form"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/about-lawyers.png')); ?>","dimRatio":0,"style":{"color":[]}} -->
<div class="wp-block-cover"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/about-lawyers.png')); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center"></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->