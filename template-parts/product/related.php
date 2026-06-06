<?php
/**
 * Related products
 *
 * @package alergobot
 */

$related = function_exists('get_field') ? get_field('related_products') : null;
if (empty($related)) {
	return;
}

$icons_uri = alergobot_assets_uri('img/icons.svg');
?>
<section class="equipment equipment--related">
	<div class="equipment__container _container">
		<div class="equipment__head">
			<div class="equipment__intro">
				<h2 class="equipment__title title title-md" data-animate="bottom"><?php esc_html_e('Вместе с этим смотрят', 'alergobot'); ?></h2>
			</div>
			<div class="equipment__nav">
				<button class="equipment__arrow equipment__arrow--prev" type="button" aria-label="<?php esc_attr_e('Назад', 'alergobot'); ?>" data-animate="scale">
					<svg class="equipment__arrow-icon icon" width="32" height="32" aria-hidden="true">
						<use href="<?php echo esc_url($icons_uri); ?>#icon-arrow-chevron"></use>
					</svg>
				</button>
				<button class="equipment__arrow equipment__arrow--next" type="button" aria-label="<?php esc_attr_e('Вперёд', 'alergobot'); ?>" data-animate="scale">
					<svg class="equipment__arrow-icon icon" width="32" height="32" aria-hidden="true">
						<use href="<?php echo esc_url($icons_uri); ?>#icon-arrow-chevron"></use>
					</svg>
				</button>
			</div>
		</div>
		<div class="equipment__slider swiper" data-animate="bottom">
			<div class="swiper-wrapper">
				<?php foreach ($related as $post) : ?>
					<?php
					setup_postdata($post);
					$permalink = get_permalink($post);
					$title     = get_the_title($post);
					$excerpt   = get_the_excerpt($post);
					$thumb     = get_the_post_thumbnail_url($post, 'medium');
					$aria      = sprintf(
						/* translators: %s: product title */
						__('%s, подробнее', 'alergobot'),
						$title
					);
					?>
					<div class="swiper-slide equipment__slide" data-animate="bottom">
						<article class="equipment__card">
							<a class="equipment__card-link" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr($aria); ?>">
								<h3 class="equipment__card-name"><?php echo esc_html($title); ?></h3>
								<?php if ($thumb) : ?>
									<div class="equipment__card-media">
										<img class="cover-image" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" width="239" height="164" loading="lazy">
									</div>
								<?php endif; ?>
								<?php if ($excerpt) : ?>
									<p class="equipment__card-text"><?php echo esc_html($excerpt); ?></p>
								<?php endif; ?>
							</a>
						</article>
					</div>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>
