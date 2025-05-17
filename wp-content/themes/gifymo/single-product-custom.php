<?php
/**
 * Template Name: Магазин (Кастомный) – Сетка 3 колонки + Вкладки
 * Template Post Type: product
 */
get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
    $product = wc_get_product( get_the_ID() );

    // Внутренние заголовки вкладок
    $desc_tab_title    = get_post_meta( get_the_ID(), 'desc_tab_title', true );
    $spec_tab_title    = get_post_meta( get_the_ID(), 'spec_tab_title', true );
    $reviews_tab_title = get_post_meta( get_the_ID(), 'reviews_tab_title', true );
    $vendor_tab_title  = get_post_meta( get_the_ID(), 'vendor_tab_title', true );

    if ( empty($desc_tab_title) )    { $desc_tab_title    = 'Описание'; }
    if ( empty($spec_tab_title) )    { $spec_tab_title    = 'Характеристики'; }
    if ( empty($reviews_tab_title) ) { $reviews_tab_title = 'Отзывы'; }
    if ( empty($vendor_tab_title) )  { $vendor_tab_title  = 'Подробно'; }

    // Картинка во вкладке «Описание»
    $desc_image_url = get_post_meta( get_the_ID(), 'desc_image', true );

    // «Больше товаров» (related_cat_slug)
    $related_cat_slug = get_post_meta( get_the_ID(), 'related_cat_slug', true );
    if ( empty($related_cat_slug) ) {
      $terms = wp_get_post_terms( get_the_ID(), 'product_cat' );
      if ( ! is_wp_error($terms) && !empty($terms) ) {
        $related_cat_slug = $terms[0]->slug;
      }
    }

    // Три колонки на плашках:
    $desc_col1 = get_post_meta( get_the_ID(), 'desc_col1', true );
    $desc_col2 = get_post_meta( get_the_ID(), 'desc_col2', true );
    $desc_col3 = get_post_meta( get_the_ID(), 'desc_col3', true );

    // SEO-блок (вкладка «Подробно»):
    $vendor_hero_image = get_post_meta( get_the_ID(), 'vendor_hero_image', true );
    $vendor_text       = get_post_meta( get_the_ID(), 'vendor_text', true );
?>
<!-- Подключаем Font Awesome и ваш CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="/wp-content/themes/gifymo/assets/css/shop-custom.css">

<main class="shop-page single-product-page with-sticky-sidebar">
  <div class="grid-layout">
    
    <!-- (1) Галерея, Колонка 1 -->
    <section class="product-gallery boxA">
      <?php if ( $product->is_on_sale() ): ?>
        <div class="badge-offer">Sale!</div>
      <?php endif; ?>

      <!-- [изменено для видео]: вместо <img> — контейнер, куда мы динамически вставляем контент -->
      <div class="main-image">
        <div class="media-container">
          <?php
          // Изначально выводим "главную картинку" (thumb), если есть
          if ( has_post_thumbnail() ) {
            the_post_thumbnail('large', ['alt' => get_the_title()]);
          } else {
            echo '<img src="https://rin-stroy.ru/wp-content/uploads/2025/03/no-thumb.png" alt="No image">';
          }
          ?>
        </div>
      </div>
      <!-- /main-image -->

      <!-- Блок миниатюр (thumbnail-gallery) -->
      <div class="thumbnail-gallery">
      <?php
        // 1. Идшники картинок (WooCommerce gallery)
        $gallery_ids = $product->get_gallery_image_ids();

// 1) Получаем наши сохранённые поля
$video_link = get_post_meta( get_the_ID(), 'my_video_link', true );
$image_id   = get_post_meta( get_the_ID(), 'my_video_image_id', true );

