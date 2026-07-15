<?php

/**
 * Title: Team Detail
 * Slug: lawfirmpro/team-detail
 * Categories: featured
 * Description: Dynamic team members grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"team-details-main","layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="wp-block-group team-details-main"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"90px","bottom":"90px"}}}} -->
    <div class="wp-block-columns" style="padding-top:90px;padding-bottom:90px"><!-- wp:column {"width":"60%","className":"team-details-content"} -->
        <div class="wp-block-column team-details-content" style="flex-basis:60%"><!-- wp:group {"className":"team-details-stack","style":{"spacing":{"blockGap":"8px","padding":{"right":"20px"}}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"wrap"}} -->
            <div class="wp-block-group team-details-stack" style="padding-right:20px"><!-- wp:post-title {"className":"team-details-heading","style":{"typography":{"fontSize":"48px","fontStyle":"normal","fontWeight":"800","lineHeight":"1.1","letterSpacing":"0%"}},"fontFamily":"plus-jakarta-sans"} /-->

                <!-- wp:post-excerpt {"showMoreOnNewLine":false,"className":"team-details-paragraph","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.5","letterSpacing":"0%"}},"textColor":"accent","fontFamily":"plus-jakarta-sans"} /-->

                <!-- wp:paragraph {"className":"team-details-paragraph","style":{"spacing":{"padding":{"top":"18px","bottom":"18px"}},"typography":{"lineHeight":"1.5"}},"fontFamily":"plus-jakarta-sans"} -->
                <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="padding-top:18px;padding-bottom:18px;line-height:1.5">Donec consectetur vulputate nulla id varius. Sed ornare ante volutpat, volutpat mauris eleifend, cursus nibh. Vivamus posuere fermentum lectus eget tempus. Duis fermentum tristique justo, quis tempor elit finibus et. Integer suscipit pulvinar volutpat. Nulla venenatis dui vitae ligula laoreet iaculis. Donec tristique sollicitudin quam, et malesuada ex vestibulum vel. Duis risus sem, congue nec vehicula porttitor, gravida ac mauris.</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"className":"team-details-paragraph","style":{"typography":{"lineHeight":"1.5"}},"fontFamily":"plus-jakarta-sans"} -->
                <p class="team-details-paragraph has-plus-jakarta-sans-font-family" style="line-height:1.5">Quisque id lorem risus. Curabitur id luctus quam rhoncus ultrices tortor sed volutpat arcu feugiat urabitur mattis vehicula ligula, non commodo massa auctor lorem ipsum dolor sit amet, consectetur adipiscing elit pellentesque eu sagittis dui.</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"team-details-grid","style":{"border":{"width":"2px"},"spacing":{"padding":{"top":"23px","bottom":"23px","left":"30px"},"margin":{"top":"67px"},"blockGap":"56px"}},"borderColor":"accent-8","layout":{"type":"grid","columnCount":3}} -->
            <div class="wp-block-group team-details-grid has-border-color has-accent-8-border-color" style="border-width:2px;margin-top:67px;padding-top:23px;padding-bottom:23px;padding-left:30px"><!-- wp:group {"className":"team-details-grid-row","style":{"spacing":{"blockGap":"10px","padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}},"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontFamily":"plus-jakarta-sans","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center","justifyContent":"left"}} -->
                <div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"is-style-default team-details-grid-image","style":{"layout":{"selfStretch":"fixed","flexSize":"38px"}}} -->
                    <figure class="wp-block-image size-full is-style-default team-details-grid-image"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-2354.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:shortcode -->
                    <?php echo do_shortcode('[lawfirmpro_phone]'); ?>
                    <!-- /wp:shortcode -->
                </div>
                <!-- /wp:group -->

                <!-- wp:group {"className":"team-details-grid-row","style":{"spacing":{"blockGap":"10px","padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}},"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontFamily":"plus-jakarta-sans","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center","justifyContent":"left"}} -->
                <div class="wp-block-group team-details-grid-row has-plus-jakarta-sans-font-family" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0);font-style:normal;font-weight:700"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"team-details-grid-image","style":{"layout":{"selfStretch":"fixed","flexSize":"38px"}}} -->
                    <figure class="wp-block-image size-full team-details-grid-image"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/Group-2355.png')); ?>" alt="" class="" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:shortcode -->
                    <?php echo do_shortcode('[lawfirmpro_email]'); ?>
                    <!-- /wp:shortcode -->
                </div>
                <!-- /wp:group -->

                <!-- wp:shortcode -->
                <?php echo do_shortcode('[attorney_social_links]'); ?>
                <!-- /wp:shortcode -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"team-details-image"} -->
        <div class="wp-block-column team-details-image"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"customOverlayColor":"#FFF","isUserOverlayColor":false,"minHeight":400,"isDark":false,"className":"team-details-post-image","layout":{"type":"constrained"}} -->
            <div class="wp-block-cover is-light team-details-post-image" style="min-height:400px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#FFF"></span>
                <div class="wp-block-cover__inner-container"></div>
            </div>
            <!-- /wp:cover -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->