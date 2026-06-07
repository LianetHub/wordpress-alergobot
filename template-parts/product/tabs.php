<?php
/**
 * Product tabs wrapper
 *
 * @package alergobot
 */

$post_id = get_the_ID();
$icons   = alergobot_assets_uri('img/icons.svg');

$has_description = alergobot_product_has_description_tab($post_id);
$has_ru          = alergobot_product_has_ru_tab($post_id);
$has_video       = alergobot_product_has_video_tab($post_id);
$has_docs        = alergobot_product_has_docs_tab($post_id);

if (!$has_description && !$has_ru && !$has_video && !$has_docs) {
	return;
}

$tabs = [];
if ($has_description) {
	$tabs[] = ['id' => 'description', 'label' => __('Описание', 'alergobot')];
}
if ($has_ru) {
	$tabs[] = ['id' => 'ru', 'label' => __('РУ / КТРУ', 'alergobot')];
}
if ($has_video) {
	$tabs[] = ['id' => 'video', 'label' => __('Видео', 'alergobot')];
}
if ($has_docs) {
	$tabs[] = ['id' => 'docs', 'label' => __('Документы', 'alergobot')];
}

?>
<section class="product-detail">
	<div class="product-detail__container _container">
		<div class="product-tabs" role="tablist" aria-label="<?php esc_attr_e('Разделы товара', 'alergobot'); ?>">
			<?php foreach ($tabs as $index => $tab) :
				$tab_id = $tab['id'];
				$active = $index === 0;
				?>
				<button class="product-tabs__btn<?php echo $active ? ' _active' : ''; ?>" type="button" role="tab" id="product-tab-<?php echo esc_attr($tab_id); ?>" aria-selected="<?php echo $active ? 'true' : 'false'; ?>" aria-controls="product-panel-<?php echo esc_attr($tab_id); ?>" data-product-tab="<?php echo esc_attr($tab_id); ?>" data-animate="fade">
					<span class="product-tabs__text"><?php echo esc_html($tab['label']); ?></span>
					<span class="product-tabs__icon" aria-hidden="true">
						<svg class="icon" width="16" height="16">
							<use href="<?php echo esc_url($icons); ?>#icon-tab-plus"></use>
						</svg>
					</span>
				</button>
			<?php endforeach; ?>
		</div>
		<div class="product-panels">
			<?php
			foreach ($tabs as $index => $tab) {
				set_query_var('product_tab_active', $index === 0);
				get_template_part('template-parts/product/tab', $tab['id']);
			}
			?>
		</div>
	</div>
</section>
