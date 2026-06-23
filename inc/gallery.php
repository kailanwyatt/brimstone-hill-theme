<?php
/**
 * Gallery album helpers shared by templates and plugin shortcodes.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bh_gallery_album_image_ids' ) ) {
	/**
	 * Normalize gallery attachment IDs from album meta.
	 *
	 * @param int $album_id Gallery album post ID.
	 * @return int[]
	 */
	function bh_gallery_album_image_ids( $album_id ) {
		$meta_ids_key = defined( 'BHFP_GALLERY_META_IDS' ) ? BHFP_GALLERY_META_IDS : '_bhfp_attachment_ids';
		$raw          = get_post_meta( (int) $album_id, $meta_ids_key, true );
		if ( is_array( $raw ) ) {
			$ids = $raw;
		} else {
			$raw = (string) $raw;
			$ids = '' !== trim( $raw ) ? preg_split( '/\s*,\s*/', $raw ) : array();
		}

		return array_values( array_filter( array_map( 'absint', (array) $ids ) ) );
	}
}

if ( ! function_exists( 'bh_gallery_album_cover_url' ) ) {
	/**
	 * Resolve album cover URL from first attached image or featured image.
	 *
	 * @param int $album_id Gallery album post ID.
	 * @return string
	 */
	function bh_gallery_album_cover_url( $album_id ) {
		$album_id = (int) $album_id;
		$ids      = bh_gallery_album_image_ids( $album_id );
		if ( ! empty( $ids ) ) {
			$url = wp_get_attachment_image_url( $ids[0], 'large' );
			if ( $url ) {
				return $url;
			}
		}

		$thumb = get_the_post_thumbnail_url( $album_id, 'large' );

		return $thumb ? $thumb : '';
	}
}

if ( ! function_exists( 'bh_gallery_get_sorted_album_ids' ) ) {
	/**
	 * Sorted gallery album IDs for theme templates.
	 *
	 * @param array $args Optional query args passed to the plugin helper.
	 * @return int[]
	 */
	function bh_gallery_get_sorted_album_ids( $args = array() ) {
		if ( function_exists( 'bhfp_gallery_get_sorted_album_ids' ) ) {
			$result = bhfp_gallery_get_sorted_album_ids( $args );
			return isset( $result['ids'] ) ? array_map( 'intval', $result['ids'] ) : array();
		}

		$post_type = defined( 'BHFP_GALLERY_POST_TYPE' ) ? BHFP_GALLERY_POST_TYPE : 'bhfp_gallery';
		$args      = wp_parse_args(
			$args,
			array(
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			)
		);

		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'post_status'    => $args['post_status'],
				'posts_per_page' => (int) $args['posts_per_page'],
				'orderby'        => 'date',
				'order'          => 'DESC',
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);

		return array_map( 'intval', $query->posts );
	}
}

if ( ! function_exists( 'bh_gallery_get_album_categories' ) ) {
	/**
	 * Category terms for a gallery album.
	 *
	 * @param int $album_id Album post ID.
	 * @return WP_Term[]
	 */
	function bh_gallery_get_album_categories( $album_id ) {
		if ( function_exists( 'bhfp_gallery_get_album_categories' ) ) {
			return bhfp_gallery_get_album_categories( $album_id );
		}

		$taxonomy = defined( 'BHFP_GALLERY_TAXONOMY_CATEGORY' ) ? BHFP_GALLERY_TAXONOMY_CATEGORY : 'bhfp_gallery_category';
		$terms    = get_the_terms( (int) $album_id, $taxonomy );

		return ( is_array( $terms ) && ! is_wp_error( $terms ) ) ? $terms : array();
	}
}
