<?php
/**
 * Header
 *
 * @package alergobot
 */

$logo        = function_exists('get_field') ? get_field('logotip', 'option') : null;
$phone       = alergobot_get_option('nomer_telefona', '+7 (495) 352-87-77');
$phone_2     = alergobot_get_option('nomer_telefona_2', $phone);
$phone_clean = alergobot_phone_clean($phone);
$phone_2_clean = alergobot_phone_clean($phone_2);
$main_class    = alergobot_get_main_class();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="<?php echo esc_url(alergobot_assets_uri('favicon-96x96.png')); ?>" sizes="96x96">
	<link rel="icon" type="image/svg+xml" href="<?php echo esc_url(alergobot_assets_uri('favicon.svg')); ?>">
	<link rel="shortcut icon" href="<?php echo esc_url(alergobot_assets_uri('favicon.ico')); ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(alergobot_assets_uri('apple-touch-icon.png')); ?>">
	<meta name="apple-mobile-web-app-title" content="Protia">
	<link rel="manifest" href="<?php echo esc_url(alergobot_assets_uri('site.webmanifest')); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
	<header class="header">
		<div class="header__container _container _container--small">
			<div class="header__bar">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo">
					<?php if ($logo) : ?>
						<?php echo alergobot_acf_image($logo, 'full', ['class' => 'header__logo-img', 'loading' => 'eager']); ?>
					<?php else : ?>
						<img class="header__logo-img" src="<?php echo esc_url(alergobot_assets_uri('img/logo.png')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" title="PROTIA" width="111" height="31">
					<?php endif; ?>
				</a>

				<nav class="header__nav" id="header-nav" aria-label="<?php esc_attr_e('Основная навигация', 'alergobot'); ?>">
					<?php if (function_exists('have_rows') && have_rows('glavnoe_menyu', 'option')) : ?>
						<ul class="header__menu">
							<?php
							while (have_rows('glavnoe_menyu', 'option')) :
								the_row();
								$name = get_sub_field('nazvanie');
								$link = get_sub_field('ssylka');
								if (!$name || !$link) {
									continue;
								}
								?>
								<li class="header__item">
									<a class="header__link" href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a>
								</li>
							<?php endwhile; ?>
						</ul>
					<?php else : ?>
						<ul class="header__menu">
							<li class="header__item"><a class="header__link" href="<?php echo esc_url(home_url('/katalog/')); ?>"><?php esc_html_e('Каталог', 'alergobot'); ?></a></li>
							<li class="header__item"><a class="header__link" href="#popup-presentation" data-fancybox data-src="#popup-presentation"><?php esc_html_e('Презентация', 'alergobot'); ?></a></li>
							<li class="header__item"><a class="header__link" href="<?php echo esc_url(get_post_type_archive_link('blogs') ?: home_url('/blog/')); ?>"><?php esc_html_e('Статьи', 'alergobot'); ?></a></li>
							<li class="header__item"><a class="header__link" href="<?php echo esc_url(home_url('/kontakty/')); ?>"><?php esc_html_e('Контакты', 'alergobot'); ?></a></li>
						</ul>
					<?php endif; ?>
				</nav>

				<div class="header__phones" aria-label="<?php esc_attr_e('Телефоны', 'alergobot'); ?>">
					<a class="header__phone" href="tel:+<?php echo esc_attr($phone_clean); ?>"><?php echo esc_html($phone); ?></a>
					<span class="header__sep" aria-hidden="true"></span>
					<a class="header__phone" href="tel:+<?php echo esc_attr($phone_2_clean); ?>"><?php echo esc_html($phone_2); ?></a>
				</div>
				<button class="icon-menu header__toggle" type="button" aria-label="<?php esc_attr_e('Открыть меню', 'alergobot'); ?>" aria-expanded="false" aria-controls="header-nav">
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
				</button>
			</div>
		</div>
	</header>
	<main class="main<?php echo $main_class ? ' ' . esc_attr($main_class) : ''; ?>">
