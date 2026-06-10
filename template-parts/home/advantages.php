<?php
/**
 * Home section: advantages (FAQ)
 *
 * @package alergobot
 */

$faq_items = [];

if (function_exists('have_rows') && have_rows('items')) {
	while (have_rows('items')) {
		the_row();
		$faq_items[] = [
			'question' => get_sub_field('question'),
			'answer'   => get_sub_field('answer'),
			'is_open'  => (bool) get_sub_field('is_open'),
		];
	}
}

$faq_col1 = [];
$faq_col2 = [];

foreach ($faq_items as $index => $item) {
	if (($index + 1) % 2 === 0) {
		$faq_col2[] = $item;
	} else {
		$faq_col1[] = $item;
	}
}

$render_faq_item = static function ($item) {
	if (!is_array($item)) {
		return;
	}

	$is_open = !empty($item['is_open']);
	?>
	<div class="accordion__item<?php echo $is_open ? ' _active' : ''; ?>">
		<button class="accordion__header" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
			<span class="accordion__question"><?php echo esc_html($item['question'] ?? ''); ?></span>
			<svg class="accordion__chevron icon" width="32" height="32" aria-hidden="true">
				<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-panels-chevron"></use>
			</svg>
		</button>
		<div class="accordion__body">
			<div class="accordion__inner">
				<p class="accordion__answer"><?php echo nl2br(esc_html($item['answer'] ?? '')); ?></p>
			</div>
		</div>
	</div>
	<?php
};
?>
<section class="faq">
	<div class="faq__container _container">
		<div class="faq__head">
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="faq__tag tag <?php echo alergobot_anim_class('bounce-up'); ?>"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
			<?php if ($title = alergobot_home_get('title')) : ?>
				<h2 class="faq__title title-md <?php echo alergobot_anim_class('fade-up'); ?>"><?php echo nl2br(esc_html($title)); ?></h2>
			<?php endif; ?>
		</div>
		<div class="faq__columns accordion" data-accordion="">
			<?php if ($faq_col1) : ?>
				<div class="faq__col <?php echo alergobot_anim_class('stagger'); ?>">
					<?php foreach ($faq_col1 as $item) {
						$render_faq_item($item);
					} ?>
				</div>
			<?php endif; ?>
			<?php if ($faq_col2) : ?>
				<div class="faq__col <?php echo alergobot_anim_class('stagger'); ?>">
					<?php foreach ($faq_col2 as $item) {
						$render_faq_item($item);
					} ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
