<?php

/**
 * Title: Real Results
 * Slug: lawfirmpro/about-real-results
 * Categories: featured
 * Description: Law firm introduction section.
 * Keywords: law, legal, attorney, about
 * Inserter: true
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|2xl","bottom":"var:preset|spacing|2xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--2xl);padding-bottom:var(--wp--preset--spacing--2xl)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"52px","left":"52px"}}}} -->
    <div class="wp-block-columns alignwide"><!-- wp:column -->
        <div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/real-results.png')); ?>","dimRatio":0,"style":{"color":[]}} -->
            <div class="wp-block-cover"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/real-results.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
                <div class="wp-block-cover__inner-container"></div>
            </div>
            <!-- /wp:cover -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}}} -->
        <div class="wp-block-column is-vertically-aligned-center" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|0","left":"var:preset|spacing|0","top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:paragraph {"textAlign":"center","className":"practice-area-heading ","style":{"typography":{"fontSize":"48px","fontWeight":"800","lineHeight":"1.2"}},"fontFamily":"plus-jakarta-sans"} -->
                <p class="practice-area-heading has-plus-jakarta-sans-font-family" style="font-size:48px;font-weight:800;line-height:1.2"><?php echo esc_html(lawfirmpro_get_heading('heading_about_results', 'Experienced Solicitors. Proven Results.')); ?></p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

            <!-- wp:paragraph {"className":"practice-area-paragraph","fontFamily":"plus-jakarta-sans"} -->
            <p class="practice-area-paragraph has-plus-jakarta-sans-font-family"><?php echo esc_html(lawfirmpro_get_text('text_about_results', 'Our team brings together specialists across multiple areas of law, offering tailored legal solutions for individuals and businesses. We take time to understand your circumstances before developing practical strategies focused on achieving the best possible outcome.')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->