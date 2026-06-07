<?php
/**
 * Product category archive layout
 *
 * @package alergobot
 */

$term      = get_queried_object();
if (!($term instanceof WP_Term)) {
	$term = get_query_var('alergobot_product_category_term');
}
$term_id   = ($term instanceof WP_Term) ? (int) $term->term_id : 0;
$term_key  = $term_id ? 'product_category_' . $term_id : '';
$icons     = alergobot_assets_uri('img/icons.svg');

$heading_title = '';
$heading_text  = '';
$heading_logo  = null;
$work_title    = '';
$work_tag      = '';
$work_text     = '';
$work_gallery  = [];
$benefits      = [];
$cta_title     = '';
$cta_text      = '';
$cta_image     = null;
$cta_note      = '';

if ($term_key) {
	$term_fields = alergobot_get_term_fields($term_key);

	$heading_title = (string) ($term_fields['cat_heading_title'] ?? '');
	$heading_text  = (string) ($term_fields['cat_heading_text'] ?? '');
	$heading_logo  = $term_fields['cat_heading_logo'] ?? null;
	$work_title    = (string) ($term_fields['cat_work_title'] ?? '');
	$work_tag      = (string) ($term_fields['cat_work_tag'] ?? '');
	$work_text     = (string) ($term_fields['cat_work_text'] ?? '');
	$work_gallery  = (array) ($term_fields['cat_work_gallery'] ?? []);
	$benefits      = (array) ($term_fields['cat_benefits'] ?? []);
	$cta_title     = (string) ($term_fields['cat_cta_title'] ?? '');
	$cta_text      = (string) ($term_fields['cat_cta_text'] ?? '');
	$cta_image     = $term_fields['cat_cta_image'] ?? null;
	$cta_note      = (string) ($term_fields['cat_cta_note'] ?? '');
}

$logo_url      = alergobot_acf_image_url($heading_logo);
$cta_image_url = alergobot_acf_image_url($cta_image);
$has_work      = $work_title || $work_tag || $work_text || $work_gallery;
$has_cta       = $cta_title || $cta_text || $cta_note || $cta_image_url;

?>
<section class="heading heading--devices">
	<div class="heading__container _container">
		<div class="heading__grid">
			<div class="heading__main">
				<?php if ($heading_title) : ?>
					<h1 class="heading__title title title-lg" data-animate="bottom"><?php echo esc_html($heading_title); ?></h1>
				<?php endif; ?>
				<div class="heading__actions">
					<button class="btn btn--primary heading__btn" type="button" data-fancybox="" data-src="#popup-order" data-animate="bottom">
						<?php esc_html_e('оформить заказ', 'alergobot'); ?>
						<svg class="btn__icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url($icons); ?>#icon-arrow-up-right"></use>
						</svg>
					</button>
					<button class="btn btn--secondary heading__btn" type="button" data-fancybox="" data-src="#popup-consultation" data-animate="bottom">
						<?php esc_html_e('задать вопрос', 'alergobot'); ?>
						<svg class="btn__icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url($icons); ?>#icon-arrow-up-right"></use>
						</svg>
					</button>
				</div>
			</div>
			<?php if ($heading_text || $logo_url) : ?>
				<div class="heading__aside">
					<?php if ($heading_text) : ?>
						<p class="heading__text" data-animate="bottom"><?php echo esc_html($heading_text); ?></p>
					<?php endif; ?>
					<?php if ($logo_url) : ?>
						<img class="heading__logo" src="<?php echo esc_url($logo_url); ?>" alt="PROTIA" title="PROTIA" width="185" height="52" data-animate="fade">
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="heading__divider" aria-hidden="true"></div>
	</div>
</section>
<section class="category" id="category">
	<div class="category__container _container">
		<ul class="category__grid">
			<?php
			while (have_posts()) :
				the_post();
				get_template_part('template-parts/product/card');
			endwhile;
			?>
		</ul>
	</div>
