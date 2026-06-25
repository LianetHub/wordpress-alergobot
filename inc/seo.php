<?php
/**
 * SEO helpers: archive pages mapped to companion WordPress pages.
 *
 * @package alergobot
 */

if ( ! function_exists( 'alergobot_get_blogs_archive_page_id' ) ) {
	/**
	 * Companion page for the blogs CPT archive (SEO, keywords, Yoast).
	 *
	 * @return int
	 */
	function alergobot_get_blogs_archive_page_id() {
		static $page_id = null;

		if ( null !== $page_id ) {
			return $page_id;
		}

		$page    = get_page_by_path( 'stati-po-allergologii' );
		$page_id = ( $page && 'publish' === $page->post_status ) ? (int) $page->ID : 0;

		return $page_id;
	}
}

if ( ! function_exists( 'alergobot_get_seo_source_post_id' ) ) {
	/**
	 * Post ID whose SEO fields should be used on the current view.
	 *
	 * @return int
	 */
	function alergobot_get_seo_source_post_id() {
		if ( ! did_action( 'wp' ) ) {
			return 0;
		}

		if ( is_singular( 'page' ) ) {
			return (int) get_queried_object_id();
		}

		if ( is_post_type_archive( 'blogs' ) ) {
			return alergobot_get_blogs_archive_page_id();
		}

		return 0;
	}
}

if ( ! function_exists( 'alergobot_get_page_keywords' ) ) {
	/**
	 * ACF keywords for the current SEO context.
	 *
	 * @param int $post_id Optional post ID override.
	 * @return string
	 */
	function alergobot_get_page_keywords( $post_id = 0 ) {
		if ( ! function_exists( 'get_field' ) ) {
			return '';
		}

		$post_id = $post_id ? (int) $post_id : alergobot_get_seo_source_post_id();
		if ( ! $post_id ) {
			return '';
		}

		return (string) get_field( 'keywords', $post_id );
	}
}

if ( ! function_exists( 'alergobot_is_blogs_archive_view' ) ) {
	/**
	 * Whether the current request is the blogs archive.
	 *
	 * @return bool
	 */
	function alergobot_is_blogs_archive_view() {
		return did_action( 'wp' ) && is_post_type_archive( 'blogs' );
	}
}

if ( ! function_exists( 'alergobot_get_yoast_post_meta' ) ) {
	/**
	 * Read Yoast meta value from a post without calling Yoast internals.
	 *
	 * @param string $key     Yoast field key without prefix (e.g. title, metadesc).
	 * @param int    $post_id Post ID.
	 * @return string
	 */
	function alergobot_get_yoast_post_meta( $key, $post_id ) {
		$post_id = (int) $post_id;
		if ( ! $post_id ) {
			return '';
		}

		return (string) get_post_meta( $post_id, '_yoast_wpseo_' . $key, true );
	}
}

if ( ! function_exists( 'alergobot_replace_yoast_template' ) ) {
	/**
	 * Replace Yoast template variables for a post.
	 *
	 * @param string $value   Meta value.
	 * @param int    $post_id Post ID.
	 * @return string
	 */
	function alergobot_replace_yoast_template( $value, $post_id ) {
		static $busy = false;

		$value = trim( (string) $value );
		if ( '' === $value || false === strpos( $value, '%%' ) ) {
			return $value;
		}

		if ( $busy ) {
			return $value;
		}

		$post = get_post( $post_id );
		if ( ! $post || ! function_exists( 'wpseo_replace_vars' ) ) {
			return $value;
		}

		$busy   = true;
		$result = (string) wpseo_replace_vars( $value, $post );
		$busy   = false;

		return $result;
	}
}

if ( ! function_exists( 'alergobot_get_companion_yoast_values' ) ) {
	/**
	 * Resolved Yoast SEO values from the companion page (post meta only).
	 *
	 * @param int $page_id Companion page ID.
	 * @return array<string, string>
	 */
	function alergobot_get_companion_yoast_values( $page_id ) {
		static $cache = array();

		$page_id = (int) $page_id;
		if ( isset( $cache[ $page_id ] ) ) {
			return $cache[ $page_id ];
		}

		$values = array(
			'title'               => '',
			'description'         => '',
			'og_title'            => '',
			'og_description'      => '',
			'twitter_title'       => '',
			'twitter_description' => '',
			'canonical'           => '',
			'og_image'            => '',
		);

		if ( ! $page_id ) {
			$cache[ $page_id ] = $values;
			return $values;
		}

		$raw = array(
			'title'               => alergobot_get_yoast_post_meta( 'title', $page_id ),
			'description'         => alergobot_get_yoast_post_meta( 'metadesc', $page_id ),
			'og_title'            => alergobot_get_yoast_post_meta( 'opengraph-title', $page_id ),
			'og_description'      => alergobot_get_yoast_post_meta( 'opengraph-description', $page_id ),
			'twitter_title'       => alergobot_get_yoast_post_meta( 'twitter-title', $page_id ),
			'twitter_description' => alergobot_get_yoast_post_meta( 'twitter-description', $page_id ),
			'canonical'           => alergobot_get_yoast_post_meta( 'canonical', $page_id ),
		);

		foreach ( $raw as $key => $value ) {
			$values[ $key ] = alergobot_replace_yoast_template( $value, $page_id );
		}

		$og_image_id = (int) alergobot_get_yoast_post_meta( 'opengraph-image-id', $page_id );
		if ( $og_image_id ) {
			$og_image = wp_get_attachment_image_url( $og_image_id, 'full' );
			if ( $og_image ) {
				$values['og_image'] = $og_image;
			}
		}

		if ( '' === $values['og_image'] ) {
			$values['og_image'] = alergobot_get_yoast_post_meta( 'opengraph-image', $page_id );
		}

		$cache[ $page_id ] = $values;
		return $values;
	}
}

