<?php
/**
 * Home section: benefits
 *
 * @package alergobot
 */

$brand_logo_path = alergobot_home_get('brand_logo_path');
?>
<section class="benefits">
	<div class="benefits__container _container">
		<header class="benefits__head">
			<?php if ($title = alergobot_home_get('title')) : ?>
				<h2 class="benefits__title title title-md" data-animate="bottom"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="benefits__tag tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</header>
		<div class="benefits__body">
			<?php if (alergobot_home_rows('cards')) : ?>
				<div class="benefits__grid">
					<?php foreach (alergobot_home_rows('cards') as $card) :
						$card_title = $card['title'] ?? '';
						$tooltip    = $card['tooltip'] ?? '';
						?>
						<article class="benefits__card" data-animate="bottom">
							<div class="benefits__card-head">
								<span class="benefits__num"><?php echo esc_html($card['num'] ?? ''); ?></span>
								<button class="benefits__info tooltip-trigger" type="button" data-tooltip="<?php echo esc_attr($tooltip); ?>" aria-label="<?php echo esc_attr(sprintf(/* translators: %s benefit title */ __('Подробнее: %s', 'alergobot'), $card_title)); ?>" aria-expanded="false">
									<svg class="icon benefits__info-icon" aria-hidden="true">
										<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-eye-info"></use>
									</svg>
								</button>
							</div>
							<h3 class="benefits__card-title"><?php echo esc_html($card_title); ?></h3>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="benefits__brand" data-animate="bottom">
				<?php if ($brand_logo_path) : ?>
					<img class="benefits__logo" src="<?php echo esc_url(alergobot_acf_image_url($brand_logo_path)); ?>" alt="PROTIA" title="PROTIA" width="185" height="52" loading="lazy">
				<?php endif; ?>
				<?php if ($brand_text = alergobot_home_get('brand_text')) : ?>
					<p class="benefits__text"><?php echo esc_html($brand_text); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
