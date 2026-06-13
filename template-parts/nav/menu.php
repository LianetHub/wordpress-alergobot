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

if ( ! function_exists( 'have_rows' ) || ! have_rows( 'glavnoe_menyu', 'option' ) ) {
	return;
}
?>
<ul class="<?php echo esc_attr( $menu_class ); ?>">
	<?php
	while ( have_rows( 'glavnoe_menyu', 'option' ) ) :
		the_row();
		$name = get_sub_field( 'nazvanie' );
		$link = alergobot_normalize_link( get_sub_field( 'ssylka' ) );
		if ( ! $name || '' === $link ) {
			continue;
		}
		$has_submenu   = (bool) get_sub_field( 'est_podmenyu' );
		$submenu_items = array();

		if ( $has_submenu && have_rows( 'podmenyu' ) ) {
			while ( have_rows( 'podmenyu' ) ) {
				the_row();
				$sub_name = get_sub_field( 'nazvanie' );
				$sub_link = alergobot_normalize_link( get_sub_field( 'ssylka' ) );
				if ( $sub_name && '' !== $sub_link ) {
					$submenu_items[] = array(
						'name' => $sub_name,
						'link' => $sub_link,
					);
				}
			}
		}

		$is_active = alergobot_is_menu_link_active( $link );
		foreach ( $submenu_items as $submenu_item ) {
			if ( alergobot_is_menu_link_active( $submenu_item['link'] ) ) {
				$is_active = true;
				break;
			}
		}

		$item_classes = trim( $item_class . ( $has_submenu ? ' has-dropdown' : '' ) . ( $is_active ? ' _active' : '' ) );
		$link_classes = trim( $link_class . ( $is_active ? ' _active' : '' ) );
		?>
		<?php
		$popup_attrs = '';
		if ( str_starts_with( $link, '#popup-' ) ) {
			$popup_attrs = ' data-fancybox data-src="' . esc_attr( $link ) . '"';
		}
		?>
		<li class="<?php echo esc_attr( $item_classes ); ?>">
			<a class="<?php echo esc_attr( $link_classes ); ?>" href="<?php echo alergobot_esc_link( $link ); ?>"<?php echo $is_active ? ' aria-current="page"' : ''; ?><?php echo $popup_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Built from esc_attr() fragments. ?>><?php echo esc_html( $name ); ?></a>
			<?php if ( $submenu_items ) : ?>
				<ul class="header__submenu">
					<?php foreach ( $submenu_items as $submenu_item ) : ?>
						<?php
						$sub_is_active = alergobot_is_menu_link_active( $submenu_item['link'] );
						?>
						<li<?php echo $sub_is_active ? ' class="_active"' : ''; ?>>
							<a href="<?php echo alergobot_esc_link( $submenu_item['link'] ); ?>"<?php echo $sub_is_active ? ' class="_active" aria-current="page"' : ''; ?>><?php echo esc_html( $submenu_item['name'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</li>
	<?php endwhile; ?>
</ul>
