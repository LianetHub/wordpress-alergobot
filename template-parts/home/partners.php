<?php
/**
 * Home section: partners
 *
 * @package alergobot
 */

$partners = alergobot_get_partners();

?>
<section class="partners">
	<div class="partners__container _container">
		<div class="partners__head">
			<?php if ($title = alergobot_home_get('title')) : ?>
				<h2 class="partners__title title title-md <?php echo alergobot_anim_class('blur-up'); ?>"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="partners__tag tag <?php echo alergobot_anim_class('bounce-up'); ?>"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</div>
		<div class="partners__desc">
			<?php if (alergobot_home_rows('paragraphs')) : ?>
				<div class="partners__text text-lead <?php echo alergobot_anim_class('fade-up'); ?>">
					<?php foreach (alergobot_home_rows('paragraphs') as $paragraph) : ?>
						<p><?php echo esc_html($paragraph['text'] ?? ''); ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if ($note = alergobot_home_get('note')) : ?>
				<p class="partners__note <?php echo alergobot_anim_class('fade-up'); ?>"><?php echo esc_html($note); ?></p>
			<?php endif; ?>
		</div>
		<?php if ($partners) : ?>
			<div class="partners__slider swiper">
				<div class="swiper-wrapper <?php echo alergobot_anim_class('stagger'); ?>">
					<?php foreach ($partners as $partner) :
						$thumb_id = get_post_thumbnail_id($partner);
						if (!$thumb_id) {
							continue;
						}
						?>
						<div class="swiper-slide partners__slide">
							<a class="partners__card" href="#popup-partners" data-fancybox data-src="#popup-partners" aria-label="<?php echo esc_attr(get_the_title($partner)); ?>">
								<span class="partners__logo-wrap">
									<?php echo alergobot_acf_image($thumb_id, 'full', [
										'class'   => 'partners__logo',
										'alt'     => get_the_title($partner),
										'title'   => get_the_title($partner),
										'loading' => 'lazy',
									]); ?>
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
