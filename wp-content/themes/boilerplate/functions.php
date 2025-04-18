<?php

// Enqueue header script conditionally
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script(
    'boilerplate-header-effects',
    get_template_directory_uri() . '/js/header-effects.js',
    [],
    null,
    true
  );
  
});

// Enqueue the theme's stylesheet
function theme_enqueue_styles() {
  // Enqueue the main style sheet
  wp_enqueue_style('theme-style', get_stylesheet_uri());
}

// Add the styles enqueuing to wp_enqueue_scripts
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

add_theme_support('wp-block-patterns');