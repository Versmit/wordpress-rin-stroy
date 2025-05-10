<?php

if (!function_exists('gifymo_woocommerce_widget_shopping_cart_button_view_cart')) {

    /**
     * Output the view cart button.
     */
    function gifymo_woocommerce_widget_shopping_cart_button_view_cart() {
        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="button wc-forward"><span>' . esc_html__('View cart', 'gifymo') . '</span></a>';
    }
}

if (!function_exists('gifymo_woocommerce_widget_shopping_cart_proceed_to_checkout')) {

    /**
     * Output the proceed to checkout button.
     */
    function gifymo_woocommerce_widget_shopping_cart_proceed_to_checkout() {
        echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="button checkout wc-forward"><span>Оформить заказ</span></a>';
    }
}


if (!function_exists('gifymo_before_content')) {
    /**
     * Before Content
     * Wraps all WooCommerce content in wrappers which match the theme markup
     *
     * @return  void`
     * @since   1.0.0
     */
    function gifymo_before_content() {
        ?>
        <div class="wrap">
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
        if (is_product_category()) {
            $cate      = get_queried_object();
            $cateID    = $cate->term_id;
            $banner_id = get_term_meta($cateID, 'product_cat_banner_id', true);

            if ($banner_id) {
                echo '<div class="product-category-banner">';
                echo wp_get_attachment_image($banner_id, 'full');
                echo '</div>';
            }
        }
    }
}

if (!function_exists('gifymo_after_content')) {
    /**
     * After Content
     * Closes the wrapping divs
     *
     * @return  void
     * @since   1.0.0
     */
    function gifymo_after_content() {
        ?>
        </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
        </div>
        <?php
    }
}

if (!function_exists('gifymo_cart_link_fragment')) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param array $fragments Fragments to refresh via AJAX.
     *
     * @return array            Fragments to refresh via AJAX
     */
    function gifymo_cart_link_fragment($fragments) {
        global $woocommerce;

        ob_start();
        $fragments['a.cart-contents .amount']     = gifymo_cart_amount();
        $fragments['a.cart-contents .count']      = gifymo_cart_count();
        $fragments['a.cart-contents .count-text'] = gifymo_cart_count_text();

        ob_start();
        gifymo_handheld_footer_bar_cart_link();
        $fragments['a.footer-cart-contents'] = ob_get_clean();

        return $fragments;
    }
}

if (!function_exists('gifymo_cart_link')) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return string
     * @since  1.0.0
     */
    function gifymo_cart_link() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            $items = '';
            $items .= '<a data-toggle="toggle" class="cart-contents header-button" href="' . esc_url(wc_get_cart_url()) . '" title="' . __("View your shopping cart", "gifymo") . '">';
            $items .= '<i class="opal-icon-cart" aria-hidden="true"></i>';
            $items .= '<span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . '</span>';
            $items .= '</a>';

            return $items;
        }

        return '';
    }
}

if (!function_exists('gifymo_cart_amount')) {
    /**
     *
     * @return string
     *
     */
    function gifymo_cart_amount() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="amount">' . wp_kses_data(WC()->cart->get_cart_subtotal()) . '</span>';
        }

        return '';
    }
}

if (!function_exists('gifymo_cart_count')) {
    /**
     *
     * @return string
     *
     */
    function gifymo_cart_count() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . '</span>';
        }

        return '';
    }
}

if (!function_exists('gifymo_cart_count_text')) {
    /**
     *
     * @return string
     *
     */
    function gifymo_cart_count_text() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="count-text">' . wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "gifymo")) . '</span>';
        }

        return '';
    }
}

if (!function_exists('gifymo_upsell_display')) {
    /**
     * Upsells
     * Replace the default upsell function with our own which displays the correct number product columns
     *
     * @return  void
     * @since   1.0.0
     * @uses    woocommerce_upsell_display()
     */
    function gifymo_upsell_display() {
        global $product;
        $number = count($product->get_upsell_ids());
        if ($number <= 0) {
            return;
        }
        $columns = absint(get_theme_mod('gifymo_woocommerce_single_upsell_columns', 3));
        if ($columns < $number) {
            echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="columns-' . esc_attr($columns) . '">';
        }
        woocommerce_upsell_display();
        echo '</div>';
    }
}

