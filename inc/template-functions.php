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

		$layout     = function_exists('get_row_layout') ? (string) get_row_layout() : 'acf';
		$row_index  = function_exists('get_row_index') ? (int) get_row_index() : 0;
		$cache_key  = $layout . '_' . $row_index . '_' . $key;

		if (array_key_exists($cache_key, $cache)) {
			return $cache[$cache_key];
		}

		if (!function_exists('have_rows') || !have_rows($key)) {
			$cache[$cache_key] = [];
			return $cache[$cache_key];
		}

		$rows = [];
		while (have_rows($key)) {
			the_row();
			$row = get_row(true);
			if (is_array($row)) {
				$rows[] = $row;
			}
		}

		$cache[$cache_key] = $rows;
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
