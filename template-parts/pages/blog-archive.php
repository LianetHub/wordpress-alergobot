<?php

/**
 * Page template: blog-archive
 *
 * @package alergobot
 */

$context = alergobot_get_blog_archive_context();

$hero_query = alergobot_query_blogs(alergobot_get_blog_archive_base_query_args($context, [
	'posts_per_page' => 1,
]));

$featured_id = 0;
if ($hero_query->have_posts()) {
	$hero_query->the_post();
	$featured_id = get_the_ID();
}

$recent_args = alergobot_get_blog_archive_base_query_args($context, [
	'posts_per_page' => 4,
]);
if ($featured_id) {
	$recent_args['post__not_in'] = [$featured_id];
}
$recent_query = alergobot_query_blogs($recent_args);

$active_tab   = $context['active_tab'];
$active_query = alergobot_query_blogs(alergobot_get_blog_archive_query_args($context, $active_tab));
$current_page = $active_tab === 'news' ? $context['news_paged'] : $context['articles_paged'];

$articles_active = $active_tab === 'articles';
$news_active     = $active_tab === 'news';
$news_base_url   = add_query_arg('tab', 'news', $context['base_url']);

$heading_text = $context['heading_text'];
if ($heading_text === '' && !is_tax() && !is_tag()) {
	$heading_text = __('Актуальные материалы об аллергологии, диагностике и современных решениях для лабораторий.', 'alergobot');
}

?>
<section class="heading heading--blog">
	<div class="heading__container _container">
		<div class="heading__grid">
			<div class="heading__main">
				<h1 class="heading__title title title-lg <?php echo alergobot_anim_class('blur-up', '_anim-no-hide'); ?>"><?php echo esc_html($context['heading_title']); ?></h1>
			</div>
			<?php if ($heading_text) : ?>
				<div class="heading__aside">
					<p class="heading__text <?php echo alergobot_anim_class('fade-up', '_anim-no-hide'); ?>"><?php echo esc_html($heading_text); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<section class="blog-hero">
	<div class="blog-hero__container _container">
		<div class="blog-hero__layout">
			<?php
			if ($featured_id) {
				get_template_part('template-parts/blog/featured');
				wp_reset_postdata();
			}
			?>
			<?php if ($recent_query->have_posts()) : ?>
				<aside class="blog-recent" aria-labelledby="blog-recent-title">
					<h2 class="blog-recent__heading <?php echo alergobot_anim_class('fade-up'); ?>" id="blog-recent-title"><?php esc_html_e('Последние публикации', 'alergobot'); ?></h2>
					<ul class="blog-recent__list <?php echo alergobot_anim_class('stagger'); ?>">
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
</section>
<section
	class="blog-feed"
	data-blog-feed
	data-active-tab="<?php echo esc_attr($active_tab); ?>"
	data-current-page="<?php echo esc_attr((string) $current_page); ?>"
	data-base-url="<?php echo esc_url($context['base_url']); ?>"
	data-archive-term-id="<?php echo esc_attr((string) $context['archive_term_id']); ?>"
	data-tag-id="<?php echo esc_attr((string) $context['tag_id']); ?>">
	<div class="blog-feed__container _container">
		<div class="blog-tabs <?php echo alergobot_anim_class('stagger-x'); ?>" role="tablist" aria-label="<?php esc_attr_e('Тип публикаций', 'alergobot'); ?>">
			<a
				class="blog-tabs__btn<?php echo $articles_active ? ' _active' : ''; ?>"
				role="tab"
				aria-selected="<?php echo $articles_active ? 'true' : 'false'; ?>"
				aria-controls="blog-panel-feed"
				id="blog-tab-articles"
				href="<?php echo esc_url($context['base_url']); ?>"
				data-blog-tab="articles">
				<span class="blog-tabs__text"><?php esc_html_e('Статьи', 'alergobot'); ?></span>
				<span class="blog-tabs__icon" aria-hidden="true">
					<svg class="icon" width="16" height="16">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-tab-plus"></use>
					</svg>
				</span>
			</a>
			<a
				class="blog-tabs__btn<?php echo $news_active ? ' _active' : ''; ?>"
				role="tab"
				aria-selected="<?php echo $news_active ? 'true' : 'false'; ?>"
				aria-controls="blog-panel-feed"
				id="blog-tab-news"
				href="<?php echo esc_url($news_base_url); ?>"
				data-blog-tab="news">
				<span class="blog-tabs__text"><?php esc_html_e('Новости', 'alergobot'); ?></span>
				<span class="blog-tabs__icon" aria-hidden="true">
					<svg class="icon" width="16" height="16">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-tab-plus"></use>
					</svg>
				</span>
			</a>
		</div>
		<div
			class="blog-panel _active"
			id="blog-panel-feed"
			role="tabpanel"
			aria-labelledby="blog-tab-<?php echo esc_attr($active_tab); ?>"
			data-blog-panel>
			<div class="blog-grid <?php echo alergobot_anim_class('stagger'); ?>" data-blog-grid>
				<?php
				if ($active_query->have_posts()) :
					while ($active_query->have_posts()) :
						$active_query->the_post();
						get_template_part('template-parts/blog/card');
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="no-posts">' . esc_html__('Записей не найдено', 'alergobot') . '</p>';
				endif;
				?>
			</div>
		</div>
		<div data-blog-pagination-slot>
			<?php
			alergobot_render_blog_pagination(
				$active_query,
				alergobot_get_blog_archive_pagination_args($context, $active_tab)
			);
			?>
		</div>
	</div>
</section>
