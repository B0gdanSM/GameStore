<?php
// Add icon upload field to Add/Edit forms
add_action('news_category_add_form_fields', 'news_category_icon_field', 10, 2);
add_action('news_category_edit_form_fields', 'news_category_icon_field_edit', 10, 2);

function news_category_icon_field($taxonomy) {
    ?>
    <div class="form-field term-group">
        <label for="news_category_icon"><?php _e('Icon', 'textdomain'); ?></label>
        <input type="text" id="news_category_icon" name="news_category_icon" value="" />
        <button class="button news-category-upload-icon"><?php _e('Upload Icon', 'textdomain'); ?></button>
        <p class="description"><?php _e('Upload an icon for this category.', 'textdomain'); ?></p>
    </div>
    <?php
}

function news_category_icon_field_edit($term, $taxonomy) {
    $icon = get_term_meta($term->term_id, 'news_category_icon', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="news_category_icon"><?php _e('Icon', 'textdomain'); ?></label></th>
        <td>
            <input type="text" id="news_category_icon" name="news_category_icon" value="<?php echo esc_attr($icon); ?>" />
            <button class="button news-category-upload-icon"><?php _e('Upload Icon', 'textdomain'); ?></button>
            <p class="description"><?php _e('Upload an icon for this category.', 'textdomain'); ?></p>
            <?php if ($icon): ?>
                <img src="<?php echo esc_url($icon); ?>" style="max-width:50px;display:block;margin-top:10px;" />
            <?php endif; ?>
        </td>
    </tr>
    <?php
}

// Save icon field
add_action('created_news_category', 'save_news_category_icon', 10, 2);
add_action('edited_news_category', 'save_news_category_icon', 10, 2);

function save_news_category_icon($term_id, $tt_id) {
    if (isset($_POST['news_category_icon'])) {
        update_term_meta($term_id, 'news_category_icon', esc_url_raw($_POST['news_category_icon']));
    }
}

function enqueue_media_uploader() {
		if(isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'news_category') {
			wp_enqueue_media();
			wp_enqueue_script('news-term-meta', GAMESTORE_PLUGIN_URL . '/assets/js/news-term-meta.js', array('jquery'), null, true);
		}
}

// Enqueue media uploader
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');

function news_category_icon_column($columns) {
		$columns['news_category_icon'] = __('Icon', 'textdomain');
		return $columns;
}
add_filter( 'manage_edit-news_category_columns', 'news_category_icon_column' );
function news_category_icon_column_content($content, $column_name, $term_id) {
		if ($column_name === 'news_category_icon') {
				$icon = get_term_meta($term_id, 'news_category_icon', true);
				if ($icon) {
						$content = '<img src="' . esc_url($icon) . '" style="max-width:50px;display:block;" />';
				} else {
						$content = __('No icon', 'textdomain');
				}
		}
		return $content;
}
add_filter('manage_news_category_custom_column', 'news_category_icon_column_content', 10, 3);