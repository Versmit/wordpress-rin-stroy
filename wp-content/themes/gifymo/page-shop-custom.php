<?php
/*
Template Name: Магазин (Кастомный) – Сетка 3 колонки + Вкладки
*/
get_header(); ?>

<!-- Подключаем при необходимости Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Подключаем наш кастомный CSS -->
<link rel="stylesheet" href="/wp-content/themes/gifymo/assets/css/shop-custom.css">

<main class="shop-page single-product-page with-sticky-sidebar">

  <!-- СЕТКА НА 3 КОЛОНКИ -->
  <div class="grid-layout">
    
    <!-- Галерея (Колонка 1) -->
    <section class="product-gallery boxA">
      <div class="badge-offer">5% OFF</div>

      <div class="main-image">
        <img 
          src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_1.png" 
          alt="Main Product Image"
        >
      </div>

      <div class="thumbnail-gallery">
        <img src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_1.png" alt="Thumb 1">
        <img src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_2.png" alt="Thumb 2">
        <img src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_1-1.png" alt="Thumb 3">
        <img src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_2.png" alt="Thumb 4">
      </div>
    </section>
    
    <!-- Детали товара (Колонка 2) -->
    <section class="product-details boxB">
      <h1 class="product-title">Туфли из Темного Обсидиана</h1>

      <div class="product-meta">
        <div class="product-categories">
          Категории: <a href="#">Аксессуары</a>, <a href="#">Одежда</a>, <a href="#">Обувь</a>
        </div>
        <div class="product-sku">
          Артикул: M546891303
        </div>
      </div>

      <div class="product-separator"></div>

      <div class="product-price">$52.55</div>
      <div class="product-rating">
        <span class="stars">★ ★ ★ ★ ☆</span>
        <span class="reviews">0 Отзывов</span>
      </div>

      <ul class="product-features">
        <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
        <li>Aliquam id diam, ultrices, mi, eget, mauris.</li>
        <li>Ultrices eros in cursus turpis massa tincidunt ante.</li>
      </ul>

      <div class="product-separator"></div>

      <!-- Здесь мы добавляем желаемые кнопки в одну линию -->
      <div class="product-purchase rin-cart-row">
        <div class="quantity">
          <button>-</button>
          <input type="number" value="1" min="1">
          <button>+</button>
        </div>
        <button class="add-to-cart">Добавить в корзину</button>
        
        <!-- Заглушки для сравнения и избранного (замените href или используйте хуки/шорткоды) -->
        <a href="#" class="wishlist-button">
          <i class="fa-solid fa-heart"></i> В избранное
        </a>
        <a href="#" class="compare-button">
          <i class="fa-solid fa-scale-balanced"></i> Сравнить
        </a>
      </div>
    </section>

    <!-- Блок "Больше товаров из этой категории" -->
    <section class="more-items boxD">
      <h2>Больше товаров из этой категории</h2>

      <?php
      // Здесь WP_Query для товаров категории "gipsokarton"
      // (В WooCommerce: post_type=product, taxonomy=product_cat)
      $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'orderby'        => 'date',    // или 'rand' для случайных
        'order'          => 'DESC',
        'tax_query'      => array(
          array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'gipsokarton',  // Слаг категории
          ),
        ),
      );

      $query = new WP_Query( $args );

      if ( $query->have_posts() ) :
        echo '<div class="items-row">';
        
        while ( $query->have_posts() ) :
          $query->the_post(); ?>
          
          <div class="item">
            <a href="<?php the_permalink(); ?>">
              <?php 
              if ( has_post_thumbnail() ) {
                the_post_thumbnail('thumbnail');
              } else {
                // fallback
                echo '<img src="https://rin-stroy.ru/wp-content/uploads/2025/03/no-thumb.png" alt="No image">';
              }
              ?>
            </a>
          </div>
          
        <?php endwhile;
        echo '</div><!-- /.items-row -->';
        
        wp_reset_postdata(); 
      else :
        echo '<p>Нет товаров в этой категории.</p>';
      endif;
      ?>

      <!-- Ссылка "Смотреть все", на конкретный URL категории -->
      <!-- Делаем перевод "View all" -> "Смотреть все" -->
      <a href="https://rin-stroy.ru/product-category/stenovye-materialy/gipsokarton/" class="view-all-link">
        Смотреть все
      </a>
    </section>

    <!-- Сайдбар (Колонка 3) -->
    <aside class="right-column boxC">
      <div class="sticky-sidebar">
        
        <!-- Блок преимуществ -->
        <section class="advantages-card">
          <div class="advantage-item">
            <i class="fa-solid fa-truck"></i>
            <div>
              <h4>Бесплатная Доставка и Возвраты</h4>
              <p>Для всех заказов свыше $99</p>
            </div>
          </div>
          <div class="advantage-separator"></div>

          <div class="advantage-item">
            <i class="fa-solid fa-thumbs-up"></i>
            <div>
              <h4>Безопасная Оплата</h4>
              <p>Мы гарантируем безопасную оплату</p>
            </div>
          </div>
          <div class="advantage-separator"></div>

          <div class="advantage-item">
            <i class="fa-solid fa-handshake"></i>
            <div>
              <h4>Гарантия Возврата денег</h4>
              <p>Любой возврат в течение 30 дней</p>
            </div>
          </div>
        </section>
        <!-- /Блок преимуществ -->

        <!-- Баннер -->
        <section class="sidebar-block" style="margin-top:20px;">
          <img 
            src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_1-1.png"
            alt="Скидка 40% баннер"
          >
        </section>

        <section class="sidebar-block more-products" style="margin-top:20px;">
          <!-- Заголовок, теперь кликабельный -->
          <h3>
            <a href="https://rin-stroy.ru/katalog-kategorii/" style="text-decoration: none; color: inherit;">
              Каталог товаров
            </a>
          </h3>
          
          <?php
          // Рандомные товары из всего каталога (post_type=product)
          $args_sidebar = array(
            'post_type'      => 'product',
            'posts_per_page' => 3,    // Покажем 3
            'orderby'        => 'rand',
          );
          $query_side = new WP_Query( $args_sidebar );

          if ( $query_side->have_posts() ) :
            while ( $query_side->have_posts() ) :
              $query_side->the_post(); ?>
              
              <div class="product-item">
                <!-- Миниатюра кликабельна -->
                <a href="<?php the_permalink(); ?>">
                  <?php 
                  if ( has_post_thumbnail() ) {
                    the_post_thumbnail('thumbnail');
                  } else {
                    echo '<img src="https://rin-stroy.ru/wp-content/uploads/2025/03/no-thumb.png" alt="No image">';
                  }
                  ?>
                </a>
                <div>
                  <!-- Заголовок товара, но выводим только первые 3 слова -->
                  <h4>
                    <a href="<?php the_permalink(); ?>">
                      <?php 
                        // Берём полный заголовок
                        $full_title = get_the_title();
                        // Разбиваем на массив слов
                        $words = explode(' ', $full_title);
                        // Берём только первые 3
                        $first_three = array_slice($words, 0, 3);
                        // Склеиваем обратно
                        $short_title = implode(' ', $first_three);
                        // Вывод
                        echo esc_html( $short_title );
                      ?>
                    </a>
                  </h4>

                  <!-- Вывод категорий / цены -->
                  <p>
                    <?php
                      echo get_the_term_list( get_the_ID(), 'product_cat', '', ', ' );
                    ?>
                  </p>
                  <p>
                    <span>★ ★ ★ ★ ☆</span> |
                    <?php
                      $product_obj = wc_get_product( get_the_ID() );
                      if ( $product_obj ) {
                        echo $product_obj->get_price_html(); 
                      }
                    ?>
                  </p>
                </div>
              </div>

            <?php endwhile;
            wp_reset_postdata(); 
          else :
            echo '<p>No products yet.</p>';
          endif;
          ?>
        </section>
        
      </div>
    </aside>
    
    <!-- ТАБЫ (Description внутри вкладки) (колонки 1-2) -->
    <section class="product-tabs boxE">

      <!-- Список вкладок (Tab Headers) -->
      <ul class="tab-list">
        <li class="tab-item active" data-tab="desc">Description</li>
        <li class="tab-item" data-tab="spec">Specification</li>
        <li class="tab-item" data-tab="reviews">Customer Reviews (0)</li>
        <li class="tab-item" data-tab="vendor">Vendor Info</li>
      </ul>

      <!-- Содержимое вкладок (Tab Contents) -->
      <div class="tab-contents">
        
        <!-- ВКЛАДКА "DESC": вставляем всю большую раскладку описания -->
        <div class="tab-content active" id="desc">
          
          <section class="product-description">
            <!-- Ваш заголовок + контент -->
            <h2>Description</h2>
            <div class="description-divider"></div>
            
            <div class="description-row">
              <div class="description-text">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
                  incididunt arcu cursus vitae congue mauris. Sagittis id consectetur purus ut. 
                  Tellus rutrum tellus pelle Vel pretium lectus quam id leo in vitae turpis massa.
                </p>
                <ul>
                  <li>Nunc nec porttitor turpis.</li>
                  <li>Vivamus finibus vel mauris ut vehicula.</li>
                  <li>Nullam a magna porttitor, dictum risus nec.</li>
                  <li>Ultrices eros in cursus turpis massa tincidunt.</li>
                  <li>Cras ornare arcu dui vivamus arcu felis bibendum ut tristique.</li>
                </ul>
              </div>
              <div class="description-image">
                <img 
                  src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_1-1.png" 
                  alt="Placeholder right image"
                >
              </div>
            </div>
            
            <ol class="description-list">
              <li>
                <strong>Free Shipping &amp; Return</strong><br>
                We offer free shipping for products on orders above $50 
                and offer free delivery for all orders in US.
              </li>
              <li>
                <strong>Free and Easy Returns</strong><br>
                We guarantee our products and you could get 
                back all of your money anytime you want in 30 days.
              </li>
              <li>
                <strong>Special Financing</strong><br>
                Get 20%-50% off items over $50 for a month 
                or over $250 for a year with our special credit card.
              </li>
            </ol>
          </section>
          <!-- /product-description -->
          
        </div>
        <!-- /tab-content #desc -->
        
        <!-- Спецификация -->
        <div class="tab-content" id="spec">
          <h3>Specification</h3>
          <table>
            <tr>
              <th>Color</th>
              <td>Black, Blue, Green, Grey</td>
            </tr>
            <tr>
              <th>Size</th>
              <td>Extra Large, Large, Medium, Small</td>
            </tr>
          </table>
        </div>
        
        <!-- Отзывы -->
        <div class="tab-content" id="reviews">
          <h3>Customer Reviews (0)</h3>
          <p>No reviews yet.</p>
        </div>
        
        <!-- Таб "Vendor Info" -->
        <div class="tab-content" id="vendor">
          <section class="vendor-info">
            
            <!-- Широкая картинка -->
            <div class="vendor-hero-image">
              <img 
                src="https://rin-stroy.ru/wp-content/uploads/2025/03/0_1-1.png"
                alt="Vendor hero image"
              >
            </div>
            
            <!-- Заголовок -->
            <h2 class="vendor-title">Vendor Information</h2>

            <!-- Описание -->
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
              incididunt ut labore et dolore magna aliqua. Venenatis tellus in metus vulputate 
              eu scelerisque felis. Vel pretium lectus quam id leo in vitae turpis massa.
            </p>
            <p>
              Libero id faucibus nisl tincidunt eget. Aliquam id diam maecenas ultricies mi eget mauris. 
              Vestibulum mattis ullamcorper velit sed. A arcu cursus vitae congue mauris.
            </p>

          </section>
        </div>
      </div><!-- /.tab-contents -->
    </section><!-- /.product-tabs -->

  </div><!-- /grid-layout -->

