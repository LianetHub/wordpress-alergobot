<?php

/**
 * Template helpers
 *
 * @package alergobot
 */

if (!function_exists('alergobot_anim_class')) {
	function alergobot_anim_class(string $type = 'fade-up', string $extra = ''): string
	{
		return esc_attr(trim("_anim-items a-{$type} {$extra}"));
	}
}

if (!function_exists('alergobot_anim_wrap_open')) {
	/**
	 * Open a wrapper for scroll/enter animations (keeps hover/transform on inner controls).
	 *
	 * @param string $type     Animation type without `a-` prefix.
	 * @param string $extra    Extra classes, e.g. `_anim-no-hide`.
	 * @param string $modifier Layout helper: `inline`, `fill`, or empty for block.
	 */
	function alergobot_anim_wrap_open(string $type = 'fade-up', string $extra = '', string $modifier = ''): string
	{
		$modifier_class = $modifier ? ' anim-wrap--' . sanitize_html_class($modifier) : '';
		$classes        = trim('anim-wrap' . $modifier_class . " _anim-items a-{$type} {$extra}");

		return '<div class="' . esc_attr($classes) . '">';
	}
}

if (!function_exists('alergobot_anim_wrap_close')) {
	function alergobot_anim_wrap_close(): string
	{
		return '</div>';
	}
}

if (!function_exists('alergobot_blogs_archive_url')) {
	function alergobot_blogs_archive_url()
	{
		$link = get_post_type_archive_link('blogs');

		return $link ? $link : home_url('/stati-po-allergologii/');
	}
}

if (!function_exists('alergobot_query_blogs')) {
	function alergobot_query_blogs($args = [])
	{
		$defaults = [
			'post_type'      => 'blogs',
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'ignore_sticky_posts' => true,
		];

		return new WP_Query(array_merge($defaults, $args));
	}
}

if (!function_exists('alergobot_get_blog_category_term_id')) {
	function alergobot_get_blog_category_term_id($slug)
	{
		$term = get_term_by('slug', $slug, 'blog_category');

		return ($term && !is_wp_error($term)) ? (int) $term->term_id : 0;
	}
}

if (!function_exists('alergobot_get_blog_badge_label')) {
	function alergobot_get_blog_badge_label($post_id = 0)
	{
		$post_id = $post_id ?: get_the_ID();
		$terms   = wp_get_post_terms($post_id, 'blog_category', ['fields' => 'slugs']);

		if (!is_wp_error($terms) && in_array('novosti', $terms, true)) {
			return __('Новость', 'alergobot');
		}

		return __('Статья', 'alergobot');
	}
}

if (!function_exists('alergobot_get_blog_archive_context')) {
	function alergobot_get_blog_archive_context()
	{
		$context = [
			'active_tab'       => 'articles',
			'heading_title'    => __('Статьи и новости', 'alergobot'),
			'heading_text'     => '',
			'archive_taxonomy' => '',
			'archive_term_id'  => 0,
			'archive_term_slug'=> '',
			'tag_id'           => 0,
			'base_url'         => alergobot_blogs_archive_url(),
			'articles_term_id' => alergobot_get_blog_category_term_id('stati'),
			'news_term_id'     => alergobot_get_blog_category_term_id('novosti'),
			'posts_per_page'   => max(1, (int) get_option('posts_per_page', 9)),
			'articles_paged'   => max(1, (int) get_query_var('paged'), (int) get_query_var('page')),
			'news_paged'       => isset($_GET['news_page']) ? max(1, absint($_GET['news_page'])) : 1,
		];

		if (is_tax('blog_category')) {
			$term = get_queried_object();
			if ($term instanceof WP_Term) {
				$context['archive_taxonomy']  = 'blog_category';
				$context['archive_term_id']   = (int) $term->term_id;
				$context['archive_term_slug'] = $term->slug;
				$context['heading_title']     = $term->name;
				$context['heading_text']      = (string) $term->description;
				$context['base_url']          = get_term_link($term);
				$context['active_tab']        = $term->slug === 'novosti' ? 'news' : 'articles';
			}
		} elseif (is_tag()) {
			$tag = get_queried_object();
			if ($tag instanceof WP_Term) {
				$context['tag_id']        = (int) $tag->term_id;
				$context['heading_title'] = sprintf(
					/* translators: %s: tag name */
					__('Метка: %s', 'alergobot'),
					$tag->name
				);
				$context['base_url'] = get_term_link($tag);
			}
		} elseif (isset($_GET['tab']) && sanitize_key(wp_unslash($_GET['tab'])) === 'news') {
			$context['active_tab'] = 'news';
		}

		return $context;
	}
}

