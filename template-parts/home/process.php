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
				<span class="tag process__tag <?php echo alergobot_anim_class('bounce-up'); ?>"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
			<div class="process__intro">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h2 class="process__title title title-md <?php echo alergobot_anim_class('fade-up'); ?>"><?php echo wp_kses_post($title); ?></h2>
				<?php endif; ?>
			</div>
		</div>
		<?php if (alergobot_home_rows('steps')) : ?>
			<div class="process__slider swiper">
				<div class="swiper-wrapper process__grid <?php echo alergobot_anim_class('stagger'); ?>">
					<?php foreach (alergobot_home_rows('steps') as $step) : ?>
						<div class="swiper-slide process__slide">
							<article class="process__card">
								<div class="process__body">
									<span class="process__step"><?php echo esc_html($step['step_label'] ?? ''); ?></span>
									<div class="process__text">
										<h3 class="process__card-title"><?php echo wp_kses_post($step['title'] ?? ''); ?></h3>
										<p class="process__card-desc"><?php echo esc_html($step['desc'] ?? ''); ?></p>
									</div>
								</div>
								<?php if (!empty($step['image'])) : ?>
									<div class="process__media">
										<?php echo alergobot_acf_image($step['image'], 'full', [
											'class'   => 'cover-image',
											'width'   => '275',
											'height'  => '326',
											'loading' => 'lazy',
										]); ?>
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
