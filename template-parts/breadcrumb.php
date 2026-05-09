<?php
/**
 * Breadcrumb
 */
?>
<nav aria-label="breadcrumb" class="breadcrumb">
	<ol class="breadcrumb__list">
		<li class="breadcrumb__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
		<?php if ( is_page() ) : ?>
			<?php 
			// Simplified breadcrumb for pages
			$ancestors = get_post_ancestors( get_the_ID() );
			if ( ! empty( $ancestors ) ) {
				$ancestors = array_reverse( $ancestors );
				foreach ( $ancestors as $ancestor ) {
					echo '<li class="breadcrumb__item"><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a></li>';
				}
			}
			?>
			<li class="breadcrumb__item breadcrumb__item--current" aria-current="page"><?php the_title(); ?></li>
		<?php else : ?>
			<li class="breadcrumb__item breadcrumb__item--current" aria-current="page"><?php the_title(); ?></li>
		<?php endif; ?>
	</ol>
</nav>
