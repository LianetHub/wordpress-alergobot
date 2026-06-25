<?php
/**
 * Page template: katalog
 *
 * @package alergobot
 */

$page_id = get_the_ID();
$icons   = alergobot_assets_uri( 'img/icons.svg' );

$heading_title = function_exists( 'get_field' ) ? (string) get_field( 'catalog_heading_title', $page_id ) : '';
$heading_text  = function_exists( 'get_field' ) ? (string) get_field( 'catalog_heading_text', $page_id ) : '';
$heading_tags  = array(
	__( 'Устройства', 'alergobot' ),
	__( 'Анализаторы', 'alergobot' ),
	__( 'Реагенты', 'alergobot' ),
	__( 'Панели', 'alergobot' ),
);
$sections      = function_exists( 'get_field' ) ? (array) get_field( 'catalog_sections', $page_id ) : array();
$faq_items     = function_exists( 'get_field' ) ? (array) get_field( 'catalog_faq', $page_id ) : array();

$request_title = function_exists( 'get_field' ) ? (string) get_field( 'catalog_request_title', $page_id ) : '';
$request_note  = function_exists( 'get_field' ) ? (string) get_field( 'catalog_request_note', $page_id ) : '';
$request_lead  = function_exists( 'get_field' ) ? (string) get_field( 'catalog_request_lead', $page_id ) : '';

[$faq_col1, $faq_col2] = alergobot_split_faq_columns( $faq_items );

$has_request = $request_title || $request_note || $request_lead;

