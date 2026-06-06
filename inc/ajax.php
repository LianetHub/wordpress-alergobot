<?php
/**
 * AJAX handlers
 *
 * @package alergobot
 */

add_action('wp_ajax_filter_blogs', 'alergobot_ajax_filter_blogs');
add_action('wp_ajax_nopriv_filter_blogs', 'alergobot_ajax_filter_blogs');

add_action('wp_ajax_load_more_blogs', 'alergobot_ajax_load_more_blogs');
add_action('wp_ajax_nopriv_load_more_blogs', 'alergobot_ajax_load_more_blogs');

function alergobot_ajax_filter_blogs() {
	check_ajax_referer('alergobot_nonce', 'nonce');

	$category = isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '';
	$page     = isset($_POST['page']) ? absint($_POST['page']) : 1;

	$args = [
		'post_type'      => 'blogs',
		'posts_per_page' => 9,
		'paged'          => $page,
		'post_status'    => 'publish',
	];

	if ($category && $category !== 'all') {
		$args['tax_query'] = [[
			'taxonomy' => 'blog_category',
			'field'    => 'term_id',
			'terms'    => absint($category),
		]];
	}

	$query = new WP_Query($args);

	ob_start();
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part('template-parts/blog/card');
		}
		wp_reset_postdata();
	} else {
		echo '<p class="no-posts">' . esc_html__('Записей не найдено', 'alergobot') . '</p>';
	}

	wp_send_json_success([
		'html'      => ob_get_clean(),
		'max_pages' => $query->max_num_pages,
		'found'     => $query->found_posts,
	]);
}

function alergobot_ajax_load_more_blogs() {
	check_ajax_referer('alergobot_nonce', 'nonce');

	$page     = isset($_POST['page']) ? absint($_POST['page']) : 1;
	$category = isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '';

	$args = [
		'post_type'      => 'blogs',
		'posts_per_page' => 9,
		'paged'          => $page,
		'post_status'    => 'publish',
	];

	if ($category && $category !== 'all') {
		$args['tax_query'] = [[
			'taxonomy' => 'blog_category',
			'field'    => 'term_id',
			'terms'    => absint($category),
		]];
	}

	$query = new WP_Query($args);

	ob_start();
	while ($query->have_posts()) {
		$query->the_post();
		get_template_part('template-parts/blog/card');
	}
	wp_reset_postdata();

	wp_send_json_success([
		'html'      => ob_get_clean(),
		'max_pages' => $query->max_num_pages,
	]);
}
