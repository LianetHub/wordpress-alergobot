<?php
/**
 * Contact Form 7 integration
 *
 * @package alergobot
 */

// Отключаем автоматические <p> и <br> в разметке формы.
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Нормализует пути к SVG-спрайту.
 */
add_filter('wpcf7_form_elements', function ($content) {
	$icons_uri = alergobot_assets_uri('img/icons.svg');
	$theme_uri = get_template_directory_uri();

	$content = str_replace(
		[
			'@img/icons.svg',
			$theme_uri . '/img/icons.svg',
		],
		$icons_uri,
		$content
	);

	$content = preg_replace(
		'/<span class="checkbox__box"[^>]*>\s*<svg[^>]*>.*?<\/svg>\s*<\/span>/s',
		'<span class="checkbox__box" aria-hidden="true"></span>',
		$content
	);

	return $content;
});

add_action('wpcf7_mail_sent', function () {
	// Hook for analytics or custom redirects if needed.
});

/**
 * Map popup forms to CF7 shortcodes (set in ACF Options).
 */
function alergobot_popup_cf7($key, $default_shortcode = '') {
	$shortcode = alergobot_get_option($key, $default_shortcode);
	if ($shortcode) {
		echo do_shortcode($shortcode);
	}
}
