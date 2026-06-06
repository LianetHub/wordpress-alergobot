<?php
/**
 * Home section: docs
 *
 * @package alergobot
 */

?>
<section class="docs">
	<div class="docs__container _container">
		<div class="docs__head">
			<div class="docs__intro">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h2 class="docs__title title title-md" data-animate="bottom"><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
				<?php if ($text = alergobot_home_get('text')) : ?>
					<p class="docs__text text-lead" data-animate="bottom"><?php echo esc_html($text); ?></p>
				<?php endif; ?>
			</div>
			<div class="docs__nav" data-animate="bottom">
				<button class="docs__arrow docs__arrow--prev" type="button" aria-label="<?php esc_attr_e('Назад', 'alergobot'); ?>">
					<svg class="docs__arrow-icon icon" width="32" height="32" aria-hidden="true" data-animate="scale">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-chevron"></use>
					</svg>
				</button>
				<button class="docs__arrow docs__arrow--next" type="button" aria-label="<?php esc_attr_e('Вперёд', 'alergobot'); ?>">
					<svg class="docs__arrow-icon icon" width="32" height="32" aria-hidden="true" data-animate="scale">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-chevron"></use>
					</svg>
				</button>
			</div>
		</div>
		<?php if (alergobot_home_rows('items')) : ?>
			<div class="docs__slider swiper" data-animate="bottom">
				<div class="swiper-wrapper">
					<?php foreach (alergobot_home_rows('items') as $doc) :
						if (empty($doc['image_path'])) {
							continue;
						}
						$image_url = alergobot_acf_image_url($doc['image_path']);
						?>
						<div class="swiper-slide docs__slide" data-animate="bottom">
							<a href="<?php echo esc_url($image_url); ?>" data-fancybox="docs" class="docs__card">
								<div class="docs__media">
									<img class="cover-image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($doc['image_alt'] ?? ''); ?>" title="<?php echo esc_attr($doc['image_alt'] ?? ''); ?>" width="276" height="395" loading="lazy">
								</div>
								<p class="docs__caption"><?php echo esc_html($doc['caption'] ?? ''); ?></p>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
