<?php
/**
 * Plugin Name: GameStore General
 * Plugin URI: https://example.com/gamestore-general
 * Description: General functions for GameStore.
 * Version: 1.0.0
 * Author: Bohdan
 * Author URI: https://artech.kiev.ua
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

 function gamestore_remove_dashboard_widgets() {
	global $wp_meta_boxes;

	// Удаляем стандартные виджеты
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['normal']['high']['rank_math_dashboard_widget']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);

	// Отключаем "WordPress Events and News" (если присутствует)
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
}

add_action('wp_dashboard_setup', 'gamestore_remove_dashboard_widgets');