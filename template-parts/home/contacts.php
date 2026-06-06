<?php
/**
 * Home section: contacts
 *
 * @package alergobot
 */

$company_name = alergobot_get_option('kompaniya_nazvanie', 'ООО «Био Фокус»');
$map_html     = alergobot_get_map_html('contacts-map', 'contacts__map');
?>
<section class="contacts" id="contacts">
	<div class="contacts__wrap">
		<div class="contacts__container _container">
			<div class="contacts__box" data-contacts="" data-decor-parallax="" itemscope itemtype="https://schema.org/Organization">
				<meta itemprop="name" content="<?php echo esc_attr($company_name); ?>">
				<link itemprop="url" href="<?php echo esc_url(home_url('/')); ?>">
				<header class="contacts__hero">
					<div class="contacts__lead">
						<span class="tag tag--white" data-animate="scale">связь</span>
						<h2 class="contacts__title title title-md title--light" data-animate="bottom">Контакты</h2>
						<p class="contacts__text" data-animate="bottom">Заполняйте заявки на сайте нашей компании для заказа обратного звонка и консультации, чтобы купить лабораторное оборудование для диагностики. Оставляйте запрос на прайс-лист и презентацию. Предоставляем выгодные условия к сотрудничеству, чтобы купить передовое лабораторное оборудование.</p>
					</div>
					<figure class="contacts__figure" data-animate="bottom">
						<img class="contacts__photo" src="<?php echo esc_url(alergobot_assets_uri('img/home/contacts-lab.png')); ?>" alt="Специалист в лаборатории" title="Специалист в лаборатории" width="387" height="261" loading="lazy">
					</figure>
				</header>
				<div class="contacts__main">
					<div class="contacts__cards">
						<?php get_template_part('template-parts/company/contact', 'cards'); ?>
					</div>
					<?php if ($map_html) : ?>
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $map_html;
						?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
