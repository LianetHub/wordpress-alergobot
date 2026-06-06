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

if (!function_exists('alergobot_resolve_link')) {
	function alergobot_resolve_link($link)
	{
		$link = trim((string) $link);
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
		$icon = alergobot_get_option('karta_ikonka', 'img/placemark.svg');

		return [
			'show'   => (bool) alergobot_get_option('karta_pokazyvat', 1),
			'coords' => alergobot_get_option('karta_koordinaty', '55.6848,37.7466'),
			'zoom'   => (int) alergobot_get_option('karta_zoom', 16),
			'label'  => alergobot_get_option('karta_podpis', 'Карта'),
			'apiKey' => alergobot_get_option('karta_api_klyuch', ''),
			'icon'   => alergobot_assets_uri(ltrim($icon, '/')),
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

if (!function_exists('alergobot_replace_dynamic_markup')) {
	function alergobot_replace_dynamic_markup($html)
	{
		ob_start();
		get_template_part('template-parts/company/contacts', 'info');
		$contacts_info = ob_get_clean();

		$html = preg_replace('/<section class="contacts-info">.*?<\/section>/s', $contacts_info, $html, 1);

		$map_html = alergobot_get_map_html();
		if ($map_html) {
			$html = preg_replace(
				'/<div class="contacts-order__map"[^>]*><\/div>/',
				$map_html,
				$html,
				1
			);
			$html = preg_replace(
				'/<div class="contacts__map"[^>]*><\/div>/',
				alergobot_get_map_html('contacts-map', 'contacts__map'),
				$html,
				1
			);
		} else {
			$html = preg_replace('/<div class="contacts-order__map"[^>]*><\/div>/', '', $html, 1);
			$html = preg_replace('/<div class="contacts__map"[^>]*><\/div>/', '', $html, 1);
		}

		ob_start();
		get_template_part('template-parts/company/contact', 'cards');
		$contact_cards = ob_get_clean();

		$html = preg_replace(
			'/(<div class="contacts__cards">)\s*(?:<article class="contacts-card[\s\S]*?<\/article>\s*)+(<link itemprop="hasMap")/',
			'$1' . $contact_cards . '</div>' . "\n\t\t\t\t\t\t\t\t" . '$2',
			$html,
			1
		);

		return $html;
	}
}

if (!function_exists('alergobot_replace_markup_urls')) {
	function alergobot_replace_markup_urls($html)
	{
		$assets = alergobot_assets_uri();
		$home   = trailingslashit(home_url());

		$replacements = [
			'@img/' => $assets . 'img/',
			'src="img/' => 'src="' . $assets . 'img/',
			"href=\"img/" => "href=\"" . $assets . 'img/',
			"url(img/" => "url(" . $assets . 'img/',
			'href="index.html"' => 'href="' . esc_url($home) . '"',
			'href="katalog.html"' => 'href="' . esc_url(home_url('/katalog/')) . '"',
			'href="stati.html"' => 'href="' . esc_url(alergobot_blogs_archive_url()) . '"',
			'href="kontakty.html"' => 'href="' . esc_url(home_url('/kontakty/')) . '"',
			'href="analizatory.html"' => 'href="' . esc_url(home_url('/analizatory/')) . '"',
			'href="politika-konfidentsialnosti.html"' => 'href="' . esc_url(alergobot_privacy_policy_url()) . '"',
			'href="statya.html"' => 'href="' . esc_url(alergobot_blogs_archive_url()) . '"',
			'action="#"' => 'action="' . esc_url(admin_url('admin-ajax.php')) . '"',
		];

		$html = str_replace(array_keys($replacements), array_values($replacements), $html);

		return alergobot_replace_dynamic_markup($html);
	}
}

if (!function_exists('alergobot_render_markup_file')) {
	function alergobot_render_markup_file($relative_path)
	{
		$file = ALERGOBOT_DIR . '/inc/markup/' . ltrim($relative_path, '/');
		if (!file_exists($file)) {
			return;
		}
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo alergobot_replace_markup_urls(file_get_contents($file));
	}
}

if (!function_exists('alergobot_render_home_section')) {
	function alergobot_render_home_section($slug)
	{
		alergobot_render_markup_file('home/' . $slug . '.html');
	}
}

if (!function_exists('alergobot_render_page_markup')) {
	function alergobot_render_page_markup($filename)
	{
		$file = ALERGOBOT_DIR . '/inc/markup/pages/' . ltrim($filename, '/');
		if (!file_exists($file)) {
			return;
		}
		$html = file_get_contents($file);
		if (preg_match('/<main\b[^>]*>(.*)<\/main>/s', $html, $matches)) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo alergobot_replace_markup_urls($matches[1]);
			return;
		}
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo alergobot_replace_markup_urls($html);
	}
}

if (!function_exists('alergobot_inject_cf7_into_popups')) {
	function alergobot_inject_cf7_into_popups($html)
	{
		$forms = [
			'popup-consultation' => 'cf7_konsultaciya',
			'popup-order'        => 'cf7_zakaz',
			'popup-presentation' => 'cf7_prezentaciya',
		];
		foreach ($forms as $popup_id => $option_key) {
			$shortcode = alergobot_get_option($option_key, '');
			if (!$shortcode) {
				continue;
			}
			$cf7 = do_shortcode($shortcode);
			$pattern = '/(<div id="' . preg_quote($popup_id, '/') . '"[^>]*>.*?<form[^>]*>).*?(<\/form>)/s';
			$html    = preg_replace($pattern, '$1' . $cf7 . '$2', $html, 1);
		}
		return $html;
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
