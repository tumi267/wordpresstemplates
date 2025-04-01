<?php
/**
 * Plugin Name:       Dynamic Footer
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dynamic-footer
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
function create_block_dynamic_footer_block_init() {
	register_block_type( __DIR__ . '/build/dynamic-footer' );
}
add_action( 'init', 'create_block_dynamic_footer_block_init' );


function dynamic_footer_enqueue_styles() {
    // Enqueue frontend styles
    wp_enqueue_style(
        'dynamic-footer-block-style',
        plugins_url( 'build/dynamic-footer/index.css', __FILE__ ), // Adjusted path
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'build/dynamic-footer/index.css' ) // Versioning for cache busting
    );
}
add_action( 'wp_enqueue_scripts', 'dynamic_footer_enqueue_styles' ); // Ensures styles are enqueued on frontend


/**
 * Enqueues editor-specific styles for the block editor.
 */
function dynamic_footer_enqueue_editor_styles() {
    // Enqueue editor-specific styles
    wp_enqueue_style(
        'dynamic-footer-block-editor-style',
        plugins_url( 'build/dynamic-footer/index.css', __FILE__ ), // Adjusted path
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'build/dynamic-footer/index.css' ) // Versioning for cache busting
    );
}
add_action( 'enqueue_block_editor_assets', 'dynamic_footer_enqueue_editor_styles' ); // Enqueue editor styles

function custom_block_assets() {
    wp_enqueue_style('inter-font', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', [], null);
}
add_action('enqueue_block_editor_assets', 'custom_block_assets');
// Delete old options
// add_action('init', function() {
   
//     delete_option('custom_site_attributes');
// });

// Register the new combined setting
add_action('rest_api_init', function() {
    register_setting('general', 'custom_site_attributes', [
        'show_in_rest' => [
            'schema' => [
                'type'       => 'object',
                'properties' => [
                    // Navigation attributes
                    'fontFamily'        => ['type' => 'string', 'default' => 'Inter, sans-serif'],
                    'textColor'         => ['type' => 'string', 'default' => '#909090'],
                    'backgroundColor'   => ['type' => 'string', 'default' => '#FFFFFF'],
                    'backgroundOpacity' => ['type' => 'number', 'default' => 1],
                    'logoUrl'           => ['type' => 'string', 'default' => 'data:image/png;base64,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'],

                    // Footer attributes
                    'phone'       => ['type' => 'string', 'default' => '0728243782'],
                    'email'       => ['type' => 'string', 'default' => 'info@bubblegumclub.co.za'],
                    'address'     => ['type' => 'string', 'default' => '3 3rd Avenue, Melville'],
                    'description' => ['type' => 'string', 'default' => 'Bubblegum Club is a cultural organisation based in Johannesburg \u0026 Switzerland with a multi-faceted approach  of working across platforms and mediums.'],
                    'facebook'    => ['type' => 'string', 'default' => '/'],
                    'insta'       => ['type' => 'string', 'default' => '/'],
                    'linkedin'    => ['type' => 'string', 'default' => '/'],
                    'twitter'     => ['type' => 'string', 'default' => '/'],
                    'footer_logoUrl'     => ['type' => 'string', 'default' => 'data:image/png;base64,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'],
                ],
            ],
        ],
        'type'    => 'object',
        'default' => [
            // Navigation defaults
            'fontFamily'        => 'Inter, sans-serif',
            'textColor'         => '#909090',
            'backgroundColor'   => '#FFFFFF',
            'backgroundOpacity' => 1,
            'logoUrl'           => 'data:image/png;base64,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',

            // Footer defaults
            'phone'       => '0728243782',
            'email'       => 'info@bubblegumclub.co.za',
            'address'     => '3 3rd Avenue, Melville',
            'description' => 'Bubblegum Club is a cultural organisation based in Johannesburg \u0026 Switzerland with a multi-faceted approach  of working across platforms and mediums.',
            'facebook'    => '/',
            'insta'       => '/',
            'linkedin'    => '/',
            'twitter'     => '/',
            'footer_logoUrl'     => 'data:image/png;base64,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',
        ],
    ]);
});