if (!function_exists('alergobot_get_blog_archive_context_from_request')) {
	function alergobot_get_blog_archive_context_from_request(array $overrides = [])
	{
		$context = alergobot_get_blog_archive_context();
		$tab     = isset($overrides['tab']) ? sanitize_key($overrides['tab']) : '';

		if ($tab === 'news' || $tab === 'articles') {
			$context['active_tab'] = $tab;
		}

		if (isset($overrides['page'])) {
			$page = max(1, absint($overrides['page']));

			if ($context['active_tab'] === 'news') {
				$context['news_paged'] = $page;
			} else {
				$context['articles_paged'] = $page;
			}
		}

		if (!empty($overrides['archive_term_id'])) {
			$term_id = absint($overrides['archive_term_id']);
			$term    = get_term($term_id, 'blog_category');

			if ($term && !is_wp_error($term)) {
				$context['archive_taxonomy']  = 'blog_category';
				$context['archive_term_id']   = $term_id;
				$context['archive_term_slug'] = $term->slug;
			}
		}

		if (!empty($overrides['tag_id'])) {
			$context['tag_id'] = absint($overrides['tag_id']);
		}

		if (!empty($overrides['base_url'])) {
			$context['base_url'] = esc_url_raw($overrides['base_url']);
		}

		return $context;
	}
}

if (!function_exists('alergobot_get_blog_archive_pagination_args')) {
	function alergobot_get_blog_archive_pagination_args(array $context, $tab = 'articles')
	{
		$news_base_url = add_query_arg('tab', 'news', $context['base_url']);

		if ($tab === 'news') {
			return [
				'base_url'   => $news_base_url,
				'current'    => $context['news_paged'],
				'page_param' => 'news_page',
				'panel'      => 'news',
			];
		}

		return [
			'base_url' => $context['base_url'],
			'current'  => $context['articles_paged'],
			'panel'    => 'articles',
		];
	}
}

if (!function_exists('alergobot_get_blog_archive_base_query_args')) {
	function alergobot_get_blog_archive_base_query_args(array $context, array $extra = [])
	{
		$args      = array_merge(['paged' => 1], $extra);
		$tax_query = [];

		if ($context['archive_taxonomy'] === 'blog_category' && $context['archive_term_id']) {
			$tax_query[] = [
				'taxonomy' => 'blog_category',
				'field'    => 'term_id',
				'terms'    => $context['archive_term_id'],
			];
		}

		if ($context['tag_id']) {
			$tax_query[] = [
				'taxonomy' => 'post_tag',
				'field'    => 'term_id',
				'terms'    => $context['tag_id'],
			];
		}

		if ($tax_query) {
			$args['tax_query'] = count($tax_query) > 1
				? array_merge(['relation' => 'AND'], $tax_query)
				: $tax_query;
		}

		return $args;
	}
}

if (!function_exists('alergobot_get_blog_archive_query_args')) {
	function alergobot_get_blog_archive_query_args(array $context, $tab = 'articles', array $extra = [])
	{
		$args = [
			'posts_per_page' => $context['posts_per_page'],
			'paged'          => $tab === 'news' ? $context['news_paged'] : $context['articles_paged'],
		];

		$tab_slug      = $tab === 'news' ? 'novosti' : 'stati';
		$tab_term_id   = $tab === 'news' ? $context['news_term_id'] : $context['articles_term_id'];
		$archive_match = $context['archive_taxonomy'] === 'blog_category'
			&& $context['archive_term_slug'] === $tab_slug;
		$tax_query     = [];

		if ($archive_match && $context['archive_term_id']) {
			$tax_query[] = [
				'taxonomy' => 'blog_category',
				'field'    => 'term_id',
				'terms'    => $context['archive_term_id'],
			];
		} elseif ($tab_term_id) {
			$tax_query[] = [
				'taxonomy' => 'blog_category',
				'field'    => 'term_id',
				'terms'    => $tab_term_id,
			];
		}

		if ($context['tag_id']) {
			$tax_query[] = [
				'taxonomy' => 'post_tag',
				'field'    => 'term_id',
				'terms'    => $context['tag_id'],
			];
		}

		if ($tax_query) {
			$args['tax_query'] = count($tax_query) > 1
				? array_merge(['relation' => 'AND'], $tax_query)
				: $tax_query;
		}

		return array_merge($args, $extra);
	}
}

