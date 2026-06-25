<?php
/**
 * Product description tab
 *
 * @package alergobot
 */

$post_id = get_the_ID();

$description = (string) alergobot_get_post_field( 'product_panel_description', $post_id );
$table_rows  = alergobot_get_post_field( 'product_panel_table', $post_id ) ?: array();

$show_allergen_en = false;
foreach ( $table_rows as $row ) {
	if ( '' !== trim( (string) ( $row['name_en'] ?? '' ) ) ) {
		$show_allergen_en = true;
		break;
	}
}

if ( ! $description && ! $table_rows ) {
	return;
}

$is_active = (bool) get_query_var( 'product_tab_active' );

?>
<div class="product-panel<?php echo $is_active ? ' _active' : ''; ?>" id="product-panel-description" role="tabpanel" aria-labelledby="product-tab-description" data-product-panel="description"<?php echo $is_active ? '' : ' hidden=""'; ?>>
	<div class="product-panel__inner product-panel__inner--description">
		<?php if ( $description ) : ?>
			<div class="product-panel__content <?php echo alergobot_anim_class( 'fade-up' ); ?>">
				<?php echo wp_kses_post( $description ); ?>
			</div>
		<?php endif; ?>
		<?php if ( $table_rows ) : ?>
			<div class="product-block product-block--allergens">
				<div class="product-table-wrap <?php echo alergobot_anim_class( 'reveal' ); ?>" data-product-table="">
					<table class="product-table">
						<colgroup>
							<col class="product-table__col-num">
							<col class="product-table__col-name">
							<?php if ( $show_allergen_en ) : ?>
								<col class="product-table__col-allergen">
							<?php endif; ?>
							<col class="product-table__col-code">
						</colgroup>
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col"><?php esc_html_e( 'Аллерген', 'alergobot' ); ?></th>
								<?php if ( $show_allergen_en ) : ?>
									<th scope="col">Allergen</th>
								<?php endif; ?>
								<th scope="col"><?php esc_html_e( 'Код', 'alergobot' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $table_rows as $row_index => $row ) : ?>
								<tr>
									<td><?php echo esc_html( (string) ( $row_index + 1 ) ); ?></td>
									<td><?php echo esc_html( $row['name_ru'] ?? '' ); ?></td>
									<?php if ( $show_allergen_en ) : ?>
										<td><?php echo esc_html( $row['name_en'] ?? '' ); ?></td>
									<?php endif; ?>
									<td><?php echo alergobot_breakable_code( $row['code'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot class="product-table__foot">
							<tr>
								<td></td>
								<td>
									<button class="product-table__more" type="button" data-product-table-more="" aria-expanded="false"><?php esc_html_e( 'ЕЩЕ', 'alergobot' ); ?></button>
								</td>
								<?php if ( $show_allergen_en ) : ?>
									<td></td>
								<?php endif; ?>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
