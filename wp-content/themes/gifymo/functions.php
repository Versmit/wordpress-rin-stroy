<?php
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
    require get_theme_file_path('inc/back-compat.php');

    return;
}
if (is_admin()) {
    require get_theme_file_path('inc/admin/class-admin.php');
}

require get_theme_file_path('inc/tgm-plugins.php');
require get_theme_file_path('inc/template-tags.php');
require get_theme_file_path('inc/template-functions.php');
require get_theme_file_path('inc/class-main.php');
require get_theme_file_path('inc/starter-settings.php');

if ( ! class_exists( 'GifymoCore' ) ) {
    if ( gifymo_is_woocommerce_activated() ) {
        require get_theme_file_path( 'inc/vendors/woocommerce/woocommerce-template-functions.php' );
        require get_theme_file_path( 'inc/vendors/woocommerce/class-woocommerce.php' );
        require get_theme_file_path( 'inc/vendors/woocommerce/woocommerce-template-hooks.php' );
    }
    // Blog Sidebar
    require get_theme_file_path( 'inc/class-sidebar.php' );
}
// Добавление поля в административный интерфейс товара
add_action( 'woocommerce_product_options_general_product_data', 'add_custom_field_to_products' );
function add_custom_field_to_products() {
    woocommerce_wp_text_input( array(
        'id'            => 'custom_unit_type', // Идентификатор поля
        'label'         => __('Единица измерения', 'woocommerce'), // Название поля
        'placeholder'   => 'Введите единицу измерения (например, кг или м²)',
        'desc_tip'      => true,
        'description'   => __('Укажите единицу измерения для этого товара.', 'woocommerce'), // Описание поля
    ) );
}

// Сохранение данных поля при сохранении товара
add_action( 'woocommerce_process_product_meta', 'save_custom_field' );
function save_custom_field( $post_id ) {
    $custom_unit_type = isset( $_POST['custom_unit_type'] ) ? $_POST['custom_unit_type'] : '';
    update_post_meta( $post_id, 'custom_unit_type', sanitize_text_field( $custom_unit_type ) );
}
// Добавление единицы измерения к цене на странице товара
add_filter( 'woocommerce_get_price_html', 'add_unit_to_price_display', 10, 2 );
function add_unit_to_price_display( $price, $product ) {
    $unit = get_post_meta( $product->get_id(), 'custom_unit_type', true );
    if ( ! empty( $unit ) ) {
        $price .= ' / ' . esc_html( $unit );
    }
    return $price;
}
add_action('wp_footer', 'add_custom_icons_template');
function add_custom_icons_template() {
    echo do_shortcode('[elementor-template id="5690"]');
}
add_filter('woocommerce_get_price_html', 'custom_price_message', 20, 2);

function custom_price_message($price, $product) {
    if ('' === $product->get_price() || 0 == $product->get_price()) {
        return 'По запросу'; // Текст, который будет показан, если цена не установлена
    }
    return $price; // Возвращаем обычную цену, если она есть
}
add_filter('woocommerce_get_price_html', 'cw_change_product_price_display', 9999, 2);

function cw_change_product_price_display($price, $product) {
    $text = __('от');
    $is_price_from = get_field('is_price_from', $product->get_id());

    if ($is_price_from) {
        return '<span class="pre-price">' . $text . ' </span>' . $price;
    }

    return $price;
}
// Добавляем поле при редактировании вариации
function add_variation_settings_fields($loop, $variation_data, $variation) {
    woocommerce_wp_text_input(
        array(
            'id' => '_unit_of_measure[' . $variation->ID . ']',
            'label' => __('Единица измерения', 'woocommerce'),
            'desc_tip' => 'true',
            'description' => __('Введите единицу измерения для этой вариации.', 'woocommerce'),
            'wrapper_class' => 'form-row form-row-full',
            'value' => get_post_meta($variation->ID, '_unit_of_measure', true)
        )
    );
}
add_action('woocommerce_variation_options_pricing', 'add_variation_settings_fields', 10, 3);

