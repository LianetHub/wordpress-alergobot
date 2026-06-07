<?php
/**
 * Product description tab
 *
 * @package alergobot
 */

$post_id = get_the_ID();

$panel_lead = (string) alergobot_get_post_field('product_panel_lead', $post_id);
$blocks     = alergobot_get_post_field('product_blocks', $post_id) ?: [];
$allergens  = alergobot_get_post_field('product_allergens', $post_id);

if (!$panel_lead && !$blocks && !$allergens) {
	return;
}

$allergen_rows = is_array($allergens) ? ($allergens['rows'] ?? []) : [];
$is_active     = (bool) get_query_var('product_tab_active');

?>
<div class="product-panel<?php echo $is_active ? ' _active' : ''; ?>" id="product-panel-description" role="tabpanel" aria-labelledby="product-tab-description" data-product-panel="description"<?php echo $is_active ? '' : ' hidden=""'; ?>>
	<div class="product-panel__inner product-panel__inner--description">
		<?php if ($panel_lead) : ?>
			<p class="product-panel__lead" data-animate="bottom"><?php echo esc_html($panel_lead); ?></p>
		<?php endif; ?>
		<?php foreach ($blocks as $block) :
			$block_title = $block['title'] ?? '';
			$block_items = $block['items'] ?? [];
			if (!$block_title && !$block_items) {
				continue;
			}
			?>
			<div class="product-block">
				<?php if ($block_title) : ?>
					<h2 class="product-block__title title title-md-sm" data-animate="bottom"><?php echo esc_html($block_title); ?></h2>
				<?php endif; ?>
				<?php if ($block_items) : ?>
					<ul class="product-list">
						<?php foreach ($block_items as $item) :
							$item_text = $item['text'] ?? '';
							if (!$item_text) {
								continue;
							}
							?>
							<li class="product-list__item" data-animate="bottom"><?php echo esc_html($item_text); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<?php if ($allergens && ($allergens['title'] ?? '') || ($allergens['text'] ?? '') || $allergen_rows) : ?>
			<div class="product-block product-block--allergens">
				<?php if (!empty($allergens['title'])) : ?>
					<h2 class="product-block__title title title-md-sm" data-animate="bottom"><?php echo esc_html($allergens['title']); ?></h2>
				<?php endif; ?>
				<?php if (!empty($allergens['text'])) : ?>
					<p class="product-block__text" data-animate="bottom"><?php echo esc_html($allergens['text']); ?></p>
				<?php endif; ?>
				<?php if ($allergen_rows) : ?>
					<div class="product-table-wrap" data-product-table="" data-animate="bottom">
						<table class="product-table">
							<colgroup>
								<col class="product-table__col-num">
								<col class="product-table__col-name">
								<col class="product-table__col-allergen">
								<col class="product-table__col-code">
							</colgroup>
							<thead>
								<tr>
									<th scope="col">№</th>
									<th scope="col"><?php esc_html_e('Аллерген', 'alergobot'); ?></th>
									<th scope="col">Allergen</th>
									<th scope="col"><?php esc_html_e('Код', 'alergobot'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($allergen_rows as $row_index => $row) : ?>
									<tr>
										<td><?php echo esc_html((string) ($row_index + 1)); ?></td>
										<td><?php echo esc_html($row['name_ru'] ?? ''); ?></td>
										<td><?php echo esc_html($row['name_en'] ?? ''); ?></td>
										<td><?php echo esc_html($row['code'] ?? ''); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
							<tfoot class="product-table__foot">
								<tr>
									<td></td>
									<td>
										<button class="product-table__more" type="button" data-product-table-more="" aria-expanded="false"><?php esc_html_e('ЕЩЕ', 'alergobot'); ?></button>
									</td>
									<td></td>
									<td></td>
								</tr>
							</tfoot>
						</table>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