if (!function_exists('alergobot_render_blog_pagination')) {
	function alergobot_render_blog_pagination(WP_Query $query, array $args = [])
	{
		$total = (int) $query->max_num_pages;
		if ($total <= 1) {
			return;
		}

		$defaults = [
			'base_url'   => alergobot_blogs_archive_url(),
			'current'    => 1,
			'page_param' => '',
			'panel'      => '',
			'hidden'     => false,
		];
		$args     = array_merge($defaults, $args);
		$current  = max(1, min((int) $args['current'], $total));
		$base_url = $args['base_url'];

		$page_url = static function ($page) use ($base_url, $args) {
			if ($page <= 1) {
				return $args['page_param'] ? remove_query_arg($args['page_param'], $base_url) : $base_url;
			}

			if ($args['page_param']) {
				return add_query_arg($args['page_param'], $page, $base_url);
			}

			return trailingslashit($base_url) . 'page/' . $page . '/';
		};

		$pages = [1];
		if ($total > 1) {
			$start = max(2, $current - 1);
			$end   = min($total - 1, $current + 1);

			if ($start > 2) {
				$pages[] = 'dots';
			}

			for ($page = $start; $page <= $end; $page++) {
				$pages[] = $page;
			}

			if ($end < $total - 1) {
				$pages[] = 'dots';
			}

			$pages[] = $total;
		}

		$pages = array_values(array_unique($pages, SORT_REGULAR));
		?>
		<nav
			class="blog-pagination <?php echo alergobot_anim_class('fade-up'); ?>"
			aria-label="<?php esc_attr_e('Навигация по страницам', 'alergobot'); ?>"
			<?php if ($args['panel']) : ?>
				data-blog-pagination="<?php echo esc_attr($args['panel']); ?>"
			<?php endif; ?>
			<?php echo $args['hidden'] ? ' hidden' : ''; ?>
		>
			<?php if ($current > 1) : ?>
				<a class="blog-pagination__arrow blog-pagination__arrow--prev" href="<?php echo esc_url($page_url($current - 1)); ?>" data-blog-page="<?php echo esc_attr((string) ($current - 1)); ?>" aria-label="<?php esc_attr_e('Предыдущая страница', 'alergobot'); ?>">
					<svg class="icon" width="21.5" height="21.5" aria-hidden="true">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-pagination-arrow"></use>
					</svg>
				</a>
			<?php endif; ?>
			<ol class="blog-pagination__list">
				<?php foreach ($pages as $page) : ?>
					<?php if ($page === 'dots') : ?>
						<li><span class="blog-pagination__num blog-pagination__num--dots" aria-hidden="true">...</span></li>
						<?php continue; ?>
					<?php endif; ?>
					<li>
						<?php if ((int) $page === $current) : ?>
							<span class="blog-pagination__num _active" aria-current="page"><?php echo esc_html((string) $page); ?></span>
						<?php else : ?>
							<a class="blog-pagination__num" href="<?php echo esc_url($page_url((int) $page)); ?>" data-blog-page="<?php echo esc_attr((string) $page); ?>"><?php echo esc_html((string) $page); ?></a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
			<?php if ($current < $total) : ?>
				<a class="blog-pagination__arrow blog-pagination__arrow--next" href="<?php echo esc_url($page_url($current + 1)); ?>" data-blog-page="<?php echo esc_attr((string) ($current + 1)); ?>" aria-label="<?php esc_attr_e('Следующая страница', 'alergobot'); ?>">
					<svg class="icon" width="21.5" height="21.5" aria-hidden="true">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-pagination-arrow"></use>
					</svg>
				</a>
			<?php endif; ?>
		</nav>
		<?php
	}
}

if (!function_exists('alergobot_get_related_blogs_query')) {
	function alergobot_get_related_blogs_query($post_id = 0, $limit = 2)
	{
		$post_id = $post_id ?: get_the_ID();
		$args    = [
			'posts_per_page' => $limit,
			'post__not_in'   => [$post_id],
		];

		$categories = wp_get_post_terms($post_id, 'blog_category', ['fields' => 'ids']);
		if (!empty($categories) && !is_wp_error($categories)) {
			$args['tax_query'] = [[
				'taxonomy' => 'blog_category',
				'field'    => 'term_id',
				'terms'    => $categories,
			]];
		}

		return alergobot_query_blogs($args);
	}
}

