<?php
/**
 * Breadcrumb trail beneath the page title.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = array();

$items[] = array(
	'label' => __( 'Home', 'brimstone-hill' ),
	'url'   => home_url( '/' ),
);

if ( is_page() ) {
	$ancestors = get_post_ancestors( get_the_ID() );
	if ( ! empty( $ancestors ) ) {
		$ancestors = array_reverse( $ancestors );
		foreach ( $ancestors as $ancestor_id ) {
			$items[] = array(
				'label' => get_the_title( $ancestor_id ),
				'url'   => get_permalink( $ancestor_id ),
			);
		}
	}
} elseif ( is_singular( 'bhfp_gallery' ) ) {
	$gallery_page = get_page_by_path( 'discover/gallery' );
	if ( $gallery_page ) {
		$discover_page = get_post( (int) $gallery_page->post_parent );
		if ( $discover_page ) {
			$items[] = array(
				'label' => get_the_title( $discover_page ),
				'url'   => get_permalink( $discover_page ),
			);
		}
		$items[] = array(
			'label' => get_the_title( $gallery_page ),
			'url'   => get_permalink( $gallery_page ),
		);
	}
} elseif ( is_singular( 'bhfp_event' ) ) {
	$events_page = get_page_by_path( 'events/whats-on' );
	if ( ! $events_page ) {
		$events_page = get_page_by_path( 'events' );
	}
	if ( $events_page ) {
		$items[] = array(
			'label' => get_the_title( $events_page ),
			'url'   => get_permalink( $events_page ),
		);
	}
} elseif ( is_singular( 'post' ) ) {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id ) {
		$items[] = array(
			'label' => get_the_title( $posts_page_id ),
			'url'   => get_permalink( $posts_page_id ),
		);
	}
}

$current_label = get_the_title();
?>
<nav aria-label="<?php esc_attr_e( 'Breadcrumb', 'brimstone-hill' ); ?>" class="breadcrumb">
	<ol class="breadcrumb__list">
		<?php foreach ( $items as $item ) : ?>
			<li class="breadcrumb__item">
				<a class="breadcrumb__link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<span class="breadcrumb__sep" aria-hidden="true">/</span>
			</li>
		<?php endforeach; ?>
		<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">
			<span class="breadcrumb__current"><?php echo esc_html( $current_label ); ?></span>
		</li>
	</ol>
</nav>
