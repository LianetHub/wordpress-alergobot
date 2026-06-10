<?php
/**
 * AJAX handlers
 *
 * @package alergobot
 */

add_action( 'wp_ajax_filter_blogs', 'alergobot_ajax_filter_blogs' );
add_action( 'wp_ajax_nopriv_filter_blogs', 'alergobot_ajax_filter_blogs' );

function alergobot_ajax_filter_blogs() {
	check_ajax_referer( 'alergobot_nonce', 'nonce' );

	$tab = isset( $_POST['tab'] ) ? sanitize_key( wp_unslash( $_POST['tab'] ) ) : 'articles';
	if ( ! in_array( $tab, array( 'articles', 'news' ), true ) ) {
		$tab = 'articles';
	}

	$context = alergobot_get_blog_archive_context_from_request(
		array(
			'tab'             => $tab,
			'page'            => isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1,
			'archive_term_id' => isset( $_POST['archive_term_id'] ) ? absint( $_POST['archive_term_id'] ) : 0,
			'tag_id'          => isset( $_POST['tag_id'] ) ? absint( $_POST['tag_id'] ) : 0,
			'base_url'        => isset( $_POST['base_url'] ) ? esc_url_raw( wp_unslash( $_POST['base_url'] ) ) : '',
		)
	);

	$query = alergobot_query_blogs( alergobot_get_blog_archive_query_args( $context, $tab ) );

	ob_start();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/blog/card' );
		}
		wp_reset_postdata();
	} else {
		echo '<p class="no-posts">' . esc_html__( 'Записей не найдено', 'alergobot' ) . '</p>';
	}
	$html = ob_get_clean();

	ob_start();
	alergobot_render_blog_pagination( $query, alergobot_get_blog_archive_pagination_args( $context, $tab ) );
	$pagination = ob_get_clean();

	wp_send_json_success(
		array(
			'html'       => $html,
			'pagination' => $pagination,
			'max_pages'  => $query->max_num_pages,
			'found'      => $query->found_posts,
			'tab'        => $tab,
			'page'       => 'news' === $tab ? $context['news_paged'] : $context['articles_paged'],
		)
	);
}
