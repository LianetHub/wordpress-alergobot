<?php
/**
 * Home section: news
 *
 * @package alergobot
 */

?><section class="news">
				<div class="news__container _container" data-decor-parallax="">
					<div class="news__head">
						<div class="news__intro">
							<h2 class="news__title title title-md" data-animate="bottom">Новости и материалы</h2>
							<p class="news__text text-lead" data-animate="bottom">Персонал компании отслеживает новости в лабораторной диагностике аллергии. Отражает это в передовой политике и новостной рубрике с помощью виджетов-карточек на сайте. Заказывайте новостную рассылку на почту или в мессенджеры, чтобы быть в курсе самых свежих новостей, и купить нужное оборудование.</p>
						</div>
						<span class="news__tag tag" data-animate="scale">новости</span>
					</div>
					<div class="news__grid">
						<article class="news-card" data-animate="bottom">
							<a class="news-card__link" href="<?php echo esc_url(alergobot_blogs_archive_url()); ?>">
								<div class="news-card__media">
									<img class="news-card__img" src="<?php echo esc_url(alergobot_assets_uri('img/home/news-thumb.png')); ?>" alt="Новость от 09.04.2026" title="Новость от 09.04.2026" width="295" height="277" loading="lazy">
								</div>
								<div class="news-card__body">
									<time class="news-card__date" datetime="2026-04-09">09.04.2026</time>
									<div class="news-card__text">
										<h3 class="news-card__title">Lorem ipsum dolor sit amet consectetur adipiscing elit</h3>
										<p class="news-card__excerpt">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat.</p>
									</div>
									<span class="news-card__more">
										<span class="news-card__more-label">Читать статью</span>
										<span class="news-card__more-icon" aria-hidden="true">
											<svg class="icon" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
												<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
											</svg>
										</span>
									</span>
								</div>
							</a>
						</article>
						<article class="news-card" data-animate="bottom">
							<a class="news-card__link" href="<?php echo esc_url(alergobot_blogs_archive_url()); ?>">
								<div class="news-card__media">
									<img class="news-card__img" src="<?php echo esc_url(alergobot_assets_uri('img/home/news-thumb.png')); ?>" alt="Новость от 09.04.2026" title="Новость от 09.04.2026" width="295" height="277" loading="lazy">
								</div>
								<div class="news-card__body">
									<time class="news-card__date" datetime="2026-04-09">09.04.2026</time>
									<div class="news-card__text">
										<h3 class="news-card__title">Lorem ipsum dolor sit amet consectetur adipiscing elit</h3>
										<p class="news-card__excerpt">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat.</p>
									</div>
									<span class="news-card__more">
										<span class="news-card__more-label">Читать статью</span>
										<span class="news-card__more-icon" aria-hidden="true">
											<svg class="icon" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
												<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
											</svg>
										</span>
									</span>
								</div>
							</a>
						</article>
					</div>
					<div class="news__footer" data-animate="bottom">
						<a class="btn btn--primary news__btn" href="<?php echo esc_url(alergobot_blogs_archive_url()); ?>">Смотреть все материалы</a>
					</div>
				</div>
			</section>