</main>

<!-- Подключаем JS для переключения вкладок (если нет готового у темы/плагина) -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Логика переключения вкладок
  const tabItems = document.querySelectorAll(".tab-item");
  const tabContents = document.querySelectorAll(".tab-content");

  tabItems.forEach(item => {
    item.addEventListener("click", function() {
      // удаляем "active" у всех вкладок
      tabItems.forEach(i => i.classList.remove("active"));
      // удаляем "active" у всех контентов
      tabContents.forEach(c => c.classList.remove("active"));

      // даем "active" текущей вкладке
      this.classList.add("active");

      // получаем data-tab, находим соответствующий #id
      const tabId = this.getAttribute("data-tab");
      const contentEl = document.getElementById(tabId);
      if (contentEl) {
        contentEl.classList.add("active");
      }
    });
  });

  // Логика миниатюр (галереи)
  const mainImage = document.querySelector(".main-image img");
  const thumbnails = document.querySelectorAll(".thumbnail-gallery img");

  thumbnails.forEach(thumb => {
    thumb.addEventListener("click", function() {
      // Заменяем src главной картинки
      mainImage.src = this.src;
      mainImage.alt = this.alt;

      // Подсвечиваем активный thumb
      thumbnails.forEach(t => t.classList.remove("active-thumb"));
      this.classList.add("active-thumb");
    });
  });
});
</script>

<?php get_footer(); ?>
