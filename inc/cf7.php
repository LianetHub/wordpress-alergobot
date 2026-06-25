<?php
/**
 * Contact Form 7 integration
 *
 * @package alergobot
 */

// Отключаем автоматические <p> и <br> в разметке формы.
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Контекст рендера CF7: источник формы и мета-поля.
 */
function alergobot_cf7_set_render_context( $source = '' ) {
	$GLOBALS['alergobot_cf7_render_context'] = array(
		'form-source' => '' !== $source ? $source : __( 'Форма с сайта', 'alergobot' ),
		'form-page'   => alergobot_cf7_build_form_page_meta(),
		'form-time'   => (string) time(),
	);
}

function alergobot_cf7_clear_render_context() {
	unset( $GLOBALS['alergobot_cf7_render_context'] );
}

function alergobot_cf7_get_render_context() {
	return $GLOBALS['alergobot_cf7_render_context'] ?? null;
}

function alergobot_cf7_current_page_url() {
	if ( is_singular() ) {
		return get_permalink();
	}

	$host = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';

	if ( $host && $uri ) {
		return esc_url_raw( ( is_ssl() ? 'https' : 'http' ) . '://' . $host . $uri );
	}

	return esc_url( home_url( '/' ) );
}

function alergobot_cf7_page_title_for_url( $url ) {
	$post_id = url_to_postid( $url );

	if ( $post_id ) {
		return get_the_title( $post_id );
	}

	return get_bloginfo( 'name' );
}

function alergobot_cf7_decode_text( $text ) {
	return html_entity_decode( wp_strip_all_tags( (string) $text ), ENT_QUOTES, 'UTF-8' );
}

function alergobot_cf7_current_page_title() {
	if ( did_action( 'wp' ) && function_exists( 'wp_get_document_title' ) ) {
		return alergobot_cf7_decode_text( wp_get_document_title() );
	}

	return get_bloginfo( 'name', 'display' );
}

function alergobot_cf7_current_page_link_name() {
	if ( ! did_action( 'wp' ) ) {
		return get_bloginfo( 'name', 'display' );
	}

	if ( is_singular() ) {
		return get_the_title();
	}

	if ( is_tax() || is_category() || is_tag() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			if ( 'product_category' === $term->taxonomy && function_exists( 'alergobot_get_term_field' ) ) {
				$heading = trim( (string) alergobot_get_term_field( 'cat_heading_title', $term ) );
				if ( '' !== $heading ) {
					return $heading;
				}
			}

			return $term->name;
		}
	}

	if ( is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );
		if ( is_array( $post_type ) ) {
			$post_type = (string) reset( $post_type );
		}
		$object = $post_type ? get_post_type_object( $post_type ) : null;
		if ( $object && ! empty( $object->labels->name ) ) {
			return $object->labels->name;
		}
	}

	if ( is_front_page() ) {
		$front_id = (int) get_option( 'page_on_front' );
		if ( $front_id ) {
			return get_the_title( $front_id );
		}

		return get_bloginfo( 'name', 'display' );
	}

	if ( is_home() ) {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		if ( $posts_page_id ) {
			return get_the_title( $posts_page_id );
		}
	}

	if ( is_page() ) {
		return get_the_title();
	}

	return alergobot_cf7_current_page_title();
}

function alergobot_cf7_format_form_page_meta( $title, $link_name ) {
	$title     = trim( (string) $title );
	$link_name = trim( (string) $link_name );

	if ( '' === $title && '' === $link_name ) {
		return get_bloginfo( 'name', 'display' );
	}

	if ( '' === $title ) {
		return $link_name;
	}

	if ( '' === $link_name || $title === $link_name ) {
		return $title;
	}

	return $title . ' | ' . $link_name;
}

function alergobot_cf7_page_document_title_for_url( $url ) {
	$post_id = url_to_postid( $url );

	if ( $post_id ) {
		$yoast_title = get_post_meta( $post_id, '_yoast_wpseo_title', true );
		if ( is_string( $yoast_title ) && '' !== trim( $yoast_title ) ) {
			return alergobot_cf7_decode_text( $yoast_title );
		}

		return get_the_title( $post_id );
	}

	return alergobot_cf7_page_title_for_url( $url );
}

