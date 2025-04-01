<?php
// Enqueue Styles
function boilerplate_styles() {
    // Enqueue the main stylesheet for the front end
    wp_enqueue_style(
        'theme-style', // Handle
        get_template_directory_uri() . '/build/assets/css/themeStyle.css', // Path to the built CSS file
        array(), // No dependencies
        wp_get_theme()->get('Version'), // Version for cache busting
        'all' // Media type
    );
}
add_action('wp_enqueue_scripts', 'boilerplate_styles');

function enqueue_editor_styles() {
    // Enable support for editor styles
    add_theme_support('editor-styles');

    // Enqueue the editor stylesheet
    add_editor_style('build/assets/css/themeStyle.css');
}
add_action('after_setup_theme', 'enqueue_editor_styles');



// Register Custom Block Patterns
function bubblegum_register_patterns() {
    // Define the patterns to register
    $patterns = array(
        'category' => 'Category Layout',
        'nav' => 'Nav Pages'
    );

    // Loop through each pattern and register it
    foreach ($patterns as $slug => $title) {
        $pattern_path = get_template_directory() . "/patterns/$slug.php";

        // Check if the pattern file exists
        if (file_exists($pattern_path)) {
            register_block_pattern(
                "bubblegum/$slug", // Unique pattern name
                array(
                    'title'       => __($title, 'bubblegum'), // Pattern title
                    'description' => __("A custom $title pattern", 'bubblegum'), // Pattern description
                    'content'     => file_get_contents($pattern_path), // Pattern content from the file
                )
            );
        }
    }
}
add_action('init', 'bubblegum_register_patterns');

// Customize the Excerpt Length
function custom_excerpt_length($length) {
    return 20; // Limit the excerpt to 20 words
}
add_filter('excerpt_length', 'custom_excerpt_length');

// Fetch Dynamic Navigation Pages
function get_dynamic_navigation_pages() {
    // Fetch pages from WordPress
    $pages = get_pages(array(
        'sort_column' => 'post_title', // Sort by title
        'sort_order' => 'asc' // Sort in ascending order
    ));

    // Prepare the pages array for the block JSON
    $pages_data = array();
    foreach ($pages as $page) {
        $pages_data[] = array(
            'id' => $page->ID, // Page ID
            'title' => $page->post_title, // Page title
            'url' => get_permalink($page->ID) // Page URL
        );
    }

    return $pages_data;
}

// Modify Dynamic Navigation Block
function modify_dynamic_navigation_block($block_content, $block) {
    // Check if this is the 'create-block/dynamic-navigation' block
    if ($block['blockName'] === 'create-block/dynamic-navigation') {
        // Fetch dynamic pages
        $pages_data = get_dynamic_navigation_pages();

        // Get selectedPages from block attributes (if available)
        $selectedPages = isset($block['attrs']['selectedPages']) ? $block['attrs']['selectedPages'] : [];

        // Define the desired order
        $order = ['HOME', 'MAGAZINE', 'RESOURCES', 'FOUNDATION', 'ARCHIVE'];

        // Sort selectedPages based on the predefined order
        usort($selectedPages, function($a, $b) use ($order) {
            $indexA = array_search(strtoupper($a['title']), $order);
            $indexB = array_search(strtoupper($b['title']), $order);

            // If both titles are in the order array, sort by their positions
            if ($indexA !== false && $indexB !== false) {
                return $indexA - $indexB;
            }

            // If only one title is in the order array, prioritize it
            if ($indexA !== false) {
                return -1;
            }
            if ($indexB !== false) {
                return 1;
            }

            // If neither title is in the order array, maintain their original order
            return 0;
        });

        // Update the block attributes with the sorted selectedPages
        $block['attrs']['selectedPages'] = $selectedPages;

        // Remove the filter to prevent infinite loops
        remove_filter('render_block', 'modify_dynamic_navigation_block', 10);

        // Re-render the block with the updated attributes
        $block_content = render_block($block);

        // Re-add the filter for other blocks
        add_filter('render_block', 'modify_dynamic_navigation_block', 10, 2);
    }

    return $block_content;
}
add_filter('render_block', 'modify_dynamic_navigation_block', 10, 2);

// Register Custom Templates
function register_custom_templates() {
    // Register Dark Template
    add_filter('theme_post_templates', function($templates) {
        $templates['post-template-dark.html'] = 'Dark Template';
        return $templates;
    });

    // Register Light Template
    add_filter('theme_post_templates', function($templates) {
        $templates['post-template-light.html'] = 'Light Template';
        return $templates;
    });
}
add_action('init', 'register_custom_templates');