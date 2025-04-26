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
}
add_action('enqueue_block_editor_assets', 'gamestore_gutenbeg_style');

function load_latest_games()
{
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 18,
		'post_status'    => 'publish',
		'orderby'        => 'rand',
	);
	$games_query = new WP_Query($args);

	$result = array();
	if ($games_query->have_posts()) {
		while ($games_query->have_posts()) {
			$games_query->the_post();

			$product = wc_get_product(get_the_ID());

			$result[] = array(
				'link'      => get_the_permalink(),
				'thumbnail' => $product->get_image('full'),
				'price'     => $product->get_price_html(),
				'title'     => get_the_title(),
			);
		}
	}
	wp_reset_postdata();

	wp_send_json_success($result);
}
add_action('wp_ajax_load_latest_games', 'load_latest_games');
add_action('wp_ajax_nopriv_load_latest_games', 'load_latest_games');

function search_games_by_title(){
  $search_term = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
  $args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    's' => $search_term
  );
  $games_query = new WP_Query($args);

  $result = array();
  if($games_query->have_posts()){
    while($games_query->have_posts()){
      $games_query->the_post();
      
      $product = wc_get_product(get_the_ID());

      $result[] = array(
        'link' => get_the_permalink(),
        'thumbnail' => $product->get_image('full'),
        'price' => $product->get_price_html(),
        'title' => get_the_title(),
      );
    }
  }
  wp_reset_postdata();

  wp_send_json_success($result);
}
add_action('wp_ajax_search_games_by_title','search_games_by_title');
add_action('wp_ajax_nopriv_search_games_by_title','search_games_by_title');