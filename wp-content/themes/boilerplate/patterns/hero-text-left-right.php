<?php
/**
 * Title: Hero - Text Left, Image Right
 * Slug: hero-text-left-right
 * Categories: featured
 *
 * @package WordPress
 * @subpackage boilerplate
 */
?>

      <!-- wp:columns -->
      <div class="wp-block-columns">
        <!-- wp:column -->
        <div class="wp-block-column">
          <!-- wp:heading -->
          <h2>Your Bold Headline</h2>
          <!-- /wp:heading -->
          <!-- wp:paragraph -->
          <p>A short catchy description.</p>
          <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
          <!-- wp:image {"sizeSlug":"large"} -->
          <figure class="wp-block-image size-large"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/hero.jpg" alt=""/></figure>
          <!-- /wp:image -->
        </div>
        <!-- /wp:column -->
      </div>
      <!-- /wp:columns -->
