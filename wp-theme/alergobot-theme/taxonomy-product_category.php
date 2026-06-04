<?php
/**
 * Product category archive
 *
 * @package alergobot
 */

get_header();

$term = get_queried_object();
?>
<main class="page page--catalog">
	<section class="heading">
		<div class="heading__container _container">
			<h1 class="heading__title title title-lg"><?php echo esc_html($term->name); ?></h1>
			<?php if ($term->description) : ?>
				<p class="heading__text"><?php echo esc_html($term->description); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<section class="category">
		<div class="category__container _container">
			<div class="category__grid">
				<?php
				if (have_posts()) :
					while (have_posts()) :
						the_post();
						get_template_part('template-parts/product/card');
					endwhile;
				else :
					echo '<p>' . esc_html__('В этой категории пока нет продуктов.', 'alergobot') . '</p>';
				endif;
				?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
