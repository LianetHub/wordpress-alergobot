<?php
/**
 * Home section: choose
 *
 * @package alergobot
 */

?><section class="choose ">
				<div class="choose__container _container">
					<div class="choose__head">
						<div class="choose__head-main">
							<span class="tag tag--white choose__tag" data-animate="scale">выбор панели</span>
							<h2 class="choose__title title title-md title--light" data-animate="bottom">Как выбрать подходящую панель для вашей лаборатории</h2>
							<p class="choose__lead text-lead text-lead--light" data-animate="bottom">Вид панели, которую нужно купить, выбирается с учётом клинических показаний и лабораторных тестов. Зависит от профиля учреждения, сценариев диагностики.</p>
						</div>
						<p class="choose__note" data-animate="bottom">Если вы не уверены, какое решение подойдёт именно вам, наши специалисты помогут подобрать панель под задачи вашей лаборатории.</p>
					</div>
					<div class="choose__slider swiper" data-animate="bottom">
						<div class="swiper-wrapper">
							<article class="swiper-slide choose__card" data-animate="bottom">
								<div class="choose__card-text">
									<h3 class="choose__card-title">Мультипанель</h3>
									<p class="choose__card-desc">Оно нужно при респираторной, пищевой, лекарственной аллергии. Для первичной диагностики, скрининга, тестов перед иммунотерапией АСИТ.</p>
								</div>
								<div class="choose__card-media">
									<img class="cover-image" src="<?php echo esc_url(alergobot_assets_uri('img/home/choose-multipanel.png')); ?>" alt="Лабораторные исследования" title="Лабораторные исследования" width="214" height="256" loading="lazy">
								</div>
							</article>
							<article class="swiper-slide choose__card" data-animate="bottom">
								<div class="choose__card-text">
									<h3 class="choose__card-title">Респираторная панель</h3>
									<p class="choose__card-desc">Для тестов при дыхательных проблемах в диагностике с ингаляционной аллергией. Показано при насморках и кашлях, астме, поллинозах, удушьях, дерматитах и экземах.</p>
								</div>
								<div class="choose__card-media">
									<img class="cover-image" src="<?php echo esc_url(alergobot_assets_uri('img/home/choose-respiratory.jpg')); ?>" alt="Респираторная аллергия" title="Респираторная аллергия" width="214" height="256" loading="lazy">
								</div>
							</article>
							<article class="swiper-slide choose__card" data-animate="bottom">
								<div class="choose__card-text">
									<h3 class="choose__card-title">Мультипанель</h3>
									<p class="choose__card-desc">Оно нужно при респираторной, пищевой, лекарственной аллергии. Для первичной диагностики, скрининга, тестов перед иммунотерапией АСИТ.</p>
								</div>
								<div class="choose__card-media">
									<img class="cover-image" src="<?php echo esc_url(alergobot_assets_uri('img/home/choose-multipanel.png')); ?>" alt="Лабораторные исследования" title="Лабораторные исследования" width="214" height="256" loading="lazy">
								</div>
							</article>
							<article class="swiper-slide choose__card" data-animate="bottom">
								<div class="choose__card-text">
									<h3 class="choose__card-title">Респираторная панель</h3>
									<p class="choose__card-desc">Для тестов при дыхательных проблемах в диагностике с ингаляционной аллергией. Показано при насморках и кашлях, астме, поллинозах, удушьях, дерматитах и экземах.</p>
								</div>
								<div class="choose__card-media">
									<img class="cover-image" src="<?php echo esc_url(alergobot_assets_uri('img/home/choose-respiratory.jpg')); ?>" alt="Респираторная аллергия" title="Респираторная аллергия" width="214" height="256" loading="lazy">
								</div>
							</article>
						</div>
					</div>
					<div class="choose__footer" data-animate="bottom">
						<div class="choose__nav">
							<button class="choose__arrow choose__arrow--prev" type="button" aria-label="Назад" data-animate="scale">
								<svg width="32" height="32" aria-hidden="true">
									<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-chevron"></use>
								</svg>
							</button>
							<button class="choose__arrow choose__arrow--next" type="button" aria-label="Вперёд" data-animate="scale">
								<svg width="32" height="32" aria-hidden="true">
									<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-chevron"></use>
								</svg>
							</button>
						</div>
						<button class="choose__btn btn btn--white" type="button" data-fancybox="" data-src="#popup-consultation" data-animate="bottom">Получить консультацию</button>
					</div>
				</div>
			</section>