<?php
/**
 * Product RU / KTRU tab
 *
 * @package alergobot
 */

$post_id = get_the_ID();

$specs_raw = alergobot_get_post_field( 'product_ru_specs', $post_id );
$specs     = is_array( $specs_raw ) ? $specs_raw : array();
$ru_file   = alergobot_get_post_file_field( 'product_ru_file', $post_id );

if ( ! $specs && ! $ru_file ) {
	return;
}

$is_active         = (bool) get_query_var( 'product_tab_active' );
$ru_download_label = __( 'Скачать РУ', 'alergobot' );
$ru_file_shown     = false;
$ru_file_label     = $ru_file ? ( $ru_file['filename'] ?: $ru_file['title'] ?: wp_basename( $ru_file['url'] ) ) : '';

?>
<div class="product-panel<?php echo $is_active ? ' _active' : ''; ?>" id="product-panel-ru" role="tabpanel" aria-labelledby="product-tab-ru" data-product-panel="ru"<?php echo $is_active ? '' : ' hidden=""'; ?>>
	<div class="product-panel__inner product-panel__inner--ru">
		<h2 class="product-panel__heading <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php esc_html_e( 'Регистрационное удостоверение', 'alergobot' ); ?></h2>
		<?php if ( $specs || $ru_file ) : ?>
			<dl class="product-spec <?php echo alergobot_anim_class( 'stagger' ); ?>">
				<?php
				foreach ( $specs as $spec ) :
					$term  = trim( (string) ( $spec['term'] ?? '' ) );
					$value = (string) ( $spec['value'] ?? '' );
					if ( ! $term ) {
						continue;
					}

					$is_download_row = $ru_file && $ru_download_label === $term;
					if ( '' === trim( $value ) && ! $is_download_row ) {
						continue;
					}
					if ( $is_download_row ) {
						$ru_file_shown = true;
					}
					?>
					<div class="product-spec__row">
						<dt class="product-spec__term"><?php echo esc_html( $term ); ?></dt>
						<dd class="product-spec__value">
							<?php if ( $is_download_row ) : ?>
								<a class="product-spec__link" href="<?php echo esc_url( $ru_file['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $ru_file_label ); ?></a>
							<?php else : ?>
								<?php echo nl2br( esc_html( $value ) ); ?>
							<?php endif; ?>
						</dd>
					</div>
				<?php endforeach; ?>
				<?php if ( $ru_file && ! $ru_file_shown ) : ?>
					<div class="product-spec__row">
						<dt class="product-spec__term"><?php echo esc_html( $ru_download_label ); ?></dt>
						<dd class="product-spec__value">
							<a class="product-spec__link" href="<?php echo esc_url( $ru_file['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $ru_file_label ); ?></a>
						</dd>
					</div>
				<?php endif; ?>
			</dl>
		<?php endif; ?>
	</div>
</div>
