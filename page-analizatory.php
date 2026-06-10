<?php
/**
 * Template Name: Анализаторы
 *
 * @package alergobot
 */

get_header();

global $wp_query;

$term         = get_term_by( 'slug', 'analizatory', 'product_category' );
$backup_query = $wp_query;

if ( $term instanceof WP_Term ) {
	set_query_var( 'alergobot_product_category_term', $term );

	$wp_query = new WP_Query(
		array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_category',
					'field'    => 'term_id',
					'terms'    => (int) $term->term_id,
				),
			),
		)
	);
}

get_template_part( 'template-parts/product/category', 'archive' );

$wp_query = $backup_query;
wp_reset_postdata();

get_footer();
