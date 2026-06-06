<?php
/**
 * Home section: process
 *
 * @package alergobot
 */

?>
<section class="process">
	<div class="process__container _container">
		<div class="process__head">
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="tag process__tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
			<div class="process__intro">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h2 class="process__title title title-md" data-animate="bottom"><?php echo wp_kses_post($title); ?></h2>
				<?php endif; ?>
			</div>
		</div>
		<?php if (alergobot_home_rows('steps')) : ?>
			<div class="process__slider swiper" data-animate="bottom">
				<div class="swiper-wrapper process__grid">
					<?php foreach (alergobot_home_rows('steps') as $step) : ?>
						<div class="swiper-slide process__slide" data-animate="bottom">
							<article class="process__card ">
								<div class="process__body">
									<span class="process__step"><?php echo esc_html($step['step_label'] ?? ''); ?></span>
									<div class="process__text">
										<h3 class="process__card-title"><?php echo wp_kses_post($step['title'] ?? ''); ?></h3>
										<p class="process__card-desc"><?php echo esc_html($step['desc'] ?? ''); ?></p>
									</div>
								</div>
								<?php if (!empty($step['image_path'])) : ?>
									<div class="process__media">
										<img class="cover-image" src="<?php echo esc_url(alergobot_acf_image_url($step['image_path'])); ?>" alt="<?php echo esc_attr($step['image_alt'] ?? ''); ?>" title="<?php echo esc_attr($step['image_alt'] ?? ''); ?>" width="275" height="326" loading="lazy">
									</div>
								<?php endif; ?>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
