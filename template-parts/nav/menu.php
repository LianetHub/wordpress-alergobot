<?php

/**
 * Main navigation menu from ACF options.
 *
 * @package alergobot
 *
 * @var string $args['menu_class']  Menu UL class.
 * @var string $args['item_class']  LI class.
 * @var string $args['link_class']   Link class.
 */

$menu_class = $args['menu_class'] ?? 'header__menu';
$item_class = $args['item_class'] ?? 'header__item';
$link_class = $args['link_class'] ?? 'header__link';

if (!function_exists('have_rows') || !have_rows('glavnoe_menyu', 'option')) {
	return;
}
?>
<ul class="<?php echo esc_attr($menu_class); ?>">
	<?php
	while (have_rows('glavnoe_menyu', 'option')) :
		the_row();
		$name = get_sub_field('nazvanie');
		$link = get_sub_field('ssylka');
		if (!$name || !$link) {
			continue;
		}
		$has_submenu = (bool) get_sub_field('est_podmenyu');
	?>
		<?php
		$popup_attrs = '';
		if (str_starts_with($link, '#popup-')) {
			$popup_attrs = ' data-fancybox data-src="' . esc_attr($link) . '"';
		}
		?>
		<li class="<?php echo esc_attr($item_class . ($has_submenu ? ' has-dropdown' : '')); ?>">
			<a class="<?php echo esc_attr($link_class); ?>" href="<?php echo alergobot_esc_link($link); ?>" <?php echo $popup_attrs; ?>><?php echo esc_html($name); ?></a>
			<?php if ($has_submenu && have_rows('podmenyu')) : ?>
				<ul class="header__submenu">
					<?php
					while (have_rows('podmenyu')) :
						the_row();
						$sub_name = get_sub_field('nazvanie');
						$sub_link = get_sub_field('ssylka');
						if ($sub_name && $sub_link) :
					?>
							<li><a href="<?php echo alergobot_esc_link($sub_link); ?>"><?php echo esc_html($sub_name); ?></a></li>
					<?php
						endif;
					endwhile;
					?>
				</ul>
			<?php endif; ?>
		</li>
	<?php endwhile; ?>
</ul>