<?php
/**
 * Title: Hero - Latest in Category
 * Slug: hero-category-featured
 * Categories: featured
 *
 * @package WordPress
 * @subpackage boilerplate
 */
?>

<!-- wp:query {"queryId":2,"query":{"perPage":1,"pages":1,"offset":0,"postType":"post","category":"featured","order":"desc","orderBy":"date"}} -->
<div class="wp-block-query">
    <!-- wp:post-template -->
    <!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignfull">
        <!-- wp:post-featured-image {"align":"wide"} /-->
        <!-- wp:post-title /-->
        <!-- wp:post-excerpt /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
</div>
<!-- /wp:query -->
