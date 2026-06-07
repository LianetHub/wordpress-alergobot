<?php
/**
 * Single product
 *
 * @package alergobot
 */

get_header();

while (have_posts()) :
	the_post();

	get_template_part('template-parts/product/hero');
	get_template_part('template-parts/product/tabs');
	get_template_part('template-parts/product/benefits');
	get_template_part('template-parts/product/related');
endwhile;

get_footer();
