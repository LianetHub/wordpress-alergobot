<?php
/**
 * Home section: advantages (FAQ)
 *
 * @package alergobot
 */

$faq_items = alergobot_home_rows('items');
$faq_col1  = array_slice($faq_items, 0, 4);
$faq_col2  = array_slice($faq_items, 4);

$render_faq_item = static function (array $item) {
	$is_open = !empty($item['is_open']);
	?>
	<div class="accordion__item<?php echo $is_open ? ' _active' : ''; ?>" data-animate="bottom">
		<button class="accordion__header" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
			<span class="accordion__question"><?php echo esc_html($item['question'] ?? ''); ?></span>
			<svg class="accordion__chevron icon" width="32" height="32" aria-hidden="true">
				<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-panels-chevron"></use>
			</svg>
		</button>
		<div class="accordion__body">
			<div class="accordion__inner">
				<p class="accordion__answer"><?php echo esc_html($item['answer'] ?? ''); ?></p>
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
				<span class="faq__tag tag" data-animate="scale"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
			<?php if ($title = alergobot_home_get('title')) : ?>
				<h2 class="faq__title title-md" data-animate="bottom"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
		</div>
		<div class="faq__columns accordion" data-accordion="">
			<?php if ($faq_col1) : ?>
				<div class="faq__col">
					<?php foreach ($faq_col1 as $item) {
						$render_faq_item($item);
					} ?>
				</div>
			<?php endif; ?>
			<?php if ($faq_col2) : ?>
				<div class="faq__col">
					<?php foreach ($faq_col2 as $item) {
						$render_faq_item($item);
					} ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
