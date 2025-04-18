<?php
/**
 * Title: hero-latest-post
 * Slug: latest-hero-post
 * Categories: featured
 *
 * @package WordPress
 * @subpackage boilerplate
 */
?>

<!-- wp:query {"queryId":1,"query":{"perPage":1,"pages":1,"offset":0,"postType":"post","order":"desc","orderBy":"date"}} -->
<div class="wp-block-query">
    <!-- wp:post-template -->
    <!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"40px","bottom":"40px"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignfull" style="position:relative;padding-top:40px;padding-bottom:40px">

        <!-- wp:post-featured-image {"align":"full"} /-->

        <!-- Overlay text inside the image -->
        <div class="hero-overlay-text" style="position:absolute;top:0;left:0;width:100%;height:100%;display:flex;flex-direction:column;justify-content:center;align-items:center;color:white;padding:2rem;text-align:center;z-index:2;">
            <!-- wp:post-title {"textAlign":"center","level":2} /-->
            <!-- wp:post-excerpt {"textAlign":"center"} /-->
            <!-- wp:post-date {"textAlign":"center"} /-->
        </div>
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
</div>
<!-- /wp:query -->
