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

$articles_query = alergobot_query_blogs(alergobot_get_blog_archive_query_args($context, 'articles'));
$news_query     = alergobot_query_blogs(alergobot_get_blog_archive_query_args($context, 'news'));

$articles_active = $context['active_tab'] === 'articles';
$news_active     = $context['active_tab'] === 'news';
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
				<h1 class="heading__title title title-lg" data-animate="bottom"><?php echo esc_html($context['heading_title']); ?></h1>
			</div>
			<?php if ($heading_text) : ?>
				<div class="heading__aside">
					<p class="heading__text" data-animate="bottom"><?php echo esc_html($heading_text); ?></p>
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
					<h2 class="blog-recent__heading" id="blog-recent-title" data-animate="bottom"><?php esc_html_e('Последние публикации', 'alergobot'); ?></h2>
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
</section>
<section class="blog-feed">
	<div class="blog-feed__container _container">
		<div class="blog-tabs" role="tablist" aria-label="<?php esc_attr_e('Тип публикаций', 'alergobot'); ?>">
			<button
				class="blog-tabs__btn<?php echo $articles_active ? ' _active' : ''; ?>"
				type="button"
				role="tab"
				aria-selected="<?php echo $articles_active ? 'true' : 'false'; ?>"
				aria-controls="blog-panel-articles"
				id="blog-tab-articles"
				data-blog-tab="articles"
				data-animate="fade">
				<span class="blog-tabs__text"><?php esc_html_e('Статьи', 'alergobot'); ?></span>
				<span class="blog-tabs__icon" aria-hidden="true">
					<svg class="icon" width="16" height="16">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-tab-plus"></use>
					</svg>
				</span>
			</button>
			<button
				class="blog-tabs__btn<?php echo $news_active ? ' _active' : ''; ?>"
				type="button"
				role="tab"
				aria-selected="<?php echo $news_active ? 'true' : 'false'; ?>"
				aria-controls="blog-panel-news"
				id="blog-tab-news"
				data-blog-tab="news"
				data-animate="fade">
				<span class="blog-tabs__text"><?php esc_html_e('Новости', 'alergobot'); ?></span>
				<span class="blog-tabs__icon" aria-hidden="true">
					<svg class="icon" width="16" height="16">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-tab-plus"></use>
					</svg>
				</span>
			</button>
		</div>
		<div
			class="blog-panel<?php echo $articles_active ? ' _active' : ''; ?>"
			id="blog-panel-articles"
			role="tabpanel"
			aria-labelledby="blog-tab-articles"
			data-blog-panel="articles"
			<?php echo $articles_active ? '' : ' hidden'; ?>>
			<div class="blog-grid" data-blog-grid>
				<?php
				if ($articles_query->have_posts()) :
					while ($articles_query->have_posts()) :
						$articles_query->the_post();
						get_template_part('template-parts/blog/card');
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="no-posts">' . esc_html__('Записей не найдено', 'alergobot') . '</p>';
				endif;
				?>
			</div>
		</div>
		<div
			class="blog-panel<?php echo $news_active ? ' _active' : ''; ?>"
			id="blog-panel-news"
			role="tabpanel"
			aria-labelledby="blog-tab-news"
			data-blog-panel="news"
			<?php echo $news_active ? '' : ' hidden'; ?>>
			<div class="blog-grid" data-blog-grid>
				<?php
				if ($news_query->have_posts()) :
					while ($news_query->have_posts()) :
						$news_query->the_post();
						get_template_part('template-parts/blog/card');
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="no-posts">' . esc_html__('Записей не найдено', 'alergobot') . '</p>';
				endif;
				?>
			</div>
		
				
		</div>
		<?php
		alergobot_render_blog_pagination($articles_query, [
			'base_url' => $context['base_url'],
			'current'  => $context['articles_paged'],
			'panel'    => 'articles',
			'hidden'   => !$articles_active,
		]);
		alergobot_render_blog_pagination($news_query, [
			'base_url'   => $news_base_url,
			'current'    => $context['news_paged'],
			'page_param' => 'news_page',
			'panel'      => 'news',
			'hidden'     => !$news_active,
		]);
		?>
	</div>
</section>