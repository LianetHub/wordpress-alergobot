<?php

/**
 * Page template: blog-single
 *
 * @package alergobot
 */

$post_id       = get_the_ID();
$intro         = '';

if (function_exists('alergobot_get_blog_intro')) {
	$intro = alergobot_get_blog_intro($post_id);
} else {
	if (function_exists('get_field')) {
		$acf_intro = get_field('intro', $post_id);
		if (is_string($acf_intro) && trim($acf_intro) !== '') {
			$intro = $acf_intro;
		}
	}
	if ($intro === '' && $post_id && has_excerpt($post_id)) {
		$intro = get_the_excerpt($post_id);
	}
}

$recent_query  = null;
$related_query = null;

if ($post_id) {
	if (function_exists('alergobot_query_blogs')) {
		$recent_query = alergobot_query_blogs([
			'posts_per_page' => 6,
			'post__not_in'   => [$post_id],
		]);
	} else {
		$recent_query = new WP_Query([
			'post_type'      => 'blogs',
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'post__not_in'   => [$post_id],
			'orderby'        => 'date',
			'order'          => 'DESC',
		]);
	}

	if (function_exists('alergobot_get_related_blogs_query')) {
		$related_query = alergobot_get_related_blogs_query($post_id, 2);
	} else {
		$related_args = [
			'post_type'      => 'blogs',
			'post_status'    => 'publish',
			'posts_per_page' => 2,
			'post__not_in'   => [$post_id],
			'orderby'        => 'date',
			'order'          => 'DESC',
		];
		$categories = wp_get_post_terms($post_id, 'blog_category', ['fields' => 'ids']);
		if (!empty($categories) && !is_wp_error($categories)) {
			$related_args['tax_query'] = [[
				'taxonomy' => 'blog_category',
				'field'    => 'term_id',
				'terms'    => $categories,
			]];
		}
		$related_query = new WP_Query($related_args);
	}
}

?>
<div class="article">
	<div class="article__container _container">
		<div class="article__layout">
			<header class="article__header" data-animate="bottom">
				<h1 class="article__title title title-lg title--brand"><?php the_title(); ?></h1>
				<?php if ($intro) : ?>
					<div class="article__intro typography-block">
						<?php echo wp_kses_post(wpautop($intro)); ?>
					</div>
				<?php endif; ?>
			</header>
			<?php if (has_post_thumbnail()) : ?>
				<figure class="article__hero" data-animate="bottom">
					<?php
					the_post_thumbnail('large', [
						'class'   => 'article__hero-img',
						'loading' => 'eager',
						'width'   => 407,
						'height'  => 420,
					]);
					?>
				</figure>
			<?php endif; ?>
			<div class="article__body typography-block">
				<?php the_content(); ?>
			</div>
			<?php if ($recent_query instanceof WP_Query && $recent_query->have_posts()) : ?>
				<aside class="article__aside blog-recent" aria-labelledby="article-popular-title">
					<h2 class="blog-recent__heading" id="article-popular-title" data-animate="bottom"><?php esc_html_e('Популярные статьи', 'alergobot'); ?></h2>
					<ul class="blog-recent__list">
						<?php
						while ($recent_query->have_posts()) :
							$recent_query->the_post();
							get_template_part('template-parts/blog/recent', 'item');
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</aside>
			<?php endif; ?>
		</div>
	</div>
	<?php if ($related_query instanceof WP_Query && $related_query->have_posts()) : ?>
		<section class="article-more">
			<div class="article-more__container _container">
				<h2 class="article-more__title title title-md title--brand" data-animate="bottom"><?php esc_html_e('Вас может заинтересовать', 'alergobot'); ?></h2>
				<div class="article-more__grid">
					<?php
					while ($related_query->have_posts()) :
						$related_query->the_post();
						get_template_part('template-parts/blog/related', 'card');
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</div>