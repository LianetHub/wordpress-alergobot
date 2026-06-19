<?php
/**
 * Home section: advantages (FAQ)
 *
 * @package alergobot
 */

$faq_items = array();

if ( function_exists( 'have_rows' ) && have_rows( 'items' ) ) {
	while ( have_rows( 'items' ) ) {
		the_row();
		$faq_items[] = array(
			'question' => get_sub_field( 'question' ),
			'answer'   => get_sub_field( 'answer' ),
			'is_open'  => (bool) get_sub_field( 'is_open' ),
		);
	}
}

get_template_part(
	'template-parts/section/faq',
	null,
	array(
		'tag'   => alergobot_home_get( 'tag' ),
		'title' => alergobot_home_get( 'title' ),
		'items' => $faq_items,
	)
);
