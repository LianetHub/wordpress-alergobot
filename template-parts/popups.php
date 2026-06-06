<?php
/**
 * Popups markup
 *
 * @package alergobot
 */

$file = ALERGOBOT_DIR . '/inc/markup/_popups.html';
if (!file_exists($file)) {
	return;
}

$html = file_get_contents($file);
$html = alergobot_replace_markup_urls($html);
$html = alergobot_inject_cf7_into_popups($html);

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $html;