if (!function_exists('alergobot_get_blog_intro')) {
	function alergobot_get_blog_intro($post_id = 0)
	{
		$post_id = $post_id ?: get_the_ID();
		$intro   = '';

		if (function_exists('get_field')) {
			$acf_intro = get_field('intro', $post_id);
			if (is_string($acf_intro) && trim($acf_intro) !== '') {
				$intro = $acf_intro;
			}
		}

		if ($intro === '' && $post_id && has_excerpt($post_id)) {
			$intro = get_the_excerpt($post_id);
		}

		return is_string($intro) ? $intro : '';
	}
}

if (!function_exists('alergobot_privacy_policy_url')) {
	function alergobot_privacy_policy_url()
	{
		$page = get_page_by_path('privacy-policy');

		return $page ? get_permalink($page) : home_url('/privacy-policy/');
	}
}

if (!function_exists('alergobot_home_get')) {
	function alergobot_home_get($key, $default = '')
	{
		if (function_exists('get_sub_field')) {
			$value = get_sub_field($key);
			if ($value !== null && $value !== '' && $value !== false) {
				return $value;
			}
		}

		return $default;
	}
}

if (!function_exists('alergobot_home_rows')) {
	function alergobot_home_rows($key)
	{
		static $cache = [];

		if (!function_exists('get_sub_field')) {
			return [];
		}

		$context = 'default';
		if (function_exists('get_row_layout') && function_exists('get_row_index')) {
			$context = get_row_layout() . ':' . get_row_index();
		}

		$cache_key = $context . ':' . $key;
		if (isset($cache[$cache_key])) {
			return $cache[$cache_key];
		}

		$value = get_sub_field($key);
		if (!is_array($value) || $value === []) {
			$cache[$cache_key] = [];
		} else {
			$cache[$cache_key] = array_values($value);
		}

		return $cache[$cache_key];
	}
}

if (!function_exists('alergobot_acf_link_url')) {
	function alergobot_acf_link_url($link, $fallback = '#')
	{
		if (!is_array($link) || empty($link['url'])) {
			return $fallback;
		}

		return alergobot_resolve_link($link['url']);
	}
}

if (!function_exists('alergobot_acf_link_title')) {
	function alergobot_acf_link_title($link, $fallback = '')
	{
		if (!is_array($link)) {
			return $fallback;
		}

		return (string) ($link['title'] ?? $fallback);
	}
}

if (!function_exists('alergobot_acf_link_target')) {
	function alergobot_acf_link_target($link)
	{
		if (!is_array($link) || empty($link['target'])) {
			return '';
		}

		return (string) $link['target'];
	}
}

if (!function_exists('alergobot_normalize_link')) {
	function alergobot_normalize_link($link)
	{
		if (is_array($link)) {
			return trim((string) ($link['url'] ?? ''));
		}

		return trim((string) $link);
	}
}

if (!function_exists('alergobot_resolve_link')) {
	function alergobot_resolve_link($link)
	{
		$link = alergobot_normalize_link($link);
		if ($link === '' || $link === '#') {
			return $link;
		}
		if (str_starts_with($link, '#') || str_starts_with($link, 'mailto:') || str_starts_with($link, 'tel:')) {
			return $link;
		}
		if (preg_match('#^https?://#i', $link)) {
			return $link;
		}

		return home_url('/' . ltrim($link, '/'));
	}
}

if (!function_exists('alergobot_esc_link')) {
	function alergobot_esc_link($link)
	{
		$resolved = alergobot_resolve_link($link);

		if (str_starts_with($resolved, '#')) {
			return esc_attr($resolved);
		}

		return esc_url($resolved);
	}
}

if (!function_exists('alergobot_catalog_url')) {
	function alergobot_catalog_url()
	{
		$page = get_page_by_path('oborudovanie');

		if ($page) {
			return get_permalink($page);
		}

		return home_url('/oborudovanie/');
	}
}

if (!function_exists('alergobot_get_product_category_term_id')) {
	function alergobot_get_product_category_term_id($slug)
	{
		$term = get_term_by('slug', $slug, 'product_category');

		return ($term && !is_wp_error($term)) ? (int) $term->term_id : 0;
	}
}

if (!function_exists('alergobot_get_product_category_link')) {
	function alergobot_get_product_category_link($slug, $fallback = '')
	{
		if (!alergobot_get_product_category_term_id($slug)) {
			return $fallback ?: alergobot_catalog_url();
		}

		return home_url(user_trailingslashit('oborudovanie/' . $slug));
	}
}

