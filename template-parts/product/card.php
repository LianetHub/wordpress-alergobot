<?php
/**
 * Product card in category archive
 *
 * @package alergobot
 */

$permalink = get_permalink();
$post_id   = get_the_ID();
$icons     = alergobot_assets_uri('img/icons.svg');

$card_title = (string) alergobot_get_post_field('product_card_title', $post_id);
if (!$card_title) {
	$card_title = get_the_title();
}

$card_text = (string) alergobot_get_post_field('product_hero_text', $post_id);
$thumb     = get_the_post_thumbnail_url($post_id, 'medium');

?>
<li class="category__item">
	<div class="category__card">
		<div class="category__content">
			<?php if ($card_title) : ?>
				<h2 class="category__title title title-md">
					<a href="<?php echo esc_url($permalink); ?>"><?php echo wp_kses_post($card_title); ?></a>
				</h2>
			<?php endif; ?>
			<?php if ($card_text) : ?>
				<p class="category__text"><?php echo esc_html($card_text); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<div class="category__footer">
		<div class="category__actions">
			<a class="btn btn--primary category__btn a-hover-lift" href="<?php echo esc_url($permalink); ?>">
				<?php esc_html_e('подробнее', 'alergobot'); ?>
				<svg class="btn__icon" width="28" height="28" aria-hidden="true">
					<use href="<?php echo esc_url($icons); ?>#icon-arrow-up-right"></use>
				</svg>
			</a>
			<button class="btn btn--secondary category__btn" type="button" data-fancybox="" data-src="#popup-order">
				<?php esc_html_e('заказать', 'alergobot'); ?>
				<svg class="btn__icon" width="28" height="28" aria-hidden="true">
					<use href="<?php echo esc_url($icons); ?>#icon-arrow-up-right"></use>
				</svg>
			</button>
		</div>
		<?php if ($thumb) : ?>
			<div class="category__media">
				<img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(wp_strip_all_tags($card_title)); ?>" title="<?php echo esc_attr(wp_strip_all_tags($card_title)); ?>" width="239" height="164" loading="lazy">
			</div>
		<?php endif; ?>
	</div>
</li>
