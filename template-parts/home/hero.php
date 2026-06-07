<?php
/**
 * Home section: hero
 *
 * @package alergobot
 */

$btn_catalog     = alergobot_home_get('btn_catalog');
$btn_catalog_url = alergobot_acf_link_url($btn_catalog, alergobot_catalog_url());
?>
<section class="hero">
	<div class="hero__container _container">
		<div class="hero__grid">
			<div class="hero__main">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h1 class="hero__title title title-lg" data-animate="bottom"><?php echo wp_kses_post($title); ?></h1>
				<?php endif; ?>
				<div class="hero__actions" data-animate="bottom">
					<a class="btn btn--white hero__btn" href="<?php echo esc_url($btn_catalog_url); ?>">
						<?php echo esc_html(alergobot_acf_link_title($btn_catalog, __('Перейти в каталог', 'alergobot'))); ?>
						<svg class="btn__icon" width="32" height="32" aria-hidden="true">
							<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
						</svg>
					</a>
					<button class="hero__btn btn btn--white-outline" type="button" data-fancybox data-src="#popup-presentation"><?php echo esc_html(alergobot_home_get('btn_presentation_label', __('Запросить презентацию', 'alergobot'))); ?></button>
				</div>
				<div class="hero__note" >
					<?php if ($flag_image = alergobot_home_get('flag_image')) : ?>
						<span class="hero__flag" aria-hidden="true" data-animate="scale">
							<?php echo alergobot_acf_image($flag_image, 'full', [
								'width'   => '83',
								'height'  => '67',
								'loading' => 'eager',
							]); ?>
						</span>
					<?php endif; ?>
					<?php if ($note = alergobot_home_get('note_text')) : ?>
						<p data-animate="bottom"><?php echo esc_html($note); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php if (alergobot_home_rows('cards')) : ?>
				<ul class="hero__cards">
					<?php foreach (alergobot_home_rows('cards') as $card) : ?>
						<li class="hero__card" data-animate="bottom">
							<span class="hero__card-icon" aria-hidden="true">
								<svg width="42" height="42" aria-hidden="true">
									<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#<?php echo esc_attr($card['icon'] ?? ''); ?>"></use>
								</svg>
							</span>
							<span class="hero__card-text"><?php echo wp_kses_post(nl2br($card['text'] ?? '')); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
