<?php

/**
 * Template helpers
 *
 * @package alergobot
 */

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
			class="blog-pagination"
			aria-label="<?php esc_attr_e('Навигация по страницам', 'alergobot'); ?>"
			<?php if ($args['panel']) : ?>
				data-blog-pagination="<?php echo esc_attr($args['panel']); ?>"
			<?php endif; ?>
			<?php echo $args['hidden'] ? ' hidden' : ''; ?>
			data-animate="bottom"
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
		if (!function_exists('get_sub_field')) {
			return [];
		}

		$value = get_sub_field($key);
		if (!is_array($value) || $value === []) {
			return [];
		}

		return array_values($value);
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
			'<div class="%s" id="%s" data-map data-coords="%s" data-zoom="%d" data-icon="%s" role="region" aria-label="%s" aria-busy="true" data-animate="bottom"></div>',
			esc_attr($class),
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
			return 'main--catalog';
		}
		if (is_page_template('page-katalog.php')) {
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

if (!function_exists('alergobot_get_option')) {
	function alergobot_get_option($key, $default = '')
	{
		if (function_exists('get_field')) {
			$value = get_field($key, 'option');
			if ($value !== null && $value !== '' && $value !== false) {
				return $value;
			}
		}
		return $default;
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
