<?php
/**
 * Plugin Name:       Post Hero
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       post-hero
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
function create_block_post_hero_block_init() {
	register_block_type( __DIR__ . '/build/post-hero' );
}
add_action( 'init', 'create_block_post_hero_block_init' );

function hero_post_enqueue_styles() {
    $style_path = plugin_dir_path( __FILE__ ) . 'build/post-hero/index.css';

    if ( file_exists( $style_path ) ) {
        wp_enqueue_style(
            'post-hero-style', // Handle
            plugins_url( 'build/post-hero/index.css', __FILE__ ), // URL
            array(), // Dependencies
            filemtime( $style_path ) // Cache busting
        );
    }
}
add_action( 'wp_enqueue_scripts', 'hero_post_enqueue_styles' );

function hero_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@400;500&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'hero_fonts');

function dynamic_hero_fonts() {
    wp_enqueue_style( 'roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', false );
}

add_action( 'enqueue_block_assets', 'dynamic_hero_fonts' );


function enqueue_admin_script() {
    wp_enqueue_script('jquery'); // Ensure jQuery is available

    $script = "
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('a[href*=\"action=edit&post_type=wp_template\"]').forEach(button => {
            button.addEventListener('click', () => {
                const urlParams = new URLSearchParams(window.location.search);
                const postId = urlParams.get('post'); // Get post ID from the URL
                if (postId) {
                    localStorage.setItem('originalPostId', postId); // Store it globally
                }
            });
        });
    });
    ";

    wp_add_inline_script('jquery', $script);
}
add_action('admin_enqueue_scripts', 'enqueue_admin_script');
