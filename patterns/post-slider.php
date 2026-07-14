<?php

/**
 * Title: Post Slider
 * Slug: lawfirmpro/post-slider
 * Categories: featured
 * Description: Display latest posts in a slider layout.
 */
?>

<!-- wp:group {"className":"custom-post-slider","layout":{"type":"default"}} -->
<div class="wp-block-group custom-post-slider"><!-- wp:query {"queryId":21,"query":{"perPage":6,"postType":"attorney","order":"desc","orderBy":"date","sticky":"","parents":[],"format":[]}} -->
    <div class="wp-block-query"><!-- wp:post-template -->
        <!-- wp:post-featured-image {"isLink":true} /-->

        <!-- wp:post-title {"level":3,"isLink":true} /-->

        <!-- wp:post-excerpt {"moreText":"Read More"} /-->
        <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->
</div>
<!-- /wp:group -->