// 2) Если оба заполнены, выводим миниатюру
if ( $video_link && $image_id ) {
    // Получаем URL той картинки, которую выбрал админ
    $preview_url = wp_get_attachment_image_url( $image_id, 'medium' );
    if ( !$preview_url ) {
        // fallback
        $preview_url = 'https://via.placeholder.com/150x100';
    }

    // Выводим
    printf(
        '<img class="video-thumb" src="%s" alt="Видео превью" data-video="%s">',
        esc_url($preview_url),
        esc_url($video_link)
    );
}
        // 2. Наши ссылки на видео (метаполе video_urls)
        $video_urls_raw = get_post_meta( get_the_ID(), 'video_urls', true );
        // превратим это в массив, уберём пустые строки
        $video_urls = array_filter( array_map( 'trim', explode("\n", $video_urls_raw ) ) );

        // Сначала выводим миниатюры картинок
        if ( $gallery_ids ) {
          foreach ( $gallery_ids as $img_id ) {
              $thumb_url = wp_get_attachment_image_url( $img_id, 'medium' );
              $full_url  = wp_get_attachment_image_url( $img_id, 'large' );
              $alt       = get_post_meta( $img_id, '_wp_attachment_image_alt', true );

              printf(
                  '<img src="%s" data-full="%s" alt="%s">',
                  esc_url($thumb_url),
                  esc_url($full_url),
                  esc_attr($alt)
              );
          }
        } else {
          // fallback
          $placeholder = esc_url( get_theme_file_uri('assets/img/no-thumb.png') );
          echo '<img src="'.$placeholder.'" data-full="'.$placeholder.'" alt="No image">';
        }

        // Теперь добавляем миниатюры видео
        if ( ! empty($video_urls) ) {
          // можно использовать свою иконку для "Видео", напр. video-icon.png
          $video_icon_url = 'https://rin-stroy.ru/wp-content/uploads/2025/03/video-icon.png';

          foreach ( $video_urls as $video_url ) {
            printf(
              '<img class="video-thumb" src="%1$s" data-video="%2$s" alt="video">',
              esc_url($video_icon_url),
              esc_url($video_url)
            );
          }
        }
      ?>
      </div>
      <!-- /thumbnail-gallery -->
    </section>
    
    <!-- (2) Детали товара, Колонка 2 -->
    <section class="product-details boxB">
      <h1 class="product-title"><?php the_title(); ?></h1>

      <div class="product-meta">
        <div class="product-categories">
          <?php 
            echo 'Категории: ';
            echo wc_get_product_category_list( get_the_ID(), ', ' );
          ?>
        </div>
        <div class="product-sku">
          <?php
            if ( $product->get_sku() ) {
              echo 'Артикул: ' . esc_html($product->get_sku());
            }
          ?>
        </div>
      </div>

      <div class="product-separator"></div>

      <div class="product-price">
        <?php echo $product->get_price_html(); ?>
      </div>
      <div class="product-rating">
        <span class="stars">
          <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
        </span>
        <span class="reviews">
          <?php
            printf(
              _n('%s Отзыв','%s Отзывов',$product->get_review_count(),'woocommerce'),
              $product->get_review_count()
            );
          ?>
        </span>
      </div>

      <!-- Короткое описание (преимущества) -->
      <ul class="product-features">
        <?php
        $short_desc = apply_filters('woocommerce_short_description', $post->post_excerpt);
        if ( $short_desc ) {
          echo wp_kses_post($short_desc);
        } else {
          // fallback
          echo '<li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                <li>Aliquam id diam, ultrices, mi, eget, mauris.</li>
                <li>Ultrices eros in cursus turpis massa tincidunt ante.</li>';
        }
        ?>
      </ul>

      <div class="product-separator"></div>

      <!-- ▬▬ Блок покупки – с формой Woo ▬▬ -->
      <form class="cart product-purchase rin-cart-row"
            action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
            method="post" enctype="multipart/form-data">

        <div class="quantity">
          <button type="button" class="qty-minus">−</button>
          <input  type="number" name="quantity" value="1" min="1" />
          <button type="button" class="qty-plus">+</button>
        </div>

        <!-- кнопка-триггер -->
        <button type="submit"
                name="add-to-cart"
                value="<?php echo esc_attr( $product->get_id() ); ?>"
                class="add-to-cart single_add_to_cart_button button alt ajax_add_to_cart">
          <i class="fa-solid fa-cart-shopping"></i>
          <span>Добавить в корзину</span>
        </button>

      </form>
      <!-- /Блок покупки -->
    </section>

    <!-- (3) Блок "Больше товаров" -->
    <section class="more-items boxD">
      <h2>Больше товаров из категории</h2>
      <?php
      if ( !empty($related_cat_slug) ) {
        $args = [
          'post_type'      => 'product',
          'posts_per_page' => 4,
          'orderby'        => 'date',
          'order'          => 'DESC',
          'tax_query'      => [[
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $related_cat_slug,
          ]],
        ];
        $query = new WP_Query($args);
        if ( $query->have_posts() ) {
          echo '<div class="items-row">';
          while ( $query->have_posts() ) {
            $query->the_post(); ?>
            <div class="item">
              <a href="<?php the_permalink(); ?>">
                <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail('thumbnail');
                } else {
                  echo '<img src="https://rin-stroy.ru/wp-content/uploads/2025/03/no-thumb.png" alt="No image">';
                }
                ?>
              </a>
            </div>
          <?php }
          echo '</div>';
          wp_reset_postdata();
        } else {
          echo '<p>Нет товаров в этой категории.</p>';
        }
      } else {
        echo '<p>Категория не задана.</p>';
      }
      ?>
      <?php if ( !empty($related_cat_slug) ): ?>
        <a href="<?php echo esc_url(get_term_link($related_cat_slug, 'product_cat')); ?>" class="view-all-link">
          Смотреть все
        </a>
      <?php endif; ?>
    </section>

    <!-- ▬▬▬▬▬▬▬▬▬  (4) Сайдбар  ▬▬▬▬▬▬▬▬▬ -->
    <aside class="right-column boxC">
      <div class="sticky-sidebar">
        <?php
        /* читаем метаполя, которые вы добавили функцией rin_add_sidebar_metabox() */
        $cards = [];
        for ( $i = 1; $i <= 3; $i++ ) {
          $cards[] = [
            'title' => get_post_meta( get_the_ID(), "adv{$i}_title", true ),
            'text'  => get_post_meta( get_the_ID(), "adv{$i}_text",  true ),
          ];
        }
        $banner_url = get_post_meta( get_the_ID(), 'sidebar_banner_url', true );
        ?>

        <?php /* карточки‑преимущества (выводим, только если есть заголовок) */ ?>
        <?php if ( array_filter( array_column( $cards, 'title' ) ) ) : ?>
          <section class="advantages-card">
            <?php foreach ( $cards as $idx => $card ) :
              if ( empty( $card['title'] ) ) continue; ?>
              <div class="advantage-item">
                <i class="fa-solid <?php
                  echo [ 'fa-truck', 'fa-credit-card', 'fa-handshake' ][$idx] ?? 'fa-circle-check';
                ?>"></i>
                <div>
                  <h4><?php echo esc_html( $card['title'] ); ?></h4>
                  <p><?php echo esc_html( $card['text']  ); ?></p>
                </div>
              </div>
              <?php if ( $idx < 2 ) echo '<div class="advantage-separator"></div>'; ?>
            <?php endforeach; ?>
          </section>
        <?php endif; ?>

        <?php /* баннер */ ?>
        <?php if ( $banner_url ) : ?>
          <section class="sidebar-block" style="margin-top:20px;">
            <img src="<?php echo esc_url( $banner_url ); ?>" alt="">
          </section>
        <?php endif; ?>

        <!-- ▬▬▬ мини‑каталог на 3 случайных товара ▬▬▬ -->
        <section class="sidebar-block more-products" style="margin-top:20px;">
          <h3>
            <a href="https://rin-stroy.ru/katalog-kategorii/"
               style="text-decoration:none;color:inherit">
              Каталог товаров
            </a>
          </h3>

          <?php
          $q = new WP_Query([
            'post_type'      => 'product',
            'posts_per_page' => 3,
            'orderby'        => 'rand',
          ]);
          if ( $q->have_posts() ) :
            while ( $q->have_posts() ) : $q->the_post();
              $p = wc_get_product( get_the_ID() ); ?>
              <div class="product-item">
                <a href="<?php the_permalink(); ?>">
                  <?php has_post_thumbnail()
                    ? the_post_thumbnail('thumbnail')
                    : printf(
                        '<img src="%s" alt="">',
                        esc_url('https://rin-stroy.ru/wp-content/uploads/2025/03/no-thumb.png')
                      ); ?>
                </a>
                <div class="meta">
                  <h4><a href="<?php the_permalink(); ?>">
                    <?php echo esc_html( wp_trim_words( get_the_title(), 3, '' ) ); ?>
                  </a></h4>

                  <p class="price-rating">
                    <?php echo $p ? wc_get_rating_html( $p->get_average_rating() ) : '—'; ?>
                    <?php if ( $p ) :
                      echo '<span class="prod-price">' . $p->get_price_html() . '</span>';
                    endif; ?>
                  </p>
                </div>
              </div>
            <?php endwhile;
            wp_reset_postdata();
          else :
            echo '<p>Нет товаров.</p>';
          endif; ?>
        </section>
      </div><!-- /.sticky-sidebar -->
    </aside>

    <!-- (5) Вкладки (статичные названия) -->
    <section class="product-tabs boxE">
    <?php
  // Перед рендером вкладок читаем поле с контентом для калькулятора:
  $calc_tab_html = get_post_meta( get_the_ID(), 'calc_tab_html', true );
