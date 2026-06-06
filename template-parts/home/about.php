<?php
/**
 * Home section: about
 *
 * @package alergobot
 */

$logo_path = alergobot_home_get('logo_path');
?>
<section class="about">
	<div class="about__container _container">
		<div class="about__layout">
			<div class="about__main">
				<div class="about__head">
					<?php if ($tag = alergobot_home_get('tag')) : ?>
						<span class="about__tag tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
					<?php endif; ?>
					<?php if ($title = alergobot_home_get('title')) : ?>
						<h2 class="about__title title title-md" data-animate="bottom"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>
					<?php if ($logo_path) : ?>
						<div class="about__logo-wrap" data-animate="bottom">
							<img src="<?php echo esc_url(alergobot_acf_image_url($logo_path)); ?>" alt="<?php echo esc_attr(alergobot_home_get('logo_alt')); ?>" title="<?php echo esc_attr(alergobot_home_get('logo_alt')); ?>" width="254" height="47" loading="lazy">
						</div>
					<?php endif; ?>
				</div>
				<?php if (alergobot_home_rows('photos')) : ?>
					<div class="about__photos">
						<?php foreach (alergobot_home_rows('photos') as $photo) :
							if (empty($photo['image_path'])) {
								continue;
							}
							?>
							<div class="about__photo" data-animate="bottom">
								<img src="<?php echo esc_url(alergobot_acf_image_url($photo['image_path'])); ?>" class="cover-image" alt="<?php echo esc_attr($photo['image_alt'] ?? ''); ?>" title="<?php echo esc_attr($photo['image_alt'] ?? ''); ?>" width="214" height="189" loading="lazy">
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="about__concept">
					<?php if ($concept_title = alergobot_home_get('concept_title')) : ?>
						<h3 class="about__concept-title" data-animate="bottom"><?php echo esc_html($concept_title); ?></h3>
					<?php endif; ?>
					<?php if ($concept_lead = alergobot_home_get('concept_lead')) : ?>
						<p class="about__concept-lead" data-animate="bottom"><?php echo esc_html($concept_lead); ?></p>
					<?php endif; ?>
					<?php if (alergobot_home_rows('concept_list')) : ?>
						<ul class="about__list" data-animate="bottom">
							<?php foreach (alergobot_home_rows('concept_list') as $item) : ?>
								<li><?php echo esc_html($item['text'] ?? ''); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if ($concept_footer = alergobot_home_get('concept_footer')) : ?>
						<p class="about__concept-footer" data-animate="bottom"><?php echo esc_html($concept_footer); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<div class="about__aside">
				<?php if ($lead = alergobot_home_get('lead')) : ?>
					<p class="about__lead" data-animate="bottom"><?php echo esc_html($lead); ?></p>
				<?php endif; ?>
				<?php if (alergobot_home_rows('body_paragraphs')) : ?>
					<div class="about__body">
						<?php foreach (alergobot_home_rows('body_paragraphs') as $paragraph) : ?>
							<p data-animate="bottom"><?php echo esc_html($paragraph['text'] ?? ''); ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
