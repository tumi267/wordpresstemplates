<?php
/**
 * Plugin Name:       Cover Archive
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cover-archive
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
function create_block_cover_archive_block_init() {
	register_block_type( __DIR__ . '/build/cover-archive' );
}
add_action( 'init', 'create_block_cover_archive_block_init' );

function cover_archive_enqueue_editor_styles() {
    // Define the path to the editor styles
    $editor_style_path = plugin_dir_path( __FILE__ ) . 'build/cover-archive/index.css';

    // Check if the file exists
    if ( file_exists( $editor_style_path ) ) {
        // Enqueue the CSS file for the block editor
        wp_enqueue_style(
            'dynamic-cover-block-editor-style', // Handle
            plugins_url( 'build/cover-archive/index.css', __FILE__ ), // URL
            array(), // Dependencies
            filemtime( $editor_style_path ) // Cache busting
        );
    }
}
add_action( 'enqueue_block_editor_assets', 'cover_archive_enqueue_editor_styles' );

function cover_archive_enqueue_frontend_styles() {
    // Define the path to the frontend styles
    $frontend_style_path = plugin_dir_path( __FILE__ ) . 'build/cover-archive/index.css';

    // Check if the file exists
    if ( file_exists( $frontend_style_path ) ) {
        // Enqueue the CSS file for the frontend
        wp_enqueue_style(
            'dynamic-cover-block-frontend-style', // Handle
            plugins_url( 'build/cover-archive/index.css', __FILE__ ), // URL
            array(), // Dependencies
            filemtime( $frontend_style_path ) // Cache busting
        );
    }
}
add_action( 'wp_enqueue_scripts', 'cover_archive_enqueue_frontend_styles' );
