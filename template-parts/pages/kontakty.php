<?php

/**
 * Page template: kontakty
 *
 * @package alergobot
 */

?><section class="heading heading--contacts">
	<div class="heading__container _container">
		<div class="heading__grid">
			<div class="heading__main">
				<h1 class="heading__title title title-lg" data-animate="bottom">Закажите&nbsp;оборудование для диагностики аллергии</h1>
				<p class="heading__text heading__text--main" data-animate="bottom">Закажите современное оборудование для аллергодиагностики быстро и без лишних хлопот. Заполните форму, и наш менеджер подберет оптимальное решение под ваши задачи и пришлет полный прайс‑лист.</p>
			</div>
			<div class="heading__aside">
				<div class="heading__products">
					<div class="heading__product" data-animate="bottom">
						<img src="<?php echo esc_url(alergobot_assets_uri('img/product/02.png')); ?>" class="cover-image" alt="Анализатор для аллергодиагностики" title="Анализатор для аллергодиагностики">
					</div>
					<div class="heading__product" data-animate="bottom">
						<img src="<?php echo esc_url(alergobot_assets_uri('img/product/01.png')); ?>" class="cover-image" alt="Диагностическое оборудование PROTIA" title="Диагностическое оборудование PROTIA">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="contacts-order">
	<div class="contacts-order__container _container">
		<div class="contacts-order__grid">
			<form class="contacts-order__form form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post" data-animate="bottom">
				<div class="form__row">
					<label class="form__field">
						<input class="form__control" type="text" name="name" placeholder="Имя" autocomplete="name" required="">
					</label>
					<label class="form__field">
						<input class="form__control" type="text" name="company" placeholder="Компания" autocomplete="organization">
					</label>
				</div>
				<div class="form__row">
					<label class="form__field">
						<input class="form__control" type="tel" name="phone" placeholder="+7 (" autocomplete="tel" required="">
					</label>
					<label class="form__field">
						<input class="form__control" type="email" name="email" placeholder="E-mail" autocomplete="email" required="">
					</label>
				</div>
				<label class="form__field">
					<textarea class="form__control form__control--textarea" name="comment" placeholder="Комментарий" rows="4"></textarea>
				</label>
				<label class="checkbox">
					<input class="checkbox__input" type="checkbox" name="agree" required="">
					<span class="checkbox__box" aria-hidden="true"></span>
					<span class="checkbox__text">Я даю согласие на <a href="<?php echo esc_url(alergobot_privacy_policy_url()); ?>">обработку персональных данных</a> и соглашаюсь с <a href="<?php echo esc_url(alergobot_privacy_policy_url()); ?>">политикой конфиденциальности</a></span>
				</label>
				<button class="form__submit" type="submit">Отправить заявку</button>
			</form>
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