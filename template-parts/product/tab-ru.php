<?php
/**
 * Product RU / KTRU tab
 *
 * @package alergobot
 */

$post_id = get_the_ID();

$specs   = function_exists('get_field') ? get_field('product_ru_specs', $post_id) : [];
$ru_file = function_exists('get_field') ? get_field('product_ru_file', $post_id) : null;

if (!$specs && !$ru_file) {
	return;
}

$is_active = (bool) get_query_var('product_tab_active');

?>
<div class="product-panel<?php echo $is_active ? ' _active' : ''; ?>" id="product-panel-ru" role="tabpanel" aria-labelledby="product-tab-ru" data-product-panel="ru"<?php echo $is_active ? '' : ' hidden=""'; ?>>
	<div class="product-panel__inner product-panel__inner--ru">
		<h2 class="product-panel__heading" data-animate="bottom"><?php esc_html_e('Регистрационное удостоверение', 'alergobot'); ?></h2>
		<?php if ($specs) : ?>
			<dl class="product-spec">
				<?php foreach ($specs as $spec) :
					$term  = $spec['term'] ?? '';
					$value = $spec['value'] ?? '';
					if (!$term) {
						continue;
					}

					$is_download_row = is_array($ru_file) && !empty($ru_file['url'])
						&& ($value === '' || $term === __('Скачать РУ', 'alergobot'));
					if (!$value && !$is_download_row) {
						continue;
					}
					?>
					<div class="product-spec__row" data-animate="bottom">
						<dt class="product-spec__term"><?php echo esc_html($term); ?></dt>
						<dd class="product-spec__value">
							<?php if ($is_download_row) : ?>
								<a class="product-spec__link" href="<?php echo esc_url($ru_file['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($ru_file['filename'] ?? $ru_file['title'] ?? ''); ?></a>
							<?php else : ?>
								<?php echo nl2br(esc_html($value)); ?>
							<?php endif; ?>
						</dd>
					</div>
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>
	</div>
</div>
