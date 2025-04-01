<?php
/**
 * Plugin Name:       Dynamic Cover
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dynamic-cover
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
function create_block_dynamic_cover_block_init() {
    
    register_block_type( __DIR__ . '/build/dynamic-cover' );
}
add_action( 'init', 'create_block_dynamic_cover_block_init' );


/**
 * Enqueues styles for the block.
 * This will include styles for both the frontend and editor.
 */
function dynamic_cover_block_enqueue_styles() {
    // Enqueue styles for the frontend
    $style_path = plugin_dir_path( __FILE__ ) . 'build/dynamic-cover/index.css';

    if ( file_exists( $style_path ) ) {
        wp_enqueue_style(
            'dynamic-cover-block-style', // Handle
            plugins_url( 'build/dynamic-cover/index.css', __FILE__ ), // URL
            array(), // Dependencies
            filemtime( $style_path ) // Cache busting
        );
    }
}
add_action( 'enqueue_block_assets', 'dynamic_cover_block_enqueue_styles' );

/**
 * Enqueues editor-specific styles.
 * This will ensure styles are applied in the block editor.
 */
function dynamic_cover_block_enqueue_editor_styles() {
    $editor_style_path = plugin_dir_path( __FILE__ ) . 'build/dynamic-cover/index.css';

    if ( file_exists( $editor_style_path ) ) {
        wp_enqueue_style(
            'dynamic-cover-block-editor-style', // Handle
            plugins_url( 'build/dynamic-cover/index.css', __FILE__ ), // URL
            array(), // Dependencies
            filemtime( $editor_style_path ) // Cache busting
        );
    }
}
add_action( 'enqueue_block_editor_assets', 'dynamic_cover_block_enqueue_editor_styles' );
 // Register block during init
function enqueue_google_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@400;500&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'enqueue_google_fonts');

function my_dynamic_block_enqueue_fonts() {
    wp_enqueue_style( 'roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', false );
}

add_action( 'enqueue_block_assets', 'my_dynamic_block_enqueue_fonts' );