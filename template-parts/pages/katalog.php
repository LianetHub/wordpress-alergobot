<?php

/**
 * Page template: katalog
 *
 * @package alergobot
 */

$page_id = get_the_ID();
$icons   = alergobot_assets_uri('img/icons.svg');

$heading_title = function_exists('get_field') ? (string) get_field('catalog_heading_title', $page_id) : '';
$heading_text  = function_exists('get_field') ? (string) get_field('catalog_heading_text', $page_id) : '';
$heading_tags  = alergobot_get_product_category_terms();
$sections      = function_exists('get_field') ? (array) get_field('catalog_sections', $page_id) : [];
$faq_items     = function_exists('get_field') ? (array) get_field('catalog_faq', $page_id) : [];

$request_title = function_exists('get_field') ? (string) get_field('catalog_request_title', $page_id) : '';
$request_note  = function_exists('get_field') ? (string) get_field('catalog_request_note', $page_id) : '';
$request_lead  = function_exists('get_field') ? (string) get_field('catalog_request_lead', $page_id) : '';

[$faq_col1, $faq_col2] = alergobot_split_faq_columns($faq_items);

$has_request = $request_title || $request_note || $request_lead;

?><section class="heading heading--catalog">
	<div class="heading__container _container">
		<div class="heading__wrapper">
			<div class="heading__points" aria-hidden="true">
				<span class="heading__point"></span><span class="heading__point"></span><span class="heading__point"></span><span class="heading__point"></span>
			</div>
			<?php if ($heading_title) : ?>
				<h1 class="heading__title title title-lg" data-animate="bottom"><?php echo esc_html($heading_title); ?></h1>
			<?php endif; ?>
			<div class="heading__grid">
				<div class="heading__main">
					<a class="btn btn--primary heading__cta" href="#catalog-request" data-animate="bottom">
						<?php esc_html_e('Задать вопрос', 'alergobot'); ?>
						<svg class="btn__icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url($icons); ?>#icon-arrow-up-right"></use>
						</svg>
					</a>
					<?php if ($heading_tags) : ?>
						<ul class="heading__tags">
							<?php foreach ($heading_tags as $term) :
								if (!($term instanceof WP_Term)) {
									continue;
								}

								$tag_url = get_term_link($term);
								if (is_wp_error($tag_url)) {
									continue;
								}
								?>
								<li class="heading__tags-item">
									<a class="heading__tag" href="<?php echo esc_url($tag_url); ?>" data-animate="scale">
										<?php echo esc_html($term->name); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<?php if ($heading_text) : ?>
					<div class="heading__aside">
						<div class="heading__text" data-animate="bottom">
							<?php echo wp_kses_post($heading_text); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php foreach ($sections as $section) :
	$section_id    = $section['section_id'] ?? '';
	$section_class = 'catalog' . (!empty($section['is_reverse']) ? ' catalog--reverse' : '');
	$section_title = $section['title'] ?? '';
	$section_text  = $section['text'] ?? '';
	$section_btn   = $section['btn'] ?? null;
	$section_tag   = $section['tag'] ?? '';
	$gallery       = $section['gallery'] ?? [];
	$btn_url       = is_array($section_btn) ? alergobot_acf_link_url($section_btn, '') : '';
	$btn_title     = is_array($section_btn) ? alergobot_acf_link_title($section_btn, '') : '';

	if (!$section_title && !$section_text && !$btn_url && !$section_tag && !$gallery) {
		continue;
	}
