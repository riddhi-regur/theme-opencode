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
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|0"}}}} -->
    <div class="wp-block-columns alignwide"><!-- wp:column {"verticalAlignment":"center","className":"contact-map"} -->
        <div class="wp-block-column is-vertically-aligned-center contact-map"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group"><!-- wp:heading {"textAlign":"center","className":"practice-area-heading ","style":{"typography":{"fontWeight":"800","lineHeight":"1.2"},"spacing":{"margin":{"right":"var:preset|spacing|lg"}}}} -->
                <h2 class="wp-block-heading practice-area-heading" style="margin-right:var(--wp--preset--spacing--lg);font-weight:800;line-height:1.2"><?php echo esc_html(lawfirmpro_get_heading('heading_about_lawyers', 'Supporting You Every Step of the Way')); ?></h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"className":"practice-area-paragraph","style":{"spacing":{"margin":{"right":"var:preset|spacing|lg"}}},"fontFamily":"plus-jakarta-sans"} -->
                <p class="practice-area-paragraph has-plus-jakarta-sans-font-family" style="margin-right:var(--wp--preset--spacing--lg)">Legal matters can be stressful, but you don't have to face them alone. From your first consultation to the final resolution, our solicitors provide clear communication, honest advice, and dedicated support throughout your legal journey.</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"contact-form"} -->
        <div class="wp-block-column contact-form"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/about-lawyers.png')); ?>","dimRatio":0,"style":{"color":[]}} -->
            <div class="wp-block-cover"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/about-lawyers.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
                <div class="wp-block-cover__inner-container"></div>
            </div>
            <!-- /wp:cover -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->