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
