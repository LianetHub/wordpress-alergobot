<?php
/**
 * Single blog post
 *
 * @package alergobot
 */

get_header();

while (have_posts()) :
	the_post();
	get_template_part('template-parts/pages/blog', 'single');
endwhile;

get_footer();
