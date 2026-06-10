<?php
/**
 * Home section: catalog-teaser
 *
 * @package alergobot
 */

$btn_analyzers = alergobot_home_get('btn_analyzers');
$btn_panels    = alergobot_home_get('btn_panels');
?>
<section class="catalog-teaser">
	<div class="catalog-teaser__container _container" data-decor-parallax="">
		<div class="catalog-teaser__head">
			<?php if ($title = alergobot_home_get('title')) : ?>
				<h2 class="catalog-teaser__title title title-md" data-animate="bottom"><?php echo wp_kses_post($title); ?></h2>
			<?php endif; ?>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="catalog-teaser__tag tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</div>
		<div class="catalog-teaser__body">
			<div class="catalog-teaser__main">
				<?php if ($text = alergobot_home_get('text')) : ?>
					<p class="catalog-teaser__text text-lead" data-animate="bottom"><?php echo wp_kses_post($text); ?></p>
				<?php endif; ?>
				<div class="catalog-teaser__actions">
					<a class="btn btn--primary catalog-teaser__btn" data-animate="bottom" href="<?php echo esc_url(alergobot_acf_link_url($btn_analyzers, alergobot_get_product_category_link('analizatory'))); ?>">
						<?php echo esc_html(alergobot_acf_link_title($btn_analyzers, __('Смотреть анализаторы', 'alergobot'))); ?>
						<svg class="btn__icon icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
						</svg>
					</a>
					<a class="btn btn--secondary catalog-teaser__btn" data-animate="bottom" href="<?php echo esc_url(alergobot_acf_link_url($btn_panels, alergobot_catalog_url() . '#catalog-reagents')); ?>">
						<?php echo esc_html(alergobot_acf_link_title($btn_panels, __('смотреть панели', 'alergobot'))); ?>
						<svg class="btn__icon icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
						</svg>
					</a>
				</div>
			</div>
			<?php if (alergobot_home_rows('gallery')) : ?>
				<ul class="catalog-teaser__gallery">
					<?php foreach (alergobot_home_rows('gallery') as $item) :
						if (empty($item['image'])) {
							continue;
						}
						$img_w = $item['image_width'] ?? 800;
						$img_h = $item['image_height'] ?? 600;
						?>
						<li class="catalog-teaser__card" data-animate="bottom">
							<?php echo alergobot_acf_image($item['image'], 'full', [
								'class'   => 'cover-image',
								'alt'     => $item['image_alt'] ?? '',
								'title'   => $item['image_title'] ?? '',
								'width'   => (string) $img_w,
								'height'  => (string) $img_h,
								'loading' => 'lazy',
							]); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
