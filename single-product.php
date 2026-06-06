<?php
/**
 * Single product
 *
 * @package alergobot
 */

get_header();

while (have_posts()) :
	the_post();
	?>
	<main class="page page--product">
		<?php
		if (file_exists(ALERGOBOT_DIR . '/inc/markup/pages/product.html') && !get_field('use_custom_layout')) {
			alergobot_render_page_markup('product.html');
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
		?>
	</main>
	<?php
endwhile;

get_footer();
