<?php
/**
 * homefinder WooCommerce hooks
 *
 * @package homefinder
 */

/**
 * Styles
 *
 * @see  gifymo_woocommerce_scripts()
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);


if (class_exists('YITH_Woocompare_Frontend')) {
    global $yith_woocompare;
    if (!is_admin()) {
        remove_action('woocommerce_single_product_summary', array($yith_woocompare->obj, 'add_compare_link'), 35);
        add_action('woocommerce_after_add_to_cart_form', array($yith_woocompare->obj, 'add_compare_link'), 15);
    }
}

add_action('woocommerce_before_main_content', 'gifymo_before_content', 10);
add_action('woocommerce_after_main_content', 'gifymo_after_content', 10);
add_action('gifymo_content_top', 'gifymo_shop_messages', 15);
add_action('gifymo_content_top', 'woocommerce_breadcrumb', 10);

add_action('woocommerce_after_shop_loop', 'gifymo_product_columns_wrapper_close', 40);

add_filter('loop_shop_columns', 'gifymo_loop_columns');


remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'gifymo_template_loop_product_thumbnail', 10);


add_action('woocommerce_before_shop_loop', 'gifymo_sorting_wrapper', 1);
add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 2);


add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 5);
add_action('woocommerce_before_shop_loop', 'gifymo_sorting_wrapper_close', 7);


add_action('woocommerce_single_product_summary', 'gifymo_woocommerce_single_product_summary_inner_start', -1);
add_action('woocommerce_single_product_summary', 'gifymo_woocommerce_single_product_summary_inner_end', 99999);

add_action('woocommerce_single_product_summary', 'gifymo_woocommerce_get_product_label_sale', 4);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);

add_action('woocommerce_before_single_product_summary', 'gifymo_woocommerce_before_single_product_summary_inner_start', 5);
add_action('woocommerce_before_single_product_summary', 'gifymo_woocommerce_show_product_sale_flash_start', 5);
add_action('woocommerce_before_single_product_summary', 'gifymo_woocommerce_show_product_sale_flash_end', 99999);
add_action('woocommerce_after_single_product_summary', 'gifymo_woocommerce_before_single_product_summary_inner_end', -1);

add_action('woocommerce_before_add_to_cart_quantity', 'gifymo_single_product_quantity_label', 10);


/**
 * Remove Action
 */
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

add_action('woocommerce_after_single_product', 'woocommerce_output_product_data_tabs', 10);
add_action('woocommerce_after_single_product', 'gifymo_upsell_display', 15);
add_action('woocommerce_after_single_product', 'gifymo_output_related_products', 20);


$product_single_style = get_theme_mod('gifymo_woocommerce_single_product_style', 1);

switch ($product_single_style) {
    case 1:
        // Support lightbox
        add_action('after_setup_theme', array(gifymo_WooCommerce::getInstance(), 'add_support_gallery_all'));
        break;
    case 2:
        // Supports Single Image
        add_action('after_setup_theme', array(gifymo_WooCommerce::getInstance(), 'add_support_lightbox'));
        add_filter('woocommerce_single_product_image_thumbnail_html', 'gifymo_woocommerce_single_product_image_thumbnail_html', 10, 2);
        break;

    case 3:
        // Supports Single Image
        add_action('after_setup_theme', array(gifymo_WooCommerce::getInstance(), 'add_support_lightbox'));
        add_filter('woocommerce_single_product_image_thumbnail_html', 'gifymo_woocommerce_single_product_image_thumbnail_html', 10, 2);
        break;

    case 4 :
        // Support lightbox
        add_action('after_setup_theme', array(gifymo_WooCommerce::getInstance(), 'add_support_gallery_all'));
        break;
}


if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.3', '>=')) {
    add_filter('woocommerce_add_to_cart_fragments', 'gifymo_cart_link_fragment');
} else {
    add_filter('add_to_cart_fragments', 'gifymo_cart_link_fragment');
}

/**
 * Checkout Page
 *
 * @see gifymo_checkout_before_customer_details_container
 * @see gifymo_checkout_after_customer_details_container
 * @see gifymo_checkout_after_order_review_container
 */

add_action('woocommerce_checkout_before_customer_details', 'gifymo_checkout_before_customer_details_container', 1);
add_action('woocommerce_checkout_after_customer_details', 'gifymo_checkout_after_customer_details_container', 1);
add_action('woocommerce_checkout_after_order_review', 'gifymo_checkout_after_order_review_container', 1);
add_action('woocommerce_checkout_order_review', 'gifymo_woocommerce_order_review_heading', 1);


// Cart Page
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('gifymo_after_form_cart', 'gifymo_woocommerce_cross_sell_display');

// Layout Product
function gifymo_include_hooks_product_blocks() {


    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

    add_action('woocommerce_before_shop_loop_item', 'gifymo_woocommerce_product_loop_start', -1);
    add_action('woocommerce_before_shop_loop', 'gifymo_product_columns_wrapper', 40);


    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */

    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

    add_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_product_loop_image_start', 5);
    add_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_product_loop_label_start', 10);
    add_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_get_product_label_new', 15);
    add_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_get_product_label_stock', 20);
    add_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_get_product_label_sale', 25);
    add_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_product_loop_label_end', 30);
    add_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_product_loop_action', 40);
    add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
    add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
    add_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_product_loop_image_end', 100);


    /**
     * Hook: woocommerce_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     */
    add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    add_action('woocommerce_shop_loop_item_title', 'gifymo_woocommerce_product_loop_caption_start', 0);


    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

    add_action('woocommerce_after_shop_loop_item_title', 'gifymo_woocommerce_product_loop_caption_end', 99);


    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

    add_action('woocommerce_after_shop_loop_item', 'gifymo_woocommerce_product_loop_end', 999);


    /**
     * Hook: gifymo_woocommerce_product_loop_action.
     */
    add_action('gifymo_woocommerce_product_loop_action', 'woocommerce_template_loop_add_to_cart', 25);
}


/**
 * Cart widget
 */
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

add_action('woocommerce_widget_shopping_cart_buttons', 'gifymo_woocommerce_widget_shopping_cart_button_view_cart', 10);
add_action('woocommerce_widget_shopping_cart_buttons', 'gifymo_woocommerce_widget_shopping_cart_proceed_to_checkout', 20);


if (isset($_GET['action']) && $_GET['action'] === 'elementor') {
    return;
}

gifymo_include_hooks_product_blocks();

if (get_theme_mod('gifymo_woocommerce_product_style', 'grid') == 'list') {
    remove_action('woocommerce_before_shop_loop_item_title', 'gifymo_woocommerce_product_loop_action', 40);
    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 15);
    add_action('woocommerce_after_shop_loop_item_title', 'gifymo_woocommerce_product_loop_action', 40);

}


function gifymo_update_setting_yith_plugin() {
    if (get_option('yith_woocompare_compare_button_in_product_page') == 'yes') {
        update_option('yith_woocompare_compare_button_in_product_page', 'no');
    }

    if (get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
        update_option('yith_woocompare_compare_button_in_products_list', 'no');
    }

    if (get_option('yith_wcwl_button_position') != 'shortcode') {
        update_option('yith_wcwl_button_position', 'shortcode');
    }
}

add_action('yit_framework_after_print_wc_panel_content', 'gifymo_update_setting_yith_plugin');
