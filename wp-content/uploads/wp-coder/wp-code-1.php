<?php

  defined( 'ABSPATH' ) || exit;
// Добавление метаполя для видео URL
add_action('add_meta_boxes', 'add_video_url_metabox');
function add_video_url_metabox() {
    add_meta_box(
        'product_video_url',
        'Product Video URL',
        'product_video_url_callback',
        'product',
        'side',
        'default'
    );
}

function product_video_url_callback($post) {
    wp_nonce_field('save_product_video_url', 'product_video_url_nonce');
    $value = get_post_meta($post->ID, '_product_video_url', true);
    echo '<label for="product_video_url">Video URL</label>';
    echo '<input type="text" id="product_video_url" name="product_video_url" value="' . esc_attr($value) . '" size="25" />';
}

// Сохранение метаполя
add_action('save_post', 'save_product_video_url');
function save_product_video_url($post_id) {
    if (!isset($_POST['product_video_url_nonce'])) {
        return $post_id;
    }
    $nonce = $_POST['product_video_url_nonce'];
    if (!wp_verify_nonce($nonce, 'save_product_video_url')) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (isset($_POST['product_video_url'])) {
        $video_url = sanitize_text_field($_POST['product_video_url']);
        update_post_meta($post_id, '_product_video_url', $video_url);
    }
}
// Отображение видео на странице товара
add_action('woocommerce_before_single_product_summary', 'display_product_video', 20);
function display_product_video() {
    global $product;
    $video_url = get_post_meta($product->get_id(), '_product_video_url', true);
    if ($video_url) {
        echo '<div class="product-video">
                <video width="400" controls>
                    <source src="' . esc_url($video_url) . '" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
              </div>';
    }
}
