<?php
/**
 * Enqueue styles and scripts
 *
 * @package alergobot
 */

add_action('wp_enqueue_scripts', function () {
	$uri = ALERGOBOT_ASSETS_URI;
	$ver = ALERGOBOT_VERSION;

	wp_enqueue_style('alergobot-swiper', $uri . '/css/libs/swiper-bundle.min.css', [], $ver);
	wp_enqueue_style('alergobot-fancybox', $uri . '/css/libs/fancybox.min.css', [], $ver);
	wp_enqueue_style('alergobot-reset', $uri . '/css/reset.min.css', [], $ver);
	wp_enqueue_style('alergobot-global', $uri . '/css/style-global.min.css', ['alergobot-reset'], $ver);
	wp_enqueue_style('alergobot-header', $uri . '/css/header.min.css', ['alergobot-global'], $ver);
	wp_enqueue_style('alergobot-footer', $uri . '/css/footer.min.css', ['alergobot-global'], $ver);

	// Полный бандл (fallback при неполной сборке split CSS).
	if (file_exists(ALERGOBOT_DIR . '/assets/css/style.min.css')) {
		wp_enqueue_style('alergobot-style-bundle', $uri . '/css/style.min.css', ['alergobot-reset'], $ver);
	}

	alergobot_enqueue_conditional_styles($uri, $ver);

	wp_enqueue_script('alergobot-swiper', $uri . '/js/libs/swiper-bundle.min.js', [], $ver, true);
	wp_enqueue_script('alergobot-fancybox', $uri . '/js/libs/fancybox.min.js', ['alergobot-swiper'], $ver, true);
	wp_enqueue_script('alergobot-app', $uri . '/js/app.min.js', ['alergobot-fancybox'], $ver, true);

	if (is_page_template('page-kontakty.php') || is_page('kontakty')) {
		wp_enqueue_script('alergobot-map', $uri . '/js/map.js', ['alergobot-app'], $ver, true);
	}

	wp_localize_script('alergobot-app', 'theme_ajax', [
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce'    => wp_create_nonce('alergobot_nonce'),
		'home_url' => home_url('/'),
	]);
});

/**
 * Conditional page styles (regulation §3.2).
 */
function alergobot_enqueue_conditional_styles($uri, $ver) {
	$deps = ['alergobot-global', 'alergobot-header', 'alergobot-footer'];

	if (is_front_page()) {
		wp_enqueue_style('alergobot-home', $uri . '/css/home.min.css', $deps, $ver);
	}

	if (is_page_template('page-katalog.php') || is_page('katalog')) {
		wp_enqueue_style('alergobot-catalog', $uri . '/css/catalog.min.css', $deps, $ver);
	}

	if (is_singular('product')) {
		wp_enqueue_style('alergobot-product', $uri . '/css/product.min.css', $deps, $ver);
	}

	if (is_page_template('page-analizatory.php') || is_tax('product_category', 'analyzers') || is_page('analizatory')) {
		wp_enqueue_style('alergobot-analyzers', $uri . '/css/analyzers.min.css', $deps, $ver);
	}

	if (is_page_template('page-kontakty.php') || is_page('kontakty')) {
		wp_enqueue_style('alergobot-contacts', $uri . '/css/contacts.min.css', $deps, $ver);
	}

	if (is_post_type_archive('blogs') || is_singular('blogs') || is_tax('blog_category')) {
		wp_enqueue_style('alergobot-blog', $uri . '/css/blog.min.css', $deps, $ver);
	}

	if (is_singular('blogs')) {
		wp_enqueue_style('alergobot-article', $uri . '/css/article.min.css', $deps, $ver);
	}

	if (is_page_template('page-policy.php') || is_page('politika-konfidentsialnosti')) {
		wp_enqueue_style('alergobot-policy', $uri . '/css/policy.min.css', $deps, $ver);
	}

	if (is_404()) {
		wp_enqueue_style('alergobot-not-found', $uri . '/css/not-found.min.css', $deps, $ver);
	}
}
