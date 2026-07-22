<?php

/**
 * Title: Protect Rights
 * Slug: lawfirmpro/home-v2-about
 * Categories: featured
 * Description: Dynamic protect rights grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5"><?php echo esc_html(lawfirmpro_get_label('label_about_us', 'About Us')); ?></a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"protect-rights-heading-group","layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group protect-rights-heading-group"><!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
        <h2 class="wp-block-heading has-text-align-center"><?php echo esc_html(lawfirmpro_get_heading('heading_home_v2_about', 'Protecting Your Rights With Dedication')); ?></h2>
        <!-- /wp:heading -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns {"className":"about-v2-columns","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg"},"margin":{"top":"var:preset|spacing|sm"}}}} -->
    <div class="wp-block-columns about-v2-columns" style="margin-top:var(--wp--preset--spacing--sm)"><!-- wp:column {"verticalAlignment":"center","className":"about-v2-column1","style":{"spacing":{"blockGap":"var:preset|spacing|sm"}}} -->
        <div class="wp-block-column is-vertically-aligned-center about-v2-column1"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|md"}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
                <p class="has-accent-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_text('text_home_v2_about_p1', 'With over 25 years of experience, ' . get_bloginfo('name') . ' has been a trusted partner for individuals and businesses across England and Wales. Our team of expert solicitors provides tailored legal solutions with a personal touch.')); ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
                <p class="has-accent-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_text('text_home_v2_about_p2', 'From conveyancing and family law to personal injury and commercial disputes, we combine deep expertise with genuine care for our clients. Your legal matters are handled with precision, confidentiality, and dedication.')); ?></p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group"><!-- wp:details {"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"plus-jakarta-sans"} -->
                <details class="wp-block-details has-plus-jakarta-sans-font-family" style="font-size:16px;font-style:normal;font-weight:600">
                    <summary>What areas of law do you specialise in?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block"} -->
                    <p></p>
                    <!-- /wp:paragraph -->
                </details>
                <!-- /wp:details -->

                <!-- wp:details {"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"plus-jakarta-sans"} -->
                <details class="wp-block-details has-plus-jakarta-sans-font-family" style="font-size:16px;font-style:normal;font-weight:600">
                    <summary>How much will my case cost?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block"} -->
                    <p></p>
                    <!-- /wp:paragraph -->
                </details>
                <!-- /wp:details -->
            </div>
            <!-- /wp:group -->

            <!-- wp:buttons {"className":"button-gaps","style":{"spacing":{"blockGap":"16px","padding":{"top":"var:preset|spacing|lg","bottom":"var:preset|spacing|lg"}}},"layout":{"type":"flex","justifyContent":"left","flexWrap":"nowrap"}} -->
            <div class="wp-block-buttons button-gaps" style="padding-top:var(--wp--preset--spacing--lg);padding-bottom:var(--wp--preset--spacing--lg)"><!-- wp:button {"className":"transparent-text-black is-style-fill","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","lineHeight":"1","letterSpacing":"0px","textTransform":"uppercase"}},"fontFamily":"plus-jakarta-sans"} -->
                <div class="wp-block-button transparent-text-black is-style-fill"><a class="wp-block-button__link has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('about_page_id', '/about/')); ?>" style="font-size:16px;font-style:normal;font-weight:800;letter-spacing:0px;line-height:1;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_learn_more', 'Learn More')); ?> ➔</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"top"} -->
        <div class="wp-block-column is-vertically-aligned-top"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/justice.png')); ?>","dimRatio":0,"overlayColor":"secondary","isUserOverlayColor":true,"minHeight":300,"contentPosition":"bottom center","isDark":false,"sizeSlug":"full","align":"center","className":"protect-rights-cover","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"default"}} -->
            <div class="wp-block-cover aligncenter is-light has-custom-content-position is-position-bottom-center protect-rights-cover" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);min-height:300px"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/justice.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-0 has-background-dim"></span>
                <div class="wp-block-cover__inner-container"><!-- wp:image {"width":"406px","height":"542px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","className":"protect-rights-img"} -->
                    <figure class="wp-block-image aligncenter size-full is-resized protect-rights-img"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/justice-man.png')); ?>" alt="" style="object-fit:cover;width:406px;height:542px" /></figure>
                    <!-- /wp:image -->
                </div>
            </div>
            <!-- /wp:cover -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->