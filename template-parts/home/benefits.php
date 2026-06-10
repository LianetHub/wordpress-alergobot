<?php
/**
 * Home section: benefits
 *
 * @package alergobot
 */

$brand_logo = alergobot_get_option('logotip_color');
$cards      = [];

if (function_exists('have_rows') && have_rows('cards')) {
	while (have_rows('cards')) {
		the_row();
		$cards[] = [
			'num'     => get_sub_field('num'),
			'title'   => get_sub_field('title') ?: get_sub_field('text'),
			'tooltip' => get_sub_field('tooltip'),
		];
	}
}
?>
<section class="benefits">
	<div class="benefits__container _container">
		<header class="benefits__head">
			<?php if ($title = alergobot_home_get('title')) : ?>
				<h2 class="benefits__title title title-md <?php echo alergobot_anim_class('fade-up'); ?>"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="benefits__tag tag <?php echo alergobot_anim_class('bounce-up'); ?>"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</header>
		<div class="benefits__body">
			<?php if ($cards) : ?>
				<div class="benefits__grid <?php echo alergobot_anim_class('stagger'); ?>">
					<?php foreach ($cards as $card_index => $card) :
						$card_num   = $card['num'] ?: (string) ($card_index + 1);
						$card_title = $card['title'] ?? '';
						$tooltip    = $card['tooltip'] ?? '';
						?>
						<article class="benefits__card">
							<div class="benefits__card-head">
								<span class="benefits__num"><?php echo esc_html($card_num); ?></span>
								<?php if ($tooltip) : ?>
									<button class="benefits__info tooltip-trigger" type="button" data-tooltip="<?php echo esc_attr($tooltip); ?>" aria-label="<?php echo esc_attr(sprintf(/* translators: %s benefit title */ __('Подробнее: %s', 'alergobot'), $card_title)); ?>" aria-expanded="false">
										<svg class="icon benefits__info-icon" aria-hidden="true">
											<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-eye-info"></use>
										</svg>
									</button>
								<?php endif; ?>
							</div>
							<?php if ($card_title) : ?>
								<h3 class="benefits__card-title"><?php echo esc_html($card_title); ?></h3>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="benefits__brand">
				<?php if ($brand_logo) : ?>
					<img class="benefits__logo <?php echo alergobot_anim_class('scale-up'); ?>" src="<?php echo esc_url(alergobot_acf_image_url($brand_logo)); ?>" alt="PROTIA" title="PROTIA" width="185" height="52" loading="lazy">
				<?php endif; ?>
				<?php if ($brand_text = alergobot_home_get('brand_text')) : ?>
					<p class="benefits__text <?php echo alergobot_anim_class('fade-left'); ?>"><?php echo esc_html($brand_text); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
