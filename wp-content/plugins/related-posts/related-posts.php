<?php
/**
 * Plugin Name:       Related Posts
 * Description:       pulls related posts from catagorie and renders card.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       related-posts
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_related_posts_block_init() {
	register_block_type( __DIR__ . '/build/related-posts' );
}
add_action( 'init', 'create_block_related_posts_block_init' );

function related_post_enqueue_styles() {
    // Front-end styles
    $style_path = plugin_dir_path( __FILE__ ) . 'build/related-posts/index.css';
    if ( file_exists( $style_path ) ) {
        wp_enqueue_style(
            'related-posts-style', // Handle
            plugins_url( 'build/related-posts/index.css', __FILE__ ), // URL
            array(), // Dependencies
            filemtime( $style_path ) // Cache busting
        );
    }

    // Editor styles
    wp_enqueue_style(
        'related-posts-editor-style',
        plugins_url( 'build/related-posts/index.css', __FILE__ ),
        array(),
        filemtime( $style_path )
    );
}
add_action( 'wp_enqueue_scripts', 'related_post_enqueue_styles' ); // Frontend
add_action( 'enqueue_block_assets', 'related_post_enqueue_styles' ); // Editor



function related_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@400;500&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'related_fonts');


function robot_relate_fonts() {
    wp_enqueue_style( 'roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', false );
}

add_action( 'enqueue_block_assets', 'robot_relate_fonts' );