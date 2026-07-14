<?php

/**
 * Title: Contact-Form
 * Slug: lawfirmpro/contact-form
 * Categories: featured
 * Description: Dynamic contact form.
 * Inserter: true
 */
?>
<!-- wp:group {"className":"contact-form-main","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"backgroundColor":"custom-f-6-f-6-f-6","layout":{"type":"default"}} -->
<div class="wp-block-group contact-form-main has-custom-f-6-f-6-f-6-background-color has-background" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:group {"align":"wide","className":"contact-form-stack","style":{"spacing":{"padding":{"top":"33px","bottom":"33px"},"blockGap":"27px","margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}},"dimensions":{"minHeight":"auto"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top","justifyContent":"center"}} -->
    <div class="wp-block-group alignwide contact-form-stack" style="min-height:auto;margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:33px;padding-bottom:33px"><!-- wp:heading {"className":"contact-form-heading","style":{"typography":{"lineHeight":"1.1"}}} -->
        <h2 class="wp-block-heading contact-form-heading" style="line-height:1.1"><?php echo esc_html(lawfirmpro_get_heading('heading_contact', 'Get In Touch')); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:group {"className":"contact-form-row","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
        <div class="wp-block-group contact-form-row" style="margin-top:var(--wp--preset--spacing--0);margin-bottom:var(--wp--preset--spacing--0);padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:shortcode -->
            <?php echo do_shortcode('[lawfirmpro_cf7]'); ?>
            <!-- /wp:shortcode -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->