?>
	<section class="<?php echo esc_attr($section_class); ?>" <?php echo $section_id ? ' id="' . esc_attr($section_id) . '"' : ''; ?>>
		<div class="catalog__container _container">
			<div class="catalog__main">
				<div class="catalog__info">
					<?php if ($section_title) : ?>
						<h2 class="catalog__title title title-md" data-animate="bottom"><?php echo esc_html($section_title); ?></h2>
					<?php endif; ?>
					<?php if ($section_text) : ?>
						<p class="catalog__text" data-animate="bottom"><?php echo esc_html($section_text); ?></p>
					<?php endif; ?>
					<?php if ($btn_url && $btn_title) : ?>
						<a class="btn btn--primary catalog__btn" href="<?php echo esc_url($btn_url); ?>" data-animate="bottom" <?php echo alergobot_acf_link_target($section_btn) ? ' target="' . esc_attr(alergobot_acf_link_target($section_btn)) . '"' : ''; ?>>
							<?php echo esc_html($btn_title); ?>
							<svg class="btn__icon" width="28" height="28">
								<use href="<?php echo esc_url($icons); ?>#icon-arrow-up-right"></use>
							</svg>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="catalog__side">
				<?php if ($section_tag) : ?>
					<span class="tag catalog__tag" data-animate="scale"><?php echo esc_html($section_tag); ?></span>
				<?php endif; ?>
				<?php if ($gallery) : ?>
					<div class="catalog__gallery" data-decor-parallax="">
						<?php foreach ($gallery as $gallery_item) :
							$image = $gallery_item['image'] ?? null;
							$link  = $gallery_item['link'] ?? null;
							$img_url = alergobot_acf_image_url($image);
							if (!$img_url) {
								continue;
							}
							$img_alt = is_array($image) ? ($image['alt'] ?? '') : '';
							$img_w   = is_array($image) ? ($image['width'] ?? '') : '';
							$img_h   = is_array($image) ? ($image['height'] ?? '') : '';
							$link_url = is_array($link) ? alergobot_acf_link_url($link, '') : '';
						?>
							<?php if ($link_url) : ?>
								<a href="<?php echo esc_url($link_url); ?>" class="catalog__product" data-animate="bottom">
									<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" title="<?php echo esc_attr($img_alt); ?>" <?php echo $img_w ? ' width="' . esc_attr((string) $img_w) . '"' : ''; ?><?php echo $img_h ? ' height="' . esc_attr((string) $img_h) . '"' : ''; ?> loading="lazy">
								</a>
							<?php else : ?>
								<div class="catalog__product" data-animate="bottom">
									<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" title="<?php echo esc_attr($img_alt); ?>" <?php echo $img_w ? ' width="' . esc_attr((string) $img_w) . '"' : ''; ?><?php echo $img_h ? ' height="' . esc_attr((string) $img_h) . '"' : ''; ?> loading="lazy">
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endforeach; ?>
<?php if ($has_request) : ?>
	<section class="request request--plain" id="catalog-request">
		<div class="request__box">
			<div class="request__container _container">
				<div class="request__grid">
					<?php if ($request_title || $request_note) : ?>
						<div class="request__info">
							<?php if ($request_title) : ?>
								<h2 class="request__title title title-md title--light" data-animate="bottom"><?php echo esc_html($request_title); ?></h2>
							<?php endif; ?>
							<?php if ($request_note) : ?>
								<div class="request__note" data-animate="bottom">
									<span class="request__note-icon" aria-hidden="true">
										<svg class="request__note-icon-svg" width="50" height="50" aria-hidden="true">
											<use href="<?php echo esc_url($icons); ?>#icon-request-chat"></use>
										</svg>
									</span>
									<p class="request__note-text"><?php echo esc_html($request_note); ?></p>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="request__form-col">
						<?php if ($request_lead) : ?>
							<p class="request__lead" data-animate="bottom"><?php echo esc_html($request_lead); ?></p>
						<?php endif; ?>
						<div class="request__form form" data-animate="bottom">
							<?php alergobot_cf7_form('cf7_zakaz'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php if ($faq_col1 || $faq_col2) : ?>
	<section class="faq">
		<div class="faq__container _container">
			<div class="faq__head">
				<span class="faq__tag tag" data-animate="scale">FAQ</span>
				<h2 class="faq__title title-md" data-animate="bottom"><?php esc_html_e('Информация по часто задаваемым вопросам', 'alergobot'); ?></h2>
			</div>
			<div class="faq__columns accordion" data-accordion="">
				<?php foreach ([$faq_col1, $faq_col2] as $column_index => $column_items) : ?>
					<?php if (!$column_items) {
						continue;
					} ?>
					<div class="faq__col">
						<?php foreach ($column_items as $item_index => $item) :
							$question = $item['question'] ?? '';
							$answer   = $item['answer'] ?? '';
							if (!$question) {
								continue;
							}
							$is_active = $column_index === 0 && $item_index === 0;
						?>
							<div class="accordion__item<?php echo $is_active ? ' _active' : ''; ?>" data-animate="bottom">
								<button class="accordion__header" type="button" aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>">
									<span class="accordion__question"><?php echo esc_html($question); ?></span>
									<svg class="accordion__chevron icon" width="32" height="32" aria-hidden="true">
										<use href="<?php echo esc_url($icons); ?>#icon-panels-chevron"></use>
									</svg>
								</button>
								<?php if ($answer) : ?>
									<div class="accordion__body">
										<div class="accordion__inner">
											<p class="accordion__answer"><?php echo esc_html($answer); ?></p>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>