?>
      <ul class="tab-list">
        <li class="tab-item active" data-tab="desc">описание</li>
        <li class="tab-item" data-tab="spec">характеристики</li>
        <li class="tab-item" data-tab="reviews">отзывы</li>
        <li class="tab-item" data-tab="vendor">подробно о товаре</li>
          <?php if ( ! empty($calc_tab_html) ): ?>
    <li class="tab-item" data-tab="calc">калькулятор</li>
  <?php endif; ?>
      </ul>

      <div class="tab-contents">
        
        <!-- Вкладка "Описание" -->
        <div class="tab-content active" id="desc">
          <section class="product-description">
            <h2><?php echo esc_html($desc_tab_title); ?></h2>
            <div class="description-divider"></div>
            
            <div class="description-row">
              <div class="description-text">
                <?php the_content(); // Основное описание ?>
              </div>
              <div class="description-image">
                <?php 
                if ( $desc_image_url ) {
                  echo '<img src="'.esc_url($desc_image_url).'" alt="desc_image">';
                } else {
                  echo '<img src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_1-1.png" alt="Placeholder right image">';
                }
                ?>
              </div>
            </div>
            
            <!-- Три колонки на плашках -->
            <div class="desc-three-cols" style="margin-top:20px;">
              <div class="col-block">
                <?php
                if ( $desc_col1 ) {
                  echo wp_kses_post($desc_col1);
                } else {
                  echo '<strong>Free Shipping &amp; Return</strong><br>
                        We offer free shipping for products on orders above $50 
                        and offer free delivery for all orders in US.';
                }
                ?>
              </div>
              <div class="col-block">
                <?php
                if ( $desc_col2 ) {
                  echo wp_kses_post($desc_col2);
                } else {
                  echo '<strong>Free and Easy Returns</strong><br>
                        We guarantee our products and you could 
                        get back all of your money anytime you want in 30 days.';
                }
                ?>
              </div>
              <div class="col-block">
                <?php
                if ( $desc_col3 ) {
                  echo wp_kses_post($desc_col3);
                } else {
                  echo '<strong>Special Financing</strong><br>
                        Get 20%-50% off items over $50 for a month 
                        or over $250 for a year with our special credit card.';
                }
                ?>
              </div>
            </div>

          </section>
        </div>
        
        <!-- Вкладка "Характеристики" -->
        <div class="tab-content" id="spec">
          <h2><?php echo esc_html($spec_tab_title); ?></h2>
          <div style="margin-left:auto; margin-right:0; text-align:right;">
            <?php wc_display_product_attributes($product); ?>
          </div>
        </div>
        
