<?php
/**
 * Plugin Name:       Dynamic Post Block
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dynamic-post-block
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 */
function create_block_dynamic_post_block_block_init() {
    // Register the block type
    register_block_type( __DIR__ . '/build/dynamic-post-block', array(
        'editor_script' => 'dynamic-post-block-editor',  // Enqueue editor script
        'editor_style'  => 'dynamic-post-block-editor-style', // Enqueue editor styles
        'style'          => 'dynamic-post-block-style',   // Enqueue front-end styles
    ));

    // Register the block editor script
    wp_register_script(
        'dynamic-post-block-editor', 
        plugins_url( 'block.js', __FILE__ ), 
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ),
        true
    );
}

// Frontend enqueue styles (ensure this is hooked correctly)
function dynamic_post_block_enqueue_styles() {
    wp_enqueue_style(
        'dynamic-post-block-style', // Unique handle
        plugins_url( '/build/dynamic-post-block/index.css', __FILE__ ), 
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . '/build/dynamic-post-block/index.css' )
    );
}
add_action( 'enqueue_block_assets', 'dynamic_post_block_enqueue_styles' ); 
add_action( 'wp_enqueue_scripts', 'dynamic_post_block_enqueue_styles' );
add_action( 'init', 'create_block_dynamic_post_block_block_init' ); // Register block during init


function post_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@400;500&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'post_fonts');

function dynamic_post_fonts() {
    wp_enqueue_style( 'roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', false );
}

add_action( 'enqueue_block_assets', 'dynamic_post_fonts' );