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
 */

define('GAMESTORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GAMESTORE_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once(GAMESTORE_PLUGIN_PATH . '/inc/games-core.php');