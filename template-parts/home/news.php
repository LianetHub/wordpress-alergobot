<?php
/**
 * Home section: news
 *
 * @package alergobot
 */

$footer_btn = alergobot_home_get('footer_btn');
?>
<section class="news">
	<div class="news__container _container" data-decor-parallax="">
		<div class="news__head">
			<div class="news__intro">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h2 class="news__title title title-md" data-animate="bottom"><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
				<?php if ($text = alergobot_home_get('text')) : ?>
					<p class="news__text text-lead" data-animate="bottom"><?php echo esc_html($text); ?></p>
				<?php endif; ?>
			</div>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="news__tag tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</div>
		<?php if (alergobot_home_rows('items')) : ?>
			<div class="news__grid">
				<?php foreach (alergobot_home_rows('items') as $item) :
					$date       = $item['date'] ?? '';
					$link       = $item['link'] ?? [];
					$link_url   = alergobot_acf_link_url($link, alergobot_blogs_archive_url());
					$date_attr  = $date ? esc_attr($date) : '';
					$date_label = $date ? wp_date('d.m.Y', strtotime($date)) : '';
					?>
					<article class="news-card" data-animate="bottom">
						<a class="news-card__link" href="<?php echo esc_url($link_url); ?>">
							<?php if (!empty($item['image_path'])) : ?>
								<div class="news-card__media">
									<img class="news-card__img" src="<?php echo esc_url(alergobot_acf_image_url($item['image_path'])); ?>" alt="<?php echo esc_attr($item['image_alt'] ?? ''); ?>" title="<?php echo esc_attr($item['image_alt'] ?? ''); ?>" width="295" height="277" loading="lazy">
								</div>
							<?php endif; ?>
							<div class="news-card__body">
								<?php if ($date_label) : ?>
									<time class="news-card__date" datetime="<?php echo $date_attr; ?>"><?php echo esc_html($date_label); ?></time>
								<?php endif; ?>
								<div class="news-card__text">
									<h3 class="news-card__title"><?php echo esc_html($item['title'] ?? ''); ?></h3>
									<p class="news-card__excerpt"><?php echo esc_html($item['excerpt'] ?? ''); ?></p>
								</div>
								<span class="news-card__more">
									<span class="news-card__more-label"><?php esc_html_e('Читать статью', 'alergobot'); ?></span>
									<span class="news-card__more-icon" aria-hidden="true">
										<svg class="icon" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
											<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
										</svg>
									</span>
								</span>
							</div>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<div class="news__footer" data-animate="bottom">
			<a class="btn btn--primary news__btn" href="<?php echo esc_url(alergobot_acf_link_url($footer_btn, alergobot_blogs_archive_url())); ?>"><?php echo esc_html(alergobot_acf_link_title($footer_btn, __('Смотреть все материалы', 'alergobot'))); ?></a>
		</div>
	</div>
</section>
