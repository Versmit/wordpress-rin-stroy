</div><!-- #content -->
</div><!-- .site-content-contain -->
<footer id="colophon" class="site-footer">
	<?php
	if ( gifymo_is_footer_builder() ) {
		gifymo_the_footer_builder();
	} else {
		get_template_part( 'template-parts/footer' );
	}

	do_action( 'opal-render-footer' );
	?>
</footer><!-- #colophon -->
</div><!-- #page -->
<?php do_action( 'opal_end_wrapper' ) ?>
</div><!-- end.opal-wrapper-->
<?php wp_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchIcon = document.getElementById('search-icon');
    const searchForm = document.getElementById('mobile-search-form');

    /* тихо выходим, если элементов нет */
    if ( ! searchIcon || ! searchForm ) return;

    searchIcon.addEventListener('click', function (e) {
        e.preventDefault();
        searchForm.classList.toggle('active');
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const blocks = document.querySelectorAll('.product-block');
  if (!blocks.length) return;            /* других блоков нет – скрипт не нужен */

  blocks.forEach(block => {
    const gallery       = block.querySelector('.product-gallery');
    const images        = gallery?.querySelectorAll('.product-image') || [];
    const dotsContainer = block.querySelector('.product-dots');
    if (!images.length || !dotsContainer) return;   // 保険

    let current = 0;

    /* создаём точки */
    images.forEach((img, idx) => {
      const dot = document.createElement('div');
      dot.className = 'dot' + (idx ? '' : ' active');
      dot.addEventListener('click', () => update(idx));
      dotsContainer.appendChild(dot);
    });

    /* колесо мыши */
    block.addEventListener('wheel', e => {
      current = (current + (e.deltaY > 0 ? 1 : images.length - 1)) % images.length;
      update(current);
      e.preventDefault();
    });

    function update(i) {
      gallery.style.transform = `translateX(${-i * 220}px)`;
      dotsContainer
        .querySelectorAll('.dot')
        .forEach((d, n) => d.classList.toggle('active', n === i));
    }
  });
});
</script>
<!-- Это наш блок с контактами -->
<div id="popupContactOptions" style="display: none;">
    <!-- Ссылки на мессенджеры -->
    <a href="https://api.whatsapp.com/send/?phone=79260533750" target="_blank"><i class="fab fa-whatsapp"></i></a>
    <a href="https://t.me/RIN_stroy" target="_blank"><i class="fab fa-telegram-plane"></i></a>
    <a href="mailto:info@rin-stroy.ru"><i class="fas fa-envelope"></i></a>
    <a href="tel:+74993947490"><i class="fas fa-phone-alt"></i></a> <!-- Иконка звонка -->
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Проверяем, что это мобильная версия
    if (window.innerWidth <= 768) {
        // Ищем стрелочку
        const toggleArrow = document.querySelector('.callback a');
        const popupContactOptions = document.getElementById('popupContactOptions'); // Блок с контактами

        if (toggleArrow && popupContactOptions) {
            // Добавляем обработчик клика по стрелочке
            toggleArrow.addEventListener('click', function(event) {
                event.preventDefault();
                console.log('Клик по стрелочке произошел.');

                // Показать/скрыть блок с контактами
                if (popupContactOptions.style.display === 'block') {
                    popupContactOptions.style.display = 'none';
                } else {
                    popupContactOptions.style.display = 'block';
                }
            });
            
            console.log("Стрелочка найдена, обработчик добавлен.");
        } else {
            console.log("Стрелочка или блок с контактами не найдены.");
        }
    }
});
</script>
<script>
jQuery(document).ready(function($) {
    $('.rutube-video-link').on('click', function(e) {
        e.preventDefault();

        var videoUrl = $(this).data('video-url');
        var embedUrl = getRutubeEmbedUrl(videoUrl);

        var iframe = '<iframe width="100%" height="600" src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>';

        // Заменяем основное изображение на видео
        $('.woocommerce-product-gallery__wrapper').html('<div class="woocommerce-product-gallery__image">' + iframe + '</div>');
    });

    function getRutubeEmbedUrl(url) {
        var match = url.match(/video\/([a-zA-Z0-9]+)/);
        if (match) {
            return 'https://rutube.ru/play/embed/' + match[1];
        }
        return '';
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {

  /* ---- ищем разметку баннера ---- */
  const images      = document.querySelectorAll('.banner-image');
  const h1Element   = document.querySelector('.banner-text-2');
  const pElement    = document.querySelector('.banner-text-1');

  /* ▸ если чего‑то нет – просто выходим */
  if (!images.length || !h1Element || !pElement) return;

  /* ---- есть баннер, можно работать ---- */
  const texts = [
    { h1: 'HABEZ‑GIPS', p: 'РИН‑Строй — официальные представители продукции' },
    { h1: 'INVENTO',   p: 'Самые лучшие строительные материалы'            },
    { h1: 'AKSOLIT',   p: 'Технологии сложнее – отделка проще'             },
    { h1: 'Гипсолит',  p: 'Время перемен'                                  }
  ];

  let current = 0;
  images[current].classList.add('active');
  h1Element.textContent = texts[current].h1;
  pElement.textContent  = texts[current].p;
  h1Element.style.opacity = 1;
  pElement.style.opacity  = 1;

  function nextSlide () {
    images[current].classList.remove('active');
    h1Element.style.opacity = 0;
    pElement.style.opacity  = 0;

    current = (current + 1) % images.length;

    setTimeout(() => {
      images[current].classList.add('active');
      h1Element.textContent = texts[current].h1;
      pElement.textContent  = texts[current].p;
      h1Element.style.opacity = 1;
      pElement.style.opacity  = 1;
    }, 500);
  }

  setInterval(nextSlide, 4000);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const gallery = document.querySelector('.gallery');
  if (!gallery) return;                 /* ← если галереи нет – выходим */

  const galleryWrapper = gallery.parentElement;

  /* дублируем содержимое для бесшовной прокрутки */
  gallery.innerHTML += gallery.innerHTML;

  let galleryWidth      = gallery.scrollWidth / 2;
  let currentTranslateX = 0;
  let requestId;
  let isAnimating       = true;

  function animate () {
    currentTranslateX -= 1;
    if (currentTranslateX <= -galleryWidth) currentTranslateX = 0;
    gallery.style.transform = `translateX(${currentTranslateX}px)`;
    requestId = requestAnimationFrame(animate);
  }
  animate();

  window.addEventListener('resize', () => {
    galleryWidth      = gallery.scrollWidth / 2;
    currentTranslateX = 0;
  });

  galleryWrapper.addEventListener('mouseenter', () => {
    cancelAnimationFrame(requestId);
    isAnimating = false;
  });
  galleryWrapper.addEventListener('mouseleave', () => {
    if (!isAnimating) { isAnimating = true; animate(); }
  });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const carousel = document.querySelector('.category-carousel');
  const leftBtn  = document.querySelector('.carousel-btn.left');
  const rightBtn = document.querySelector('.carousel-btn.right');
  if (!carousel || !leftBtn || !rightBtn || !carousel.children.length) return;

  let itemWidth = calcItemWidth();
  let pos = 0, busy = false;

  rightBtn.addEventListener('click', scrollLeft);  // 👉
  leftBtn .addEventListener('click', scrollRight); // 👈
  window.addEventListener('resize', () => { itemWidth = calcItemWidth(); });

  function calcItemWidth() {
    const item = carousel.children[0];
    const style = getComputedStyle(item);
    return item.offsetWidth + parseFloat(style.marginLeft) + parseFloat(style.marginRight);
  }

  function scrollLeft() {
    if (busy) return; busy = true;
    carousel.style.transition = 'transform .5s';
    pos -= itemWidth;
    carousel.style.transform = `translateX(${pos}px)`;

    carousel.addEventListener('transitionend', function te() {
      carousel.removeEventListener('transitionend', te);
      carousel.appendChild(carousel.firstElementChild);
      carousel.style.transition = 'none';
      pos += itemWidth;
      carousel.style.transform = `translateX(${pos}px)`;
      busy = false;
    });
  }

  function scrollRight() {
    if (busy) return; busy = true;
    carousel.insertBefore(carousel.lastElementChild, carousel.firstElementChild);
    carousel.style.transition = 'none';
    pos -= itemWidth;
    carousel.style.transform = `translateX(${pos}px)`;
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        carousel.style.transition = 'transform .5s';
        pos += itemWidth;
        carousel.style.transform = `translateX(${pos}px)`;
      });
    });
    carousel.addEventListener('transitionend', () => (busy = false), { once:true });
  }
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function openPopup(imageUrl) {
            document.getElementById("popup-image").src = imageUrl;
            document.getElementById("popup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("popup-image").src = "";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("popup")) {
                closePopup();
            }
        }

        // Сделать функции глобальными
        window.openPopup = openPopup;
        window.closePopup = closePopup;
    });
