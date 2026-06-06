<?php
/**
 * Template tags
 *
 * @package alergobot
 */

if (!function_exists('str_starts_with')) {
	function str_starts_with($haystack, $needle)
	{
		$haystack = (string) $haystack;
		$needle   = (string) $needle;

		if ($needle === '') {
			return true;
		}

		return strncmp($haystack, $needle, strlen($needle)) === 0;
	}
}

if (!function_exists('alergobot_assets_uri')) {
	function alergobot_assets_uri($path = '') {
		return trailingslashit(ALERGOBOT_ASSETS_URI) . ltrim($path, '/');
	}
}

if (!function_exists('alergobot_phone_clean')) {
	function alergobot_phone_clean($phone) {
		return preg_replace('![^0-9]+!', '', (string) $phone);
	}
}

if (!function_exists('alergobot_icon')) {
	function alergobot_icon($id, $width = 24, $height = 24, $class = 'icon') {
		$class_attr = $class ? ' class="' . esc_attr($class) . '"' : '';
		printf(
			'<svg%s width="%d" height="%d" aria-hidden="true"><use href="%s#%s"></use></svg>',
			$class_attr,
			(int) $width,
			(int) $height,
			esc_url(alergobot_assets_uri('img/icons.svg')),
			esc_attr($id)
		);
	}
}

if (!function_exists('alergobot_acf_image_url')) {
	function alergobot_acf_image_url($image, $size = 'full', $fallback = '') {
		if (empty($image)) {
			return $fallback;
		}

		if (is_numeric($image)) {
			$url = wp_get_attachment_image_url((int) $image, $size);
			return $url ?: $fallback;
		}

		if (is_string($image)) {
			if (preg_match('#^https?://#i', $image) || str_starts_with($image, '/')) {
				return $image;
			}

			return alergobot_assets_uri(ltrim($image, '/'));
		}

		if (!is_array($image)) {
			return $fallback;
		}

		$url = $image['sizes'][$size] ?? $image['url'] ?? '';
		return $url ?: $fallback;
	}
}

if (!function_exists('alergobot_acf_image')) {
	function alergobot_acf_image($image, $size = 'full', $attrs = []) {
		$url = alergobot_acf_image_url($image, $size);
		if (!$url) {
			return '';
		}

		if (is_numeric($image)) {
			$image = [
				'url' => $url,
			];
		} elseif (is_string($image)) {
			$image = ['url' => $url];
		} elseif (!is_array($image)) {
			return '';
		}

		$url = $image['sizes'][$size] ?? $image['url'] ?? $url;
		if (!$url) {
			return '';
		}

		$alt     = $attrs['alt'] ?? ($image['alt'] ?? '');
		$title   = $attrs['title'] ?? ($image['title'] ?? '');
		$w       = $attrs['width'] ?? ($image['width'] ?? '');
		$h       = $attrs['height'] ?? ($image['height'] ?? '');
		$loading = $attrs['loading'] ?? 'lazy';
		$class   = $attrs['class'] ?? '';
		$class_attr = $class ? sprintf(' class="%s"', esc_attr($class)) : '';

		return sprintf(
			'<img src="%s" alt="%s" title="%s" width="%s" height="%s" loading="%s"%s>',
			esc_url($url),
			esc_attr($alt),
			esc_attr($title),
			esc_attr($w),
			esc_attr($h),
			esc_attr($loading),
			$class_attr
		);
	}
}