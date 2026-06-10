<?php
/**
 * Blog category archive (legacy /category/stati, /category/novosti)
 *
 * @package alergobot
 */

get_header();
?>
	<?php get_template_part( 'template-parts/pages/blog', 'archive' ); ?>
<?php
get_footer();