function alergobot_cf7_build_form_page_meta( $url = null ) {
	if ( null === $url ) {
		return alergobot_cf7_format_form_page_meta(
			alergobot_cf7_current_page_title(),
			alergobot_cf7_current_page_link_name()
		);
	}

	$url = esc_url( $url );

	return alergobot_cf7_format_form_page_meta(
		alergobot_cf7_page_document_title_for_url( $url ),
		alergobot_cf7_page_title_for_url( $url )
	);
}

function alergobot_cf7_get_submission_referer_url() {
	$referer = wp_get_referer();

	if ( ! $referer && ! empty( $_SERVER['HTTP_REFERER'] ) ) {
		$referer = esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) );
	}

	return $referer ? esc_url( $referer ) : esc_url( home_url( '/' ) );
}

function alergobot_cf7_is_url_like( $value ) {
	$value = trim( (string) $value );

	return '' !== $value && ( str_contains( $value, '://' ) || str_starts_with( $value, '//' ) );
}

function alergobot_cf7_set_hidden_field( $content, $name, $value ) {
	$escaped_name  = preg_quote( $name, '/' );
	$escaped_value = esc_attr( $value );

	$pattern = '/(<input(?=[^>]*\bname="' . $escaped_name . '")[^>]*\bvalue=")([^"]*)("[^>]*>)/i';
	if ( preg_match( $pattern, $content ) ) {
		return preg_replace( $pattern, '${1}' . $escaped_value . '${3}', $content );
	}

	$pattern_no_value = '/(<input(?=[^>]*\bname="' . $escaped_name . '")(?![^>]*\bvalue=)[^>]*)(>)/i';
	if ( preg_match( $pattern_no_value, $content ) ) {
		return preg_replace( $pattern_no_value, '${1} value="' . $escaped_value . '${2}', $content );
	}

	return $content . sprintf(
		'<input type="hidden" name="%1$s" value="%2$s" class="wpcf7-form-control wpcf7-hidden" />',
		esc_attr( $name ),
		$escaped_value
	);
}

/**
 * Нормализует пути к SVG-спрайту.
 */
add_filter(
	'wpcf7_form_elements',
	function ( $content ) {
		$icons_uri = alergobot_assets_uri( 'img/icons.svg' );
		$theme_uri = get_template_directory_uri();

		$content = str_replace(
			array(
				'@img/icons.svg',
				$theme_uri . '/img/icons.svg',
			),
			$icons_uri,
			$content
		);

		$content = preg_replace(
			'/<span class="checkbox__box"[^>]*>\s*<svg[^>]*>.*?<\/svg>\s*<\/span>/s',
			'<span class="checkbox__box" aria-hidden="true"></span>',
			$content
		);

		return $content;
	}
);

/**
 * Заполняет скрытые мета-поля CF7 при рендере формы.
 */
add_filter(
	'wpcf7_form_elements',
	function ( $content ) {
		$context = alergobot_cf7_get_render_context();

		if ( ! $context ) {
			return $content;
		}

		foreach ( $context as $name => $value ) {
			$content = alergobot_cf7_set_hidden_field( $content, $name, $value );
		}

		return $content;
	},
	20
);

function alergobot_cf7_get_submission_page_meta() {
	$submission = WPCF7_Submission::get_instance();
	$posted     = $submission ? (array) $submission->get_posted_data() : array();
	$url        = alergobot_cf7_get_submission_referer_url();

	if ( ! empty( $posted['form-page'] ) ) {
		$page_meta = (string) $posted['form-page'];

		if ( str_contains( $page_meta, ' | ' ) ) {
			[$title, $second] = array_pad( explode( ' | ', $page_meta, 2 ), 2, '' );
			$title            = trim( $title );
			$second           = trim( $second );

			if ( alergobot_cf7_is_url_like( $second ) ) {
				return array(
					'title' => '' !== $title ? $title : alergobot_cf7_page_title_for_url( $second ),
					'url'   => esc_url( $second ),
				);
			}

			if ( '' !== $title || '' !== $second ) {
				return array(
					'title' => '' !== $title ? $title : $second,
					'url'   => $url,
				);
			}
		}

		$single = trim( $page_meta );
		if ( '' !== $single ) {
			return array(
				'title' => $single,
				'url'   => $url,
			);
		}
	}

	return array(
		'title' => alergobot_cf7_page_title_for_url( $url ),
		'url'   => $url,
	);
}

