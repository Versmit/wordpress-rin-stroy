<?php
/**
 * Template Name: Catalog
 */
get_header();
?>

<link rel="stylesheet"
      href="<?php echo get_stylesheet_directory_uri(); ?>/catalog.css"
      media="all" />

<section class="catalog">
	<?php
	$items = [
		// Стеновые материалы
		[
			'cat'  => 'Стеновые материалы',
			'sub'  => 'Гипсокартон',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/гипсокатон2.png',
			'link' => 'https://rin-stroy.ru/product-category/stenovye-materialy/gipsokarton/',
		],
		[
			'cat'  => 'Стеновые материалы',
			'sub'  => 'Пазогребневые плиты',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/2dea9903-cc4b-47ae-8b15-f2376cdebb35.png',
			'link' => 'https://rin-stroy.ru/product-category/stenovye-materialy/pazogrebnevye-plity/',
		],
		[
			'cat'  => 'Стеновые материалы',
			'sub'  => 'Строительные блоки',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/строительные-блоки.png',
			'link' => 'https://rin-stroy.ru/product-category/stenovye-materialy/stroitelnye-bloki/',
		],

		// Сухие смеси и грунтовки
		[
			'cat'  => 'Сухие смеси и грунтовки',
			'sub'  => 'Гипс',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/гипс.png',
			'link' => 'https://rin-stroy.ru/product-category/suhie-stroitelnye-smesi-i-gruntovki/gips/',
		],
		[
			'cat'  => 'Сухие смеси и грунтовки',
			'sub'  => 'Грунтовки',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/грунтовка.png',
			'link' => 'https://rin-stroy.ru/product-category/suhie-stroitelnye-smesi-i-gruntovki/gruntovki/',
		],
		[
			'cat'  => 'Сухие смеси и грунтовки',
			'sub'  => 'Кладочные и монтажные смеси',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/кладочные-и-монтажные-смеси.png',
			'link' => 'https://rin-stroy.ru/product-category/suhie-stroitelnye-smesi-i-gruntovki/kladochnye-i-montazhnye-smesi/',
		],
		[
			'cat'  => 'Сухие смеси и грунтовки',
			'sub'  => 'Плиточные клеи',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/плиточные-клеи.png',
			'link' => 'https://rin-stroy.ru/product-category/suhie-stroitelnye-smesi-i-gruntovki/plitochnye-klei/',
		],
		[
			'cat'  => 'Сухие смеси и грунтовки',
			'sub'  => 'Смеси для устройства пола',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/напольные-смеси.png',
			'link' => 'https://rin-stroy.ru/product-category/suhie-stroitelnye-smesi-i-gruntovki/napolnie-smesi/',
		],
		[
			'cat'  => 'Сухие смеси и грунтовки',
			'sub'  => 'Шпаклевочные смеси',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/шпаклевка.png',
			'link' => 'https://rin-stroy.ru/product-category/suhie-stroitelnye-smesi-i-gruntovki/shpaklevochnye-smesi/',
		],
		[
			'cat'  => 'Сухие смеси и грунтовки',
			'sub'  => 'Штукатурки',
			'img'  => 'https://rin-stroy.ru/wp-content/uploads/2025/04/штукатурка.png',
			'link' => 'https://rin-stroy.ru/product-category/suhie-stroitelnye-smesi-i-gruntovki/shtukaturki/',
		],
	];

	foreach ( $items as $item ) : ?>
		<article class="catalog__card">
			<a href="<?php echo esc_url( $item['link'] ); ?>" class="catalog__link">
				<div class="catalog__img">
					<img src="<?php echo esc_url( $item['img'] ); ?>"
					     alt="<?php echo esc_attr( $item['sub'] ); ?>">
				</div>

				<div class="catalog__meta">
					<span class="catalog__category"><?php echo esc_html( $item['cat'] ); ?></span>
					<span class="catalog__stars" aria-label="Рейтинг 5 из 5">★★★★★</span>
				</div>

				<h3 class="catalog__title"><?php echo esc_html( $item['sub'] ); ?></h3>
			</a>
		</article>
	<?php endforeach; ?>
</section>

<?php get_footer(); ?>
