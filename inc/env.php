<?php
/**
 * Load environment variables from .env file.
 *
 * @package alergobot
 */

if (!function_exists('alergobot_load_env_configs')) {
	/**
	 * @param string $path Path to .env file.
	 */
	function alergobot_load_env_configs($path)
	{
		if (!file_exists($path)) {
			return;
		}

		$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		if ($lines === false) {
			return;
		}

		foreach ($lines as $line) {
			$line = trim($line);

			if ($line === '' || strpos($line, '#') === 0) {
				continue;
			}

			if (strpos($line, '=') === false) {
				continue;
			}

			list($name, $value) = explode('=', $line, 2);
			$name = trim($name);
			$value = trim($value);

			if (
				(strlen($value) >= 2)
				&& (
					($value[0] === '"' && substr($value, -1) === '"')
					|| ($value[0] === "'" && substr($value, -1) === "'")
				)
			) {
				$value = substr($value, 1, -1);
			}

			$_ENV[$name] = $value;
		}
	}
}

if (!function_exists('alergobot_env')) {
	/**
	 * @param string $key
	 * @param string $default
	 * @return string
	 */
	function alergobot_env($key, $default = '')
	{
		if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
			return (string) $_ENV[$key];
		}

		$env_value = getenv($key);

		if ($env_value !== false && $env_value !== '') {
			return (string) $env_value;
		}

		return $default;
	}
}

alergobot_load_env_configs(ALERGOBOT_DIR . '/.env');

if (defined('ABSPATH')) {
	alergobot_load_env_configs(ABSPATH . '.env');
}
