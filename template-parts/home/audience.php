<?php
/**
 * Home section: audience
 *
 * @package alergobot
 */

$photo_path = alergobot_home_get('photo_path');
?>
<section class="audience">
	<div class="audience__container _container">
		<div class="audience__head">
			<div class="audience__intro">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h2 class="section-head__title title title-md" data-animate="scale"><?php echo wp_kses_post($title); ?></h2>
				<?php endif; ?>
				<?php if ($text = alergobot_home_get('text')) : ?>
					<p class="section-head__text text-lead" data-animate="scale"><?php echo esc_html($text); ?></p>
				<?php endif; ?>
			</div>
			<?php if ($photo_path) : ?>
				<div class="audience__photo" data-animate="scale">
					<img src="<?php echo esc_url(alergobot_acf_image_url($photo_path)); ?>" class="cover-image" alt="<?php echo esc_attr(alergobot_home_get('photo_alt')); ?>" title="<?php echo esc_attr(alergobot_home_get('photo_alt')); ?>" width="427" height="212" loading="lazy">
				</div>
			<?php endif; ?>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="audience__tag tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</div>
		<div class="audience__scene" data-audience="">
			<img src="<?php echo esc_url(alergobot_assets_uri('img/home/audience-molecules.png')); ?>" alt="Фото малекул" width="529" height="477" loading="lazy" aria-hidden="true" class="audience__molecules">
			<?php if (alergobot_home_rows('cards')) : ?>
				<div class="audience__cards">
					<?php foreach (alergobot_home_rows('cards') as $card) :
						$is_active = !empty($card['is_active']);
						?>
						<button class="audience__card<?php echo $is_active ? ' _active' : ''; ?>" type="button" data-audience-card="" aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>" data-animate="bottom">
							<span class="audience__card-title"><?php echo esc_html($card['title'] ?? ''); ?></span>
							<span class="audience__toggle" aria-hidden="true"></span>
							<span class="audience__card-text"><?php echo esc_html($card['text'] ?? ''); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
