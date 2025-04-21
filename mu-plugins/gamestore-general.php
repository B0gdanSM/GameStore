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

// Allow SVG uploads
function gamestore_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'gamestore_mime_types');

// Fix SVG display in media library
function gamestore_fix_svg() {
  echo '<style>
      .attachment-266x266, .thumbnail img {
          width: 100% !important;
          height: auto !important;
      }
  </style>';
}
add_action('admin_head', 'gamestore_fix_svg');

function gamestore_register_news_post_type() {
    $labels = array(
        'name'                  => _x('News', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('News Item', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('News', 'text_domain'),
        'name_admin_bar'        => __('News Item', 'text_domain'),
        'archives'              => __('News Archives', 'text_domain'),
        'attributes'            => __('News Item Attributes', 'text_domain'),
        'all_items'             => __('All News', 'text_domain'),
        'add_new_item'          => __('Add New News Item', 'text_domain'),
        'add_new'               => __('Add New', 'text_domain'),
        'edit_item'             => __('Edit News Item', 'text_domain'),
        'view_item'             => __('View News Item', 'text_domain'),
        'search_items'          => __('Search News', 'text_domain'),
        'not_found'             => __('No news found', 'text_domain'),
        'not_found_in_trash'    => __('No news found in trash', 'text_domain'),
        'featured_image'        => __('News Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
    );

    $args = array(
        'label'                 => __('News', 'text_domain'),
        'description'           => __('Company or website news', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-megaphone',
        'show_in_admin_bar'     => true,
        'show_in_rest'          => true,
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'news'),
    );

    register_post_type('news', $args);
}
add_action('init', 'gamestore_register_news_post_type', 0);
