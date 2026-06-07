<?php

/**
 * Template Name: Политика конфиденциальности
 *
 * @package alergobot
 */

get_header();
?>
<?php
while (have_posts()) :
	the_post();
?>
	<section class="policy" data-decor-parallax>
		<div class="policy__container _container">
			<div class="policy__inner typography-block" data-animate="bottom">
				<h1> <?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
		</div>
	</section>
<?php
endwhile;
?>
<?php
get_footer();
