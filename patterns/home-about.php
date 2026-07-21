<?php

/**
 * Title: Home About
 * Slug: lawfirmpro/home-about
 * Categories: featured
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top"><!-- wp:columns -->
    <div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center"} -->
        <div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group"><!-- wp:heading {"level":2,"style":{"typography":{"fontStyle":"normal","fontWeight":"300"}}} -->
                <h2 class="wp-block-heading " style="font-style:normal;font-weight:300"><?php echo esc_html(lawfirmpro_get_heading('heading_home_about_1', 'Trusted by Clients')); ?></h2>
                <!-- /wp:heading -->

                <!-- wp:heading {"style":{"spacing":{"margin":{"top":"0px"}}}} -->
                <h2 class="wp-block-heading " style="margin-top:0px"><?php echo esc_html(lawfirmpro_get_heading('heading_home_about_2', 'Across England & Wales')); ?></h2>
                <!-- /wp:heading -->
            </div>
            <!-- /wp:group -->

            <!-- wp:paragraph {"className":"challenges-paragraph has-accent-color has-text-color","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
            <p class="challenges-paragraph has-accent-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_text('text_home_about_p1', 'For over 25 years, we\'ve helped individuals, families, and businesses navigate legal challenges with confidence. Our commitment is simple—provide honest advice, practical solutions, and dedicated representation from start to finish.')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"className":"challenges-paragraph has-accent-color has-text-color","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
            <p class="challenges-paragraph has-accent-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_text('text_home_about_p2', 'From first consultations to courtroom advocacy, our solicitors are known for professionalism, integrity, and achieving the best possible outcomes for every client.')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons {"className":"button-gaps","style":{"spacing":{"blockGap":"16px","padding":{"top":"var:preset|spacing|lg","bottom":"var:preset|spacing|lg"}}},"layout":{"type":"flex","justifyContent":"left","flexWrap":"nowrap"}} -->
            <div class="wp-block-buttons button-gaps" style="padding-top:var(--wp--preset--spacing--lg);padding-bottom:var(--wp--preset--spacing--lg)"><!-- wp:button {"className":"transparent-text-black is-style-fill","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"}},"fontFamily":"plus-jakarta-sans"} -->
                <div class="wp-block-button transparent-text-black is-style-fill"><a class="wp-block-button__link has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('about_page_id', '/about/')); ?>" style="font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_read_more', 'Read More')); ?> ➔</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column"><!-- wp:columns {"isStackedOnMobile":false,"className":"column-gap","style":{"spacing":{"blockGap":{"left":"13px"}}}} -->
            <div class="wp-block-columns has-medium-gutter column-gap"><!-- wp:column -->
                <div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/legal-challanges-1.png')); ?>","dimRatio":0,"isUserOverlayColor":true,"minHeight":100,"minHeightUnit":"%","sizeSlug":"full","className":"legal-challenge-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
                    <div class="wp-block-cover legal-challenge-hero" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);min-height:100%"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/legal-challanges-1.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
                        <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}}} -->
                            <p class="has-text-align-center"></p>
                            <!-- /wp:paragraph -->
                        </div>
                    </div>
                    <!-- /wp:cover -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|0"}}} -->
                <div class="wp-block-column"><!-- wp:group {"className":"column-gap","style":{"spacing":{"blockGap":"13px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","flexWrap":"nowrap"}} -->
                    <div class="wp-block-group column-gap"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fit","flexSize":null}}} -->
                        <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/legal-challanges-2.jpg')); ?>" alt="" /></figure>
                        <!-- /wp:image -->

                        <!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fit","flexSize":null}}} -->
                        <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/legal-challanges-3.png')); ?>" alt="" /></figure>
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