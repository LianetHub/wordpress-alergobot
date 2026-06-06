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
		'rewrite'            => ['slug' => 'oborudovanie', 'with_front' => false],
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
		'rewrite'           => ['slug' => 'category', 'with_front' => false],
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
		'has_archive'        => 'stati-po-allergologii',
		'rewrite'            => ['slug' => 'stati', 'with_front' => false],
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
		'rewrite'           => ['slug' => 'category', 'with_front' => false],
		'show_in_rest'      => true,
	]);

	register_taxonomy_for_object_type('post_tag', 'blogs');
});

/**
 * Create default catalog terms on theme switch.
 */
add_action('after_switch_theme', function () {
	$product_terms = [
		'oborudovanie' => 'Оборудование',
		'analyzers'    => 'Анализаторы',
		'reagents'     => 'Реагенты',
		'panels'       => 'Панели',
	];
	foreach ($product_terms as $slug => $name) {
		if (!term_exists($slug, 'product_category')) {
			wp_insert_term($name, 'product_category', ['slug' => $slug]);
		}
	}

	$blog_terms = [
		'stati'   => 'Статьи',
		'novosti' => 'Новости',
	];
	foreach ($blog_terms as $slug => $name) {
		if (!term_exists($slug, 'blog_category')) {
			wp_insert_term($name, 'blog_category', ['slug' => $slug]);
		}
	}

	flush_rewrite_rules();
});
