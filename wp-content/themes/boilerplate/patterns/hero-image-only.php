<?php
/**
 * Title: Hero - Image Only
 * Slug: hero-image-only
 * Categories: featured
 *
 * @package WordPress
 * @subpackage boilerplate
 */

?>

<!-- wp:image {"sizeSlug":"full"} -->
<figure class="wp-block-image size-full">
    <img src="' . esc_url( get_template_directory_uri() ) . '/assets/hero.jpg" alt="Hero Image"/>
</figure>
<!-- /wp:image -->