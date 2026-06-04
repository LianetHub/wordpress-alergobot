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
		'public'             => true,
		'has_archive'        => false,
		'rewrite'            => ['slug' => 'product', 'with_front' => false],
		'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
		'menu_icon'          => 'dashicons-products',
		'menu_position'      => 5,
		'show_in_rest'       => true,
	]);

	register_taxonomy('product_category', ['product'], [
		'labels' => [
			'name'          => 'Категории каталога',
			'singular_name' => 'Категория',
		],
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => ['slug' => 'catalog'],
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
		'public'             => true,
		'has_archive'        => true,
		'rewrite'            => ['slug' => 'blog', 'with_front' => false],
		'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'author'],
		'menu_icon'          => 'dashicons-admin-post',
		'menu_position'      => 6,
		'show_in_rest'       => true,
	]);

	register_taxonomy('blog_category', ['blogs'], [
		'labels' => [
			'name'          => 'Категории статей',
			'singular_name' => 'Категория',
		],
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => ['slug' => 'blog-category'],
		'show_in_rest'      => true,
	]);
});

/**
 * Create default catalog terms on theme switch.
 */
add_action('after_switch_theme', function () {
	$terms = [
		'equipment' => 'Оборудование',
		'analyzers' => 'Анализаторы',
		'reagents'  => 'Реагенты',
		'panels'    => 'Панели',
	];
	foreach ($terms as $slug => $name) {
		if (!term_exists($slug, 'product_category')) {
			wp_insert_term($name, 'product_category', ['slug' => $slug]);
		}
	}

	flush_rewrite_rules();
});
