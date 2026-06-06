<?php
/**
 * Contact Form 7 integration
 *
 * @package alergobot
 */

add_filter('wpcf7_form_elements', function ($content) {
	$content = preg_replace('/<span[^>]*>(.*?)<\/span>/s', '$1', $content);
	$content = preg_replace('/<p\b[^>]*>/', '', $content);
	$content = str_replace('</p>', '', $content);
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
