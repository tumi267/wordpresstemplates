<?php
/**
 * Plugin Name:       Infinite Scroll
 * Description:       When user scrolls to bottom of page, the page loads more data.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       infinite-scroll
 *
 * @package CreateBlock
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_infinite_scroll_block_init() {
    register_block_type(__DIR__ . '/build/infinite-scroll');
}
add_action('init', 'create_block_infinite_scroll_block_init');

/**
 * Enqueue frontend and editor styles.
 */
function infinitescroll_enqueue_styles() {
    $style_path = plugin_dir_path(__FILE__) . 'build/infinite-scroll/index.css';
    wp_enqueue_style(
        'infinite-scroll-style',
        plugin_dir_url(__FILE__) . 'build/infinite-scroll/index.css',
        array(),
        filemtime($style_path)
    );
}
add_action('enqueue_block_assets', 'infinitescroll_enqueue_styles'); // Loads in both editor and frontend

/**
 * Register REST API endpoint for infinite scroll.
 */
function register_infinite_scroll_endpoint() {
    register_rest_route('infinite-scroll/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'load_more_posts',
        'args' => array(
            'page' => array(
                'validate_callback' => function ($param) {
                    return is_numeric($param);
                }
            ),
            'category' => array(
                'validate_callback' => function ($param) {
                    return is_numeric($param);
                }
            ),
            'year' => array(
                'validate_callback' => function ($param) {
                    return is_numeric($param);
                }
            ),
            'author' => array(
                'validate_callback' => function ($param) {
                    return is_numeric($param);
                }
            ),
            'posts_per_page' => array(
                'validate_callback' => function ($param) {
                    return is_numeric($param);
                }
            ),
        ),
    ));
}
add_action('rest_api_init', 'register_infinite_scroll_endpoint');

/**
 * Callback function to load more posts.
 */
function load_more_posts($data) {
    $page = isset($data['page']) ? absint($data['page']) : 1;
    $category = isset($data['category']) ? absint($data['category']) : null;
    $year = isset($data['year']) ? absint($data['year']) : null;
    $author = isset($data['author']) ? absint($data['author']) : null;
    $posts_per_page = isset($data['posts_per_page']) ? absint($data['posts_per_page']) : 5;

    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'order' => 'DESC',       // Add this line to order by descending date
        'orderby' => 'date',     // Add this line to order by date
    );

    if ($category) {
        $args['cat'] = $category;
    }

    if ($year) {
        $args['year'] = $year;
    }

    if ($author) {
        $args['author'] = $author;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $posts = [];
        while ($query->have_posts()) {
            $query->the_post();
            $posts[] = [
                'title' => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'link' => get_permalink(),
                'date' => get_the_date('c'),
            ];
        }

        wp_reset_postdata();

        return rest_ensure_response([
            'posts' => $posts,
        ]);
    } else {
        return rest_ensure_response([
            'posts' => [],
        ]);
    }
}

/**
 * Enqueue frontend scripts.
 */
function infinitescroll_enqueue_scripts() {
    // Default posts per page value
    $default_posts_per_page = 5;

    // Get the current post's ID (used to fetch block attributes)
    global $post;
    $posts_per_page = $default_posts_per_page;  // Default to 5 posts per page

    // Check if the post contains the Infinite Scroll block and retrieve its attributes
    if ($post && has_block('create-block/infinite-scroll', $post)) {
        $blocks = parse_blocks($post->post_content);  // Parse blocks within the post content

        // Debugging: Log all block data to see if the attribute is being saved correctly
        error_log(print_r($blocks, true));

        foreach ($blocks as $block) {
            if ($block['blockName'] === 'create-block/infinite-scroll') {
                // Check if postsPerPage exists and log it for debugging
                if (isset($block['attrs']['postsPerPage'])) {
                    $posts_per_page = $block['attrs']['postsPerPage'];
                } else {
                    // Log if postsPerPage is not set
                    error_log("postsPerPage not set in block attributes.");
                }
                break;
            }
        }
    }

    // Enqueue the infinite scroll script
    wp_enqueue_script(
        'infinite-scroll-script',
        plugin_dir_url(__FILE__) . 'build/infinite-scroll/view.js',
        array('jquery'),
        filemtime(plugin_dir_path(__FILE__) . 'build/infinite-scroll/view.js'),
        true
    );

    // Localize script to pass data to JavaScript
    wp_localize_script('infinite-scroll-script', 'infiniteScrollData', [
        'rest_url' => esc_url_raw(rest_url()),
        'nonce' => wp_create_nonce('wp_rest'),
        'posts_per_page' => $posts_per_page,
    ]);
}
add_action('wp_enqueue_scripts', 'infinitescroll_enqueue_scripts');

/**
 * Helper function to get the postsPerPage value from the database.
 */
function get_posts_per_page_from_database($default) {
    global $post;

    // Check if the current post contains the Infinite Scroll block
    if ($post && has_block('create-block/infinite-scroll', $post)) {
        // Parse the blocks in the post content
        $blocks = parse_blocks($post->post_content);

        // Loop through the blocks to find the Infinite Scroll block
        foreach ($blocks as $block) {
            if ($block['blockName'] === 'create-block/infinite-scroll') {
                // Return the saved postsPerPage value or the default
                return $block['attrs']['postsPerPage'] ?? $default;
            }
        }
    }

    // Return the default value if the block is not found
    return $default;
}

/**
 * Allow filtering users by role in the REST API.
 */
function allow_filter_users_by_role($args, $request) {
    if (current_user_can('read')) {
        $args['who'] = 'authors';
    }
    return $args;
}
add_filter('rest_user_query', 'allow_filter_users_by_role', 10, 2);

/**
 * Add the 'roles' field to the REST API response for users.
 */
function add_roles_to_rest_user_response($response, $user, $request) {
    $response->data['roles'] = $user->roles;
    return $response;
}
add_filter('rest_prepare_user', 'add_roles_to_rest_user_response', 10, 3);

