<?php
/**
 * Home section: pick
 *
 * @package alergobot
 */

?>
<section class="pick" id="pick">
	<div class="pick__container _container">
		<div class="pick__header">
			<div class="pick__main">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h2 class="pick__title title title-md" data-animate="bottom"><?php echo wp_kses_post($title); ?></h2>
				<?php endif; ?>
				<?php if ($text = alergobot_home_get('text')) : ?>
					<p class="pick__text text-lead" data-animate="bottom"><?php echo esc_html($text); ?></p>
				<?php endif; ?>
			</div>
			<div class="pick__side">
				<?php if (alergobot_home_rows('tags')) : ?>
					<div class="pick__tags">
						<?php foreach (alergobot_home_rows('tags') as $tag_item) : ?>
							<span class="pick__tag tag" data-animate="scale"><?php echo esc_html($tag_item['text'] ?? ''); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="pick__benefits">
					<?php if ($benefits_title = alergobot_home_get('benefits_title')) : ?>
						<h3 class="pick__subtitle" data-animate="bottom"><?php echo esc_html($benefits_title); ?></h3>
					<?php endif; ?>
					<?php if (alergobot_home_rows('benefits_list')) : ?>
						<ul class="pick__list">
							<?php foreach (alergobot_home_rows('benefits_list') as $benefit) : ?>
								<li data-animate="bottom"><?php echo esc_html($benefit['text'] ?? ''); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php if (alergobot_home_rows('videos')) : ?>
			<div class="pick__videos">
				<?php foreach (alergobot_home_rows('videos') as $video) : ?>
					<div class="pick__video" data-animate="bottom">
						<button class="pick__video-media" type="button" aria-label="<?php echo esc_attr($video['aria_label'] ?? ''); ?>" data-fancybox="pick-video" data-type="iframe" data-width="960" data-height="540" data-src="<?php echo esc_url($video['video_url'] ?? ''); ?>">
							<?php if (!empty($video['poster'])) : ?>
								<?php echo alergobot_acf_image($video['poster'], 'full', [
									'width'   => '650',
									'height'  => '382',
									'loading' => 'lazy',
								]); ?>
							<?php endif; ?>
							<span class="pick__play" aria-hidden="true">
								<svg width="38" height="61" aria-hidden="true">
									<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-pick-play"></use>
								</svg>
							</span>
						</button>
						<?php if (!empty($video['captions']) && is_array($video['captions'])) : ?>
							<div class="pick__caption" >
								<?php foreach ($video['captions'] as $caption) : ?>
									<p data-animate="bottom"><?php echo esc_html($caption['text'] ?? ''); ?></p>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
