<?php

/**
 * Custom post types and taxonomies
 *
 * @package alergobot
 */

add_action('init', function () {
	register_post_type('product', [
		'labels' => [
			'name'                     => 'Продукция',
			'singular_name'            => 'Продукт',
			'menu_name'                => 'Продукция',
			'name_admin_bar'           => 'Продукт',
			'add_new'                  => 'Добавить',
			'add_new_item'             => 'Добавить продукт',
			'new_item'                 => 'Новый продукт',
			'edit_item'                => 'Редактировать продукт',
			'view_item'                => 'Просмотреть продукт',
			'view_items'               => 'Просмотреть продукцию',
			'search_items'             => 'Искать продукцию',
			'not_found'                => 'Продукция не найдена',
			'not_found_in_trash'       => 'В корзине продукция не найдена',
			'parent_item_colon'        => 'Родительский продукт:',
			'all_items'                => 'Вся продукция',
			'archives'                 => 'Архив продукции',
			'attributes'               => 'Атрибуты продукта',
			'insert_into_item'         => 'Вставить в продукт',
			'uploaded_to_this_item'    => 'Загружено для этого продукта',
			'featured_image'           => 'Изображение продукта',
			'set_featured_image'       => 'Установить изображение продукта',
			'remove_featured_image'    => 'Удалить изображение продукта',
			'use_featured_image'       => 'Использовать как изображение продукта',
			'filter_items_list'        => 'Фильтровать список продукции',
			'filter_by_date'           => 'Фильтровать по дате',
			'items_list_navigation'    => 'Навигация по списку продукции',
			'items_list'               => 'Список продукции',
			'item_published'           => 'Продукт опубликован.',
			'item_published_privately' => 'Продукт опубликован приватно.',
			'item_reverted_to_draft'   => 'Продукт возвращён в черновики.',
			'item_scheduled'           => 'Публикация продукта запланирована.',
			'item_updated'             => 'Продукт обновлён.',
			'item_link'                => 'Ссылка на продукт',
			'item_link_description'    => 'Ссылка на страницу продукта.',
		],
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'exclude_from_search'   => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-products',
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'supports'              => ['title', 'editor', 'thumbnail', 'excerpt'],
		'taxonomies'            => ['product_category'],
		'has_archive'           => false,
		'rewrite'               => false,
		'query_var'             => true,
		'can_export'            => true,
		'delete_with_user'      => false,
		'show_in_rest'          => true,
	]);

	register_taxonomy('product_category', ['product'], [
		'labels' => [
			'name'                       => 'Категории каталога',
			'singular_name'              => 'Категория каталога',
			'menu_name'                  => 'Категории каталога',
			'search_items'               => 'Искать категории',
			'all_items'                  => 'Все категории',
			'parent_item'                => 'Родительская категория',
			'parent_item_colon'          => 'Родительская категория:',
			'edit_item'                  => 'Редактировать категорию',
			'view_item'                  => 'Просмотреть категорию',
			'update_item'                => 'Обновить категорию',
			'add_new_item'               => 'Добавить категорию',
			'new_item_name'              => 'Название новой категории',
			'not_found'                  => 'Категории не найдены',
			'no_terms'                   => 'Нет категорий',
			'name_field_description'     => 'Название отображается на сайте.',
			'slug_field_description'     => 'Slug — URL-friendly версия названия.',
			'parent_field_description'   => 'Выберите родительскую категорию для иерархии.',
			'desc_field_description'     => 'Описание по умолчанию не выводится.',
			'filter_by_item'             => 'Фильтровать по категории',
			'items_list_navigation'      => 'Навигация по списку категорий',
			'items_list'                 => 'Список категорий',
			'back_to_items'              => '← К категориям',
			'item_link'                  => 'Ссылка на категорию',
			'item_link_description'      => 'Ссылка на страницу категории.',
		],
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'hierarchical'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_tagcloud'         => false,
		'show_in_quick_edit'    => true,
		'show_admin_column'     => true,
		'rewrite'               => [
			'slug'         => 'oborudovanie',
			'with_front'   => false,
			'hierarchical' => false,
		],
		'query_var'             => true,
		'show_in_rest'          => true,
	]);

	register_post_type('blogs', [
		'labels' => [
			'name'                     => 'Статьи',
			'singular_name'            => 'Статья',
			'menu_name'                => 'Статьи',
			'name_admin_bar'           => 'Статья',
			'add_new'                  => 'Добавить',
			'add_new_item'             => 'Добавить статью',
			'new_item'                 => 'Новая статья',
			'edit_item'                => 'Редактировать статью',
			'view_item'                => 'Просмотреть статью',
			'view_items'               => 'Просмотреть статьи',
			'search_items'             => 'Искать статьи',
			'not_found'                => 'Статей не найдено',
			'not_found_in_trash'       => 'В корзине статей не найдено',
			'parent_item_colon'        => 'Родительская статья:',
			'all_items'                => 'Все статьи',
			'archives'                 => 'Архив статей',
			'attributes'               => 'Атрибуты статьи',
			'insert_into_item'         => 'Вставить в статью',
			'uploaded_to_this_item'    => 'Загружено для этой статьи',
			'featured_image'           => 'Изображение статьи',
			'set_featured_image'       => 'Установить изображение статьи',
			'remove_featured_image'    => 'Удалить изображение статьи',
			'use_featured_image'       => 'Использовать как изображение статьи',
			'filter_items_list'        => 'Фильтровать список статей',
			'filter_by_date'           => 'Фильтровать по дате',
			'items_list_navigation'    => 'Навигация по списку статей',
			'items_list'               => 'Список статей',
			'item_published'           => 'Статья опубликована.',
			'item_published_privately' => 'Статья опубликована приватно.',
			'item_reverted_to_draft'   => 'Статья возвращена в черновики.',
			'item_scheduled'           => 'Публикация статьи запланирована.',
			'item_updated'             => 'Статья обновлена.',
			'item_link'                => 'Ссылка на статью',
			'item_link_description'    => 'Ссылка на страницу статьи.',
		],
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'exclude_from_search'   => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-admin-post',
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'author'],
		'taxonomies'            => ['blog_category', 'post_tag'],
		'has_archive'           => false,
		'rewrite'               => false,
		'query_var'             => true,
		'can_export'            => true,
		'delete_with_user'      => false,
		'show_in_rest'          => true,
	]);

	register_taxonomy('blog_category', ['blogs'], [
		'labels' => [
			'name'                       => 'Категории статей',
			'singular_name'              => 'Категория статьи',
			'menu_name'                  => 'Категории статей',
			'search_items'               => 'Искать категории',
			'all_items'                  => 'Все категории',
			'parent_item'                => 'Родительская категория',
			'parent_item_colon'          => 'Родительская категория:',
			'edit_item'                  => 'Редактировать категорию',
			'view_item'                  => 'Просмотреть категорию',
			'update_item'                => 'Обновить категорию',
			'add_new_item'               => 'Добавить категорию',
			'new_item_name'              => 'Название новой категории',
			'not_found'                  => 'Категории не найдены',
			'no_terms'                   => 'Нет категорий',
			'name_field_description'     => 'Название отображается на сайте.',
			'slug_field_description'     => 'Slug — URL-friendly версия названия.',
			'parent_field_description'   => 'Выберите родительскую категорию для иерархии.',
			'desc_field_description'     => 'Описание по умолчанию не выводится.',
			'filter_by_item'             => 'Фильтровать по категории',
			'items_list_navigation'      => 'Навигация по списку категорий',
			'items_list'                 => 'Список категорий',
			'back_to_items'              => '← К категориям',
			'item_link'                  => 'Ссылка на категорию',
			'item_link_description'      => 'Ссылка на страницу категории.',
		],
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'hierarchical'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_tagcloud'         => false,
		'show_in_quick_edit'    => true,
		'show_admin_column'     => true,
		'rewrite'               => false,
		'query_var'             => true,
		'show_in_rest'          => true,
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
