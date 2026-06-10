<?php
/**
 * WordPress gallery output for article content
 *
 * @package alergobot
 */

add_filter( 'use_default_gallery_style', '__return_false' );

add_filter( 'post_gallery', 'alergobot_render_post_gallery', 10, 3 );

/**
 * Custom gallery markup with Fancybox grouping.
 *
 * @param string $output   Default gallery output.
 * @param array  $attr     Shortcode attributes.
 * @param int    $instance Gallery instance number.
 * @return string
 */
function alergobot_render_post_gallery( $output, $attr, $instance ) {
	$post = get_post();

	$atts = shortcode_atts(
		array(
			'order'   => 'ASC',
			'orderby' => 'menu_order ID',
			'id'      => $post ? $post->ID : 0,
			'columns' => 3,
			'size'    => 'full',
			'include' => '',
			'exclude' => '',
			'link'    => 'file',
		),
		$attr,
		'gallery'
	);

	$id = (int) $atts['id'];

	if ( $id < 1 ) {
		return $output;
	}

	if ( ! empty( $atts['include'] ) ) {
		$include     = array_map( 'intval', array_filter( explode( ',', $atts['include'] ) ) );
		$attachments = get_posts(
			array(
				'include'        => $include,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => 'post__in',
			)
		);
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$exclude     = array_map( 'intval', array_filter( explode( ',', $atts['exclude'] ) ) );
		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'exclude'        => $exclude,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);
	} else {
		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);
	}

	if ( empty( $attachments ) ) {
		return $output;
	}

	$columns    = max( 1, min( 9, (int) $atts['columns'] ) );
	$size       = sanitize_key( $atts['size'] );
	$gallery_id = 'gallery-' . (int) $instance;
	$classes    = array(
		'gallery',
		'galleryid-' . $id,
		'gallery-columns-' . $columns,
		'gallery-size-' . $size,
		'article__gallery',
	);

	if ( 2 === $columns ) {
		$classes[] = 'article__gallery--duo';
	}

	$html = sprintf(
		'<div id="%1$s" class="%2$s %3$s">',
		esc_attr( $gallery_id ),
		esc_attr( implode( ' ', $classes ) ),
		alergobot_anim_class( 'reveal' )
	);

	foreach ( $attachments as $attachment ) {
		$full_src = wp_get_attachment_image_src( $attachment->ID, 'full' );
		if ( ! $full_src ) {
			continue;
		}

		$image = wp_get_attachment_image(
			$attachment->ID,
			$size,
			false,
			array(
				'decoding' => 'async',
				'loading'  => 'lazy',
			)
		);

		if ( ! $image ) {
			continue;
		}

		$html .= '<figure class="gallery-item">';
		$html .= '<div class="gallery-icon">';
		$html .= sprintf(
			'<a href="%1$s" data-fancybox="%2$s">%3$s</a>',
			esc_url( $full_src[0] ),
			esc_attr( $gallery_id ),
			$image
		);
		$html .= '</div>';
		$html .= '</figure>';
	}

	$html .= '</div>';

	return $html;
}
