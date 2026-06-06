<?php
/**
 * Home section: partners
 *
 * @package alergobot
 */

?>
<section class="partners">
	<div class="partners__container _container">
		<div class="partners__head">
			<?php if ($title = alergobot_home_get('title')) : ?>
				<h2 class="partners__title title title-md" data-animate="bottom"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="partners__tag tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</div>
		<div class="partners__desc">
			<?php if (alergobot_home_rows('paragraphs')) : ?>
				<div class="partners__text text-lead" data-animate="bottom">
					<?php foreach (alergobot_home_rows('paragraphs') as $paragraph) : ?>
						<p><?php echo esc_html($paragraph['text'] ?? ''); ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if ($note = alergobot_home_get('note')) : ?>
				<p class="partners__note" data-animate="bottom"><?php echo esc_html($note); ?></p>
			<?php endif; ?>
		</div>
		<?php if (alergobot_home_rows('logos')) : ?>
			<div class="partners__slider swiper" data-animate="bottom">
				<div class="swiper-wrapper">
					<?php foreach (alergobot_home_rows('logos') as $logo) :
						if (empty($logo['image_path'])) {
							continue;
						}
						$link = $logo['link'] ?? [];
						?>
						<div class="swiper-slide partners__slide" data-animate="bottom">
							<a class="partners__card" href="<?php echo esc_url(alergobot_acf_link_url($link, '#')); ?>" aria-label="<?php echo esc_attr($logo['aria_label'] ?? ''); ?>">
								<span class="partners__logo-wrap">
									<img class="partners__logo" src="<?php echo esc_url(alergobot_acf_image_url($logo['image_path'])); ?>" alt="<?php echo esc_attr($logo['image_alt'] ?? ''); ?>" title="<?php echo esc_attr($logo['image_alt'] ?? ''); ?>" loading="lazy">
								</span>
								<span class="partners__arrow" aria-hidden="true">
									<svg class="partners__arrow-icon icon" width="28" height="28">
										<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
									</svg>
								</span>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
