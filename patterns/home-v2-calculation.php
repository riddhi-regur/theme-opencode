<?php

/**
 * Title: Calculation
 * Slug: lawfirmpro/home-v2-calculation
 * Categories: featured
 * Description: Dynamic calculation grid.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"section-spacing-top","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-spacing-top"><!-- wp:group {"className":"calculations-grid","style":{"spacing":{"padding":{"top":"36px","bottom":"36px"}},"border":{"top":{"color":"var:preset|color|accent-2","width":"1px"},"right":[],"bottom":[],"left":[]}},"layout":{"type":"grid","columnCount":4}} -->
    <div class="wp-block-group calculations-grid" style="border-top-color:var(--wp--preset--color--accent-2);border-top-width:1px;padding-top:36px;padding-bottom:36px"><!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"top"}} -->
        <div class="wp-block-group"><!-- wp:heading {"level":4,"className":"has-text-align-center calculations-heading"} -->
            <h4 class="wp-block-heading has-text-align-center calculations-heading"><?php echo esc_html(lawfirmpro_get_heading('stat_1_number', '100+')); ?></h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"has-text-align-center has-secondary-color has-text-color has-link-color has-accent-color","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
            <p class="has-text-align-center has-secondary-color has-text-color has-link-color has-accent-color"><?php echo esc_html(lawfirmpro_get_heading('stat_1_label', 'Successful Cases')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"top"}} -->
        <div class="wp-block-group"><!-- wp:heading {"level":4,"className":"has-text-align-center calculations-heading"} -->
            <h4 class="wp-block-heading has-text-align-center calculations-heading"><?php echo esc_html(lawfirmpro_get_heading('stat_2_number', '30+')); ?></h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"has-text-align-center has-secondary-color has-text-color has-link-color has-accent-color","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
            <p class="has-text-align-center has-secondary-color has-text-color has-link-color has-accent-color"><?php echo esc_html(lawfirmpro_get_heading('stat_2_label', 'Years of Legal Experience')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center"}} -->
        <div class="wp-block-group"><!-- wp:heading {"level":4,"className":"has-text-align-center calculations-heading"} -->
            <h4 class="wp-block-heading has-text-align-center calculations-heading"><?php echo esc_html(lawfirmpro_get_heading('stat_3_number', '4.9/5')); ?></h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"has-text-align-center has-secondary-color has-text-color has-link-color has-accent-color","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
            <p class="has-text-align-center has-secondary-color has-text-color has-link-color has-accent-color"><?php echo esc_html(lawfirmpro_get_heading('stat_3_label', 'Average Client Rating')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"top"}} -->
        <div class="wp-block-group"><!-- wp:heading {"level":4,"className":"has-text-align-center calculations-heading"} -->
            <h4 class="wp-block-heading has-text-align-center calculations-heading"><?php echo esc_html(lawfirmpro_get_heading('stat_4_number', '1.4K+')); ?></h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"has-text-align-center has-secondary-color has-text-color has-link-color has-accent-color","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}}},"textColor":"accent"} -->
            <p class="has-text-align-center has-secondary-color has-text-color has-link-color has-accent-color"><?php echo esc_html(lawfirmpro_get_heading('stat_4_label', 'Happy Customers')); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->