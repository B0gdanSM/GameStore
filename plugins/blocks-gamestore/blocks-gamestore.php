<?php

/**
 * Plugin Name:       Blocks Gamestore
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blocks-gamestore
 *
 * @package CreateBlock
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('BLOCKS_GAMESTORE_PATH', plugin_dir_path(__FILE__));

require_once(BLOCKS_GAMESTORE_PATH . 'blocks.php');

function create_block_blocks_gamestore_block_init()
{
	if (function_exists('wp_register_block_types_from_metadata_collection')) {
		wp_register_block_types_from_metadata_collection(__DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php');
		return;
	}


	if (function_exists('wp_register_block_metadata_collection')) {
		wp_register_block_metadata_collection(__DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php');
	}

	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach (array_keys($manifest_data) as $block_type) {
		register_block_type(__DIR__ . "/build/{$block_type}");
	}
}
add_action('init', 'create_block_blocks_gamestore_block_init');

add_filter('block_type_metadata_settings', function ($settings, $metadata) {
    $callbacks = [
        'blocks-gamestore/games-line'         => 'view_block_games_line',
        'blocks-gamestore/recent-news'        => 'view_block_recent_news',
        'blocks-gamestore/subscribe'          => 'view_block_subscribe',
        'blocks-gamestore/featured-products'  => 'view_block_featured_products',
        'blocks-gamestore/single-news'        => 'view_block_single_news',
        'blocks-gamestore/news-header'        => 'view_block_news_header',
        'blocks-gamestore/news-box'           => 'view_block_news_box',
    ];

    if (isset($callbacks[$metadata['name']])) {
        $settings['render_callback'] = $callbacks[$metadata['name']];
    }

    return $settings;
}, 10, 2);

add_filter('block_categories_all', function ($categories) {
	return array_merge(
		$categories,
		[
			[
				'slug' => 'gamestore',
				'title' => 'GameStore'
			]
		]
	);
}, 10, 2);