function alergobot_cf7_field_value( $value ) {
	if ( is_array( $value ) ) {
		$value = array_filter( $value, static fn( $item ) => '' !== $item && null !== $item );

		return implode( ', ', array_map( 'strval', $value ) );
	}

	return trim( (string) $value );
}

/**
 * Человекочитаемое значение чекбокса согласия (acceptance agree).
 */
function alergobot_cf7_format_agree_value( $value ) {
	$value = alergobot_cf7_field_value( $value );

	if ( '' === $value || '0' === $value ) {
		return __( 'Не дано', 'alergobot' );
	}

	if ( '1' === $value || strcasecmp( $value, 'on' ) === 0 || strcasecmp( $value, 'yes' ) === 0 ) {
		return __( 'Одобрено', 'alergobot' );
	}

	return $value;
}

add_action(
	'wpcf7_mail_failed',
	function ( $contact_form ) {
		if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
			return;
		}

		error_log( 'CF7 mail failed for form #' . $contact_form->id() );
	},
	10,
	1
);

/**
 * Кастомные mail-теги: [_date_msk], [_url], [_post_title], [_post_url].
 */
add_filter(
	'wpcf7_special_mail_tags',
	function ( $output, $name ) {
		if ( '_date_msk' === $name ) {
			$tz = new DateTimeZone( 'Europe/Moscow' );

			return ( new DateTime( 'now', $tz ) )->format( 'd.m.Y H:i:s' );
		}

		if ( '_url' === $name ) {
			$page_meta = alergobot_cf7_get_submission_page_meta();

			return $page_meta['url'];
		}

		if ( '_post_title' === $name ) {
			$page_meta = alergobot_cf7_get_submission_page_meta();

			return $page_meta['title'];
		}

		if ( '_post_url' === $name ) {
			$page_meta = alergobot_cf7_get_submission_page_meta();

			return $page_meta['url'];
		}

		return $output;
	},
	10,
	2
);

/**
 * Серверный fallback для скрытых мета-полей CF7.
 */
add_filter(
	'wpcf7_posted_data',
	function ( $posted ) {
		$page_url = alergobot_cf7_get_submission_referer_url();

		if ( empty( $posted['form-time'] ) ) {
			$posted['form-time'] = (string) time();
		}

		if ( empty( $posted['form-page'] ) ) {
			$posted['form-page'] = alergobot_cf7_build_form_page_meta( $page_url );
		}

		if ( empty( $posted['form-source'] ) ) {
			$posted['form-source'] = __( 'Форма с сайта', 'alergobot' );
		}

		return $posted;
	}
);

/**
 * Форматирование mail-тегов для писем.
 */
add_filter(
	'wpcf7_mail_tag_replaced',
	function ( $replaced, $submitted, $html, $mail_tag ) {
		if ( ! is_object( $mail_tag ) ) {
			return $replaced;
		}

		$field = $mail_tag->field_name();

		if ( 'agree' === $field ) {
			$formatted = alergobot_cf7_format_agree_value( $submitted );

			return $html ? esc_html( $formatted ) : $formatted;
		}

		if ( 'your-message' === $field ) {
			$message = alergobot_cf7_field_value( $submitted );

			if ( '' === $message ) {
				return $html ? '&mdash;' : '—';
			}

			return $html ? nl2br( esc_html( $message ), false ) : $message;
		}

		return $replaced;
	},
	10,
	4
);

/**
 * Map popup forms to CF7 shortcodes (set in ACF Options).
 */
function alergobot_popup_cf7( $key, $source = '', $default_shortcode = '' ) {
	alergobot_cf7_form( $key, $source, $default_shortcode );
}
