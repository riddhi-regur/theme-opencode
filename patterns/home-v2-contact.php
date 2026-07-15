<?php

/**
 * Title: Contact
 * Slug: lawfirmpro/home-v2-contact
 * Categories: featured
 * Description: Dynamic contact section.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"consultation-main","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|3xl"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group consultation-main" style="padding-bottom:var(--wp--preset--spacing--3xl)"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/contact-form.png')); ?>","dimRatio":0,"customOverlayColor":"#544a46","isUserOverlayColor":false,"minHeight":400,"sizeSlug":"large","layout":{"type":"constrained"}} -->
    <div class="wp-block-cover" style="min-height:400px"><img class="wp-block-cover__image-background size-large" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/contact-form.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#544a46"></span>
        <div class="wp-block-cover__inner-container"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|0","left":"var:preset|spacing|0"}}}} -->
            <div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"default"}} -->
                <div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"metadata":{"categories":["featured"],"patternName":"lawfirmpro/contact-form","name":"Contact-Form"},"className":"contact-form-main","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"backgroundColor":"accent-5","textColor":"primary","layout":{"type":"default"}} -->
                    <div class="wp-block-group contact-form-main has-primary-color has-accent-5-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:group {"align":"wide","className":"contact-form-stack","style":{"spacing":{"padding":{"top":"33px","bottom":"33px"},"blockGap":"27px","margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}},"dimensions":{"minHeight":"auto"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top","justifyContent":"center"}} -->
                        <div class="wp-block-group alignwide contact-form-stack" style="min-height:auto;margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:33px;padding-bottom:33px"><!-- wp:heading {"className":"contact-form-heading","style":{"typography":{"lineHeight":"1.1"}}} -->
                            <h2 class="wp-block-heading contact-form-heading" style="line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_consultation', 'Book a Free Consultation')); ?></h2>
                            <!-- /wp:heading -->

                            <!-- wp:group {"className":"contact-form-row","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
                            <div class="wp-block-group contact-form-row" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:shortcode -->
                                [lawfirmpro_cf7]
                                <!-- /wp:shortcode -->
                            </div>
                            <!-- /wp:group -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"center","backgroundColor":"accent-5"} -->
                <div class="wp-block-column is-vertically-aligned-center has-accent-5-background-color has-background"></div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
    </div>
    <!-- /wp:cover -->
</div>
<!-- /wp:group -->