if (!function_exists('gifymo_output_related_products')) {
    /**
     * Related
     *
     * @return  void
     * @since   1.0.0
     * @uses    woocommerce_related_products()
     */
    function gifymo_output_related_products() {
        $columns = absint(get_theme_mod('gifymo_woocommerce_single_related_columns', 3));
        $number  = absint(get_theme_mod('gifymo_woocommerce_single_related_number', 3));
        if ($columns < $number) {
            echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="columns-' . esc_attr($columns) . '">';
        }
        $args = array(
            'posts_per_page' => $number,
            'columns'        => $columns,
            'orderby'        => 'rand'
        );
        woocommerce_related_products($args);
        echo '</div>';
    }
}

if (!function_exists('gifymo_sorting_wrapper')) {
    /**
     * Sorting wrapper
     *
     * @return  void
     * @since   1.4.3
     */
    function gifymo_sorting_wrapper() {
        echo '<div class="osf-sorting-wrapper"><div class="osf-sorting">';
    }
}

if (!function_exists('gifymo_sorting_wrapper_close')) {
    /**
     * Sorting wrapper close
     *
     * @return  void
     * @since   1.4.3
     */
    function gifymo_sorting_wrapper_close() {
        echo '</div></div>';
    }
}

if (!function_exists('gifymo_sorting_group')) {
    /**
     * Sorting wrapper
     *
     * @return  void
     * @since   1.4.3
     */
    function gifymo_sorting_group() {
        echo '<div class="osf-sorting-group col-lg-6 col-sm-12">';
    }
}

if (!function_exists('gifymo_sorting_group_close')) {
    /**
     * Sorting wrapper close
     *
     * @return  void
     * @since   1.4.3
     */
    function gifymo_sorting_group_close() {
        echo '</div>';
    }
}


if (!function_exists('gifymo_product_columns_wrapper')) {
    /**
     * Product columns wrapper
     *
     * @return  void
     * @since   2.2.0
     */
    function gifymo_product_columns_wrapper() {
        $columns = gifymo_loop_columns();
        if (get_theme_mod('gifymo_woocommerce_product_style', 'grid') == 'list') {
            $columns = 1;
        }
        echo '<div class="columns-' . intval($columns) . '">';
    }
}

if (!function_exists('gifymo_loop_columns')) {
    /**
     * Default loop columns on product archives
     *
     * @return integer products per row
     * @since  1.0.0
     */
    function gifymo_loop_columns() {
        $columns = get_theme_mod('gifymo_woocommerce_archive_columns', 4);

        return intval(apply_filters('gifymo_products_columns', $columns));
    }
}

if (!function_exists('gifymo_product_columns_wrapper_close')) {
    /**
     * Product columns wrapper close
     *
     * @return  void
     * @since   2.2.0
     */
    function gifymo_product_columns_wrapper_close() {
        echo '</div>';
    }
}

if (!function_exists('gifymo_shop_messages')) {
    /**
     * homefinder shop messages
     *
     * @since   1.4.4
     * @uses    gifymo_do_shortcode
     */
    function gifymo_shop_messages() {
        if (!is_checkout()) {
            echo wp_kses_post(gifymo_do_shortcode('woocommerce_messages'));
        }
    }
}

if (!function_exists('gifymo_woocommerce_pagination')) {
    /**
     * homefinder WooCommerce Pagination
     * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
     * but since homefinder adds pagination before that function is excuted we need a separate function to
     * determine whether or not to display the pagination.
     *
     * @since 1.4.4
     */
    function gifymo_woocommerce_pagination() {
        if (woocommerce_products_will_display()) {
            woocommerce_pagination();
        }
    }
}