?><section class="heading heading--catalog">
	<div class="heading__container _container">
		<div class="heading__wrapper">
			<div class="heading__points" aria-hidden="true">
				<span class="heading__point"></span><span class="heading__point"></span><span class="heading__point"></span><span class="heading__point"></span>
			</div>
			<?php if ( $heading_title ) : ?>
				<h1 class="heading__title title title-lg <?php echo alergobot_anim_class( 'blur-up', '_anim-no-hide' ); ?>"><?php echo esc_html( $heading_title ); ?></h1>
			<?php endif; ?>
			<div class="heading__grid">
				<div class="heading__main">
					<?php echo alergobot_anim_wrap_open( 'fade-up', '_anim-no-hide', 'inline' ); ?>
					<a class="btn btn--primary heading__cta a-hover-lift" data-fancybox href="#popup-consultation">
						<?php esc_html_e( 'Задать вопрос', 'alergobot' ); ?>
						<svg class="btn__icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url( $icons ); ?>#icon-arrow-up-right"></use>
						</svg>
					</a>
					<?php echo alergobot_anim_wrap_close(); ?>
					<ul class="heading__tags">
						<?php foreach ( $heading_tags as $heading_tag ) : ?>
							<li class="heading__tags-item">
								<span class="heading__tag <?php echo alergobot_anim_class( 'bounce-up', '_anim-no-hide' ); ?>"><?php echo esc_html( $heading_tag ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php if ( $heading_text ) : ?>
					<div class="heading__aside">
						<div class="heading__text <?php echo alergobot_anim_class( 'fade-up', '_anim-no-hide' ); ?>">
							<?php echo wp_kses_post( $heading_text ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php
foreach ( $sections as $section ) :
	$section_id    = $section['section_id'] ?? '';
	$section_class = 'catalog' . ( ! empty( $section['is_reverse'] ) ? ' catalog--reverse' : '' );
	$section_title = $section['title'] ?? '';
	$section_text  = $section['text'] ?? '';
	$section_btn = $section['btn'] ?? null;
	$section_tag = $section['tag'] ?? '';
	$gallery     = $section['gallery'] ?? array();
	$btn_url     = is_array( $section_btn ) ? alergobot_acf_link_url( $section_btn, '' ) : '';

	if ( ! $section_title && ! $section_text && ! $btn_url && ! $section_tag && ! $gallery ) {
		continue;
	}
	?>
	<section class="<?php echo esc_attr( $section_class ); ?>" <?php echo $section_id ? ' id="' . esc_attr( $section_id ) . '"' : ''; ?>>
		<div class="catalog__container _container">
			<div class="catalog__main <?php echo alergobot_anim_class( 'fade' ); ?>">
				<div class="catalog__info">
					<?php if ( $section_title ) : ?>
						<h2 class="catalog__title title title-md <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $section_title ); ?></h2>
					<?php endif; ?>
					<?php if ( $section_text ) : ?>
						<p class="catalog__text <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $section_text ); ?></p>
					<?php endif; ?>
					<?php
					if ( is_array( $section_btn ) ) :
						$button_url   = alergobot_acf_link_url( $section_btn, '' );
						$button_title = alergobot_acf_link_title( $section_btn, '' );
						if ( $button_url && $button_title ) :
							?>
							<?php echo alergobot_anim_wrap_open( 'fade-up', '', 'fill' ); ?>
							<a class="btn btn--primary catalog__btn a-hover-lift" href="<?php echo esc_url( $button_url ); ?>"<?php echo alergobot_acf_link_target( $section_btn ) ? ' target="' . esc_attr( alergobot_acf_link_target( $section_btn ) ) . '"' : ''; ?>>
								<?php echo esc_html( $button_title ); ?>
								<svg class="btn__icon" width="28" height="28">
									<use href="<?php echo esc_url( $icons ); ?>#icon-arrow-up-right"></use>
								</svg>
							</a>
							<?php echo alergobot_anim_wrap_close(); ?>
							<?php
						endif;
					endif;
					?>
				</div>
			</div>
			<div class="catalog__side">
				<?php if ( $section_tag ) : ?>
					<span class="tag catalog__tag <?php echo alergobot_anim_class( 'bounce-up' ); ?>"><?php echo esc_html( $section_tag ); ?></span>
				<?php endif; ?>
				<?php if ( $gallery ) : ?>
					<div class="catalog__gallery" data-motion="catalog-gallery" data-motion-target=".catalog__gallery-decor">
						<div class="catalog__gallery-decor" aria-hidden="true"></div>
						<?php
						foreach ( $gallery as $gallery_item ) :
							$gallery_item = alergobot_resolve_catalog_gallery_item( $gallery_item, $btn_url );
							if ( ! $gallery_item ) {
								continue;
							}

							alergobot_render_catalog_gallery_product(
								$gallery_item,
								$gallery_item['link_url'] ? 'a' : 'div'
							);
							?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endforeach; ?>
<?php if ( $has_request ) : ?>
	<section class="request request--plain" id="catalog-request">
		<div class="request__box">
			<div class="request__container _container">
				<div class="request__grid">
					<?php if ( $request_title || $request_note ) : ?>
						<div class="request__info">
							<?php if ( $request_title ) : ?>
								<h2 class="request__title title title-md title--light <?php echo alergobot_anim_class( 'blur-up' ); ?>"><?php echo esc_html( $request_title ); ?></h2>
							<?php endif; ?>
							<?php if ( $request_note ) : ?>
								<div class="request__note <?php echo alergobot_anim_class( 'fade-up' ); ?>">
									<span class="request__note-icon" aria-hidden="true">
										<svg class="request__note-icon-svg" width="50" height="50" aria-hidden="true">
											<use href="<?php echo esc_url( $icons ); ?>#icon-request-chat"></use>
										</svg>
									</span>
									<p class="request__note-text"><?php echo esc_html( $request_note ); ?></p>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="request__form-col">
						<?php if ( $request_lead ) : ?>
							<p class="request__lead <?php echo alergobot_anim_class( 'fade-left' ); ?>"><?php echo esc_html( $request_lead ); ?></p>
						<?php endif; ?>
						<div class="request__form form <?php echo alergobot_anim_class( 'form-rise' ); ?>">
							<?php alergobot_cf7_form( 'cf7_zakaz', __( 'Каталог', 'alergobot' ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php if ( $faq_col1 || $faq_col2 ) : ?>
	<section class="faq">
		<div class="faq__container _container">
			<div class="faq__head">
				<span class="faq__tag tag <?php echo alergobot_anim_class( 'bounce-up' ); ?>">FAQ</span>
				<h2 class="faq__title title-md <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php esc_html_e( 'Информация по часто задаваемым вопросам', 'alergobot' ); ?></h2>
			</div>
			<div class="faq__columns accordion" data-accordion="">
				<?php foreach ( array( $faq_col1, $faq_col2 ) as $column_index => $column_items ) : ?>
					<?php
					if ( ! $column_items ) {
						continue;
					}
					?>
					<div class="faq__col <?php echo alergobot_anim_class( 'stagger' ); ?>">
						<?php
						foreach ( $column_items as $item_index => $item ) :
							$question = $item['question'] ?? '';
							$answer   = $item['answer'] ?? '';
							if ( ! $question ) {
								continue;
							}
							$is_active = 0 === $column_index && 0 === $item_index;
							?>
							<div class="accordion__item<?php echo $is_active ? ' _active' : ''; ?>">
								<button class="accordion__header" type="button" aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>">
									<span class="accordion__question"><?php echo esc_html( $question ); ?></span>
									<svg class="accordion__chevron icon" width="32" height="32" aria-hidden="true">
										<use href="<?php echo esc_url( $icons ); ?>#icon-panels-chevron"></use>
									</svg>
								</button>
								<?php if ( $answer ) : ?>
									<div class="accordion__body">
										<div class="accordion__inner">
											<p class="accordion__answer"><?php echo esc_html( $answer ); ?></p>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>