// Сохраняем данные при сохранении вариации
function save_variation_settings_fields($post_id) {
    $unit_of_measure = $_POST['_unit_of_measure'][$post_id] ?? '';
    if (!empty($unit_of_measure)) {
        update_post_meta($post_id, '_unit_of_measure', esc_attr($unit_of_measure));
    }
}
add_action('woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2);

// Отображение значения единицы измерения на странице продукта
function display_unit_of_measure_on_product_page() {
    global $product;
    if ($product->is_type('variable')) {
        $variations = $product->get_available_variations();
        foreach ($variations as $variation) {
            $unit_of_measure = get_post_meta($variation['variation_id'], '_unit_of_measure', true);
            if (!empty($unit_of_measure)) { // Проверяем, что значение не пустое
                echo '<div class="unit-of-measure">Единица измерения: ' . esc_html($unit_of_measure) . '</div>';
            }
        }
    }
}
add_action('woocommerce_single_product_summary', 'display_unit_of_measure_on_product_page', 25);

add_action( 'product_cat_edit_form_fields', 'wpm_taxonomy_edit_meta_field', 10, 2 );

function wpm_taxonomy_edit_meta_field($term) {
$t_id = $term->term_id;
$term_meta = get_option( "taxonomy_$t_id" );
  $content = $term_meta['custom_term_meta'] ? wp_kses_post( $term_meta['custom_term_meta'] ) : '';
  $settings = array( 'textarea_name' => 'term_meta[custom_term_meta]' );
  ?>
  <tr class="form-field">
  <th scope="row" valign="top"><label for="term_meta[custom_term_meta]">Второе описание или банеры внизу для категории</label></th>
    <td>
      <?php wp_editor( $content, 'product_cat_details', $settings ); ?>
     
    </td>
  </tr>
<?php
}

add_action( 'edited_product_cat', 'save_taxonomy_custom_meta', 10, 2 ); 
add_action( 'create_product_cat', 'save_taxonomy_custom_meta', 10, 2 );

function save_taxonomy_custom_meta( $term_id ) {
  if ( isset( $_POST['term_meta'] ) ) {
    $t_id = $term_id;
    $term_meta = get_option( "taxonomy_$t_id" );
    $cat_keys = array_keys( $_POST['term_meta'] );
    foreach ( $cat_keys as $key ) {
      if ( isset ( $_POST['term_meta'][$key] ) ) {
        $term_meta[$key] = wp_kses_post( stripslashes($_POST['term_meta'][$key]) );
      }
    }
   
    update_option( "taxonomy_$t_id", $term_meta );
  }
}

add_action('woocommerce_after_shop_loop', 'wpm_product_cat_archive_add_meta');

function wpm_product_cat_archive_add_meta() {
    $t_id = get_queried_object()->term_id;
    $term_meta = get_option("taxonomy_$t_id"); // Получаем метаданные термина

    // Проверяем, что $term_meta является массивом и содержит ключ 'custom_term_meta'
    if (is_array($term_meta) && isset($term_meta['custom_term_meta'])) {
        $term_meta_content = $term_meta['custom_term_meta'];
        if (!empty($term_meta_content)) {
            echo '<div class="woo-sc-box normal rounded full">';
            echo apply_filters('the_content', $term_meta_content);
            echo '</div>';
        }
    }
}

add_filter('storefront_handheld_footer_bar_links', 'customize_handheld_footer_bar_links');

function customize_handheld_footer_bar_links($links) {
    // Добавляем или изменяем ссылку для кнопки "Каталог"
    $links['catalog_key'] = '<a href="https://rin-stroy.ru/katalog-kategorii/"><i class="fas fa-bars"></i> Каталог</a>';

    // Добавляем или изменяем ссылку для кнопки "Корзина"
    if (isset($links['cart'])) {
        $links['cart'] = '<a href="https://rin-stroy.ru/corzina/"><i class="fa fa-shopping-cart"></i> Корзина</a>';
    }

    // Добавляем или изменяем ссылку для кнопки "Поиск"
    if (isset($links['search'])) {
        $links['search'] = '
        <div id="search-container">
            <a href="#" id="search-icon"><i class="fa fa-search"></i> Поиск</a>
            <form id="mobile-search-form" class="mobile-search-form" role="search" method="get" action="' . esc_url(home_url('/')) . '">
                <input type="search" name="s" placeholder="Поиск..." class="search-input"/>
                <button type="submit" class="search-button">Искать</button>
            </form>
        </div>';
    }
    // Добавляем кнопку для "Акции"
    $links['deals'] = '<a href="https://rin-stroy.ru/sale/"><i class="fa fa-tags"></i> Акции</a>';

    // Добавляем кнопку для "Звонок"
    $links['callback'] = '<a href="tel:+79250533750"><i class="fa fa-phone"></i> Звонок</a>';

    return $links;
}

// Отключить вывод ошибок
error_reporting(0);

// Включить или выключить отображение ошибок (рекомендуется выключить на продакшене)
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
function video_carousel_shortcode($atts, $content = null) {
    // Удаляем пробелы и ненужные символы
    $content = trim($content);

    // Проверяем, есть ли контент
    if (empty($content)) {
        return '<p>Видео не найдены.</p>';
    }

    // Очищаем контент и разрешаем только iframe теги
    $content = wp_kses($content, array(
        'iframe' => array(
            'src' => array(),
            'width' => array(),
            'height' => array(),
            'frameborder' => array(),
            'allow' => array(),
            'allowfullscreen' => array(),
            'title' => array(),
            'referrerpolicy' => array()
        )
    ));

    // Разбиваем контент на отдельные строки
    $video_iframes = explode("\n", $content);

    ob_start();
    ?>
    <div class="video-carousel">
        <?php foreach ($video_iframes as $iframe) : ?>
            <div class="video-slide">
                <?php echo $iframe; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <style>
        .video-carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
        }
        .video-slide {
            flex: 0 0 auto;
            scroll-snap-align: start;
            margin-right: 10px;
        }
        .video-slide iframe {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%; /* 100% ширина родительского контейнера */
            max-width: 560px; /* Максимальная ширина видео */
            height: 315px; /* Пропорциональная высота */
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('video_carousel', 'video_carousel_shortcode');
function custom_category_carousel_script() {
    if (is_page('название-вашей-страницы') || is_front_page()) { // Укажите условие для определенной страницы
        ?>
        <script>
        const carousel = document.querySelector('.carousel');
        const leftButton = document.querySelector('.carousel-btn.left');
        const rightButton = document.querySelector('.carousel-btn.right');

        let scrollAmount = 0;

        rightButton.addEventListener('click', () => {
            const maxScroll = carousel.scrollWidth - carousel.clientWidth;
            if (scrollAmount < maxScroll) {
                scrollAmount += 160; // Прокрутка на ширину одного элемента плюс отступы
                carousel.scrollTo({
                    top: 0,
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            } else {
                scrollAmount = 0;
                carousel.scrollTo({
                    top: 0,
                    left: 0,
                    behavior: 'smooth'
                });
            }
        });

        leftButton.addEventListener('click', () => {
            if (scrollAmount > 0) {
                scrollAmount -= 160;
                carousel.scrollTo({
                    top: 0,
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            } else {
                scrollAmount = carousel.scrollWidth - carousel.clientWidth;
                carousel.scrollTo({
                    top: 0,
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'custom_category_carousel_script');
function add_custom_product_meta_box() {
    add_meta_box(
        'product_info_meta_box', // ID метабокса
        'Дополнительная информация о товаре', // Заголовок метабокса
        'show_product_info_meta_box', // Функция, которая выводит HTML код метабокса
        'product', // Тип записи (товар)
        'normal', // Положение метабокса
        'high' // Приоритет
    );
}
add_action('add_meta_boxes', 'add_custom_product_meta_box');

function show_product_info_meta_box($post) {
    $meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="info_1">Информация 1:</label>
        <input type="text" name="info_1" id="info_1" value="<?php echo esc_attr($meta['info_1'][0] ?? ''); ?>" />
    </p>
    <p>
        <label for="link_1">Ссылка 1:</label>
        <input type="url" name="link_1" id="link_1" value="<?php echo esc_attr($meta['link_1'][0] ?? ''); ?>" />
    </p>
    <p>
        <label for="image_1">Изображение 1:</label>
        <input type="text" name="image_1" id="image_1" value="<?php echo esc_attr($meta['image_1'][0] ?? ''); ?>" />
        <button type="button" class="upload_image_button button">Загрузить изображение</button>
    </p>
    <p>
        <label for="info_2">Информация 2:</label>
        <input type="text" name="info_2" id="info_2" value="<?php echo esc_attr($meta['info_2'][0] ?? ''); ?>" />
    </p>
    <p>
        <label for="link_2">Ссылка 2:</label>
        <input type="url" name="link_2" id="link_2" value="<?php echo esc_attr($meta['link_2'][0] ?? ''); ?>" />
    </p>
    <p>
        <label for="image_2">Изображение 2:</label>
        <input type="text" name="image_2" id="image_2" value="<?php echo esc_attr($meta['image_2'][0] ?? ''); ?>" />
        <button type="button" class="upload_image_button button">Загрузить изображение</button>
    </p>
    <p>
        <label for="info_3">Информация 3:</label>
        <input type="text" name="info_3" id="info_3" value="<?php echo esc_attr($meta['info_3'][0] ?? ''); ?>" />
    </p>
    <p>
        <label for="link_3">Ссылка 3:</label>
        <input type="url" name="link_3" id="link_3" value="<?php echo esc_attr($meta['link_3'][0] ?? ''); ?>" />
    </p>
    <p>
        <label for="image_3">Изображение 3:</label>
        <input type="text" name="image_3" id="image_3" value="<?php echo esc_attr($meta['image_3'][0] ?? ''); ?>" />
        <button type="button" class="upload_image_button button">Загрузить изображение</button>
    </p>
    <?php
}

function save_product_info_meta_box($post_id) {
    update_post_meta($post_id, 'info_1', sanitize_text_field($_POST['info_1']));
    update_post_meta($post_id, 'link_1', sanitize_text_field($_POST['link_1']));
    update_post_meta($post_id, 'image_1', sanitize_text_field($_POST['image_1']));
    update_post_meta($post_id, 'info_2', sanitize_text_field($_POST['info_2']));
    update_post_meta($post_id, 'link_2', sanitize_text_field($_POST['link_2']));
    update_post_meta($post_id, 'image_2', sanitize_text_field($_POST['image_2']));
    update_post_meta($post_id, 'info_3', sanitize_text_field($_POST['info_3']));
    update_post_meta($post_id, 'link_3', sanitize_text_field($_POST['link_3']));
    update_post_meta($post_id, 'image_3', sanitize_text_field($_POST['image_3']));
}
add_action('save_post', 'save_product_info_meta_box');

function display_custom_product_info() {
    if ( is_singular( 'product' ) ) {
        $info_1 = get_post_meta( get_the_ID(), 'info_1', true );
        $link_1 = get_post_meta( get_the_ID(), 'link_1', true );
        $image_1 = get_post_meta( get_the_ID(), 'image_1', true );

        $info_2 = get_post_meta( get_the_ID(), 'info_2', true );
        $link_2 = get_post_meta( get_the_ID(), 'link_2', true );
        $image_2 = get_post_meta( get_the_ID(), 'image_2', true );

        $info_3 = get_post_meta( get_the_ID(), 'info_3', true );
        $link_3 = get_post_meta( get_the_ID(), 'link_3', true );
        $image_3 = get_post_meta( get_the_ID(), 'image_3', true );

        if ( $info_1 || $info_2 || $info_3 ) {
            echo '<div class="custom-product-info-wrapper">';

            if ( !empty($info_1) ) {
                $background_style = !empty($image_1) ? 'style="background-image: url(' . esc_url($image_1) . ');"' : '';
                echo '<div class="info-card-custom" ' . $background_style . '>';
                echo '<div class="info-card-icon-custom"><!-- Здесь можно вставить иконку, если нужно --></div>';
                echo '<div class="info-card-text-custom">' . esc_html( $info_1 ) . '</div>';
                if ( !empty($link_1) ) {
                    echo '<a href="' . esc_url( $link_1 ) . '" class="info-card-link-custom">Подробнее</a>';
                }
                echo '</div>';
            }

            if ( !empty($info_2) ) {
                $background_style = !empty($image_2) ? 'style="background-image: url(' . esc_url($image_2) . ');"' : '';
                echo '<div class="info-card-custom" ' . $background_style . '>';
                echo '<div class="info-card-icon-custom"><!-- Здесь можно вставить иконку, если нужно --></div>';
                echo '<div class="info-card-text-custom">' . esc_html( $info_2 ) . '</div>';
                if ( !empty($link_2) ) {
                    echo '<a href="' . esc_url( $link_2 ) . '" class="info-card-link-custom">Подробнее</a>';
                }
                echo '</div>';
            }

            if ( !empty($info_3) ) {
                $background_style = !empty($image_3) ? 'style="background-image: url(' . esc_url($image_3) . ');"' : '';
                echo '<div class="info-card-custom" ' . $background_style . '>';
                echo '<div class="info-card-icon-custom"><!-- Здесь можно вставить иконку, если нужно --></div>';
                echo '<div class="info-card-text-custom">' . esc_html( $info_3 ) . '</div>';
                if ( !empty($link_3) ) {
                    echo '<a href="' . esc_url( $link_3 ) . '" class="info-card-link-custom">Подробнее</a>';
                }
                echo '</div>';
            }

            echo '</div>';
        }
    }
}
add_action('woocommerce_single_product_summary', 'display_custom_product_info', 20);

function enqueue_custom_admin_scripts() {
    global $typenow;
    if( $typenow == 'product' ) {
        wp_enqueue_media();
        wp_enqueue_script( 'custom-meta-box-image', get_stylesheet_directory_uri() . '/js/custom-meta-box-image.js', array('jquery'), null, true );
    }
}
add_action( 'admin_enqueue_scripts', 'enqueue_custom_admin_scripts' );
// Добавление произвольного поля в редактор товара
function custom_product_tab_additional_field() {
    woocommerce_wp_text_input(
        array(
            'id'          => 'custom_tab_content',
            'label'       => __('Дополнительное поле для таблички', 'woocommerce'),
            'desc_tip'    => 'true',
            'description' => __('Введите содержимое, которое будет отображаться в табличке на странице товара.', 'woocommerce'),
            'type'        => 'textarea'
        )
    );
}
add_action('woocommerce_product_options_general_product_data', 'custom_product_tab_additional_field');

// Сохранение произвольного поля
function custom_product_tab_save_additional_field($post_id) {
    $custom_tab_content = isset($_POST['custom_tab_content']) ? $_POST['custom_tab_content'] : '';
    update_post_meta($post_id, 'custom_tab_content', sanitize_textarea_field($custom_tab_content));
}
add_action('woocommerce_process_product_meta', 'custom_product_tab_save_additional_field');
// Отображение таблички на странице товара
function custom_product_tab_display() {
    global $post;

    $custom_tab_content = get_post_meta($post->ID, 'custom_tab_content', true);

    if (!empty($custom_tab_content)) {
        echo '<div class="custom-product-tab-wrapper">';
        echo '<div class="custom-product-tab-content">';
        echo wp_kses_post($custom_tab_content);
        echo '</div>';
        echo '</div>';
    }
}
add_action('woocommerce_single_product_summary', 'custom_product_tab_display', 25);
// Создание метабокса для добавления видео и миниатюры
function product_video_custom_field() {
    $prefix = 'osf_products_'; // Префикс для полей

    // Создаем метабокс с использованием CMB2
    $cmb = new_cmb2_box(array(
        'id'            => $prefix . 'product_video',
        'title'         => esc_html__('Product Video Config', 'gifymo-core'),
        'object_types'  => array('product'), // Тип записи (продукты)
        'context'       => 'normal',
        'priority'      => 'high',
    ));

    // Поле для видео YouTube/Vimeo
    $cmb->add_field(array(
        'name' => __('Product video (YouTube & Vimeo)', 'gifymo-core'),
        'desc' => __('Supports video from YouTube and Vimeo.', 'gifymo-core'),
        'id' => $prefix . '_video',
        'type' => 'oembed', // oEmbed для YouTube и Vimeo
    ));

    // Поле для видео Rutube
    $cmb->add_field(array(
        'name' => __('Product video (Rutube)', 'gifymo-core'),
        'desc' => __('Supports video from Rutube.', 'gifymo-core'),
        'id' => $prefix . '_video_rutube',
        'type' => 'text', // Поле текста для Rutube
    ));

    // Поле для миниатюры
    $cmb->add_field(array(
        'name' => __('Video Thumbnail', 'gifymo-core'),
        'desc' => __('Upload an image or enter an URL.', 'gifymo-core'),
        'id' => $prefix . '_video_thumbnail',
        'type' => 'file',
        'text' => array(
            'add_upload_file_text' => 'Add Image' // Текст для кнопки загрузки
        ),
        'preview_size' => 'thumbnail', // Миниатюра в админке
    ));
}
add_action('cmb2_admin_init', 'product_video_custom_field');

// Функция для отображения видео и миниатюры
function custom_display_video_in_gallery() {
    global $post;
    // Проверяем наличие миниатюры
    $thumbnail_url = get_post_meta($post->ID, 'osf_products__video_thumbnail', true);
    if ($thumbnail_url) {
        echo '<div class="woocommerce-product-gallery__image">';
        echo '<img src="' . esc_url($thumbnail_url) . '" alt="Video Thumbnail" />';
        echo '</div>';
    }

    // Видео с Rutube
    $video_rutube_url = get_post_meta($post->ID, 'osf_products__video_rutube', true);
    if ($video_rutube_url && strpos($video_rutube_url, 'rutube.ru') !== false) {
        $embed_url = get_rutube_embed_url($video_rutube_url,);
		
		$thumb = '';
		if (preg_match('/rutube\.ru\/video\/([a-zA-Z0-9]+)/', $video_rutube_url, $matches) && !empty($matches[1])) {
			$thumb = 'data-thumb="https://rutube.ru/api/video/'.$matches[1].'/thumbnail/?redirect=1"';
		}
        echo '<div class="woocommerce-product-gallery__image" data-rutube-url="'.$video_rutube_url.'" '.$thumb.'>';
        echo '<iframe width="100%" height="338" src="' . esc_url($embed_url) . '" frameborder="0" allowfullscreen></iframe>';
        echo '</div>';
    }

    // Видео с YouTube и Vimeo
    $video_url = get_post_meta($post->ID, 'osf_products__video', true);
    if ($video_url) {
        echo '<div class="woocommerce-product-gallery__image">';
        echo wp_oembed_get($video_url);
        echo '</div>';
    }
}
add_action('woocommerce_product_thumbnails', 'custom_display_video_in_gallery', 20);

// Функция для получения правильного Rutube embed URL
function get_rutube_embed_url($url) {
    if (preg_match('/rutube\.ru\/video\/([a-zA-Z0-9]+)/', $url, $matches)) {
        return 'https://rutube.ru/play/embed/' . $matches[1];
    }
    return $url;
}
function custom_enqueue_scripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('jquery');
}
add_filter('gettext', 'translate_woocommerce_text', 20, 3);
function translate_woocommerce_text($translated_text, $text, $domain) {
    if ($domain === 'woocommerce' || $domain === 'default') {
        switch ($text) {
            case 'Description':
                $translated_text = 'Описание';
                break;
            case 'Additional information':
                $translated_text = 'Дополнительная информация';
                break;
            case 'Reviews (%d)':
            case 'Reviews (%s)':
            case 'Reviews':
                $translated_text = 'Отзывы';
                break;
            case 'Related products':
                $translated_text = 'Похожие товары';
                break;
            case 'You may also like…':
                $translated_text = 'С этим покупают';
                break;
            case 'No products in the cart.':
            case 'There are no products in the cart.':
                $translated_text = 'В корзине нет товаров.';
                break;
            case 'Your cart is currently empty.':
            case 'Your cart is empty.':
                $translated_text = 'Ваша корзина пуста.';
                break;
        }
    }
    return $translated_text;
}
function custom_translate_woocommerce_texts( $translated_text, $text, $domain ) {
    // Переводы
    switch ( $text ) {
        case 'Default sorting':
            $translated_text = 'По умолчанию';
            break;

        case 'Sort by popularity':
            $translated_text = 'По популярности';
            break;

        case 'Sort by average rating':
            $translated_text = 'По среднему рейтингу';
            break;

        case 'Sort by latest':
            $translated_text = 'По новизне';
            break;

        case 'Sort by price: low to high':
            $translated_text = 'По цене: от низкой к высокой';
            break;

        case 'Sort by price: high to low':
            $translated_text = 'По цене: от высокой к низкой';
            break;

        case 'Relevance':
            $translated_text = 'Сортировать';
            break;
			
        case 'This product is currently out of stock and unavailable.':
            $translated_text = 'В настоящее время этого товара нет в наличии, и он недоступен.';
            break;

        case 'There are no reviews yet.':
            $translated_text = 'Отзывов пока нет.';
            break;

        case 'Edit product':
            $translated_text = 'Редактировать товар';
            break;

        case 'Product description':
            $translated_text = 'Описание товара';
            break;

        case 'Catalog visibility:':
            $translated_text = 'Видимость каталога:';
            break;

        case 'Shop and search results':
            $translated_text = 'Магазин и результаты поиска';
            break;

        case 'Edit':
            $translated_text = 'Редактировать';
            break;

        case 'Copy to a new draft':
            $translated_text = 'Скопировать в новый черновик';
            break;

        case 'Product image':
            $translated_text = 'Изображение товара';
            break;

        case 'Remove product image':
            $translated_text = 'Удалить изображение товара';
            break;

        case 'Product gallery':
            $translated_text = 'Галерея товаров';
            break;

        case 'Add product gallery images':
            $translated_text = 'Добавление изображений из галереи товаров';
            break;

        case 'Add Image':
            $translated_text = 'Загрузить изображение';
            break;


        case 'Product categories':
            $translated_text = 'Категории товаров';
            break;

        case 'All categories':
            $translated_text = 'Все категории';
            break;

        case 'Product tags':
            $translated_text = 'Теги товара';
            break;

        case 'Choose from the most used tags':
            $translated_text = 'Выберите один из наиболее часто используемых тегов';
            break;

        case 'Product data':
            $translated_text = 'Данные о товаре';
            break;

        case 'Add new product':
            $translated_text = 'Добавить новый товар';
            break;

        case 'Product short description':
            $translated_text = 'Краткое описание товара';
            break;

        case 'Product short description':
            $translated_text = 'Краткое описание товара';
            break;

        case 'Simple product':
            $translated_text = 'Простой товар';
            break;

        case 'Variable product':
            $translated_text = 'Вариативный товар';
            break;

        case 'External/Affiliate product':
            $translated_text = 'Внешний/Партнерский товар';
            break;

        case 'Grouped product':
            $translated_text = 'Сгруппированный товар';
            break;

        case 'Virtual':
            $translated_text = 'Виртуальный';
            break;

        case 'Downloadable':
            $translated_text = 'Загружаемый';
            break;

        case 'Separate tags with commas':
            $translated_text = 'Разделяйте теги запятыми';
            break;

        case 'All Products':
            $translated_text = 'Все товары';
            break;

        case 'Leave a Comment':
            $translated_text = 'Оставить комментарий';
            break;


		case 'by:':
            $translated_text = 'От:';
            break;

		case 'Post on:':
            $translated_text = 'Пост опубликован:';
            break;

		case 'Comments:':
            $translated_text = 'Комментарии:';
            break;

		case 'Categories:':
            $translated_text = 'Категории:';
            break;

		case 'ADD TO CART':
            $translated_text = 'В корзину';
            break;

		case 'has been added to your cart.':
            $translated_text = 'был добавлен в вашу корзину.';
            break;

    }

    return $translated_text;
}
add_filter( 'gettext', 'custom_translate_woocommerce_texts', 20, 3 );
function add_gips_calculator_to_product_page() {
    if (has_term(array('gipsokarton', 'pazogrebnevye-plity'), 'product_cat')) { // Проверяем, относится ли товар к одной из категорий
        echo '<div id="gips-calculator"></div>';
    }
}
add_action('woocommerce_single_product_summary', 'add_gips_calculator_to_product_page', 25);

add_action('wp_head', function() {
    if (is_product()) {
        global $post;
        $terms = get_the_terms($post->ID, 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            $product_category = $terms[0]->slug; // Берем первую категорию
            echo "<script>window.productCategory = '" . esc_js($product_category) . "';</script>";
        }
    }
});
add_filter( 'gettext', 'custom_translate_woocommerce_phrases', 999, 3 );
function custom_translate_woocommerce_phrases( $translated_text, $text, $domain ) {
    if ( $text === 'Update cart' ) {
        return 'Обновить корзину';
    }
    if ( $text === 'Cart totals' ) {
        return 'Итого по корзине';
    }
    if ( $text === 'Subtotal' ) {
        return 'Промежуточный итог';
    }
    if ( $text === 'Total' ) {
        return 'Итого';
    }
    if ( $text === 'Proceed to checkout' ) {
        return 'Перейти к оформлению';
    }
    if ( $text === 'Coupon code' ) {
        return 'Промокод';
    }
    if ( $text === 'View cart' ) {
        return 'Посмотреть корзину';
    }
    if ( $text === 'Checkout' ) {
        return 'Оформление заказа';
    }
    return $translated_text;
}
/**
 * Регистрируем дополнительные метабоксы и сохраняем их значения
 * для постов типа product (WooCommerce). 
 * В итоге: картинки, колонки, "больше товаров", заголовки вкладок, SEO-блок.
 */


/* -----------------------------------------------------
   1) Метабоксы: desc_image, related_cat_slug, desc_bottom_block
----------------------------------------------------- */
add_action( 'add_meta_boxes', 'rst_add_my_custom_meta_boxes' );
function rst_add_my_custom_meta_boxes() {

    // "desc_image" (URL картинки в описании)
    add_meta_box(
        'rst_desc_image_box',
        'Описание: Картинка (desc_image)',
        'rst_desc_image_box_cb',
        'product',
        'normal',
        'default'
    );

    // "related_cat_slug" (слаг категории «Больше товаров»)
    add_meta_box(
        'rst_related_cat_box',
        'Слаг категории для блока "Больше товаров..."',
        'rst_related_cat_box_cb',
        'product',
        'normal',
        'default'
    );

    // "desc_bottom_block" (HTML для большого блока)
    add_meta_box(
        'rst_desc_bottom_box',
        'Нижний блок в описании (Html)',
        'rst_desc_bottom_box_cb',
        'product',
        'normal',
        'default'
    );
}

// Коллбэк "desc_image"
function rst_desc_image_box_cb( $post ) {
    $value = get_post_meta( $post->ID, 'desc_image', true );
    echo '<p>Загрузите или введите URL картинки, которая будет выводиться справа в описании.</p>';
    echo '<label for="rst_desc_image">URL картинки:</label><br/>';
    echo '<input type="text" id="rst_desc_image" name="rst_desc_image" value="' . esc_attr($value) . '" style="width:90%;max-width:600px;" />';
}

// Коллбэк "related_cat_slug"
function rst_related_cat_box_cb( $post ) {
    $value = get_post_meta( $post->ID, 'related_cat_slug', true );
    echo '<p>Укажите слаг категории (например: "gipsokarton"). Если пусто, берётся первая категория товара.</p>';
    echo '<input type="text" name="rst_related_cat_slug" value="' . esc_attr($value) . '" style="width:40%;"/>';
}

// Коллбэк "desc_bottom_block"
function rst_desc_bottom_box_cb( $post ) {
    $value = get_post_meta( $post->ID, 'desc_bottom_block', true );
    echo '<p>Здесь можно ввести HTML для большого блока в описании (если нужно).</p>';
    echo '<textarea name="rst_desc_bottom_block" style="width:100%;height:200px;">' . esc_textarea($value) . '</textarea>';
}

// Сохран полей при сохранении товара
add_action( 'save_post_product', 'rst_save_my_product_meta' );
function rst_save_my_product_meta( $post_id ) {

    // "desc_image"
    if ( isset($_POST['rst_desc_image']) ) {
        update_post_meta( $post_id, 'desc_image', sanitize_text_field($_POST['rst_desc_image']) );
    }

    // "related_cat_slug"
    if ( isset($_POST['rst_related_cat_slug']) ) {
        update_post_meta( $post_id, 'related_cat_slug', sanitize_text_field($_POST['rst_related_cat_slug']) );
    }

    // "desc_bottom_block" (html)
    if ( isset($_POST['rst_desc_bottom_block']) ) {
        // Разрешаем часть HTML (или всё через wp_kses_post())
        $allowed_html = array(
          'strong' => array(),
          'p' => array(),
          'br' => array(),
          'ul' => array(),
          'ol' => array(),
          'li' => array(),
          'em' => array(),
          'b' => array(),
        );
        $clean = wp_kses( $_POST['rst_desc_bottom_block'], $allowed_html );
        update_post_meta( $post_id, 'desc_bottom_block', $clean );
    }
}


/* -----------------------------------------------------
   2) Три колонки: desc_col1, desc_col2, desc_col3
----------------------------------------------------- */
add_action( 'add_meta_boxes', 'rst_add_columns_metaboxes' );
function rst_add_columns_metaboxes() {
    add_meta_box(
        'rst_desc_bottom_3cols',
        'Нижний блок (3 колонки)',
        'rst_desc_bottom_3cols_cb',
        'product',
        'normal',
        'default'
    );
}

function rst_desc_bottom_3cols_cb( $post ) {
    $col1 = get_post_meta($post->ID, 'desc_col1', true);
    $col2 = get_post_meta($post->ID, 'desc_col2', true);
    $col3 = get_post_meta($post->ID, 'desc_col3', true);

    echo '<p>Введите HTML или обычный текст для каждой из 3 колонок:</p>';

    // Поле 1
    echo '<h4>Колонка #1</h4>';
    echo '<textarea name="rst_desc_col1" style="width:100%;height:100px;">'
         . esc_textarea($col1) . '</textarea>';

    // Поле 2
    echo '<h4>Колонка #2</h4>';
    echo '<textarea name="rst_desc_col2" style="width:100%;height:100px;">'
         . esc_textarea($col2) . '</textarea>';

    // Поле 3
    echo '<h4>Колонка #3</h4>';
    echo '<textarea name="rst_desc_col3" style="width:100%;height:100px;">'
         . esc_textarea($col3) . '</textarea>';
}

// Сохран трёх колонок
add_action( 'save_post_product', 'rst_save_columns_metaboxes' );
function rst_save_columns_metaboxes( $post_id ) {
    if ( isset($_POST['rst_desc_col1']) ) {
        $val = wp_kses_post( $_POST['rst_desc_col1'] );
        update_post_meta( $post_id, 'desc_col1', $val );
    }
    if ( isset($_POST['rst_desc_col2']) ) {
        $val = wp_kses_post( $_POST['rst_desc_col2'] );
        update_post_meta( $post_id, 'desc_col2', $val );
    }
    if ( isset($_POST['rst_desc_col3']) ) {
        $val = wp_kses_post( $_POST['rst_desc_col3'] );
        update_post_meta( $post_id, 'desc_col3', $val );
    }
}


/* -----------------------------------------------------
   3) Vendor Info (SEO-блок): vendor_hero_image + vendor_text
----------------------------------------------------- */
add_action( 'add_meta_boxes', 'my_add_vendorinfo_metabox' );
function my_add_vendorinfo_metabox() {
  add_meta_box(
    'my_vendor_info',
    'Vendor Info (SEO-блок)',
    'my_vendor_info_cb',
    'product',
    'normal',
    'default'
  );
}

function my_vendor_info_cb( $post ) {
  $image = get_post_meta( $post->ID, 'vendor_hero_image', true );
  $text  = get_post_meta( $post->ID, 'vendor_text', true );

  echo '<p>URL картинки (Wide Image):</p>';
  echo '<input type="text" style="width:100%;" name="vendor_hero_image" value="'.esc_attr($image).'">';

  echo '<p>SEO-текст для вкладки «Подробно о товаре»:</p>';
  echo '<textarea name="vendor_text" style="width:100%; height:150px;">'
       . esc_textarea($text) . '</textarea>';
}

add_action( 'save_post_product', 'my_save_vendorinfo_meta' );
function my_save_vendorinfo_meta( $post_id ) {
  // Картинка
  if ( isset($_POST['vendor_hero_image']) ) {
    update_post_meta($post_id, 'vendor_hero_image', sanitize_text_field($_POST['vendor_hero_image']));
  }
  // SEO-текст
  if ( isset($_POST['vendor_text']) ) {
    update_post_meta($post_id, 'vendor_text', wp_kses_post($_POST['vendor_text']));
  }
}


/* -----------------------------------------------------
   4) Заголовки вкладок:
   - desc_tab_title    (Описание)
   - spec_tab_title    (Характеристики)
   - reviews_tab_title (Отзывы)
   - vendor_tab_title  (Подробно о товаре)
----------------------------------------------------- */

/** (A) desc_tab_title - «Описание» */
add_action( 'add_meta_boxes', 'my_add_desc_tab_title_metabox' );
function my_add_desc_tab_title_metabox() {
  add_meta_box(
    'my_desc_tab_title',
    'Заголовок вкладки «Описание»',
    'my_desc_tab_title_cb',
    'product',
    'normal',
    'default'
  );
}
function my_desc_tab_title_cb( $post ) {
  $val = get_post_meta( $post->ID, 'desc_tab_title', true );
  echo '<p>Укажите заголовок для вкладки «Описание»:</p>';
  echo '<input type="text" style="width:100%" name="desc_tab_title" value="' . esc_attr($val) . '">';
}
add_action( 'save_post_product', 'my_save_desc_tab_title_meta' );
function my_save_desc_tab_title_meta( $post_id ) {
  if ( isset($_POST['desc_tab_title']) ) {
    update_post_meta($post_id, 'desc_tab_title', sanitize_text_field($_POST['desc_tab_title']));
  }
}

/** (B) spec_tab_title - «Характеристики» */
add_action( 'add_meta_boxes', 'my_add_spec_tab_title_metaboxes' );
function my_add_spec_tab_title_metaboxes() {
  add_meta_box(
    'my_spec_tab_title',
    'Заголовок вкладки «Характеристики»',
    'my_spec_tab_title_cb',
    'product',
    'normal',
    'default'
  );
}
function my_spec_tab_title_cb( $post ) {
  $val = get_post_meta( $post->ID, 'spec_tab_title', true );
  echo '<p>Заголовок для вкладки «Характеристики»:</p>';
  echo '<input type="text" style="width:100%" name="spec_tab_title" value="' . esc_attr($val) . '">';
}
add_action( 'save_post_product', 'my_save_spec_tab_title_meta' );
function my_save_spec_tab_title_meta( $post_id ) {
  if ( isset($_POST['spec_tab_title']) ) {
    update_post_meta($post_id, 'spec_tab_title', sanitize_text_field($_POST['spec_tab_title']));
  }
}

/** (C) reviews_tab_title - «Отзывы» */
add_action( 'add_meta_boxes', 'my_add_reviews_tab_title_metabox' );
function my_add_reviews_tab_title_metabox() {
  add_meta_box(
    'my_reviews_tab_title',
    'Заголовок вкладки «Отзывы»',
    'my_reviews_tab_title_cb',
    'product',
    'normal',
    'default'
  );
}
function my_reviews_tab_title_cb( $post ) {
  $val = get_post_meta( $post->ID, 'reviews_tab_title', true );
  echo '<p>Заголовок для вкладки «Отзывы»:</p>';
  echo '<input type="text" style="width:100%" name="reviews_tab_title" value="' . esc_attr($val) . '">';
}
add_action( 'save_post_product', 'my_save_reviews_tab_title_meta' );
function my_save_reviews_tab_title_meta( $post_id ) {
  if ( isset($_POST['reviews_tab_title']) ) {
    update_post_meta($post_id, 'reviews_tab_title', sanitize_text_field($_POST['reviews_tab_title']));
  }
}

/** (D) vendor_tab_title - «Подробно о товаре» */
add_action( 'add_meta_boxes', 'my_add_vendor_tab_title_metabox' );
function my_add_vendor_tab_title_metabox() {
  add_meta_box(
    'my_vendor_tab_title',
    'Заголовок вкладки «Подробно о товаре»',
    'my_vendor_tab_title_cb',
    'product',
    'normal',
    'default'
  );
}
function my_vendor_tab_title_cb( $post ) {
  $val = get_post_meta( $post->ID, 'vendor_tab_title', true );
  echo '<p>Заголовок для вкладки «Подробно о товаре»:</p>';
  echo '<input type="text" style="width:100%" name="vendor_tab_title" value="' . esc_attr($val) . '">';
}
add_action( 'save_post_product', 'my_save_vendor_tab_title_meta' );
function my_save_vendor_tab_title_meta( $post_id ) {
  if ( isset($_POST['vendor_tab_title']) ) {
    update_post_meta($post_id, 'vendor_tab_title', sanitize_text_field($_POST['vendor_tab_title']));
  }
}
wp_enqueue_script(
    'rst-thumb-switch',
    get_stylesheet_directory_uri() . '/assets/js/thumb-switch.js',
    array('jquery'),
    '1.0',
    true
);
add_action( 'wp_enqueue_scripts', function () {

   // пример: грузим ‘scroll‑gallery.js’ только на главной
   if ( is_front_page() ) {
       wp_enqueue_script( 'scroll-gallery',
           get_stylesheet_directory_uri() . '/assets/js/scroll-gallery.js',
           array('jquery'), '1.0', true );
   }
});
add_action( 'wp_enqueue_scripts', function () {

    // грузим фильтр‑сертификатов только на нужной странице (например, /certificates/)
    if ( is_page( 'certificates' ) ) {
        wp_enqueue_script(
            'cert-filter',
            get_stylesheet_directory_uri() . '/assets/js/cert-filter.js',
            array(), '1.0', true
        );
    }
});
/* ───────────────────────────────────────────────
   1.  МЕТА‑бокс «Сайдбар товара»
   ─────────────────────────────────────────────── */
add_action( 'add_meta_boxes', 'rin_add_sidebar_metabox' );
function rin_add_sidebar_metabox() {
	add_meta_box(
		'rin_sidebar_box',
		'Сайдбар товара: преимущества и баннер',
		'rin_sidebar_box_cb',
		'product',
		'normal',        // вкладка «Основное»
		'default'
	);
}

/* форма в админке */
function rin_sidebar_box_cb( $post ) {

	/* значения, если уже сохранены */
	$data = [
		'adv1_title'   => get_post_meta( $post->ID, 'adv1_title',   true ),
		'adv1_text'    => get_post_meta( $post->ID, 'adv1_text',    true ),
		'adv2_title'   => get_post_meta( $post->ID, 'adv2_title',   true ),
		'adv2_text'    => get_post_meta( $post->ID, 'adv2_text',    true ),
		'adv3_title'   => get_post_meta( $post->ID, 'adv3_title',   true ),
		'adv3_text'    => get_post_meta( $post->ID, 'adv3_text',    true ),
		'banner_url'   => get_post_meta( $post->ID, 'sidebar_banner_url', true ),
	];

	/* простая HTML‑форма */
	?>
	<style>.rin-sidebar-field{width:100%}</style>

	<h4>Три карточки‑преимущества</h4>
	<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
		<p><strong>Карточка <?php echo $i; ?></strong></p>
		<input  class="rin-sidebar-field" type="text"
				name="adv<?php echo $i; ?>_title"
				placeholder="Заголовок"
				value="<?php echo esc_attr( $data["adv{$i}_title"] ); ?>">

		<textarea class="rin-sidebar-field" rows="2"
				name="adv<?php echo $i; ?>_text"
				placeholder="Описание"><?php
					echo esc_textarea( $data["adv{$i}_text"] );
				?></textarea>
	<?php endfor; ?>

	<hr>

	<h4>Баннер (URL картинки)</h4>
	<input  class="rin-sidebar-field" type="text"
			name="sidebar_banner_url"
			placeholder="https://example.com/banner.jpg"
			value="<?php echo esc_attr( $data['banner_url'] ); ?>">
	<?php
}

/* сохраняем */
add_action( 'save_post_product', 'rin_save_sidebar_meta' );
function rin_save_sidebar_meta( $post_id ) {

	$fields = [
		'adv1_title','adv1_text',
		'adv2_title','adv2_text',
		'adv3_title','adv3_text',
		'sidebar_banner_url'
	];

	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta(
				$post_id,
				$field,
				wp_kses_post( $_POST[ $field ] )
			);
		}
	}
}

/**
 * 1. Регистрируем метабокс "Видео (кастомное превью)" с двумя полями:
 *    - my_video_link (URL ссылки на видео)
 *    - my_video_image_id (ID картинки из медиабиблиотеки, которая будет миниатюрой)
 */
function my_add_single_video_metabox() {
    add_meta_box(
        'my_single_video_box',
        'Видео (кастомное превью)',
        'my_render_single_video_metabox',
        'product', // CPT "product" (WooCommerce)
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'my_add_single_video_metabox');

/**
 * 2. Вывод HTML внутри метабокса (админка).
 */
function my_render_single_video_metabox($post) {
    // Получаем значения, если были сохранены
    $video_link = get_post_meta($post->ID, 'my_video_link', true);
    $image_id   = get_post_meta($post->ID, 'my_video_image_id', true);

    // Для превью берем URL миниатюры, если прикреплена
    $thumb_url = '';
    if ($image_id) {
        $thumb_url = wp_get_attachment_image_url($image_id, 'thumbnail');
    }
    ?>
    <p><strong>Ссылка на видео (YouTube, RuTube, MP4...):</strong></p>
    <input type="text"
           name="my_video_link"
           value="<?php echo esc_attr($video_link); ?>"
           style="width: 100%; max-width:600px;" />

    <hr>

    <p><strong>Миниатюра (картинка для превью):</strong></p>
    <div style="display:flex; align-items:center; gap:20px;">
        <!-- Блок превью -->
        <div class="my-video-preview-wrap" style="width:100px; height:auto;">
            <?php if ($thumb_url): ?>
                <img src="<?php echo esc_url($thumb_url); ?>" 
                     alt="Превью" 
                     style="max-width:100%; height:auto;">
            <?php else: ?>
                <img src="https://via.placeholder.com/100x80?text=No+Preview"
                     alt="Превью" 
                     style="opacity:0.3; max-width:100%; height:auto;">
            <?php endif; ?>
        </div>

        <!-- Поле для хранения ID медиавложения -->
        <input type="hidden" name="my_video_image_id"
               value="<?php echo esc_attr($image_id); ?>">

        <!-- Кнопки -->
        <input type="button"
               class="button my-video-upload-btn"
               value="Загрузить / Выбрать">
        <input type="button"
               class="button my-video-remove-btn"
               value="Убрать превью"
               style="color:red;">
    </div>

    <script>
    (function($){
      $(document).ready(function(){

        // Клик "Загрузить / Выбрать"
        $('.my-video-upload-btn').on('click', function(e){
          e.preventDefault();
          let frame = wp.media({
            title: 'Выберите/загрузите картинку для превью',
            button: { text: 'Использовать эту картинку' },
            multiple: false
          });

          frame.on('select', function(){
            let attachment = frame.state().get('selection').first().toJSON();
            // Сохраняем ID
            $('input[name="my_video_image_id"]').val(attachment.id);
            // Обновляем превью
            $('.my-video-preview-wrap img')
              .attr('src', attachment.url)
              .css('opacity','1');
          });

          frame.open();
        });

        // Клик "Убрать превью"
        $('.my-video-remove-btn').on('click', function(e){
          e.preventDefault();
          $('input[name="my_video_image_id"]').val('');
          $('.my-video-preview-wrap img')
            .attr('src', 'https://via.placeholder.com/100x80?text=No+Preview')
            .css('opacity','0.3');
        });

      });
    })(jQuery);
    </script>

    <?php
}

/**
 * 3. Сохраняем данные метаполя
 */
function my_save_single_video_metabox($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['my_video_link'])) {
        update_post_meta($post_id, 'my_video_link', sanitize_text_field($_POST['my_video_link']));
    }
    if (isset($_POST['my_video_image_id'])) {
        update_post_meta($post_id, 'my_video_image_id', absint($_POST['my_video_image_id']));
    }
}
add_action('save_post', 'my_save_single_video_metabox');

/**
 * 4. Подключаем скрипты wp.media (чтобы работал медиазагрузчик)
 */
function my_video_admin_scripts($hook) {
    // Подключаем только на страницах редактирования (product)
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'my_video_admin_scripts');
/**
 * Подключаем скрипт калькулятора (только на странице товара)
 */
function mytheme_enqueue_calc_script() {
  if ( is_product() ) {
    wp_enqueue_script(
      'gips-calc',
      get_stylesheet_directory_uri() . '/js/gips-calc.js',
      array(), // зависимости, если нужны (например, ['jquery'])
      '1.0',
      true      // грузить в футере
    );
  }
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_calc_script');

/**
 * Передаём JS-переменную window.productCategory в <head>
 * (чтобы скрипт знал, с какой категорией мы работаем).
 */
add_action('wp_head', function() {
  if ( is_product() ) {
    global $post;
    $terms = get_the_terms($post->ID, 'product_cat');
    if ( $terms && ! is_wp_error($terms) ) {
      $product_category = $terms[0]->slug; // Берём первую категорию
      echo "<script>window.productCategory = '" . esc_js($product_category) . "';</script>";
    }
  }
});
/**
 * Регистрируем свой метабокс для продуктов
 */
function my_calc_tab_metabox_init() {
    add_meta_box(
        'calc_tab_metabox',
        'Вкладка «Калькулятор»',
        'my_calc_tab_metabox_callback',
        'product',            // тип поста: product
        'normal', 
        'default'
    );
}
add_action('add_meta_boxes', 'my_calc_tab_metabox_init');

function my_calc_tab_metabox_callback($post) {
    // Достаём текущее значение (если уже сохранено)
    $value = get_post_meta($post->ID, 'calc_tab_html', true);
    ?>
    <label for="calc_tab_html">HTML для вкладки «Калькулятор»:</label>
    <textarea id="calc_tab_html" name="calc_tab_html" rows="5" style="width:100%;">
        <?php echo esc_textarea($value); ?>
    </textarea>
    <p class="description">
      Оставьте поле пустым, если вкладка «Калькулятор» не нужна.<br>
      Для вывода калькулятора можно написать <code>&lt;div id="gips-calculator"&gt;&lt;/div&gt;</code>.
    </p>
    <?php
}

/**
 * Сохраняем значение поля
 */
function my_calc_tab_metabox_save($post_id) {
    // Если это автосохранение или у пользователя нет прав — выходим
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( !current_user_can('edit_post', $post_id) ) return;
    
    // Сохраняем
    if ( isset($_POST['calc_tab_html']) ) {
        update_post_meta($post_id, 'calc_tab_html', wp_kses_post($_POST['calc_tab_html']));
    }
}
add_action('save_post', 'my_calc_tab_metabox_save');
