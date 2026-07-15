<?php

/**
 * Title: Home About
 * Slug: lawfirmpro/home-about
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-legal-challenges","style":{"spacing":{"margin":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-legal-challenges" style="margin-top:var(--wp--preset--spacing--xl);margin-bottom:var(--wp--preset--spacing--xl)"><!-- wp:columns -->
    <div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center"} -->
        <div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"legal-challenges-stack","style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group legal-challenges-stack"><!-- wp:heading {"textAlign":"center","level":2,"className":"challanges-heading","style":{"typography":{"fontWeight":"300"}}} -->
                <h2 class="wp-block-heading challanges-heading" style="font-weight:300"><?php echo esc_html(lawfirmpro_get_heading('heading_home_about_1', 'Trusted by Clients')); ?></h2>
                <!-- /wp:heading -->

                <!-- wp:heading {"textAlign":"center","level":2,"className":"challanges-heading","style":{"spacing":{"margin":{"top":"0px"}}}} -->
                <h2 class="wp-block-heading challanges-heading" style="margin-top:0px"><?php echo esc_html(lawfirmpro_get_heading('heading_home_about_2', 'Across England & Wales')); ?></h2>
                <!-- /wp:heading -->
            </div>
            <!-- /wp:group -->

            <!-- wp:paragraph {"className":"challenges-paragraph","textColor":"accent","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}}} -->
            <p class="challenges-paragraph has-accent-color has-text-color"><?php echo esc_html(lawfirmpro_get_text('text_home_about_p1', 'For over 25 years, we\'ve helped individuals, families, and businesses navigate legal challenges with confidence. Our commitment is simple—provide honest advice, practical solutions, and dedicated representation from start to finish.')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"className":"challenges-paragraph","textColor":"accent","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}}} -->
            <p class="challenges-paragraph has-accent-color has-text-color"><?php echo esc_html(lawfirmpro_get_text('text_home_about_p2', 'From first consultations to courtroom advocacy, our solicitors are known for professionalism, integrity, and achieving the best possible outcomes for every client.')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"40px","bottom":"40px"}}}} -->
            <div class="wp-block-buttons" style="margin-top:40px;margin-bottom:40px"><!-- wp:button {"backgroundColor":"primary","textColor":"secondary","className":"read-more-btn is-style-fill","style":{"typography":{"fontStyle":"normal","fontWeight":"800","fontSize":"16px","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"fontFamily":"plus-jakarta-sans"} -->
                <div class="wp-block-button read-more-btn is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('about_page_id', '/about/')); ?>" style="font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_read_more', 'Read More')); ?> ➔</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column"><!-- wp:columns {"isStackedOnMobile":false,"className":"column-gap","style":{"spacing":{"blockGap":{"left":"13px"}}}} -->
            <div class="wp-block-columns is-not-stacked-on-mobile column-gap"><!-- wp:column -->
                <div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/legal-challanges-1.png')); ?>","dimRatio":0,"isUserOverlayColor":true,"minHeight":300,"sizeSlug":"full","className":"legal-challenge-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
                    <div class="wp-block-cover legal-challenge-hero" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);min-height:300px"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/legal-challanges-1.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
                        <div class="wp-block-cover__inner-container"></div>
                    </div>
                    <!-- /wp:cover -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|0"}}} -->
                <div class="wp-block-column"><!-- wp:group {"className":"column-gap","style":{"spacing":{"blockGap":"13px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","flexWrap":"nowrap"}} -->
                    <div class="wp-block-group column-gap"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"legal-challenges-images","style":{"layout":{"selfStretch":"fit","flexSize":null}}} -->
                        <figure class="wp-block-image size-full legal-challenges-images"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/legal-challanges-2.jpg')); ?>" alt="" class="" /></figure>
                        <!-- /wp:image -->

                        <!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"legal-challenges-images","style":{"layout":{"selfStretch":"fit","flexSize":null}}} -->
                        <figure class="wp-block-image size-full legal-challenges-images"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/legal-challanges-3.png')); ?>" alt="" class="" /></figure>
                        <!-- /wp:image -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->