if (!function_exists('alergobot_get_product_category_terms')) {
	/**
	 * Product catalog categories in display order.
	 *
	 * @return WP_Term[]
	 */
	function alergobot_get_product_category_terms()
	{
		$order = ['ustroystva', 'analizatory', 'reagenty', 'paneli'];
		$terms = get_terms([
			'taxonomy'   => 'product_category',
			'hide_empty' => false,
		]);

		if (is_wp_error($terms) || !$terms) {
			return [];
		}

		$by_slug = [];
		foreach ($terms as $term) {
			$by_slug[$term->slug] = $term;
		}

		$ordered = [];
		foreach ($order as $slug) {
			if (isset($by_slug[$slug])) {
				$ordered[] = $by_slug[$slug];
			}
		}

		foreach ($terms as $term) {
			if (!in_array($term->slug, $order, true)) {
				$ordered[] = $term;
			}
		}

		return $ordered;
	}
}

if (!function_exists('alergobot_resolve_catalog_gallery_item')) {
	/**
	 * Normalize catalog section gallery row: image URL, alt, dimensions, link.
	 *
	 * @param array  $item           ACF gallery repeater row.
	 * @param string $fallback_link  Section button URL when item link is empty.
	 * @return array{img_url: string, img_hover_url: string, img_alt: string, img_w: int|string, img_h: int|string, link_url: string, link_target: string}|null
	 */
	function alergobot_resolve_catalog_gallery_item($item, $fallback_link = '')
	{
		if (!is_array($item)) {
			return null;
		}

		$product = $item['product'] ?? null;
		$image   = $item['image'] ?? null;
		$image_hover = $item['image_hover'] ?? null;
		$link    = $item['link'] ?? null;

		if (is_numeric($product)) {
			$product = get_post((int) $product);
		}

		if ($product instanceof WP_Post) {
			$post_id = $product->ID;

			if (!$image) {
				$thumb_id = get_post_thumbnail_id($post_id);
				if ($thumb_id) {
					$image = $thumb_id;
				}
			}
		}

		$img_url = alergobot_acf_image_url($image);
		if (!$img_url) {
			return null;
		}

		$img_alt = is_array($image) ? (string) ($image['alt'] ?? '') : '';
		if ($img_alt === '' && $product instanceof WP_Post) {
			$img_alt = get_the_title($product);
		}

		$img_w = is_array($image) ? ($image['width'] ?? '') : '';
		$img_h = is_array($image) ? ($image['height'] ?? '') : '';

		$link_url    = is_array($link) ? alergobot_acf_link_url($link, '') : '';
		$link_target = is_array($link) ? alergobot_acf_link_target($link) : '';

		if (!$link_url && $product instanceof WP_Post) {
			$link_url = get_permalink($product);
		}

		if (!$link_url && $fallback_link) {
			$link_url = $fallback_link;
		}

		$img_hover_url = alergobot_acf_image_url($image_hover);

		return [
			'img_url'       => $img_url,
			'img_hover_url' => $img_hover_url,
			'img_alt'       => $img_alt,
			'img_w'         => $img_w,
			'img_h'         => $img_h,
			'link_url'      => $link_url,
			'link_target'   => $link_target,
		];
	}
}

if (!function_exists('alergobot_render_catalog_gallery_product')) {
	/**
	 * Render catalog section gallery card with optional hover image.
	 *
	 * @param array  $item Resolved gallery row from alergobot_resolve_catalog_gallery_item().
	 * @param string $tag  Wrapper tag: `a` or `div`.
	 */
	function alergobot_render_catalog_gallery_product(array $item, $tag = 'a')
	{
		$has_hover = !empty($item['img_hover_url']);
		$class     = 'catalog__product' . ($has_hover ? ' catalog__product--has-hover' : '');
		$img_attrs = '';

		if (!empty($item['img_w'])) {
			$img_attrs .= ' width="' . esc_attr((string) $item['img_w']) . '"';
		} else {
			$img_attrs .= ' width="239"';
		}

		if (!empty($item['img_h'])) {
			$img_attrs .= ' height="' . esc_attr((string) $item['img_h']) . '"';
		} else {
			$img_attrs .= ' height="164"';
		}

		if ($tag === 'a') {
			echo '<div class="' . alergobot_anim_class('reveal') . '">';
			printf(
				'<a href="%1$s" class="%2$s"%3$s%4$s>',
				esc_url($item['link_url']),
				esc_attr($class),
				!empty($item['link_target']) ? ' target="' . esc_attr($item['link_target']) . '"' : '',
				($item['link_target'] ?? '') === '_blank' ? ' rel="noopener noreferrer"' : ''
			);
		} else {
			echo '<div class="' . alergobot_anim_class('reveal') . '">';
			printf('<div class="%s">', esc_attr($class));
		}
		?>
		<span class="catalog__product-media">
			<img class="catalog__product-img<?php echo $has_hover ? ' catalog__product-img--default' : ''; ?>" src="<?php echo esc_url($item['img_url']); ?>" alt="<?php echo esc_attr($item['img_alt']); ?>" title="<?php echo esc_attr($item['img_alt']); ?>"<?php echo $img_attrs; ?> loading="lazy">
			<?php if ($has_hover) : ?>
				<img class="catalog__product-img catalog__product-img--hover" src="<?php echo esc_url($item['img_hover_url']); ?>" alt="" aria-hidden="true"<?php echo $img_attrs; ?> loading="lazy">
			<?php endif; ?>
		</span>
		<?php
		echo $tag === 'a' ? '</a></div>' : '</div></div>';
	}
}

