<?php

/**
 * Plugin Name: Core GameStor
 * Description: Core functions for GameStore.
 * 	Version: 1.0.0
 * Author: Bohdan
 * Author URI: https://artech.kiev.ua
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: core-gamestore
 * Domain Path: /languages
 * Requires plugins: woocommerce
 */

define('GAMESTORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GAMESTORE_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once(GAMESTORE_PLUGIN_PATH . '/inc/games-search.php');
require_once(GAMESTORE_PLUGIN_PATH . '/inc/games-meta.php');
require_once(GAMESTORE_PLUGIN_PATH . '/inc/games-tax.php');
require_once(GAMESTORE_PLUGIN_PATH . '/inc/social-shared.php');
require_once(GAMESTORE_PLUGIN_PATH . '/inc/news-term-meta.php');
require_once(GAMESTORE_PLUGIN_PATH . '/inc/games-filter.php');
 require_once(GAMESTORE_PLUGIN_PATH . '/inc/woo-blocks-hooks.php');