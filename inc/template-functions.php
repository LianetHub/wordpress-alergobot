<?php
/**
 * Template helpers
 *
 * @package alergobot
 */

if (!function_exists('alergobot_replace_markup_urls')) {
	function alergobot_replace_markup_urls($html) {
		$assets = alergobot_assets_uri();
		$home   = trailingslashit(home_url());

		$replacements = [
			'@img/' => $assets . 'img/',
			'src="img/' => 'src="' . $assets . 'img/',
			"href=\"img/" => "href=\"" . $assets . 'img/',
			"url(img/" => "url(" . $assets . 'img/',
			'href="index.html"' => 'href="' . esc_url($home) . '"',
			'href="katalog.html"' => 'href="' . esc_url(home_url('/katalog/')) . '"',
			'href="stati.html"' => 'href="' . esc_url(get_post_type_archive_link('blogs') ?: home_url('/stati/')) . '"',
			'href="kontakty.html"' => 'href="' . esc_url(home_url('/kontakty/')) . '"',
			'href="analizatory.html"' => 'href="' . esc_url(home_url('/analizatory/')) . '"',
			'href="politika-konfidentsialnosti.html"' => 'href="' . esc_url(home_url('/politika-konfidentsialnosti/')) . '"',
			'href="statya.html"' => 'href="' . esc_url(home_url('/blog/')) . '"',
			'action="#"' => 'action="' . esc_url(admin_url('admin-ajax.php')) . '"',
		];

		return str_replace(array_keys($replacements), array_values($replacements), $html);
	}
}

if (!function_exists('alergobot_render_markup_file')) {
	function alergobot_render_markup_file($relative_path) {
		$file = ALERGOBOT_DIR . '/inc/markup/' . ltrim($relative_path, '/');
		if (!file_exists($file)) {
			return;
		}
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo alergobot_replace_markup_urls(file_get_contents($file));
	}
}

if (!function_exists('alergobot_render_home_section')) {
	function alergobot_render_home_section($slug) {
		alergobot_render_markup_file('home/' . $slug . '.html');
	}
}

if (!function_exists('alergobot_render_page_markup')) {
	function alergobot_render_page_markup($filename) {
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
	function alergobot_inject_cf7_into_popups($html) {
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
	function alergobot_get_main_class() {
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
		if (is_page_template('page-policy.php')) {
			return 'main--policy';
		}

		return '';
	}
}

if (!function_exists('alergobot_get_option')) {
	function alergobot_get_option($key, $default = '') {
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
	function alergobot_render_main_menu($menu_class = 'header__menu') {
		if (function_exists('have_rows') && have_rows('glavnoe_menyu', 'option')) {
			echo '<ul class="' . esc_attr($menu_class) . '">';
			while (have_rows('glavnoe_menyu', 'option')) {
				the_row();
				$name = get_sub_field('nazvanie');
				$link = get_sub_field('ssylka');
				if (!$name || !$link) {
					continue;
				}
				$has_submenu = get_sub_field('est_podmenyu');
				echo '<li class="header__item' . ($has_submenu ? ' has-dropdown' : '') . '">';
				printf(
					'<a class="header__link" href="%s">%s</a>',
					esc_url($link),
					esc_html($name)
				);
				if ($has_submenu && have_rows('podmenyu')) {
					echo '<ul class="header__submenu">';
					while (have_rows('podmenyu')) {
						the_row();
						$sub_name = get_sub_field('nazvanie');
						$sub_link = get_sub_field('ssylka');
						if ($sub_name && $sub_link) {
							printf(
								'<li><a href="%s">%s</a></li>',
								esc_url($sub_link),
								esc_html($sub_name)
							);
						}
					}
					echo '</ul>';
				}
				echo '</li>';
			}
			echo '</ul>';
			return;
		}

		alergobot_render_markup_file('_header.html');
		// Extract only nav menu from markup fallback handled in header.php
	}
}

if (!function_exists('alergobot_cf7_form')) {
	function alergobot_cf7_form($option_key, $fallback_shortcode = '') {
		$shortcode = alergobot_get_option($option_key, $fallback_shortcode);
		if ($shortcode && function_exists('wpcf7_contact_form')) {
			echo do_shortcode($shortcode);
		}
	}
}