if (!function_exists('alergobot_get_post_field')) {
	/**
	 * Cached ACF field for a post (loads all fields once per post).
	 *
	 * @param string   $key     Field name.
	 * @param int|null $post_id Post ID.
	 * @return mixed
	 */
	function alergobot_get_post_field($key, $post_id = 0)
	{
		static $cache = [];

		$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
		if (!$post_id || !function_exists('get_field')) {
			return false;
		}

		if (!isset($cache[$post_id])) {
			$cache[$post_id] = function_exists('get_fields') ? (get_fields($post_id) ?: []) : [];
		}

		if (array_key_exists($key, $cache[$post_id])) {
			return $cache[$post_id][$key];
		}

		$value = get_field($key, $post_id);
		$cache[$post_id][$key] = $value;

		return $value;
	}
}

if (!function_exists('alergobot_get_term_fields')) {
	/**
	 * Cached ACF fields for a taxonomy term.
	 *
	 * @param string|int|WP_Term $term Term object, ID, or ACF term key.
	 * @return array<string, mixed>
	 */
	function alergobot_get_term_fields($term)
	{
		static $cache = [];

		if (!function_exists('get_fields')) {
			return [];
		}

		if ($term instanceof WP_Term) {
			$term_key = $term;
		} elseif (is_numeric($term)) {
			$term_key = 'product_category_' . (int) $term;
		} else {
			$term_key = (string) $term;
		}

		if ($term_key === '') {
			return [];
		}

		if (!isset($cache[$term_key])) {
			$cache[$term_key] = get_fields($term_key) ?: [];
		}

		return $cache[$term_key];
	}
}

if (!function_exists('alergobot_product_has_description_tab')) {
	function alergobot_product_has_description_tab($post_id)
	{
		if (!function_exists('get_field')) {
			return false;
		}

		if ((string) alergobot_get_post_field('product_panel_lead', $post_id) !== '') {
			return true;
		}

		$blocks = alergobot_get_post_field('product_blocks', $post_id);
		if (is_array($blocks)) {
			foreach ($blocks as $block) {
				if (!empty($block['title'])) {
					return true;
				}

				foreach ($block['items'] ?? [] as $item) {
					if (!empty($item['text'])) {
						return true;
					}
				}
			}
		}

		$allergens = alergobot_get_post_field('product_allergens', $post_id);
		if (!is_array($allergens)) {
			return false;
		}

		if (!empty($allergens['title']) || !empty($allergens['text'])) {
			return true;
		}

		return !empty($allergens['rows']);
	}
}

if (!function_exists('alergobot_product_has_ru_tab')) {
	function alergobot_product_has_ru_tab($post_id)
	{
		if (!function_exists('get_field')) {
			return false;
		}

		$ru_file = alergobot_get_post_field('product_ru_file', $post_id);
		if (is_array($ru_file) && !empty($ru_file['url'])) {
			return true;
		}

		$specs = alergobot_get_post_field('product_ru_specs', $post_id);
		if (!is_array($specs)) {
			return false;
		}

		foreach ($specs as $spec) {
			$term  = $spec['term'] ?? '';
			$value = $spec['value'] ?? '';
			if (!$term) {
				continue;
			}

			if ($value !== '' || (is_array($ru_file) && !empty($ru_file['url']))) {
				return true;
			}
		}

		return false;
	}
}

if (!function_exists('alergobot_product_has_video_tab')) {
	function alergobot_product_has_video_tab($post_id)
	{
		if (!function_exists('get_field')) {
			return false;
		}

		return (bool) alergobot_acf_image_url(alergobot_get_post_field('product_video_poster', $post_id));
	}
}

