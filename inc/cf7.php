<?php
/**
 * Contact Form 7 integration
 *
 * @package alergobot
 */

// Отключаем автоматические <p> и <br> в разметке формы.
add_filter('wpcf7_autop_or_not', '__return_false');

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
