<?php

/**
 * Title: Team Detail Section 2
 * Slug: lawfirmpro/team-detail-section-2
 * Categories: featured
 * Description: Dynamic team members grid.
 * Inserter: true
 */
?>
<!-- wp:cover {"overlayColor":"accent-5","isUserOverlayColor":true,"isDark":false,"align":"full","className":"team-details-main-cover","style":{"spacing":{"padding":{"top":"var:preset|spacing|4xl","bottom":"var:preset|spacing|4xl","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull is-light team-details-main-cover" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--4xl);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--4xl);padding-left:var(--wp--preset--spacing--0)"><span aria-hidden="true" class="wp-block-cover__background has-accent-5-background-color has-background-dim-100 has-background-dim"></span>
    <div class="wp-block-cover__inner-container"><!-- wp:columns {"verticalAlignment":"top","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":{"top":"var:preset|spacing|sm","left":"16px"}}},"backgroundColor":"accent-5"} -->
        <div class="wp-block-columns are-vertically-aligned-top has-accent-5-background-color has-background" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:column {"verticalAlignment":"top","className":"team-details-column","style":{"spacing":{"padding":{"top":"37px","bottom":"37px","left":"37px","right":"37px"}},"border":{"width":"2px"}},"backgroundColor":"secondary","borderColor":"accent-8"} -->
            <div class="wp-block-column is-vertically-aligned-top team-details-column has-border-color has-accent-8-border-color has-secondary-background-color has-background" style="border-width:2px;padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px"><!-- wp:group {"style":{"spacing":{"blockGap":"6px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
                <div class="wp-block-group">                <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"}},"fontFamily":"plus-jakarta-sans"} -->
                    <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="line-height:1.5"><?php echo esc_html(get_post_meta(get_the_ID(), '_attorney_education_date', true)); ?></p>
                    <!-- /wp:paragraph -->

                    <!-- wp:heading {"className":"team-details-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1"}}} -->
                    <h2 class="wp-block-heading team-details-heading" style="font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_label('label_education', 'Education')); ?></h2>
                    <!-- /wp:heading -->
                </div>
                <!-- /wp:group -->

                <!-- wp:group {"style":{"spacing":{"margin":{"top":"39px"}}},"layout":{"type":"default"}} -->
                <div class="wp-block-group" style="margin-top:39px"><!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                    <div class="wp-block-group"><!-- wp:image {"width":"20px","height":"20px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"team-detail-right-image","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}}} -->
                        <figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-4.png')); ?>" alt="" class="" style="object-fit:cover;width:20px;height:20px" /></figure>
                        <!-- /wp:image -->

                        <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
                        <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}}} -->
                            <h2 class="wp-block-heading team-details-paragraph" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(get_post_meta(get_the_ID(), '_attorney_education_0_title', true)); ?></h2>
                            <!-- /wp:heading -->

                            <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
                            <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:20px;line-height:1.5"><?php echo esc_html(get_the_content()); ?></p>
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
                        <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}}} -->
                            <h2 class="wp-block-heading team-details-paragraph" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(get_post_meta(get_the_ID(), '_attorney_education_1_title', true)); ?></h2>
                            <!-- /wp:heading -->

                            <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
                            <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:20px;line-height:1.5"><?php echo esc_html(get_the_content()); ?></p>
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
                        <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}}} -->
                            <h2 class="wp-block-heading team-details-paragraph" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(get_post_meta(get_the_ID(), '_attorney_education_2_title', true)); ?></h2>
                            <!-- /wp:heading -->

                            <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
                            <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:20px;line-height:1.5"><?php echo esc_html(get_the_content()); ?></p>
                            <!-- /wp:paragraph -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column {"verticalAlignment":"top","className":"team-details-column","style":{"spacing":{"padding":{"top":"37px","bottom":"37px","left":"37px","right":"37px"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"backgroundColor":"primary","textColor":"secondary"} -->
            <div class="wp-block-column is-vertically-aligned-top team-details-column has-secondary-color has-primary-background-color has-text-color has-background has-link-color" style="padding-top:37px;padding-right:37px;padding-bottom:37px;padding-left:37px"><!-- wp:group {"style":{"spacing":{"blockGap":"6px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
                <div class="wp-block-group">                <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"}},"textColor":"accent","fontFamily":"plus-jakarta-sans"} -->
                    <p class="team-details-paragraph has-accent-color has-text-color has-plus-jakarta-sans-font-family" style="line-height:1.5"><?php echo esc_html(get_post_meta(get_the_ID(), '_attorney_career_date', true)); ?></p>
                    <!-- /wp:paragraph -->

                    <!-- wp:heading {"className":"team-details-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1"}},"textColor":"secondary"} -->
                    <h2 class="wp-block-heading team-details-heading has-secondary-color has-text-color" style="font-weight:800;line-height:1.1"><strong><?php echo esc_html(lawfirmpro_get_label('label_career', 'Career')); ?></strong></h2>
                    <!-- /wp:heading -->
                </div>
                <!-- /wp:group -->

                <!-- wp:group {"style":{"spacing":{"margin":{"top":"39px"}}},"layout":{"type":"default"}} -->
                <div class="wp-block-group" style="margin-top:39px"><!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                    <div class="wp-block-group"><!-- wp:image {"width":"20px","height":"20px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"team-detail-right-image","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}},"color":{"duotone":"var:preset|duotone|midnight-glow"}}} -->
                        <figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-4.png')); ?>" alt="" class="" style="object-fit:cover;width:20px;height:20px" /></figure>
                        <!-- /wp:image -->

                        <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
                        <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}},"textColor":"secondary"} -->
                            <h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(get_post_meta(get_the_ID(), '_attorney_career_0_title', true)); ?></h2>
                            <!-- /wp:heading -->

                            <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
                            <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:20px;line-height:1.5"><?php echo esc_html(get_the_content()); ?></p>
                            <!-- /wp:paragraph -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->

                    <!-- wp:separator {"className":"is-style-wide","backgroundColor":"accent-2"} -->
                    <hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide" />
                    <!-- /wp:separator -->

                    <!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                    <div class="wp-block-group"><!-- wp:image {"width":"20px","height":"20px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"team-detail-right-image","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}},"color":{"duotone":"var:preset|duotone|midnight-glow"}}} -->
                        <figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-4.png')); ?>" alt="" class="" style="object-fit:cover;width:20px;height:20px" /></figure>
                        <!-- /wp:image -->

                        <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
                        <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}},"textColor":"secondary"} -->
                            <h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(get_post_meta(get_the_ID(), '_attorney_career_1_title', true)); ?></h2>
                            <!-- /wp:heading -->

                            <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
                            <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:20px;line-height:1.5"><?php echo esc_html(get_the_content()); ?></p>
                            <!-- /wp:paragraph -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->

                    <!-- wp:separator {"className":"is-style-wide","backgroundColor":"accent-2"} -->
                    <hr class="wp-block-separator has-text-color has-accent-2-color has-alpha-channel-opacity has-accent-2-background-color has-background is-style-wide" />
                    <!-- /wp:separator -->

                    <!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                    <div class="wp-block-group"><!-- wp:image {"width":"20px","height":"20px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"team-detail-right-image","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}},"color":{"duotone":"var:preset|duotone|midnight-glow"}}} -->
                        <figure class="wp-block-image size-full is-resized team-detail-right-image" style="margin-top:var(--wp--preset--spacing--0);margin-right:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);margin-left:var(--wp--preset--spacing--0)"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-4.png')); ?>" alt="" class="" style="object-fit:cover;width:20px;height:20px" /></figure>
                        <!-- /wp:image -->

                        <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
                        <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">                        <!-- wp:heading {"className":"team-details-paragraph","style":{"typography":{"fontSize":"24px","fontWeight":"800","lineHeight":"1.3"}},"textColor":"secondary"} -->
                            <h2 class="wp-block-heading team-details-paragraph has-secondary-color has-text-color" style="font-size:24px;font-weight:800;line-height:1.3"><?php echo esc_html(get_post_meta(get_the_ID(), '_attorney_career_2_title', true)); ?></h2>
                            <!-- /wp:heading -->

                            <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"},"spacing":{"margin":{"right":"20px"}}},"fontFamily":"plus-jakarta-sans"} -->
                            <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="margin-right:20px;line-height:1.5"><?php echo esc_html(get_the_content()); ?></p>
                            <!-- /wp:paragraph -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
    </div>
</div>
<!-- /wp:cover -->