<?php

/**
 * Title: Protect Rights
 * Slug: lawfirmpro/home-v2-about
 * Categories: featured
 * Description: Dynamic protect rights grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"protect-rights-main","style":{"spacing":{"margin":{"top":"var:preset|spacing|xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group protect-rights-main" style="margin-top:var(--wp--preset--spacing--xl)"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"textColor":"accent-7","className":"is-style-outline","style":{"typography":{"textAlign":"center","fontSize":"16px","fontStyle":"normal","fontWeight":"600","lineHeight":"1.5","letterSpacing":"0%"},"elements":{"link":{"color":{"text":"var:preset|color|accent-7"}}},"border":{"width":"1px","color":"#afafaf","radius":{"topLeft":"300px","topRight":"300px","bottomLeft":"300px","bottomRight":"300px"}},"spacing":{"padding":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|xs","left":"24px","right":"24px"}}},"fontFamily":"plus-jakarta-sans"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-accent-7-color has-text-color has-link-color has-border-color has-plus-jakarta-sans-font-family has-text-align-center has-custom-font-size wp-element-button" style="border-color:#afafaf;border-width:1px;border-top-left-radius:300px;border-top-right-radius:300px;border-bottom-left-radius:300px;border-bottom-right-radius:300px;padding-top:var(--wp--preset--spacing--xs);padding-right:24px;padding-bottom:var(--wp--preset--spacing--xs);padding-left:24px;font-size:16px;font-style:normal;font-weight:600;letter-spacing:0%;line-height:1.5"><?php echo esc_html(lawfirmpro_get_label('label_about_us', 'About Us')); ?></a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

    <!-- wp:group {"className":"protect-rights-heading-group","style":{"spacing":{"blockGap":"21px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
    <div class="wp-block-group protect-rights-heading-group"><!-- wp:heading {"className":"protect-rights-heading","style":{"typography":{"fontWeight":"800","lineHeight":"1.1","fontSize":"56px"},"spacing":{"padding":{"right":"20px","left":"20px"}}}} -->
        <h2 class="wp-block-heading protect-rights-heading" style="padding-right:20px;padding-left:20px;font-size:56px;font-weight:800;line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_home_v2_about', 'Protecting Your Rights With Dedication')); ?></h2>
        <!-- /wp:heading -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns -->
    <div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center"} -->
        <div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"article-title","style":{"typography":{"fontWeight":"500"}},"fontFamily":"plus-jakarta-sans"} -->
            <p class="article-title has-text-color has-plus-jakarta-sans-font-family" style="font-weight:500"><?php echo esc_html(lawfirmpro_get_text('text_home_v2_about_p1', 'With over 25 years of experience, ' . get_bloginfo('name') . ' has been a trusted partner for individuals and businesses across England and Wales. Our team of expert solicitors provides tailored legal solutions with a personal touch.')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"className":"article-title","style":{"typography":{"fontWeight":"500"}},"fontFamily":"plus-jakarta-sans"} -->
            <p class="article-title has-text-color has-plus-jakarta-sans-font-family" style="font-weight:500"><?php echo esc_html(lawfirmpro_get_text('text_home_v2_about_p2', 'From conveyancing and family law to personal injury and commercial disputes, we combine deep expertise with genuine care for our clients. Your legal matters are handled with precision, confidentiality, and dedication.')); ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:details {"className":"article-title","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"plus-jakarta-sans"} -->
            <details class="wp-block-details article-title has-plus-jakarta-sans-font-family" style="font-size:16px;font-style:normal;font-weight:600">
                <summary>What areas of law do you specialise in?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block"} -->
                <p></p>
                <!-- /wp:paragraph -->
            </details>
            <!-- /wp:details -->

            <!-- wp:details {"className":"article-title","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"plus-jakarta-sans"} -->
            <details class="wp-block-details article-title has-plus-jakarta-sans-font-family" style="font-size:16px;font-style:normal;font-weight:600">
                <summary>How much will my case cost?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block"} -->
                <p></p>
                <!-- /wp:paragraph -->
            </details>
            <!-- /wp:details -->

            <!-- wp:buttons -->
            <div class="wp-block-buttons"><!-- wp:button {"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"800","textTransform":"uppercase"}},"fontFamily":"plus-jakarta-sans"} -->
                <div class="wp-block-button"><a class="wp-block-button__link has-plus-jakarta-sans-font-family has-custom-font-size wp-element-button" href="<?php echo esc_url(lawfirmpro_get_page_url('about_page_id', '/about/')); ?>" style="font-size:16px;font-style:normal;font-weight:800;text-transform:uppercase"><?php echo esc_html(lawfirmpro_get_label('btn_learn_more', 'Learn More')); ?> 🡲</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"top"} -->
        <div class="wp-block-column is-vertically-aligned-top"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri('assets/images/justice.png')); ?>","dimRatio":0,"overlayColor":"secondary","isUserOverlayColor":true,"minHeight":300,"contentPosition":"bottom center","isDark":false,"sizeSlug":"full","align":"center","className":"protect-rights-cover","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"default"}} -->
            <div class="wp-block-cover aligncenter is-light has-custom-content-position is-position-bottom-center protect-rights-cover" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);min-height:300px"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_theme_file_uri('assets/images/justice.png')); ?>" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-0 has-background-dim"></span>
                <div class="wp-block-cover__inner-container"><!-- wp:image {"width":"406px","height":"542px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","className":"protect-rights-img"} -->
                    <figure class="wp-block-image aligncenter size-full is-resized protect-rights-img"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/justice-man.png')); ?>" alt="" class="" style="object-fit:cover;width:406px;height:542px" /></figure>
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
