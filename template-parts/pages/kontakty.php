<?php

/**
 * Page template: kontakty
 *
 * @package alergobot
 */

?>

<section class="heading heading--contacts">
	<div class="heading__container _container">
		<div class="heading__grid">
			<div class="heading__main">
				<h1 class="heading__title title title-lg <?php echo alergobot_anim_class('blur-up', '_anim-no-hide'); ?>">Закажите&nbsp;оборудование для диагностики аллергии</h1>
				<p class="heading__text heading__text--main <?php echo alergobot_anim_class('fade-up', '_anim-no-hide'); ?>">Закажите современное оборудование для аллергодиагностики быстро и без лишних хлопот. Заполните форму, и наш менеджер подберет оптимальное решение под ваши задачи и пришлет полный прайс‑лист.</p>
			</div>
			<div class="heading__aside">
				<div class="heading__products">
					<div class="heading__product <?php echo alergobot_anim_class('fade-up', '_anim-no-hide'); ?>">
						<img src="<?php echo esc_url(alergobot_assets_uri('img/product/02.png')); ?>" class="cover-image" alt="Анализатор для аллергодиагностики" title="Анализатор для аллергодиагностики" width="800" height="600" fetchpriority="high">
					</div>
					<div class="heading__product <?php echo alergobot_anim_class('scale-up', '_anim-no-hide'); ?>">
						<img src="<?php echo esc_url(alergobot_assets_uri('img/product/01.png')); ?>" class="cover-image" alt="Диагностическое оборудование PROTIA" title="Диагностическое оборудование PROTIA" width="800" height="600" fetchpriority="high">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="contacts-order">
	<div class="contacts-order__container _container">
		<div class="contacts-order__grid">
			<div class="contacts-order__form <?php echo alergobot_anim_class('fade-up'); ?>">
				<?php alergobot_cf7_form('cf7_zakaz'); ?>
			</div>
			<?php
			$map_html = alergobot_get_map_html();
			if ($map_html) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $map_html;
			}
			?>
		</div>
	</div>
</section>
<?php get_template_part('template-parts/company/contacts', 'info'); ?>
