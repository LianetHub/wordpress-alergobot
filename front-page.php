<?php
/**
 * Front page template
 *
 * @package alergobot
 */

get_header();

if (function_exists('have_rows') && have_rows('page_content')) :
	while (have_rows('page_content')) :
		the_row();
		get_template_part('template-parts/section/section', get_row_layout());
	endwhile;
else :
	$sections = [
		'hero',
		'audience',
		'catalog-teaser',
		'pick',
		'panels',
		'choose',
		'equipment',
		'process',
		'partners',
		'docs',
		'request',
		'about',
		'benefits',
		'news',
		'advantages',
		'contacts',
	];
	foreach ($sections as $section) {
		get_template_part('template-parts/home/' . $section);
	}
endif;

get_footer();