</script>
    <script>
        jQuery(document).ready(function($) {
            var frame;
            $('.upload_image_button').on('click', function(e) {
                e.preventDefault();
                var button = $(this);

                // Создаем новое окно выбора медиафайлов
                frame = wp.media({
                    title: 'Выберите или загрузите изображение',
                    button: {
                        text: 'Использовать это изображение'
                    },
                    multiple: false
                });

                // Действие при выборе изображения
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    button.prev('input').val(attachment.url);
                });

                // Открываем окно выбора медиафайлов
                frame.open();
            });
        });
    </script>
    <script>
function openPopup(imageSrc) {
    document.getElementById('popup-image').src = imageSrc;
    document.getElementById('popup').style.display = 'block';
    document.body.classList.add('popup-active'); // Добавляем класс
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.body.classList.remove('popup-active'); // Удаляем класс
}
    </script>
<script>
document.addEventListener('DOMContentLoaded', () => {

  const filters       = document.querySelectorAll('.filter');
  const showAllButton = document.getElementById('showAll');
  const certificates  = document.querySelectorAll('.carousel-item-new');

  /* ⬇️   ЕСЛИ любая из коллекций пуста — просто выходим */
  if (!filters.length || !showAllButton || !certificates.length) {
      console.log('cert‑filter: элементов нет на этой странице');
      return;               /* ← теперь return находится ВНУТРИ функции */
  }
  filters.forEach(filter => {
    filter.addEventListener('click', e => {
      e.preventDefault();
      const category = filter.getAttribute('data-cert');
      certificates.forEach(cert => {
        cert.style.display =
          cert.getAttribute('data-category') === category ? 'block' : 'none';
      });
    });
  });

  showAllButton.addEventListener('click', () => {
    certificates.forEach(cert => cert.style.display = 'block');
  });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let calculatorDiv = document.getElementById("gips-calculator");
    if (!calculatorDiv) return;

    // Получаем категорию из глобальной переменной
    let productCategory = window.productCategory || "unknown";

    // Устанавливаем площадь одного листа в зависимости от категории
    let areaPerSheet = productCategory === "gipsokarton" ? 3 :
                       productCategory === "pazogrebnevye-plity" ? 0.3335 :
                       3; // по умолчанию гипсокартон

    console.log("Определённая категория:", productCategory);
    console.log("Используемая площадь материала:", areaPerSheet);

    calculatorDiv.innerHTML = `
        <div class="gips-container">
            <h3>Калькулятор расчета материала</h3>

            <div class="gips-mode-options">
                <label><input type="radio" name="calcMode" value="area" checked> Ввести общую площадь</label>
                <label><input type="radio" name="calcMode" value="dimensions"> Ввести длину и высоту</label>
            </div>

            <div id="areaInput" class="gips-inputs">
                <label>Общая площадь (м²): <input type="number" id="totalArea" min="1" step="0.1"></label>
                <label>Добавить запас (%): <input type="number" id="reserve" min="0" step="1" value="10"></label>
            </div>

            <div id="dimensionsInput" class="gips-inputs" style="display: none;">
                <label>Длина стены (м): <input type="number" id="length" min="1" step="0.1"></label>
                <label>Высота стены (м): <input type="number" id="height" min="1" step="0.1"></label>
                <label>Добавить запас (%): <input type="number" id="reserve-dim" min="0" step="1" value="10"></label>
            </div>

            <button id="calculateBtn" type="button">Рассчитать</button>

            <p id="result" class="gips-result"></p>
        </div>
    `;

    let calcModeRadios = document.querySelectorAll('input[name="calcMode"]');
    let areaInput      = document.getElementById("areaInput");
    let dimensionsInput= document.getElementById("dimensionsInput");

    calcModeRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            if (this.value === "area") {
                areaInput.style.display = "flex";
                dimensionsInput.style.display = "none";
            } else {
                areaInput.style.display = "none";
                dimensionsInput.style.display = "flex";
            }
        });
    });

    document.getElementById("calculateBtn").addEventListener("click", function () {
        let mode = document.querySelector('input[name="calcMode"]:checked').value;
        let totalArea = 0;
        let reserve = 0;

        if (mode === "area") {
            totalArea = parseFloat(document.getElementById("totalArea").value);
            reserve   = parseFloat(document.getElementById("reserve").value);
        } else {
            let length = parseFloat(document.getElementById("length").value);
            let height = parseFloat(document.getElementById("height").value);
            reserve    = parseFloat(document.getElementById("reserve-dim").value);
            if (length > 0 && height > 0) {
                totalArea = length * height;
            }
        }

        if (totalArea > 0) {
            let totalWithReserve = totalArea * (1 + reserve / 100);
            let sheetsNeeded     = Math.ceil(totalWithReserve / areaPerSheet);

            console.log("Общая площадь с запасом:", totalWithReserve);
            console.log("Рассчитанное количество:", sheetsNeeded);

            document.getElementById("result").innerHTML = `
                Общая площадь: <strong>${totalWithReserve.toFixed(2)}</strong> м² <br>
                Необходимое количество материалов: <strong>${sheetsNeeded}</strong> шт.
            `;
        } else {
            document.getElementById("result").innerHTML = "Введите корректные данные!";
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let addToCartButton = document.querySelector('.single_add_to_cart_button');
    if (addToCartButton) {
        addToCartButton.innerText = "В корзину";
    }
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Заменяем текст уведомления об успешном добавлении в корзину
    let notices = document.querySelectorAll('.woocommerce-message');
    notices.forEach(function(notice) {
        if (notice.innerText.includes("has been added to your cart.")) {
            notice.innerText = notice.innerText.replace("has been added to your cart.", "добавлен в корзину.");
        }
    });

    // Заменяем текст кнопки "View cart"
    let viewCartButtons = document.querySelectorAll('.wc-forward');
    viewCartButtons.forEach(function(button) {
        if (button.innerText.includes("View cart")) {
            button.innerText = "Перейти в корзину";
        }
    });

});
</script>
<script>
console.log("Классы body:", document.body.classList);
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  function initCategoryToggle() {
    const items = document.querySelectorAll('.wc-block-product-categories-list-item');

    if (items.length === 0) {
      setTimeout(initCategoryToggle, 300);
      return;
    }

    const currentUrl = window.location.href;

    items.forEach(function (item) {
      const subMenu = item.querySelector('ul.wc-block-product-categories-list');
      const link = item.querySelector('a');

      if (link && !item.classList.contains('toggle-ready')) {
        const toggle = document.createElement('span');
        toggle.classList.add('category-toggle');

        // ✅ SVG без inline-стилей — цвет и толщина теперь задаются через CSS
        toggle.innerHTML = `
          <svg class="category-icon" width="12" height="12" viewBox="0 0 24 24">
            <path d="M8 5l8 7-8 7" />
          </svg>
        `;

        if (subMenu) {
          toggle.addEventListener('click', function (e) {
            e.preventDefault();

            // 🔁 Аккордеон: закрыть все, кроме текущего
            items.forEach(i => {
              if (i !== item) {
                i.classList.remove('open');
              }
            });

            item.classList.toggle('open');
          });

          item.classList.add('has-children');
        }

        link.parentElement.insertBefore(toggle, link);
        item.classList.add('toggle-ready');
      }

      // 🧠 Автораскрытие, если текущая страница — часть подкатегорий
      const nestedLinks = item.querySelectorAll('ul a');
      nestedLinks.forEach(function (nestedLink) {
        if (currentUrl.includes(nestedLink.href)) {
          item.classList.add('open');
        }
      });
    });
  }

  initCategoryToggle();
});
</script>
</body>
</html>
