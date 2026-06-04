<?php
/**
 * Single blog post
 *
 * @package alergobot
 */

get_header();

$post_id    = get_the_ID();
$title      = function_exists('get_field') && get_field('zagolovok') ? get_field('zagolovok') : get_the_title();
$categories = get_the_terms($post_id, 'blog_category');
?>
<main class="page page--article">
	<?php
	if (file_exists(ALERGOBOT_DIR . '/inc/markup/pages/statya.html')) {
		alergobot_render_page_markup('statya.html');
	} else :
		?>
		<article class="article">
			<div class="article__container _container">
				<h1 class="article__title title title-lg"><?php echo esc_html($title); ?></h1>
				<div class="article__meta">
					<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j F Y')); ?></time>
					<?php if ($categories && !is_wp_error($categories)) : ?>
						<span><?php echo esc_html(implode(', ', wp_list_pluck($categories, 'name'))); ?></span>
					<?php endif; ?>
				</div>
				<?php if (has_post_thumbnail()) : ?>
					<div class="article__media">
						<?php the_post_thumbnail('large', ['loading' => 'lazy']); ?>
					</div>
				<?php endif; ?>
				<div class="article__content">
					<?php the_content(); ?>
				</div>
			</div>
		</article>
		<?php
	endif;
	?>
</main>
<?php
get_footer();
