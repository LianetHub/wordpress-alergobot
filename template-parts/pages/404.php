<?php

/**
 * Page template: 404
 *
 * @package alergobot
 */

$title    = alergobot_get_option('404_title', __('Такой страницы не существует', 'alergobot'));
$subtitle = alergobot_get_option('404_subtitle', __('Воспользуйтесь меню, чтобы перейти на другие страницы', 'alergobot'));
?>
<section class="not-found">
	<div class="not-found__container _container">
		<div class="not-found__head">
			<?php if ($title) : ?>
				<h1 class="not-found__title title title-md" data-animate="bottom"><?php echo esc_html($title); ?></h1>
			<?php endif; ?>
			<?php if ($subtitle) : ?>
				<p class="not-found__text text-lead" data-animate="bottom"><?php echo esc_html($subtitle); ?></p>
			<?php endif; ?>
		</div>
		<div class="not-found__visual" aria-hidden="true" data-animate="fade">
			<img src="<?php echo esc_url(alergobot_assets_uri('img/404.png')); ?>" alt="" title="" width="703" height="383">
		</div>
		<div class="not-found__actions" data-animate="bottom">
			<a class="btn btn--primary not-found__btn" href="<?php echo esc_url(home_url('/')); ?>"> Вернуться на главную <svg class="btn__icon" width="28" height="28" aria-hidden="true">
					<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
				</svg>
			</a>
			<a class="btn btn--secondary not-found__btn" href="<?php echo esc_url(home_url('/katalog/')); ?>"> Смотреть каталог <svg class="btn__icon" width="28" height="28" aria-hidden="true">
					<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
				</svg>
			</a>
		</div>
	</div>
</section>