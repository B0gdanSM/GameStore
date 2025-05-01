<?php

function view_block_games_line($attributes)
{
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => $attributes['count'],
		'orderby' => 'date',
		'order' => 'DESC',
	);
	$games_query = new WP_Query($args);

	// Начинаем буферизацию вывода
	ob_start();
	echo '<div ' . get_block_wrapper_attributes() . '>';
	if ($games_query->have_posts()) {
		echo '<div class="games-line-container"><div class="swiper-wrapper">';
		while ($games_query->have_posts()) {
			$games_query->the_post();
			$product = wc_get_product(get_the_ID());
			echo '<div class="swiper-slide game-item">';
			echo '<a href="' . get_the_permalink() . '">';
			echo $product->get_image('full');
			echo '</a>';
			echo '</div>';
		}
		echo '</div></div>';
	}
	echo '</div>';

	wp_reset_postdata();

	// Возвращаем буферизированный вывод
	return ob_get_clean();
}


function view_block_recent_news($attributes)
{
	$args = array(
		'post_type' => 'news',
		'posts_per_page' => $attributes['count'],
		'orderby' => 'date',
		'order' => 'DESC',
	);
	$news_query = new WP_Query($args);

	$image_bg = ($attributes['image']) ? 'style="background-image: url(' . $attributes['image'] . ')"' : '';

	ob_start();
	echo '<div ' . get_block_wrapper_attributes() . ' ' . $image_bg . '>';
	if ($news_query->have_posts()) {
		if ($attributes['title']) {
			echo '<h2>' . $attributes['title'] . '</h2>';
		}
		if ($attributes['description']) {
			echo '<p>' . $attributes['description'] . '</p>';
		}
		echo '<div class="recent-news wrapper">';
		while ($news_query->have_posts()) {
			$news_query->the_post();
			echo '<div class="news-item">';
			echo '<h3>' . get_the_title() . '</h3>';
			if (has_post_thumbnail()) {
				echo '<div class="news-thumbnail">';
				echo '<img src="' . get_the_post_thumbnail_url() . '" class="blur-image" alt="' . get_the_title() . '">';
				echo '<img src="' . get_the_post_thumbnail_url() . '" class="original-image" alt="' . get_the_title() . '">';
				echo '</div>';
			}
			echo '<div class="news-excerpt">' . get_the_excerpt() . '</div>';
			echo '<a href="' . get_the_permalink() . '" class="read-more">Open the post</a>';
			echo '</div>';
		}
		echo '</div>';
	} else {
		echo '<p>No recent news found.</p>';
	}
	echo '</div>';

	wp_reset_postdata();
	return ob_get_clean();
}

function view_block_subscribe($attributes)
{
	$image_bg = ($attributes['image']) ? 'style="background-image: url(' . $attributes['image'] . ')"' : '';

	ob_start();
	echo '<div ' . get_block_wrapper_attributes(array('class' => 'alignfull')) . ' ' . $image_bg . '>';
	echo '<div class="subscribe-inner wrapper">';
	echo '<h2 class="subscribe-title">' . $attributes['title'] . '</h2>';
	echo '<p class="subscribe-description">' . $attributes['description'] . '</p>';
	echo '<div class="subscribe-shortcode">' . do_shortcode($attributes['shortcode']) . '</div>';
	echo '</div>';
	echo '</div>';
	return ob_get_clean();
}

function view_block_featured_products($attributes)
{
	$featured_games = wc_get_products(array(
		'status' => 'publish',
		'limit' => $attributes['count'],
		'featured' => true,
		'orderby' => 'date',
		'order' => 'DESC',
	));

	ob_start();
	echo '<div ' . get_block_wrapper_attributes(array('class' => 'featured-products')) . '>';

	if ($attributes['title']) {
		echo '<h2>' . esc_html($attributes['title']) . '</h2>';
	}
	if ($attributes['description']) {
		echo '<p>' . esc_html($attributes['description']) . '</p>';
	}

	$platforms = array('Xbox', 'PC', 'PlayStation');

	if (!empty($featured_games)) {
		echo '<div class="game-list">';
		foreach ($featured_games as $product) {
			$platforms_html = '';
			
			echo '<div class="game-result">';
			echo '<a href="' . esc_url($product->get_permalink()) . '">';
			echo '<div class="game-featured-image">' . $product->get_image('medium') . '</div>';
			echo '<div class="game-meta">';
			echo '<div class="game-price">' . $product->get_price_html() . '</div>';
			echo '<h3 class="game-title">' . esc_html($product->get_name()) . '</h3>';
			echo '<div class="game-platforms">';
			foreach ($platforms as $platform) {
				$meta_key = '_platform_' . strtolower($platform);
				$class_name = 'platform-' . strtolower($platform);

				if (get_post_meta($product->get_ID(), $meta_key, true) === 'yes') {
					$platforms_html .= '<div class="' . esc_attr($class_name) . '"></div>';
				}
			}

			echo $platforms_html;
			echo '</div>';
			echo '</div>';
			echo '</a>';
			echo '</div>';
		}
		echo '</div>';
	} else {
		echo '<p>No products found.</p>';
	}

	echo '</div>';
	return ob_get_clean();
}
