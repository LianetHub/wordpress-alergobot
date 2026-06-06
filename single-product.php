<?php
/**
 * Single product
 *
 * @package alergobot
 */

get_header();

while (have_posts()) :
	the_post();

	if (!get_field('use_custom_layout')) {
		get_template_part('template-parts/pages/product', 'single');
	} else {
		?>
		<section class="product-hero">
			<div class="product-hero__container _container">
				<h1 class="product-hero__title title title-lg"><?php the_title(); ?></h1>
				<?php if (has_excerpt()) : ?>
					<p class="product-hero__text"><?php echo esc_html(get_the_excerpt()); ?></p>
				<?php endif; ?>
				<?php the_content(); ?>
			</div>
		</section>
		<?php
		get_template_part('template-parts/product/related');
	}
endwhile;

get_footer();
