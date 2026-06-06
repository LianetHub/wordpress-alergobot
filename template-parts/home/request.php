<?php
/**
 * Home section: request
 *
 * @package alergobot
 */

?>
<section class="request" id="request">
	<div class="request__box" data-decor-parallax="">
		<div class="request__container _container">
			<div class="request__grid">
				<div class="request__info">
					<?php if ($title = alergobot_home_get('title')) : ?>
						<h2 class="request__title title title-md title--light" data-animate="bottom"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>
					<?php if ($note = alergobot_home_get('note')) : ?>
						<p class="request__note" data-animate="bottom"><?php echo wp_kses_post($note); ?></p>
					<?php endif; ?>
				</div>
				<div class="request__form-col">
					<?php if ($lead = alergobot_home_get('lead')) : ?>
						<p class="request__lead" data-animate="bottom"><?php echo esc_html($lead); ?></p>
					<?php endif; ?>
					<form class="request__form form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post" data-animate="bottom">
						<div class="form__row">
							<label class="form__field">
								<input class="form__control" type="text" name="name" placeholder="<?php esc_attr_e('Имя', 'alergobot'); ?>" autocomplete="name" required="">
							</label>
							<label class="form__field">
								<input class="form__control" type="text" name="company" placeholder="<?php esc_attr_e('Компания', 'alergobot'); ?>" autocomplete="organization">
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
							<textarea class="form__control form__control--textarea" name="comment" placeholder="<?php esc_attr_e('Комментарий', 'alergobot'); ?>" rows="4"></textarea>
						</label>
						<label class="checkbox">
							<input class="checkbox__input" type="checkbox" name="agree" required="">
							<span class="checkbox__box">
								<svg class="icon" width="20" height="20" aria-hidden="true">
									<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-check"></use>
								</svg>
							</span>
							<span class="checkbox__text"><?php esc_html_e('Я даю согласие на', 'alergobot'); ?> <a href="<?php echo esc_url(alergobot_privacy_policy_url()); ?>"><?php esc_html_e('обработку персональных данных', 'alergobot'); ?></a> <?php esc_html_e('и соглашаюсь с', 'alergobot'); ?> <a href="<?php echo esc_url(alergobot_privacy_policy_url()); ?>"><?php esc_html_e('политикой конфиденциальности', 'alergobot'); ?></a></span>
						</label>
						<button class="form__submit" type="submit"><?php esc_html_e('Отправить заявку', 'alergobot'); ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
