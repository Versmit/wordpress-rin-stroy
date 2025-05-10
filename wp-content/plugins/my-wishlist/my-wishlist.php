<?php
/*
Plugin Name: My Wishlist
Description: Собственный список желаний для WooCommerce.
Version: 1.0
Author: Ваше имя
*/

// Добавляем кнопку "Добавить в список желаний" на страницу товара
function mywl_add_wishlist_button() {
    global $product;
    echo '<button class="mywl-add-to-wishlist" data-product-id="' . esc_attr($product->get_id()) . '">Добавить в список желаний</button>';
}
add_action('woocommerce_after_add_to_cart_button', 'mywl_add_wishlist_button');

// Обработка AJAX-запроса для добавления товара в список желаний
function mywl_add_to_wishlist() {
    $product_id = intval($_POST['product_id']);
    if ($product_id > 0) {
        if (is_user_logged_in()) {
            // Для зарегистрированных пользователей
            $user_id = get_current_user_id();
            $wishlist = get_user_meta($user_id, 'mywl_wishlist', true);
            if (!is_array($wishlist)) {
                $wishlist = array();
            }
            if (!in_array($product_id, $wishlist)) {
                $wishlist[] = $product_id;
                update_user_meta($user_id, 'mywl_wishlist', $wishlist);
            }
        } else {
            // Для гостей используем куки
            $wishlist = isset($_COOKIE['mywl_wishlist']) ? explode(',', $_COOKIE['mywl_wishlist']) : array();
            if (!in_array($product_id, $wishlist)) {
                $wishlist[] = $product_id;
                setcookie('mywl_wishlist', implode(',', $wishlist), time() + 3600 * 24 * 30, '/');
            }
        }
        wp_send_json_success('Товар добавлен в список желаний.');
    } else {
        wp_send_json_error('Некорректный идентификатор товара.');
    }
}
add_action('wp_ajax_mywl_add_to_wishlist', 'mywl_add_to_wishlist');
add_action('wp_ajax_nopriv_mywl_add_to_wishlist', 'mywl_add_to_wishlist');

// Подключаем стили и скрипты только на нужных страницах
function mywl_enqueue_assets() {
    global $post;
    $enqueue = false;

    if ( is_product() ) {
        $enqueue = true;
    } elseif ( isset($post) && has_shortcode( $post->post_content, 'my_wishlist' ) ) {
        $enqueue = true;
    }

    if ( $enqueue ) {
        // Подключаем стили
        wp_enqueue_style(
            'mywl-wishlist-style',
            plugin_dir_url(__FILE__) . 'style.css',
            array(),
            '1.0'
        );

        // Подключаем скрипты
        wp_enqueue_script(
            'mywl-wishlist-script',
            plugin_dir_url(__FILE__) . 'js/wishlist.js',
            array('jquery'),
            '1.0',
            true
        );

        wp_localize_script('mywl-wishlist-script', 'mywl_wishlist_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'mywl_enqueue_assets');

// Шорткод для отображения списка желаний
function mywl_display_wishlist() {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta($user_id, 'mywl_wishlist', true);
    } else {
        $wishlist = isset($_COOKIE['mywl_wishlist']) ? explode(',', $_COOKIE['mywl_wishlist']) : array();
    }

    if (!empty($wishlist)) {
        $args = array(
            'post_type'      => 'product',
            'post__in'       => $wishlist,
            'orderby'        => 'post__in',
            'posts_per_page' => -1,
        );
        $loop = new WP_Query($args);

        if ($loop->have_posts()) {
            echo '<div class="mywl-wishlist-container">';
            echo '<ul class="mywl-wishlist-products">';
            while ($loop->have_posts()) : $loop->the_post();
                global $product;
                echo '<li>';
                echo '<div class="mywl-product-image">' . $product->get_image() . '</div>';
                echo '<div class="mywl-product-info">';
                echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
                echo '<div class="mywl-product-price">' . $product->get_price_html() . '</div>';
                echo '<button class="mywl-remove-from-wishlist" data-product-id="' . esc_attr( $product->get_id() ) . '">Удалить из списка желаний</button>';
                echo '</div>';
                echo '</li>';
            endwhile;
            echo '</ul>';
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>Ваш список желаний пуст.</p>';
        }
    } else {
        echo '<p>Ваш список желаний пуст.</p>';
    }
}
add_shortcode('my_wishlist', 'mywl_display_wishlist');

// Обработка AJAX-запроса для удаления товара из списка желаний
function mywl_remove_from_wishlist() {
    $product_id = intval($_POST['product_id']);
    if ($product_id > 0) {
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $wishlist = get_user_meta($user_id, 'mywl_wishlist', true);
            if (($key = array_search($product_id, $wishlist)) !== false) {
                unset($wishlist[$key]);
                update_user_meta($user_id, 'mywl_wishlist', $wishlist);
            }
        } else {
            $wishlist = isset($_COOKIE['mywl_wishlist']) ? explode(',', $_COOKIE['mywl_wishlist']) : array();
            if (($key = array_search($product_id, $wishlist)) !== false) {
                unset($wishlist[$key]);
                setcookie('mywl_wishlist', implode(',', $wishlist), time() + 3600 * 24 * 30, '/');
            }
        }
        wp_send_json_success('Товар удален из списка желаний.');
    } else {
        wp_send_json_error('Некорректный идентификатор товара.');
    }
}
add_action('wp_ajax_mywl_remove_from_wishlist', 'mywl_remove_from_wishlist');
add_action('wp_ajax_nopriv_mywl_remove_from_wishlist', 'mywl_remove_from_wishlist');

// Переносим список желаний из куки в мета-данные пользователя при входе
function mywl_merge_wishlist_on_login($user_login, $user) {
    $user_id = $user->ID;
    $user_wishlist = get_user_meta($user_id, 'mywl_wishlist', true);
    $cookie_wishlist = isset($_COOKIE['mywl_wishlist']) ? explode(',', $_COOKIE['mywl_wishlist']) : array();
    $merged_wishlist = array_unique(array_merge((array)$user_wishlist, $cookie_wishlist));
    update_user_meta($user_id, 'mywl_wishlist', $merged_wishlist);
    setcookie('mywl_wishlist', '', time() - 3600, '/'); // Удаляем куки
}
add_action('wp_login', 'mywl_merge_wishlist_on_login', 10, 2);
