<?php

function gamestore_styles()
{
	wp_enqueue_style('gamestore-general', get_template_directory_uri() . '/assets/css/gamestore.css', [], wp_get_theme()->get('Version'));
	wp_enqueue_script('gamestore-theme-related', get_template_directory_uri() . '/assets/js/gamestore-theme-related.js', [], wp_get_theme()->get('Version'), true);
	wp_localize_script('gamestore-theme-related', 'gamestore_params', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
	));


	//Swiper Slider
	wp_enqueue_style('swiper-bundle', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', [], wp_get_theme()->get('Version'));
	wp_enqueue_script('swiper-bundle', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', [], wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'gamestore_styles');

function gamestore_google_font()
{
	$font_url = '';
	$font = 'Urbanist'; // Название шрифта
	$font_extra = 'ital,wght@0,400;0,700;1,400;1,700'; // Параметры стилей и весов

	// Проверяем, включено ли использование Google Fonts
	if ('off' !== _x('on', 'Google font: on or off', 'gamestore')) {
		$query_args = array(
			'family' => urldecode($font . ':' . $font_extra), // Шрифт и параметры
			'subset' => urldecode('latin,latin-ext'), // Поддерживаемые символы
			'display' => urldecode('swap'), // Опция `display`
		);
		$font_url = add_query_arg($query_args, '//fonts.googleapis.com/css2');
	}

	return $font_url;
}

function gamestore_google_font_script()
{
	wp_enqueue_style(
		'gamestore-google-font', // Уникальный идентификатор
		gamestore_google_font(), // URL, созданный функцией
		[], // Зависимости
		'1.0.0' // Версия
	);
}
add_action('wp_enqueue_scripts', 'gamestore_google_font_script');

function gamestore_gutenbeg_style()
{
	wp_enqueue_style(
		'gamestore-google-font', // Уникальный идентификатор
		gamestore_google_font(), // URL, созданный функцией
		[], // Зависимости
		'1.0.0' // Версия
	);

	wp_enqueue_style(
		'gamestore-editor-styles',
		get_template_directory_uri() . '/assets/css/editor-style.css',
		[],
		'1.0.0'
	);

	wp_enqueue_style(
		'gamestore-editor-styles',
		get_template_directory_uri() . '/assets/css/editor-style.css',
		[],
		'1.0.0'
	);
}
add_action('enqueue_block_editor_assets', 'gamestore_gutenbeg_style');
add_action('enqueue_block_assets', 'gamestore_gutenbeg_style');

function gutenberg_activate_on_products( $can_edit, $post_type){
  if($post_type === 'product'){
    return true;
  }
  return $can_edit;
}
add_filter('use_block_editor_for_post_type','gutenberg_activate_on_products',10,2);

function enable_taxonomy_rest( $args ){
  $args['show_in_rest'] = true;
  return $args;
}
add_filter('woocommerce_taxonomy_args_product_cat','enable_taxonomy_rest');
add_filter('woocommerce_taxonomy_args_product_tag','enable_taxonomy_rest');
add_filter('woocommerce_product_description_heading','__return_null');