if (!function_exists('gifymo_handheld_footer_bar_cart_link')) {
    /**
     * The cart callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function gifymo_handheld_footer_bar_cart_link() {
        ?>
        <a class="footer-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'gifymo'); ?>">
            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
        <?php
    }
}


if (!function_exists('gifymo_checkout_before_customer_details_container')) {
    function gifymo_checkout_before_customer_details_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '<div class="row"><div class="col-lg-7 col-md-12 col-sm-12"><div class="inner">';
        }
    }
}

if (!function_exists('gifymo_checkout_after_customer_details_container')) {
    function gifymo_checkout_after_customer_details_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '</div></div><div class="col-lg-5 col-md-12 col-sm-12"><div class="inner order_review_inner"> ';
        }
    }
}

if (!function_exists('gifymo_checkout_after_order_review_container')) {
    function gifymo_checkout_after_order_review_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '</div></div></div>';
        }
    }
}

if (!function_exists('gifymo_woocommerce_single_product_add_to_cart_before')) {
    function gifymo_woocommerce_single_product_add_to_cart_before() {
        echo '<div class="woocommerce-cart"><div class="inner woocommerce-cart-inner">';
    }
}

if (!function_exists('gifymo_woocommerce_single_product_add_to_cart_after')) {
    function gifymo_woocommerce_single_product_add_to_cart_after() {
        echo '</div></div>';
    }
}


if (!function_exists('gifymo_woocommerce_before_single_product_summary_inner_start')) {
    function gifymo_woocommerce_before_single_product_summary_inner_start() {
        echo '<div class="product-inner">';
    }
}

if (!function_exists('gifymo_woocommerce_before_single_product_summary_inner_end')) {
    function gifymo_woocommerce_before_single_product_summary_inner_end() {
        echo '</div>';
    }
}

if (!function_exists('gifymo_woocommerce_single_product_summary_inner_start')) {
    function gifymo_woocommerce_single_product_summary_inner_start() {
        echo '<div class="inner">';
    }
}

if (!function_exists('gifymo_woocommerce_single_product_summary_inner_end')) {
    function gifymo_woocommerce_single_product_summary_inner_end() {
        echo '</div>';
    }
}

if (!function_exists('gifymo_woocommerce_show_product_sale_flash_start')) {
    function gifymo_woocommerce_show_product_sale_flash_start() {
        echo '<div class="entry-gallery">';
    }
}

if (!function_exists('gifymo_woocommerce_show_product_sale_flash_end')) {
    function gifymo_woocommerce_show_product_sale_flash_end() {
        echo '</div>';
    }
}

if (!function_exists('gifymo_template_loop_product_thumbnail')) {
    function gifymo_template_loop_product_thumbnail($size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0) {
        echo gifymo_get_loop_product_thumbnail();

    }
}
if (!function_exists('gifymo_woocommerce_order_review_heading')) {
    function gifymo_woocommerce_order_review_heading() {
        echo ' <h3 class="order_review_heading">Ваш заказ</h3>';
    }
}


if (!function_exists('gifymo_get_loop_product_thumbnail')) {
    function gifymo_get_loop_product_thumbnail($size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0) {
        global $product;
        if (!$product) {
            return '';
        }
        $gallery    = $product->get_gallery_image_ids();
        $hover_skin = get_theme_mod('gifymo_woocommerce_product_hover', 'none');
        if ($hover_skin == '0' || count($gallery) <= 0) {
            echo '<div class="product-image">' . $product->get_image('shop_catalog') . '</div>';

            return '';
        }
        $image_featured = '<div class="product-image">' . $product->get_image('shop_catalog') . '</div>';
        $image_featured .= '<div class="product-image second-image">' . wp_get_attachment_image($gallery[0], 'shop_catalog') . '</div>';

        echo <<<HTML
<div class="product-img-wrap {$hover_skin}">
    <div class="inner">
        {$image_featured}
    </div>
</div>
HTML;
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_image_start')) {
    function gifymo_woocommerce_product_loop_image_start() {
        echo '<div class="product-transition">';
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_image_end')) {
    function gifymo_woocommerce_product_loop_image_end() {
        echo '</div>';
    }
}


if (!function_exists('gifymo_woocommerce_product_loop_action')) {
    function gifymo_woocommerce_product_loop_action() {
        ?>
        <div class="group-action">
            <div class="shop-action">
                <?php do_action('gifymo_woocommerce_product_loop_action'); ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('gifymo_woocommerce_change_path_shortcode')) {
    function gifymo_woocommerce_change_path_shortcode($template, $slug, $name) {
        wc_get_template('content-widget-product.php', array('show_rating' => false));
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_start')) {
    function gifymo_woocommerce_product_loop_start() {
        echo '<div class="product-block">';
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_end')) {
    function gifymo_woocommerce_product_loop_end() {
        echo '</div>';
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_caption_start')) {
    function gifymo_woocommerce_product_loop_caption_start() {
        echo '<div class="caption">';
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_caption_end')) {
    function gifymo_woocommerce_product_loop_caption_end() {
        echo '</div>';
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_group_transititon_start')) {
    function gifymo_woocommerce_product_loop_group_transititon_start() {
        echo '<div class="group-transition"><div class="group-transition-inner">';
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_group_transititon_end')) {
    function gifymo_woocommerce_product_loop_group_transititon_end() {
        echo '</div></div>';
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_label_start')) {
    function gifymo_woocommerce_product_loop_label_start() {
        echo '<div class="group-label">';
    }
}

if (!function_exists('gifymo_woocommerce_product_loop_label_end')) {
    function gifymo_woocommerce_product_loop_label_end() {
        echo '</div>';
    }
}

if (!function_exists('gifymo_woocommerce_get_product_category')) {
    function gifymo_woocommerce_get_product_category() {
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<div class="posted_in">', '</div>');
    }
}

if (!function_exists('gifymo_woocommerce_get_product_label_stock')) {
    function gifymo_woocommerce_get_product_label_stock() {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->get_stock_status() == 'outofstock') {
            echo '<span class="stock-label outofstock"><span>' . esc_html__('Out Of Stock', 'gifymo') . '</span></span>';
        } elseif ($product->get_stock_status() == 'instock') {
            echo '<span class="stock-label instock"><span>' . esc_html__('In Stock', 'gifymo') . '</span></span>';
        } else {
            echo '<span class="stock-label onbackorder"><span>' . esc_html__('On backorder', 'gifymo') . '</span></span>';
        }
    }
}

if (!function_exists('gifymo_woocommerce_get_product_label_new')) {
    function gifymo_woocommerce_get_product_label_new() {
        global $product;
        $newness_days = 30;
        $created      = strtotime($product->get_date_created());
        if ((time() - (60 * 60 * 24 * $newness_days)) < $created) {
            echo '<span class="new-label"><span>' . esc_html__('New!', 'gifymo') . '</span></span>';
        }
    }
}

if (!function_exists('gifymo_woocommerce_get_product_label_sale_number')) {
    function gifymo_woocommerce_get_product_label_sale_number() {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->is_on_sale() && $product->is_type('simple')) {
            $sale  = $product->get_sale_price();
            $price = $product->get_regular_price();
            $ratio = round(($price - $sale) / $price * 100);
            echo '<span class="onsale">-' . esc_html($ratio) . '% ' . esc_html__('Off', 'gifymo') . ' </span>';
        }
    }
}

if (!function_exists('gifymo_woocommerce_get_product_label_sale')) {
    function gifymo_woocommerce_get_product_label_sale() {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->is_on_sale() && $product->is_type('simple')) {
            echo '<span class="onsale">' . esc_html__('Sale', 'gifymo') . ' </span>';
        }
    }
}

if (!function_exists('gifymo_woocommerce_time_sale')) {
    function gifymo_woocommerce_time_sale() {
        /**
         * @var $product WC_Product
         */
        global $product;
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
        if ($time_sale) {
            wp_enqueue_script('otf-countdown');
            $time_sale += (get_option('gmt_offset') * 3600);
            echo '<div class="time">
                    <div class="deal-text d-none">' . esc_html__('Hurry up. Offer end in', 'gifymo') . '</div>
                    <div class="opal-countdown clearfix typo-quaternary"
                        data-countdown="countdown"
                        data-days="' . esc_html__("days", "gifymo") . '" 
                        data-hours="' . esc_html__("hours", "gifymo") . '"
                        data-minutes="' . esc_html__("mins", "gifymo") . '"
                        data-seconds="' . esc_html__("secs", "gifymo") . '"
                        data-Message="' . esc_html__('Expired', 'gifymo') . '"
                        data-date="' . date('m', $time_sale) . '-' . date('d', $time_sale) . '-' . date('Y', $time_sale) . '-' . date('H', $time_sale) . '-' . date('i', $time_sale) . '-' . date('s', $time_sale) . '">
                    </div>
            </div>';
        }
    }
}


