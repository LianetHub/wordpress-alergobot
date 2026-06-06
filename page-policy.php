<?php
/**
 * Template Name: Политика конфиденциальности
 *
 * @package alergobot
 */

get_header();
?>
	<?php
	if (have_posts()) :
		while (have_posts()) :
			the_post();
			the_content();
		endwhile;
	else :
		get_template_part('template-parts/pages/policy', 'fallback');
	endif;
	?>
<?php
get_footer();
