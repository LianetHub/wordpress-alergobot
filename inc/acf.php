<?php

/**
 * ACF configuration
 *
 * acf-json/ — только для локальной разработки (генератор в tools/).
 * На сервер папку не загружают: группы полей создаются вручную в админке ACF.
 *
 * @package alergobot
 */

define('ALERGOBOT_ACF_SETTINGS_SLUG', 'theme-settings');

/**
 * Путь к acf-json/ или пустая строка, если папки нет (продакшен).
 */
function alergobot_acf_json_dir()
{
	static $dir = null;

	if ($dir === null) {
		$path = ALERGOBOT_DIR . '/acf-json';
		$dir  = is_dir($path) ? $path : '';
	}

	return $dir;
}

/**
 * Доступны ли локальные JSON-файлы (только dev).
 */
function alergobot_acf_json_enabled()
{
	return alergobot_acf_json_dir() !== '';
}

add_action('acf/init', function () {
	if (!function_exists('acf_add_options_page')) {
		return;
	}

	acf_add_options_page([
		'page_title' => 'Настройки сайта',
		'menu_title' => 'Настройки сайта',
		'menu_slug'  => ALERGOBOT_ACF_SETTINGS_SLUG,
		'capability' => 'edit_posts',
		'redirect'   => false,
		'icon_url'   => 'dashicons-admin-generic',
	]);
});

if (alergobot_acf_json_enabled()) {
	add_filter('acf/settings/save_json', function () {
		return alergobot_acf_json_dir();
	});

	add_filter('acf/settings/load_json', function ($paths) {
		$paths[] = alergobot_acf_json_dir();
		return $paths;
	});
}

add_action('wp_head', function () {
	if (!function_exists('get_field')) {
		return;
	}
	$keywords = get_field('keywords', 'option');
	if ($keywords) {
		printf('<meta name="keywords" content="%s">', esc_attr($keywords));
	}
}, 1);

add_action('acf/input/admin_head', function () {
	if (!function_exists('get_current_screen')) {
		return;
	}

	$screen = get_current_screen();
	if (!$screen || strpos($screen->id, ALERGOBOT_ACF_SETTINGS_SLUG) === false) {
		return;
	}
?>
	<style type="text/css">
		h2.hndle.ui-sortable-handle {
			background: #1a5f4a;
			color: #fff !important;
			transition: all 0.25s;
		}

		.acf-field.acf-accordion .acf-label.acf-accordion-title {
			background: #e8f4ef;
			transition: all 0.25s;
		}

		.acf-accordion .acf-accordion-title label {
			text-transform: uppercase;
			color: #000;
		}

		.acf-field p.description {
			color: #c47a00;
		}

		.acf-field-group {
			border: 1px solid #1a5f4a !important;
		}
	</style>
<?php
});

add_action('admin_head', function () {
?>
	<style>
		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>>a {
			background-color: #26668c !important;
			color: #fff !important;
		}

		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>>a:hover,
		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>>a:focus {
			background-color: #1e5270 !important;
			color: #fff !important;
		}

		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>.wp-has-current-submenu>a,
		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>.current>a {
			background-color: #26668c !important;
			color: #fff !important;
		}
	</style>
<?php
});