if (!function_exists('gifymo_woocommerce_cross_sell_display')) {
    function gifymo_woocommerce_cross_sell_display() {
        woocommerce_cross_sell_display(get_theme_mod('gifymo_woocommerce_cart_cross_sells_limit', 4), get_theme_mod('gifymo_woocommerce_cart_cross_sells_columns', 2));
    }
}

function gifymo_woocommerce_single_product_image_thumbnail_html($image, $attachment_id) {
    return wc_get_gallery_image_html($attachment_id, true);
}

if (!function_exists('gifymo_single_product_quantity_label')) {
    function gifymo_single_product_quantity_label() {
        global $product;
        $min_value = apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product);
        $max_value = apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product);
        if ($max_value && $min_value !== $max_value) {
            echo '<label class="quantity_label">Количество:</label>';
        }
    }
}

function gifymo_wc_track_product_view() {

    if (!is_singular('product')) {
        return;
    }

    global $post;

    if (!isset($_COOKIE['otf_woocommerce_recently_viewed']) || isset($_COOKIE['otf_woocommerce_recently_viewed']) && empty($_COOKIE['otf_woocommerce_recently_viewed'])) {
        $viewed_products = array();
    } else {
        $viewed_products = (array)explode('|', $_COOKIE['otf_woocommerce_recently_viewed']);
    }

    // Unset if already in viewed products list.
    $keys = array_flip($viewed_products);
    if (isset($keys[$post->ID])) {
        unset($viewed_products[$keys[$post->ID]]);
    }

    $viewed_products[] = $post->ID;

    if (count($viewed_products) > 15) {
        array_shift($viewed_products);
    }

    // Store for session only.
    wc_setcookie('otf_woocommerce_recently_viewed', implode('|', $viewed_products));
}

add_action('template_redirect', 'gifymo_wc_track_product_view', 20);


function gifymo_woocommerce_single_product_image_gallery_classes($array) {
    global $product;
    $gallery = $product->get_gallery_image_ids();
    if (count($gallery) > 0) {
        $array[] = 'gifymo_has_image_gallery';
    } else {
        $array[] = 'gifymo_no_image_gallery';
    }

    return $array;
}

add_filter('woocommerce_single_product_image_gallery_classes', 'gifymo_woocommerce_single_product_image_gallery_classes', 10, 1);

function gifymo_woocommerce_pagination_args($args) {
    $args['prev_text'] = '<span class="opal-icon-angle-left"></span>' . __('Пред.', 'gifymo');
    $args['next_text'] = __('След.', 'gifymo') . '<span class="opal-icon-angle-right"></span>';
    $args['type']      = 'plain';

    return $args;
}

add_filter('woocommerce_pagination_args', 'gifymo_woocommerce_pagination_args', 10, 1);


