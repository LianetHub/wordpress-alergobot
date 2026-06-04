<?php
/**
 * Related products
 *
 * @package alergobot
 */

$related = function_exists('get_field') ? get_field('related_products') : null;
if (empty($related)) {
	return;
}
?>
<section class="product-related">
	<div class="product-related__container _container">
		<h2 class="product-related__title title"><?php esc_html_e('Похожие решения', 'alergobot'); ?></h2>
		<div class="product-related__grid">
			<?php foreach ($related as $post) : ?>
				<?php setup_postdata($post); ?>
				<?php get_template_part('template-parts/product/card'); ?>
			<?php endforeach; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