if ( ! function_exists( 'alergobot_prime_blogs_archive_seo' ) ) {
	/**
	 * Preload companion SEO values before Yoast builds head output.
	 */
	function alergobot_prime_blogs_archive_seo() {
		if ( ! alergobot_is_blogs_archive_view() ) {
			return;
		}

		alergobot_get_companion_yoast_values( alergobot_get_blogs_archive_page_id() );
	}
}

if ( ! function_exists( 'alergobot_apply_blogs_archive_presentation' ) ) {
	/**
	 * Override Yoast presentation on blogs archive with companion page SEO.
	 *
	 * @param object $presentation Yoast indexable presentation.
	 * @param object $context      Yoast meta tags context.
	 * @return object
	 */
	function alergobot_apply_blogs_archive_presentation( $presentation, $context ) {
		static $busy = false;

		if ( $busy || ! alergobot_is_blogs_archive_view() ) {
			return $presentation;
		}

		$page_id = alergobot_get_blogs_archive_page_id();
		if ( ! $page_id ) {
			return $presentation;
		}

		$busy = true;
		$seo  = alergobot_get_companion_yoast_values( $page_id );

		if ( '' !== $seo['title'] ) {
			$presentation->title = $seo['title'];
		}

		if ( '' !== $seo['description'] ) {
			$presentation->meta_description = $seo['description'];
		}

		if ( '' !== $seo['og_title'] ) {
			$presentation->open_graph_title = $seo['og_title'];
		} elseif ( '' !== $seo['title'] ) {
			$presentation->open_graph_title = $seo['title'];
		}

		if ( '' !== $seo['og_description'] ) {
			$presentation->open_graph_description = $seo['og_description'];
		} elseif ( '' !== $seo['description'] ) {
			$presentation->open_graph_description = $seo['description'];
		}

		if ( '' !== $seo['twitter_title'] ) {
			$presentation->twitter_title = $seo['twitter_title'];
		} elseif ( '' !== $seo['title'] ) {
			$presentation->twitter_title = $seo['title'];
		}

		if ( '' !== $seo['twitter_description'] ) {
			$presentation->twitter_description = $seo['twitter_description'];
		} elseif ( '' !== $seo['description'] ) {
			$presentation->twitter_description = $seo['description'];
		}

		if ( '' !== $seo['canonical'] ) {
			$presentation->canonical = $seo['canonical'];
		}

		$busy = false;

		return $presentation;
	}
}

if ( ! function_exists( 'alergobot_apply_blogs_archive_schema_graph' ) ) {
	/**
	 * Sync schema graph page name with companion page SEO title.
	 *
	 * @param array<int, array<string, mixed>> $graph   Schema graph pieces.
	 * @param object                           $context Schema context.
	 * @return array<int, array<string, mixed>>
	 */
	function alergobot_apply_blogs_archive_schema_graph( $graph, $context ) {
		if ( ! alergobot_is_blogs_archive_view() || ! is_array( $graph ) ) {
			return $graph;
		}

		$seo = alergobot_get_companion_yoast_values( alergobot_get_blogs_archive_page_id() );
		if ( '' === $seo['title'] ) {
			return $graph;
		}

		foreach ( $graph as $index => $piece ) {
			if ( ! is_array( $piece ) || empty( $piece['@type'] ) ) {
				continue;
			}

			$types = (array) $piece['@type'];
			if ( in_array( 'CollectionPage', $types, true ) ) {
				$graph[ $index ]['name'] = $seo['title'];
			}
		}

		return $graph;
	}
}

if ( ! function_exists( 'alergobot_filter_blogs_archive_opengraph_image' ) ) {
	/**
	 * Override Open Graph image on blogs archive.
	 *
	 * @param string $image Current image URL.
	 * @return string
	 */
	function alergobot_filter_blogs_archive_opengraph_image( $image ) {
		if ( ! alergobot_is_blogs_archive_view() || ! is_string( $image ) ) {
			return $image;
		}

		$seo = alergobot_get_companion_yoast_values( alergobot_get_blogs_archive_page_id() );

		return '' !== $seo['og_image'] ? $seo['og_image'] : $image;
	}
}

if ( function_exists( 'add_action' ) ) {
	add_action( 'wp', 'alergobot_prime_blogs_archive_seo', 1 );
}

if ( function_exists( 'add_filter' ) ) {
	add_filter( 'wpseo_frontend_presentation', 'alergobot_apply_blogs_archive_presentation', 20, 2 );
	add_filter( 'wpseo_schema_graph', 'alergobot_apply_blogs_archive_schema_graph', 20, 2 );
	add_filter( 'wpseo_opengraph_image', 'alergobot_filter_blogs_archive_opengraph_image', 20 );
}
