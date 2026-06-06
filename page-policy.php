<?php
/**
 * Template Name: Политика конфиденциальности
 *
 * @package alergobot
 */

get_header();
?>
<main class="page page--policy">
	<?php
	if (have_posts()) :
		while (have_posts()) :
			the_post();
			the_content();
		endwhile;
	else :
		alergobot_render_page_markup('politika-konfidentsialnosti.html');
	endif;
	?>
</main>
<?php
get_footer();