<!-- Вкладка "Отзывы" -->
<div class="tab-content" id="reviews">
  <h2><?php echo esc_html($reviews_tab_title); ?></h2>
  <?php
  // Если комментарии (отзывы) включены, подгружаем шаблон.
  // WooCommerce «перехватывает» comments_template() и показывает форму для отзывов.
  if ( comments_open() || get_comments_number() ) {
    comments_template();
  } else {
    echo '<p>Отзывы недоступны для этого товара.</p>';
  }
  ?>
</div>

        
        <!-- Вкладка "Подробно о товаре" (SEO) -->
        <div class="tab-content" id="vendor">
          <section class="vendor-info">
            <div class="vendor-hero-image">
              <?php
              if ( $vendor_hero_image ) {
                echo '<img src="'.esc_url($vendor_hero_image).'" alt="Vendor hero image">';
              } else {
                echo '<img 
                        src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_1-1.png"
                        alt="Vendor hero fallback"
                      >';
              }
              ?>
            </div>
            <h2><?php echo esc_html($vendor_tab_title); ?></h2>
            <?php
            if ( $vendor_text ) {
              echo wp_kses_post($vendor_text);
            } else {
              // fallback
              echo '<p>Здесь будет ваш SEO-текст о товаре.</p>';
            }
            ?>
          </section>
        </div>
        <!-- ▬ Вкладка "Калькулятор" ▬ -->
  <?php if ( ! empty($calc_tab_html) ): ?>
    <div class="tab-content" id="calc">
      <?php
        // Если в админке ввели HTML или шорткод, выведем его:
        // (через do_shortcode, чтобы шорткоды внутри поля отработали)
        echo do_shortcode( $calc_tab_html );
      ?>
    </div>
  <?php endif; ?>
      </div><!-- /.tab-contents -->
    </section><!-- /.product-tabs -->
  </div><!-- /grid-layout -->
