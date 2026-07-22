<?php

/**
 * Title: Calculation
 * Slug: lawfirmpro/home-v2-calculation
 * Categories: featured
 * Description: Dynamic calculation grid.
 * Inserter: true
 */
?>
<!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"spacing":{"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"backgroundColor":"primary","textColor":"secondary","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-secondary-color has-primary-background-color has-text-color has-background has-link-color" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0)"><!-- wp:group {"className":"calculations-grid","style":{"spacing":{"padding":{"top":"36px","bottom":"36px"}}},"layout":{"type":"grid","columnCount":4}} -->
    <div class="wp-block-group calculations-grid" style="padding-top:36px;padding-bottom:36px"><!-- wp:group {"style":{"spacing":{"blockGap":"8px"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"top"}} -->
        <div class="wp-block-group has-secondary-color has-text-color has-link-color"><!-- wp:heading {"level":4,"className":"has-text-align-center calculations-heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center"}},"textColor":"secondary"} -->
            <h4 class="wp-block-heading has-text-align-center calculations-heading has-secondary-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_heading('stat_1_number', '100+')); ?></h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center"}},"textColor":"secondary"} -->
            <p class="has-text-align-center has-secondary-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_heading('stat_1_label', 'Successful Cases')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"top"}} -->
        <div class="wp-block-group"><!-- wp:heading {"level":4,"className":"has-text-align-center calculations-heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center"}},"textColor":"secondary"} -->
            <h4 class="wp-block-heading has-text-align-center calculations-heading has-secondary-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_heading('stat_2_number', '30+')); ?></h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center"}},"textColor":"secondary"} -->
            <p class="has-text-align-center has-secondary-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_heading('stat_2_label', 'Years of Legal Experience')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center"}} -->
        <div class="wp-block-group"><!-- wp:heading {"level":4,"className":"has-text-align-center calculations-heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center"}},"textColor":"secondary"} -->
            <h4 class="wp-block-heading has-text-align-center calculations-heading has-secondary-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_heading('stat_3_number', '4.9/5')); ?></h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center"}},"textColor":"secondary"} -->
            <p class="has-text-align-center has-secondary-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_heading('stat_3_label', 'Average Client Rating')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"top"}} -->
        <div class="wp-block-group"><!-- wp:heading {"level":4,"className":"has-text-align-center calculations-heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center"}},"textColor":"secondary"} -->
            <h4 class="wp-block-heading has-text-align-center calculations-heading has-secondary-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_heading('stat_4_number', '1.4K+')); ?></h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center"}},"textColor":"secondary"} -->
            <p class="has-text-align-center has-secondary-color has-text-color has-link-color"><?php echo esc_html(lawfirmpro_get_heading('stat_4_label', 'Happy Customers')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->