if (!function_exists('alergobot_product_has_docs_tab')) {
	function alergobot_product_has_docs_tab($post_id)
	{
		if (!function_exists('get_field')) {
			return false;
		}

		$docs = alergobot_get_post_field('product_docs', $post_id);
		if (!is_array($docs)) {
			return false;
		}

		foreach ($docs as $doc) {
			$file = $doc['file'] ?? null;
			if (is_array($file) && !empty($file['url'])) {
				return true;
			}
		}

		return false;
	}
}

if (!function_exists('alergobot_get_term_field')) {
	function alergobot_get_term_field($field, $term)
	{
		if (!function_exists('get_field')) {
			return null;
		}

		$fields = alergobot_get_term_fields($term);

		return array_key_exists($field, $fields) ? $fields[$field] : null;
	}
}

if (!function_exists('alergobot_format_file_size')) {
	function alergobot_format_file_size($bytes)
	{
		$bytes = (int) $bytes;
		if ($bytes <= 0) {
			return '';
		}

		if ($bytes >= 1048576) {
			return number_format($bytes / 1048576, 1, '.', '') . ' Мб';
		}

		return number_format($bytes / 1024, 1, '.', '') . ' Кб';
	}
}

if (!function_exists('alergobot_split_faq_columns')) {
	function alergobot_split_faq_columns(array $items)
	{
		$count = count($items);
		if ($count === 0) {
			return [[], []];
		}

		$mid = (int) ceil($count / 2);

		return [array_slice($items, 0, $mid), array_slice($items, $mid)];
	}
}

if (!function_exists('alergobot_get_phones')) {
	function alergobot_get_phones($header_only = false)
	{
		$phones = [];

		if (!function_exists('have_rows') || !have_rows('telefony', 'option')) {
			return $phones;
		}

		while (have_rows('telefony', 'option')) {
			the_row();
			$number = get_sub_field('nomer');
			if (!$number) {
				continue;
			}
			if ($header_only && !get_sub_field('v_shapke')) {
				continue;
			}
			$phones[] = $number;
		}

		return $phones;
	}
}

if (!function_exists('alergobot_get_map_settings')) {
	function alergobot_get_map_settings()
	{
		$icon_default = 'img/placemark.svg';
		$icon = alergobot_get_option('karta_ikonka', $icon_default);

		return [
			'show'   => (bool) alergobot_get_option('karta_pokazyvat', 1),
			'coords' => alergobot_get_option('karta_koordinaty', '55.6848,37.7466'),
			'zoom'   => (int) alergobot_get_option('karta_zoom', 16),
			'label'  => alergobot_get_option('karta_podpis', 'Карта'),
			'apiKey' => alergobot_get_option('karta_api_klyuch', ''),
			'icon'   => alergobot_acf_image_url($icon, 'full', alergobot_assets_uri($icon_default)),
		];
	}
}

if (!function_exists('alergobot_get_map_html')) {
	function alergobot_get_map_html($id = 'contacts-map', $class = 'contacts-order__map')
	{
		$map = alergobot_get_map_settings();
		if (!$map['show']) {
			return '';
		}

		return sprintf(
			'<div class="%1$s" id="%2$s" data-map data-coords="%3$s" data-zoom="%4$d" data-icon="%5$s" role="region" aria-label="%6$s" aria-busy="true"></div>',
			esc_attr(trim($class . ' _anim-items a-fade-up')),
			esc_attr($id),
			esc_attr($map['coords']),
			(int) $map['zoom'],
			esc_url($map['icon']),
			esc_attr($map['label'])
		);
	}
}

if (!function_exists('alergobot_get_main_class')) {
	function alergobot_get_main_class()
	{
		if (is_front_page()) {
			return 'main--home';
		}
		if (is_404()) {
			return 'main--not-found';
		}
		if (is_search()) {
			return 'main--search';
		}
		if (is_singular('product')) {
			return 'main--product';
		}
		if (is_singular('blogs')) {
			return 'main--article';
		}
		if (is_post_type_archive('blogs')) {
			return 'main--blog';
		}
		if (is_tax('product_category')) {
			return 'main--devices';
		}
		if (is_page_template('page-katalog.php') || is_page('oborudovanie') || is_page('katalog')) {
			return 'main--catalog';
		}
		if (is_page_template('page-kontakty.php')) {
			return 'main--contacts';
		}
		if (is_page_template('page-analizatory.php')) {
			return 'main--devices';
		}
		if (is_page_template('page-policy.php') || is_page('privacy-policy')) {
			return 'main--policy';
		}

		return '';
	}
}