</main>

<!-- [изменено для видео] Скрипт для миниатюр (картинки + видео) -->
<script>
document.addEventListener('DOMContentLoaded', () => {

  const container = document.querySelector('.product-gallery .main-image .media-container');
  const thumbs    = document.querySelector('.product-gallery .thumbnail-gallery');
  if (!container || !thumbs) return;

  // Показываем <img>
  function showImage(src, alt) {
    container.innerHTML = '';
    const i = document.createElement('img');
    i.src = src;
    i.alt = alt || '';
    container.appendChild(i);
  }

  // Показываем видео (iframe YouTube / Rutube / <video>)
  function showVideo(url) {
    container.innerHTML = '';

    // 1) YouTube
    if (/youtu\.?be/.test(url)) {
      let embedUrl = url.replace('watch?v=', 'embed/');
      embedUrl = embedUrl.replace('youtu.be/', 'youtube.com/embed/');

      const iframe = document.createElement('iframe');
      iframe.src = embedUrl;
      iframe.width = '100%';
      iframe.height= '400';
      iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
      iframe.allowFullscreen = true;
      container.appendChild(iframe);

    // 2) Rutube
    } else if (/rutube\.ru/.test(url)) {
      const match = url.match(/video\/([a-z0-9]+)/i);
      if (match && match[1]) {
        const rutubeId = match[1];
        const embedUrl = 'https://rutube.ru/play/embed/' + rutubeId;

        const iframe = document.createElement('iframe');
        iframe.src = embedUrl;
        iframe.width = '100%';
        iframe.height= '400';
        iframe.frameBorder = '0';
        iframe.allowFullscreen = true;
        container.appendChild(iframe);
      } else {
        container.innerHTML = '<p>Не удалось встроить это Rutube-видео.</p>';
      }

    // 3) MP4
    } else if (/\.mp4$/i.test(url)) {
      const video = document.createElement('video');
      video.src = url;
      video.controls = true;
      video.width = 600; // пример
      container.appendChild(video);

    // 4) fallback
    } else {
      container.innerHTML = '<p>Невозможно отобразить это видео</p>';
    }
  }

  // Обработчик клика по миниатюрам
  thumbs.addEventListener('click', e => {
    const t = e.target;
    if (t.tagName !== 'IMG') return;

    // сбрасываем активный класс
    thumbs.querySelectorAll('img').forEach(img => img.classList.remove('active-thumb'));
    t.classList.add('active-thumb');

    // если это картинка?
    if (t.dataset.full) {
      showImage(t.dataset.full, t.alt);
      return;
    }
    // если это видео?
    if (t.dataset.video) {
      showVideo(t.dataset.video);
      return;
    }
    // fallback
    showImage(t.src, t.alt);
  });
});
</script>

<!-- Скрипт вкладок (как было у вас) -->
<script>
document.addEventListener('DOMContentLoaded', () => {

  const tabs      = document.querySelectorAll('.product-tabs .tab-item');
  const contents  = document.querySelectorAll('.product-tabs .tab-content');

  if ( !tabs.length || !contents.length ) return;   // защитный выход

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      contents.forEach(c => c.classList.remove('active'));

      tab.classList.add('active');
      const id = tab.dataset.tab;
      const pane = document.getElementById(id);
      if (pane) pane.classList.add('active');
    });
  });

  // qty +/-
  const minus = document.querySelector('.qty-minus');
  const plus  = document.querySelector('.qty-plus');
  const field = document.querySelector('.quantity input');

  if(minus && plus && field) {
    minus.addEventListener('click', () => {
      const val = Math.max(1, (parseInt(field.value,10) || 1) - 1);
      field.value = val;
      field.dispatchEvent(new Event('change'));
    });
    plus.addEventListener('click', () => {
      field.value = (parseInt(field.value,10) || 1) + 1;
      field.dispatchEvent(new Event('change'));
    });
  }

});
</script>

<?php
  endwhile;
endif;

get_footer();
