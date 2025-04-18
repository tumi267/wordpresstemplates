<?php
/**
 * Title: Latest Post
 * Slug: latest-post
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
    <div class="wp-block-group alignfull" style="padding-top:40px;padding-bottom:40px">
        <!-- wp:post-featured-image {"align":"wide"} /-->
        <!-- wp:post-title {"textAlign":"center"} /-->
        <!-- wp:post-excerpt {"textAlign":"center"} /-->
        <!-- wp:post-date {"textAlign":"center"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
</div>
<!-- /wp:query -->
