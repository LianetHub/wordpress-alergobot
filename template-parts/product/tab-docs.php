<?php
/**
 * Product documents tab
 *
 * @package alergobot
 */

$post_id = get_the_ID();
$icons   = alergobot_assets_uri('img/icons.svg');

$docs = alergobot_get_post_field('product_docs', $post_id) ?: [];

if (!$docs) {
	return;
}

$is_active = (bool) get_query_var('product_tab_active');

?>
<div class="product-panel<?php echo $is_active ? ' _active' : ''; ?>" id="product-panel-docs" role="tabpanel" aria-labelledby="product-tab-docs" data-product-panel="docs"<?php echo $is_active ? '' : ' hidden=""'; ?>>
	<div class="product-panel__inner product-panel__inner--docs <?php echo alergobot_anim_class('stagger'); ?>">
		<?php foreach ($docs as $doc) :
			$file    = $doc['file'] ?? null;
			$name    = $doc['name'] ?? '';
			$preview = $doc['preview'] ?? null;

			if (!is_array($file) || empty($file['url'])) {
				continue;
			}

			$file_url      = $file['url'];
			$file_name     = $name ?: ($file['filename'] ?? $file['title'] ?? '');
			$file_size     = alergobot_format_file_size($file['filesize'] ?? 0);
			$preview_url   = alergobot_acf_image_url($preview);
			$download_name = $file['filename'] ?? '';
			$tooltip       = $doc['tooltip'] ?? __('Скачать', 'alergobot');
			?>
			<a class="product-doc" href="<?php echo esc_url($file_url); ?>"<?php echo $download_name ? ' download="' . esc_attr($download_name) . '"' : ' download'; ?> rel="noopener noreferrer">
				<span class="product-doc__main">
					<?php if ($preview_url) : ?>
						<span class="product-doc__preview">
							<img src="<?php echo esc_url($preview_url); ?>" alt="" title="" width="48" height="70" loading="lazy" aria-hidden="true">
						</span>
					<?php endif; ?>
					<span class="product-doc__name"><?php echo esc_html($file_name); ?></span>
					<?php if ($file_size) : ?>
						<span class="product-doc__size"><?php echo esc_html($file_size); ?></span>
					<?php endif; ?>
				</span>
				<span class="product-doc__icon tooltip-trigger" data-tooltip="<?php echo esc_attr($tooltip); ?>" aria-label="<?php echo esc_attr($tooltip); ?>" aria-expanded="false">
					<svg class="icon" width="36" height="36" aria-hidden="true">
						<use href="<?php echo esc_url($icons); ?>#icon-eye-info"></use>
					</svg>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</div>