if (!function_exists('alergobot_get_option_raw')) {
	/**
	 * Raw ACF option value (preserves false/0 for toggles).
	 *
	 * @param string $key Field name.
	 * @return mixed|null
	 */
	function alergobot_get_option_raw($key)
	{
		static $cache = null;

		if (!function_exists('get_field')) {
			return null;
		}

		if ($cache === null) {
			$cache = function_exists('get_fields') ? (get_fields('option') ?: []) : [];
		}

		if (array_key_exists($key, $cache)) {
			return $cache[$key];
		}

		$value = get_field($key, 'option');
		$cache[$key] = $value;

		return $value;
	}
}

if (!function_exists('alergobot_get_option')) {
	function alergobot_get_option($key, $default = '')
	{
		if (!function_exists('get_field')) {
			return $default;
		}

		$value = alergobot_get_option_raw($key);
		if ($value !== null && $value !== '' && $value !== false) {
			return $value;
		}

		return $default;
	}
}

if (!function_exists('alergobot_render_favicons')) {
	function alergobot_render_favicons()
	{
		$png_url = alergobot_acf_image_url(
			alergobot_get_option('favicon_png'),
			'full',
			alergobot_assets_uri('favicon-96x96.png')
		);
		$svg_url = alergobot_acf_image_url(
			alergobot_get_option('favicon_svg'),
			'full',
			alergobot_assets_uri('favicon.svg')
		);
		$ico_url = alergobot_acf_image_url(
			alergobot_get_option('favicon_ico'),
			'full',
			alergobot_assets_uri('favicon.ico')
		);
		$apple_url = alergobot_acf_image_url(
			alergobot_get_option('favicon_apple'),
			'full',
			alergobot_assets_uri('apple-touch-icon.png')
		);
		$manifest_url = alergobot_web_manifest_url();

		printf('<link rel="icon" type="image/png" href="%s" sizes="96x96">' . "\n", esc_url($png_url));
		printf('<link rel="icon" type="image/svg+xml" href="%s">' . "\n", esc_url($svg_url));
		printf('<link rel="shortcut icon" href="%s">' . "\n", esc_url($ico_url));
		printf('<link rel="apple-touch-icon" sizes="180x180" href="%s">' . "\n", esc_url($apple_url));
		printf('<meta name="apple-mobile-web-app-title" content="%s">' . "\n", esc_attr('Protia'));
		printf('<link rel="manifest" href="%s">' . "\n", esc_url($manifest_url));
	}
}

if (!function_exists('alergobot_web_manifest_url')) {
	function alergobot_web_manifest_url()
	{
		return home_url('/site.webmanifest');
	}
}

if (!function_exists('alergobot_get_web_manifest_data')) {
	function alergobot_get_web_manifest_data()
	{
		$icon_192 = alergobot_acf_image_url(
			alergobot_get_option('favicon_manifest_192'),
			'full',
			alergobot_assets_uri('web-app-manifest-192x192.png')
		);
		$icon_512 = alergobot_acf_image_url(
			alergobot_get_option('favicon_manifest_512'),
			'full',
			alergobot_assets_uri('web-app-manifest-512x512.png')
		);

		return [
			'name'             => 'Protia',
			'short_name'       => 'Protia',
			'icons'            => [
				[
					'src'     => $icon_192,
					'sizes'   => '192x192',
					'type'    => 'image/png',
					'purpose' => 'maskable',
				],
				[
					'src'     => $icon_512,
					'sizes'   => '512x512',
					'type'    => 'image/png',
					'purpose' => 'maskable',
				],
			],
			'theme_color'      => '#ffffff',
			'background_color' => '#ffffff',
			'display'          => 'standalone',
		];
	}
}

if (!function_exists('alergobot_render_main_menu')) {
	function alergobot_render_main_menu($menu_class = 'header__menu', $item_class = 'header__item', $link_class = 'header__link')
	{
		get_template_part(
			'template-parts/nav/menu',
			null,
			[
				'menu_class' => $menu_class,
				'item_class' => $item_class,
				'link_class' => $link_class,
			]
		);
	}
}

if (!function_exists('alergobot_cf7_form')) {
	function alergobot_cf7_form($option_key, $fallback_shortcode = '')
	{
		$shortcode = alergobot_get_option($option_key, $fallback_shortcode);
		if ($shortcode && function_exists('wpcf7_contact_form')) {
			echo do_shortcode($shortcode);
		}
	}
}
