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

function alergobot_cf7_build_form_page_meta( $url = null ) {
	if ( null === $url ) {
		$url = alergobot_cf7_current_page_url();
	} else {
		$url = esc_url( $url );
	}

	return alergobot_cf7_page_title_for_url( $url ) . ' | ' . $url;
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

	if ( ! empty( $posted['form-page'] ) ) {
		$page_meta = (string) $posted['form-page'];

		if ( str_contains( $page_meta, ' | ' ) ) {
			[$title, $url] = array_pad( explode( ' | ', $page_meta, 2 ), 2, '' );
			$title         = trim( $title );
			$url           = trim( $url );

			if ( '' !== $title || '' !== $url ) {
				return array(
					'title' => '' !== $title ? $title : alergobot_cf7_page_title_for_url( $url ),
					'url'   => '' !== $url ? esc_url( $url ) : '',
				);
			}
		}
	}

	$referer = wp_get_referer();

	if ( ! $referer && ! empty( $_SERVER['HTTP_REFERER'] ) ) {
		$referer = esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) );
	}

	$url = $referer ? esc_url( $referer ) : esc_url( home_url( '/' ) );

	return array(
		'title' => alergobot_cf7_page_title_for_url( $url ),
		'url'   => $url,
	);
}

function alergobot_cf7_telegram_field_value( $value ) {
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
	$value = alergobot_cf7_telegram_field_value( $value );

	if ( '' === $value || '0' === $value ) {
		return __( 'Не дано', 'alergobot' );
	}

	if ( '1' === $value || strcasecmp( $value, 'on' ) === 0 || strcasecmp( $value, 'yes' ) === 0 ) {
		return __( 'Одобрено', 'alergobot' );
	}

	return $value;
}

function alergobot_cf7_telegram_skip_field( $name ) {
	$skip = array(
		'form-source',
		'form-page',
		'form-time',
		'g-recaptcha-response',
		'_wpcf7',
		'_wpcf7_version',
		'_wpcf7_locale',
		'_wpcf7_container_post',
		'_wpcf7_posted_data_hash',
		'_wpcf7cf_hidden_group_fields',
		'_wpcf7cf_hidden_groups',
		'_wpcf7cf_options',
	);

	return in_array( $name, $skip, true ) || str_starts_with( $name, '_' );
}

function alergobot_cf7_telegram_bold_labels( $message ) {
	$lines  = explode( "\n", $message );
	$result = array();

	foreach ( $lines as $line ) {
		$line = trim( $line );

		if ( '' === $line ) {
			$result[] = '';
			continue;
		}

		if ( preg_match( '/^(.+?):\s*(.*)$/u', $line, $matches ) ) {
			$label = trim( $matches[1] );
			$value = $matches[2];

			if ( ! preg_match( '/^https?$/i', $label ) ) {
				$result[] = '<b>' . htmlspecialchars( $label, ENT_NOQUOTES, 'UTF-8' ) . ':</b> ' . htmlspecialchars( $value, ENT_NOQUOTES, 'UTF-8' );
				continue;
			}
		}

		if ( ! str_contains( $line, ':' ) ) {
			$result[] = '<b>' . htmlspecialchars( $line, ENT_NOQUOTES, 'UTF-8' ) . '</b>';
			continue;
		}

		$result[] = htmlspecialchars( $line, ENT_NOQUOTES, 'UTF-8' );
	}

	return implode( "\n", $result );
}

function alergobot_cf7_build_telegram_message() {
	$submission = WPCF7_Submission::get_instance();

	if ( ! $submission ) {
		return '';
	}

	$posted      = (array) $submission->get_posted_data();
	$tz          = new DateTimeZone( 'Europe/Moscow' );
	$date_msk    = ( new DateTime( 'now', $tz ) )->format( 'd.m.Y H:i:s' );
	$form_source = alergobot_cf7_telegram_field_value( $posted['form-source'] ?? __( 'Форма с сайта', 'alergobot' ) );
	$form_page   = alergobot_cf7_telegram_field_value( $posted['form-page'] ?? '' );

	if ( '' === $form_page ) {
		$page_meta = alergobot_cf7_get_submission_page_meta();
		$form_page = $page_meta['title'] . ' | ' . $page_meta['url'];
	}

	$known_fields = array(
		'your-name'    => '👤 Имя',
		'company'      => '🏢 Компания',
		'your-phone'   => '📞 Телефон',
		'your-email'   => '✉️ Email',
		'your-message' => '💬 Комментарий',
		'agree'        => 'ℹ️ Согласие',
	);

	$lines = array(
		'📨 НОВАЯ ЗАЯВКА С САЙТА 📨',
		'',
		'📝 Форма: ' . $form_source,
		'📅 Дата и время: ' . $date_msk,
		'',
		'📋 ДАННЫЕ ЗАЯВКИ:',
	);

	foreach ( $known_fields as $key => $label ) {
		if ( ! isset( $posted[ $key ] ) ) {
			continue;
		}

		$value = alergobot_cf7_telegram_field_value( $posted[ $key ] );

		if ( '' === $value ) {
			continue;
		}

		if ( 'agree' === $key ) {
			$value = alergobot_cf7_format_agree_value( $value );
		}

		if ( 'your-message' === $key ) {
			$value = preg_replace( '/\s+/', ' ', $value );
		}

		$lines[] = $label . ': ' . $value;
	}

	foreach ( $posted as $key => $raw_value ) {
		if ( isset( $known_fields[ $key ] ) || alergobot_cf7_telegram_skip_field( $key ) ) {
			continue;
		}

		$value = alergobot_cf7_telegram_field_value( $raw_value );

		if ( '' === $value ) {
			continue;
		}

		$label   = 'ℹ️ ' . ucwords( str_replace( array( '-', '_' ), ' ', $key ) );
		$lines[] = $label . ': ' . $value;
	}

	$lines[] = '';
	$lines[] = 'ℹ️ Страница: ' . $form_page;

	return alergobot_cf7_telegram_bold_labels( implode( "\n", $lines ) );
}

/**
 * Telegram-уведомления при успешной отправке CF7.
 * Токен и chat_id задаются в .env (см. .env.example).
 */
add_action(
	'wpcf7_mail_sent',
	function ( $contact_form ) {
		$submission = WPCF7_Submission::get_instance();

		if ( ! $submission ) {
			return;
		}

		$token   = alergobot_env( 'ALERGOBOT_TG_BOT_TOKEN' );
		$chat_id = alergobot_env( 'ALERGOBOT_TG_CHAT_ID' );

		if ( ! $token || ! $chat_id ) {
			return;
		}

		$message = alergobot_cf7_build_telegram_message();

		if ( '' === $message ) {
			return;
		}

		$url = "https://api.telegram.org/bot{$token}/sendMessage";

		$response = wp_remote_post(
			$url,
			array(
				'body' => array(
					'chat_id'    => $chat_id,
					'text'       => $message,
					'parse_mode' => 'HTML',
				),
			)
		);

		if ( is_wp_error( $response ) && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( 'CF7 Telegram: ' . $response->get_error_message() );
		}
	},
	10,
	1
);

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
		$referer = wp_get_referer();

		if ( ! $referer && ! empty( $_SERVER['HTTP_REFERER'] ) ) {
			$referer = esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) );
		}

		$page_url = $referer ? esc_url( $referer ) : esc_url( home_url( '/' ) );

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
			$message = alergobot_cf7_telegram_field_value( $submitted );

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
