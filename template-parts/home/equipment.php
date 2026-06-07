<?php
/**
 * Home section: equipment
 *
 * @package alergobot
 */

$footer_btn = alergobot_home_get('footer_btn');
?>
<section class="equipment">
	<div class="equipment__container _container" data-decor-parallax="">
		<div class="equipment__head">
			<div class="equipment__intro">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h2 class="equipment__title title title-md" data-animate="bottom"><?php echo wp_kses_post($title); ?></h2>
				<?php endif; ?>
				<?php if ($lead = alergobot_home_get('lead')) : ?>
					<p class="equipment__lead text-lead" data-animate="bottom"><?php echo esc_html($lead); ?></p>
				<?php endif; ?>
			</div>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="tag equipment__tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</div>
		<?php if (alergobot_home_rows('items')) : ?>
			<ul class="equipment__grid">
				<?php foreach (alergobot_home_rows('items') as $item) :
					$link = $item['link'] ?? [];
					?>
					<li class="equipment__card" data-animate="bottom">
						<a class="equipment__card-link" href="<?php echo esc_url(alergobot_acf_link_url($link, '#')); ?>" aria-label="<?php echo esc_attr($item['aria_label'] ?? ''); ?>">
							<h3 class="equipment__card-name <?php echo esc_attr($item['name_class'] ?? ''); ?>"><?php echo esc_html($item['name'] ?? ''); ?></h3>
							<?php if (!empty($item['image_path'])) :
								$img_w = $item['image_width'] ?? 141;
								$img_h = $item['image_height'] ?? 106;
								?>
								<div class="equipment__card-media">
									<img class="cover-image" src="<?php echo esc_url(alergobot_acf_image_url($item['image_path'])); ?>" alt="<?php echo esc_attr($item['image_alt'] ?? ''); ?>" title="<?php echo esc_attr($item['image_alt'] ?? ''); ?>" width="<?php echo esc_attr((string) $img_w); ?>" height="<?php echo esc_attr((string) $img_h); ?>" loading="lazy">
								</div>
							<?php endif; ?>
							<p class="equipment__card-text"><?php echo esc_html($item['text'] ?? ''); ?></p>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="equipment__footer" data-animate="bottom">
			<a class="btn btn--primary equipment__btn" href="<?php echo esc_url(alergobot_acf_link_url($footer_btn, alergobot_catalog_url())); ?>"><?php echo esc_html(alergobot_acf_link_title($footer_btn, __('Подобрать оборудование', 'alergobot'))); ?></a>
		</div>
	</div>
</section>
