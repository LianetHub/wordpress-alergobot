<?php

/**
 * Custom post types and taxonomies
 *
 * @package alergobot
 */

add_action('init', function () {
	register_post_type('product', [
		'labels' => [
			'name'          => 'Продукция',
			'singular_name' => 'Продукт',
			'add_new_item'  => 'Добавить продукт',
			'edit_item'     => 'Редактировать продукт',
			'search_items'  => 'Искать продукцию',
			'not_found'     => 'Продукция не найдена',
		],
		'public'        => true,
		'has_archive'   => false,
		'rewrite'       => false,
		'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
		'menu_icon'     => 'dashicons-products',
		'menu_position' => 5,
		'show_in_rest'  => true,
	]);

	register_taxonomy('product_category', ['product'], [
		'labels' => [
			'name'          => 'Категории каталога',
			'singular_name' => 'Категория',
		],
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => ['slug' => 'oborudovanie', 'with_front' => false],
		'show_in_rest'      => true,
	]);

	register_post_type('blogs', [
		'labels' => [
			'name'          => 'Статьи',
			'singular_name' => 'Статья',
			'add_new_item'  => 'Добавить статью',
			'edit_item'     => 'Редактировать статью',
			'search_items'  => 'Искать статьи',
			'not_found'     => 'Статей не найдено',
		],
		'public'        => true,
		'has_archive'   => false,
		'rewrite'       => false,
		'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'author'],
		'menu_icon'     => 'dashicons-admin-post',
		'menu_position' => 6,
		'show_in_rest'  => true,
	]);

	register_taxonomy('blog_category', ['blogs'], [
		'labels' => [
			'name'          => 'Категории статей',
			'singular_name' => 'Категория',
		],
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => false,
		'show_in_rest'      => true,
	]);

	register_taxonomy_for_object_type('post_tag', 'blogs');
});


add_filter('request', function (array $query_vars): array {
	if (empty($query_vars['pagename']) || isset($query_vars['product_category'])) {
		return $query_vars;
	}

	if (!preg_match('#^oborudovanie/([^/]+)/?$#', (string) $query_vars['pagename'], $matches)) {
		return $query_vars;
	}

	$term = get_term_by('slug', $matches[1], 'product_category');
	if (!$term || is_wp_error($term)) {
		return $query_vars;
	}

	unset($query_vars['pagename'], $query_vars['page'], $query_vars['name']);
	$query_vars['product_category'] = $matches[1];

	return $query_vars;
});
