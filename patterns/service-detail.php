<?php

/**
 * Title: Service Detail
 * Slug: lawfirmpro/service-detail
 * Categories: featured
 * Description: Dynamic service details.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"service-details-section1","style":{"spacing":{"padding":{"top":"var:preset|spacing|3xl","bottom":"var:preset|spacing|3xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group service-details-section1" style="padding-top:var(--wp--preset--spacing--3xl);padding-bottom:var(--wp--preset--spacing--3xl)"><!-- wp:columns {"verticalAlignment":"top","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":{"top":"var:preset|spacing|sm","left":"16px"}}}} -->
    <div class="wp-block-columns are-vertically-aligned-top" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:column {"verticalAlignment":"top","width":"px","style":{"spacing":{"padding":{"left":"var:preset|spacing|0","right":"var:preset|spacing|0","top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"backgroundColor":"secondary"} -->
        <div class="wp-block-column is-vertically-aligned-top has-secondary-background-color has-background" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:group {"className":"service-detail-section1-stack","style":{"spacing":{"blockGap":"6px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group service-detail-section1-stack">                <!-- wp:heading {"textAlign":"center","className":"service-detail-section1-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1"},"spacing":{"padding":{"right":"var:preset|spacing|sm"}}}} -->
                <h2 class="wp-block-heading service-detail-section1-heading" style="padding-right:var(--wp--preset--spacing--sm);font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_hero_v1', 'Lawyers Who Put You First')); ?></h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"className":"service-detail-section1-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"padding":{"right":"var:preset|spacing|0"}}},"fontFamily":"plus-jakarta-sans"} -->
                <p class="service-detail-section1-paragraph has-plus-jakarta-sans-font-family" style="padding-right:var(--wp--preset--spacing--0);line-height:1.5"><?php echo esc_html(lawfirmpro_get_text('text_sd_intro', 'Our team brings together specialists across multiple areas of law, ensuring comprehensive legal support for every client.')); ?></p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"service-detail-section1-group","style":{"spacing":{"margin":{"top":"var:preset|spacing|lg"}}},"layout":{"type":"default"}} -->
            <div class="wp-block-group service-detail-section1-group" style="margin-top:var(--wp--preset--spacing--lg)"><!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                <div class="wp-block-group"><!-- wp:image {"width":"20px","height":"20px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"team-detail-right-image","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}}} -->
                    <figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-4.png')); ?>" alt="" class="" style="object-fit:cover;width:20px;height:20px" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
                    <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"textAlign":"center","className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}}} -->
                        <h2 class="wp-block-heading team-details-paragraph" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_feature_1', 'Tailored Funding Options')); ?></h2>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
                        <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:var(--wp--preset--spacing--sm);line-height:1.5"><?php echo esc_html(lawfirmpro_get_text('text_sd_body', 'We pride ourselves on delivering practical, results-driven legal advice with a personal touch.')); ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->

                <!-- wp:separator {"className":"is-style-wide","backgroundColor":"accent-2"} -->
                <hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide" />
                <!-- /wp:separator -->

                <!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                <div class="wp-block-group"><!-- wp:image {"width":"20px","height":"20px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"team-detail-right-image","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}}} -->
                    <figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-4.png')); ?>" alt="" class="" style="object-fit:cover;width:20px;height:20px" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
                    <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"textAlign":"center","className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}}} -->
                        <h2 class="wp-block-heading team-details-paragraph" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_feature_2', 'Seamless Process')); ?></h2>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
                        <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:var(--wp--preset--spacing--sm);line-height:1.5"><?php echo esc_html(lawfirmpro_get_text('text_sd_body', 'We pride ourselves on delivering practical, results-driven legal advice with a personal touch.')); ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->

                <!-- wp:separator {"className":"is-style-wide","backgroundColor":"accent-2"} -->
                <hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide" />
                <!-- /wp:separator -->

                <!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                <div class="wp-block-group"><!-- wp:image {"width":"20px","height":"20px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"team-detail-right-image","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}}} -->
                    <figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-4.png')); ?>" alt="" class="" style="object-fit:cover;width:20px;height:20px" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
                    <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"textAlign":"center","className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}}} -->
                        <h2 class="wp-block-heading team-details-paragraph" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_feature_3', 'Diversified Portfolio')); ?></h2>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
                        <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:var(--wp--preset--spacing--sm);line-height:1.5"><?php echo esc_html(lawfirmpro_get_text('text_sd_body', 'We pride ourselves on delivering practical, results-driven legal advice with a personal touch.')); ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"top","className":"service-details-column","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary"} -->
        <div class="wp-block-column is-vertically-aligned-top service-details-column has-secondary-color has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group.png')); ?>","dimRatio":0,"minHeight":400,"className":"service-detail-cover-img","layout":{"type":"constrained"}} -->
            <div class="wp-block-cover service-detail-cover-img" style="min-height:400px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
                <div class="wp-block-cover__inner-container"></div>
            </div>
            <!-- /wp:cover -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:cover {"overlayColor":"accent-5","isUserOverlayColor":true,"isDark":false,"align":"full","className":"service-detail-section2","style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"},"blockGap":"32px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull is-light service-detail-section2" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span>
    <div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
        <div class="wp-block-group">        <!-- wp:heading {"textAlign":"center","align":"wide","className":"service-detail-section2-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1"},"spacing":{"padding":{"right":"var:preset|spacing|sm","left":"var:preset|spacing|sm"}}}} -->
            <h2 class="wp-block-heading alignwide service-detail-section2-heading" style="padding-right:var(--wp--preset--spacing--sm);padding-left:var(--wp--preset--spacing--sm);font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_solutions', 'Funding Solutions For Growing Businesses')); ?></h2>
            <!-- /wp:heading -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"align":"wide","className":"service-detail-section2-grid","style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"grid","columnCount":2}} -->
        <div class="wp-block-group alignwide service-detail-section2-grid"><!-- wp:columns {"className":"service-detail-section2-columns","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"backgroundColor":"secondary"} -->
            <div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:column {"width":""} -->
                <div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group-1.png')); ?>","dimRatio":0,"minHeight":304,"className":"service-detail-section2-cover-img"} -->
                    <div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group-1.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
                        <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}}} -->
                            <p class="has-text-align-center"></p>
                            <!-- /wp:paragraph -->
                        </div>
                    </div>
                    <!-- /wp:cover -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"center","width":"","className":"service-detail-section2-column"} -->
                <div class="wp-block-column is-vertically-aligned-center service-detail-section2-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"service-detail-section2-icon","style":{"layout":{"selfStretch":"fit","flexSize":null}}} -->
                    <figure class="wp-block-image size-full service-detail-section2-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-5.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"className":"service-detail-section2-grid-stack","style":{"spacing":{"padding":{"left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center"}} -->
                    <div class="wp-block-group service-detail-section2-grid-stack" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                    <!-- wp:heading {"textAlign":"center","className":"service-detail-section2-subtitle","style":{"typography":{"fontSize":"24px","fontWeight":"800"}}} -->
                        <h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:24px;font-weight:800"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_step_1', 'Planning the case')); ?></h2>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph {"className":"service-detail-section2-paragraph","textColor":"accent","fontFamily":"plus-jakarta-sans"} -->
                        <p class="service-detail-section2-paragraph has-accent-color has-text-color has-plus-jakarta-sans-font-family"><?php echo esc_html(lawfirmpro_get_text('text_sd_step_body', 'With decades of combined experience, our solicitors are well-equipped to handle the most complex legal challenges.')); ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->

            <!-- wp:columns {"className":"service-detail-section2-columns","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"backgroundColor":"secondary"} -->
            <div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:column {"width":""} -->
                <div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group-2.png')); ?>","dimRatio":0,"customOverlayColor":"#473d3b","isUserOverlayColor":false,"minHeight":304,"sizeSlug":"full","className":"service-detail-section2-cover-img"} -->
                    <div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group-2.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#473d3b"></span>
                        <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}}} -->
                            <p class="has-text-align-center"></p>
                            <!-- /wp:paragraph -->
                        </div>
                    </div>
                    <!-- /wp:cover -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"center","width":"","className":"service-detail-section2-column"} -->
                <div class="wp-block-column is-vertically-aligned-center service-detail-section2-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"service-detail-section2-icon","style":{"layout":{"selfStretch":"fit","flexSize":null}}} -->
                    <figure class="wp-block-image size-full service-detail-section2-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-6.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"className":"service-detail-section2-grid-stack","style":{"spacing":{"padding":{"left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center"}} -->
                    <div class="wp-block-group service-detail-section2-grid-stack" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                    <!-- wp:heading {"textAlign":"center","className":"service-detail-section2-subtitle","style":{"typography":{"fontSize":"24px","fontWeight":"800"}}} -->
                        <h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:24px;font-weight:800"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_step_2', 'Evaluate Situation')); ?></h2>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph {"className":"service-detail-section2-paragraph","textColor":"accent","fontFamily":"plus-jakarta-sans"} -->
                        <p class="service-detail-section2-paragraph has-accent-color has-text-color has-plus-jakarta-sans-font-family"><?php echo esc_html(lawfirmpro_get_text('text_sd_step_body', 'With decades of combined experience, our solicitors are well-equipped to handle the most complex legal challenges.')); ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->

            <!-- wp:columns {"className":"service-detail-section2-columns","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"backgroundColor":"secondary"} -->
            <div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:column {"width":""} -->
                <div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group-3.png')); ?>","dimRatio":0,"customOverlayColor":"#4c3c32","isUserOverlayColor":false,"minHeight":304,"sizeSlug":"full","className":"service-detail-section2-cover-img"} -->
                    <div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group-3.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4c3c32"></span>
                        <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}}} -->
                            <p class="has-text-align-center"></p>
                            <!-- /wp:paragraph -->
                        </div>
                    </div>
                    <!-- /wp:cover -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"center","width":"","className":"service-detail-section2-column"} -->
                <div class="wp-block-column is-vertically-aligned-center service-detail-section2-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"service-detail-section2-icon","style":{"layout":{"selfStretch":"fit","flexSize":null}}} -->
                    <figure class="wp-block-image size-full service-detail-section2-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-7.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"className":"service-detail-section2-grid-stack","style":{"spacing":{"padding":{"left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center"}} -->
                    <div class="wp-block-group service-detail-section2-grid-stack" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                    <!-- wp:heading {"textAlign":"center","className":"service-detail-section2-subtitle","style":{"typography":{"fontSize":"24px","fontWeight":"800"}}} -->
                        <h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:24px;font-weight:800"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_step_3', 'Initiate Court Case')); ?></h2>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph {"className":"service-detail-section2-paragraph","textColor":"accent","fontFamily":"plus-jakarta-sans"} -->
                        <p class="service-detail-section2-paragraph has-accent-color has-text-color has-plus-jakarta-sans-font-family"><?php echo esc_html(lawfirmpro_get_text('text_sd_step_body', 'With decades of combined experience, our solicitors are well-equipped to handle the most complex legal challenges.')); ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->

            <!-- wp:columns {"className":"service-detail-section2-columns","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"backgroundColor":"secondary"} -->
            <div class="wp-block-columns service-detail-section2-columns has-secondary-background-color has-background" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:column {"width":""} -->
                <div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group-4.png')); ?>","dimRatio":0,"customOverlayColor":"#88797a","isUserOverlayColor":false,"minHeight":304,"sizeSlug":"full","className":"service-detail-section2-cover-img"} -->
                    <div class="wp-block-cover service-detail-section2-cover-img" style="min-height:304px"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/Mask-group-4.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#88797a"></span>
                        <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}}} -->
                            <p class="has-text-align-center"></p>
                            <!-- /wp:paragraph -->
                        </div>
                    </div>
                    <!-- /wp:cover -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"center","width":"","className":"service-detail-section2-column"} -->
                <div class="wp-block-column is-vertically-aligned-center service-detail-section2-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"service-detail-section2-icon","style":{"layout":{"selfStretch":"fit","flexSize":null}}} -->
                    <figure class="wp-block-image size-full service-detail-section2-icon"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-8.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"className":"service-detail-section2-grid-stack","style":{"spacing":{"padding":{"left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center"}} -->
                    <div class="wp-block-group service-detail-section2-grid-stack" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                    <!-- wp:heading {"textAlign":"center","className":"service-detail-section2-subtitle","style":{"typography":{"fontSize":"24px","fontWeight":"800"}}} -->
                        <h2 class="wp-block-heading service-detail-section2-subtitle" style="font-size:24px;font-weight:800"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_step_4', 'Gather Information')); ?></h2>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph {"className":"service-detail-section2-paragraph","textColor":"accent","fontFamily":"plus-jakarta-sans"} -->
                        <p class="service-detail-section2-paragraph has-accent-color has-text-color has-plus-jakarta-sans-font-family"><?php echo esc_html(lawfirmpro_get_text('text_sd_step_body', 'With decades of combined experience, our solicitors are well-equipped to handle the most complex legal challenges.')); ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->

        <!-- wp:buttons {"align":"wide","layout":{"type":"flex","justifyContent":"center"}} -->
        <div class="wp-block-buttons alignwide"><!-- wp:button {"backgroundColor":"primary","textColor":"secondary","className":"is-style-fill","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"spacing":{"padding":{"left":"var:preset|spacing|lg","right":"var:preset|spacing|lg","top":"14px","bottom":"14px"}}},"fontFamily":"plus-jakarta-sans"} -->
            <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-secondary-color has-primary-background-color has-text-color has-background has-link-color has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('contact_page_id', '/contact/')); ?>" style="padding-top:14px;padding-right:var(--wp--preset--spacing--lg);padding-bottom:14px;padding-left:var(--wp--preset--spacing--lg);font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_request_quote', 'Request a Quote')); ?> ➔</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
    </div>
</div>
<!-- /wp:cover -->

<!-- wp:group {"align":"wide","className":"service-detail-section3","style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"},"blockGap":"40px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide service-detail-section3" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)"><!-- wp:group {"className":"service-detail-section3-stack","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group service-detail-section3-stack">        <!-- wp:heading {"textAlign":"center","className":"service-detail-section3-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1"},"spacing":{"padding":{"right":"var:preset|spacing|sm","left":"var:preset|spacing|sm"}}}} -->
        <h2 class="wp-block-heading service-detail-section3-heading" style="padding-right:var(--wp--preset--spacing--sm);padding-left:var(--wp--preset--spacing--sm);font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_section3', 'Assets With &nbsp;Assurance Of Expert Guidance')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"service-detail-section3-paragraph","style":{"typography":{"textAlign":"center","lineHeight":"1.5"},"spacing":{"padding":{"right":"var:preset|spacing|sm","left":"var:preset|spacing|sm"}}},"fontFamily":"plus-jakarta-sans"} -->
        <p class="has-text-align-center service-detail-section3-paragraph has-plus-jakarta-sans-font-family" style="padding-right:var(--wp--preset--spacing--sm);padding-left:var(--wp--preset--spacing--sm);line-height:1.5"><?php echo esc_html(lawfirmpro_get_text('text_sd_section3_body', 'Our solicitors bring decades of combined experience across a wide range of legal disciplines. We are committed to delivering practical, results-driven advice for individuals and businesses throughout England and Wales.')); ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns {"className":"service-detail-section3-columns"} -->
    <div class="wp-block-columns service-detail-section3-columns"><!-- wp:column {"className":"service-detail-section3-column"} -->
        <div class="wp-block-column service-detail-section3-column"><!-- wp:group {"className":"service-detail-section3-columns-stack","style":{"spacing":{"padding":{"right":"8px","left":"var:preset|spacing|md","top":"var:preset|spacing|lg","bottom":"34px"}},"border":{"width":"1px"}},"borderColor":"accent-8","layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--lg);padding-right:8px;padding-bottom:34px;padding-left:var(--wp--preset--spacing--md)"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"service-detail-section3-icons"} -->
                <figure class="wp-block-image size-full service-detail-section3-icons"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-2138.png')); ?>" alt="" class="" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","className":"service-detail-section3-subtitle","style":{"typography":{"fontSize":"32px","fontWeight":"800"}}} -->
                <h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:32px;font-weight:800"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_card_1', 'Analysis Case')); ?></h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"className":"service-detail-section3-paragraph","fontFamily":"plus-jakarta-sans"} -->
                <p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family"><?php echo esc_html(lawfirmpro_get_text('text_sd_card_body', 'Our team brings together specialists across multiple areas of law, ensuring comprehensive legal support for every client.')); ?></p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"service-detail-section3-column"} -->
        <div class="wp-block-column service-detail-section3-column"><!-- wp:group {"className":"service-detail-section3-columns-stack","style":{"spacing":{"padding":{"right":"8px","left":"var:preset|spacing|md","top":"var:preset|spacing|lg","bottom":"34px"}},"border":{"width":"1px"}},"borderColor":"accent-8","layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--lg);padding-right:8px;padding-bottom:34px;padding-left:var(--wp--preset--spacing--md)"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"service-detail-section3-icons"} -->
                <figure class="wp-block-image size-full service-detail-section3-icons"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-2136.png')); ?>" alt="" class="" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","className":"service-detail-section3-subtitle","style":{"typography":{"fontSize":"32px","fontWeight":"800"}}} -->
                <h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:32px;font-weight:800"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_card_2', 'Information List')); ?></h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"className":"service-detail-section3-paragraph","fontFamily":"plus-jakarta-sans"} -->
                <p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family"><?php echo esc_html(lawfirmpro_get_text('text_sd_card_body', 'Our team brings together specialists across multiple areas of law, ensuring comprehensive legal support for every client.')); ?></p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"service-detail-section3-column"} -->
        <div class="wp-block-column service-detail-section3-column"><!-- wp:group {"className":"service-detail-section3-columns-stack","style":{"spacing":{"padding":{"right":"8px","left":"var:preset|spacing|md","top":"var:preset|spacing|lg","bottom":"34px"}},"border":{"width":"1px"}},"borderColor":"accent-8","layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group service-detail-section3-columns-stack has-border-color has-accent-8-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--lg);padding-right:8px;padding-bottom:34px;padding-left:var(--wp--preset--spacing--md)"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"service-detail-section3-icons"} -->
                <figure class="wp-block-image size-full service-detail-section3-icons"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-2137.png')); ?>" alt="" class="" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","className":"service-detail-section3-subtitle","style":{"typography":{"fontSize":"32px","fontWeight":"800"}}} -->
                <h2 class="wp-block-heading service-detail-section3-subtitle" style="font-size:32px;font-weight:800"><?php echo esc_html(lawfirmpro_get_heading('heading_sd_card_3', 'Documentation')); ?></h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"className":"service-detail-section3-paragraph","fontFamily":"plus-jakarta-sans"} -->
                <p class="service-detail-section3-paragraph has-plus-jakarta-sans-font-family"><?php echo esc_html(lawfirmpro_get_text('text_sd_card_body', 'Our team brings together specialists across multiple areas of law, ensuring comprehensive legal support for every client.')); ?></p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->