</section>
<?php if ($has_work) : ?>
	<section class="devices-work">
		<div class="devices-work__container _container">
			<div class="devices-work__head">
				<?php if ($work_title) : ?>
					<h2 class="devices-work__title title title-md" data-animate="bottom"><?php echo esc_html($work_title); ?></h2>
				<?php endif; ?>
				<?php if ($work_tag) : ?>
					<span class="tag devices-work__tag" data-animate="scale"><?php echo esc_html($work_tag); ?></span>
				<?php endif; ?>
			</div>
			<div class="devices-work__body">
				<?php if ($work_text) : ?>
					<div class="devices-work__intro" data-animate="bottom">
						<div class="devices-work__text" data-devices-work-text="">
							<?php echo wp_kses_post($work_text); ?>
						</div>
						<button class="devices-work__more" type="button" data-devices-work-more="" data-label-more="<?php esc_attr_e('Еще', 'alergobot'); ?>" data-label-less="<?php esc_attr_e('Свернуть', 'alergobot'); ?>" aria-expanded="false"><?php esc_html_e('Еще', 'alergobot'); ?></button>
					</div>
				<?php endif; ?>
				<?php if ($work_gallery) : ?>
					<div class="devices-work__gallery">
						<?php foreach ($work_gallery as $photo) :
							$photo_url = alergobot_acf_image_url($photo);
							if (!$photo_url) {
								continue;
							}
							$photo_alt = is_array($photo) ? ($photo['alt'] ?? '') : '';
							$photo_w   = is_array($photo) ? ($photo['width'] ?? '') : '';
							$photo_h   = is_array($photo) ? ($photo['height'] ?? '') : '';
							if (!$photo_w) {
								$photo_w = 315;
							}
							if (!$photo_h) {
								$photo_h = 293;
							}
							?>
							<div class="devices-work__photo" data-animate="bottom">
								<img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_alt); ?>" title="<?php echo esc_attr($photo_alt); ?>" width="<?php echo esc_attr((string) $photo_w); ?>" height="<?php echo esc_attr((string) $photo_h); ?>" loading="lazy">
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php if ($benefits) : ?>
	<section class="devices-benefits">
		<div class="devices-benefits__container _container" data-decor-parallax="">
			<div class="devices-benefits__head">
				<h2 class="devices-benefits__title title title-md" data-animate="bottom"><?php esc_html_e('Почему это важно для лаборатории', 'alergobot'); ?></h2>
				<div class="devices-benefits__nav">
					<button class="devices-benefits__arrow devices-benefits__arrow--prev" data-animate="scale" type="button" aria-label="<?php esc_attr_e('Назад', 'alergobot'); ?>"></button>
					<button class="devices-benefits__arrow devices-benefits__arrow--next" data-animate="scale" type="button" aria-label="<?php esc_attr_e('Вперёд', 'alergobot'); ?>"></button>
				</div>
			</div>
			<div class="devices-benefits__slider swiper" data-animate="bottom">
				<div class="swiper-wrapper">
					<?php foreach ($benefits as $slide) :
						$slide_title = $slide['title'] ?? '';
						$slide_text  = $slide['text'] ?? '';
						if (!$slide_title) {
							continue;
						}
						?>
						<div class="swiper-slide devices-benefits__slide" data-animate="bottom">
							<h3 class="devices-benefits__card-title"><?php echo esc_html($slide_title); ?></h3>
							<?php if ($slide_text) : ?>
								<p class="devices-benefits__card-text"><?php echo esc_html($slide_text); ?></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php if ($has_cta) : ?>
	<section class="devices-cta" id="devices-request">
		<div class="devices-cta__container _container">
			<div class="devices-cta__grid">
				<div class="devices-cta__box devices-cta__box--form" data-animate="bottom">
					<?php if ($cta_title) : ?>
						<h2 class="devices-cta__title title title-md title--light"><?php echo esc_html($cta_title); ?></h2>
					<?php endif; ?>
					<?php if ($cta_text) : ?>
						<p class="devices-cta__text"><?php echo esc_html($cta_text); ?></p>
					<?php endif; ?>
					<a class="btn btn--white devices-cta__btn" data-fancybox="" href="#popup-consultation">
						<?php esc_html_e('задать вопрос', 'alergobot'); ?>
						<svg class="btn__icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url($icons); ?>#icon-arrow-up-right"></use>
						</svg>
					</a>
				</div>
				<?php if ($cta_image_url || $cta_note) : ?>
					<div class="devices-cta__box devices-cta__box--visual" data-animate="bottom">
						<?php if ($cta_image_url) : ?>
							<div class="devices-cta__visual">
								<img src="<?php echo esc_url($cta_image_url); ?>" alt="<?php esc_attr_e('Лабораторное оборудование PROTIA', 'alergobot'); ?>" title="<?php esc_attr_e('Лабораторное оборудование PROTIA', 'alergobot'); ?>" width="570" height="298" loading="lazy">
							</div>
						<?php endif; ?>
						<?php if ($cta_note) : ?>
							<p class="devices-cta__note"><?php echo esc_html($cta_note); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
