<?php
/**
 * Home section: request
 *
 * @package alergobot
 */

?><section class="request" id="request">
				<div class="request__box" data-decor-parallax="">
					<div class="request__container _container">
						<div class="request__grid">
							<div class="request__info">
								<h2 class="request__title title title-md title--light" data-animate="bottom">Получите презентацию, прайс и консультацию по подбору решения</h2>
								<p class="request__note" data-animate="bottom">Чтобы&nbsp; купить, получить презентацию лабораторного оборудования для диагностики и тестов на аллергию, заполните форму на сайте. Прайс с текущими ценами вы получите на момент обращения.</p>
							</div>
							<div class="request__form-col">
								<p class="request__lead" data-animate="bottom">Оставьте заявку, чтобы подобрать, купить панели диагностики на аллергию и лабораторное оборудование, или изучить линейку PROTIA Allergy-Q для тестов. Мы направим материалы с оптимальным решением для вас.</p>
								<form class="request__form form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post" data-animate="bottom">
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
										<span class="checkbox__box">
											<svg class="icon" width="20" height="20" aria-hidden="true">
												<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-check"></use>
											</svg>
										</span>
										<span class="checkbox__text">Я даю согласие на <a href="<?php echo esc_url(alergobot_privacy_policy_url()); ?>">обработку персональных данных</a> и соглашаюсь с <a href="<?php echo esc_url(alergobot_privacy_policy_url()); ?>">политикой конфиденциальности</a></span>
									</label>
									<button class="form__submit" type="submit">Отправить заявку</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>