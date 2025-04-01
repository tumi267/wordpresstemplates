<?php
/**
 * Plugin Name:       Randomized Archive Bolck
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       randomized-archive-bolck
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
function create_block_randomized_archive_bolck_block_init() {
	register_block_type( __DIR__ . '/build/randomized-archive-bolck' );
}
add_action( 'init', 'create_block_randomized_archive_bolck_block_init' );


function randomized_enqueue_styles() {
    $style_path = plugin_dir_path( __FILE__ ) . 'build/randomized-archive-bolck/index.css';

    if ( file_exists( $style_path ) ) {
        wp_enqueue_style(
            'randomized-style', // Handle
            plugins_url( 'build/randomized-archive-bolck/index.css', __FILE__ ), // URL
            array(), // Dependencies
            filemtime( $style_path ) // Cache busting
        );
    }
}
add_action( 'wp_enqueue_scripts', 'randomized_enqueue_styles' );

function randomised_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@400;500&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'randomised_fonts');


