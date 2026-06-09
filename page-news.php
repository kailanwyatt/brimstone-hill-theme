<?php
/**
 * News & blog archive — uses page slug "news" (e.g. /about/news).
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();
	$bh_news_page_id = (int) get_the_ID();
endwhile;
rewind_posts();

/**
 * Build news archive URL with optional category and tag slugs (AND).
 *
 * @param string   $base_url Base page URL.
 * @param string   $cat_slug Category slug; empty to omit.
 * @param string   $tag_slug Tag slug; empty to omit.
 * @return string
 */
$bh_news_filter_url = static function ( $base_url, $cat_slug, $tag_slug ) {
	$args = array();
	if ( $cat_slug && 'all' !== $cat_slug ) {
		$args['bh_cat'] = $cat_slug;
	}
	if ( $tag_slug && 'all' !== $tag_slug ) {
		$args['bh_tag'] = $tag_slug;
	}
	return empty( $args ) ? $base_url : add_query_arg( $args, $base_url );
};

$bh_cat = isset( $_GET['bh_cat'] ) ? sanitize_title( wp_unslash( $_GET['bh_cat'] ) ) : '';
$bh_tag = isset( $_GET['bh_tag'] ) ? sanitize_title( wp_unslash( $_GET['bh_tag'] ) ) : '';

$bh_news_args = array(
	'post_type'           => 'post',
	'posts_per_page'      => -1,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
	'orderby'             => 'date',
	'order'               => 'DESC',
	'no_found_rows'       => true,
);

$bh_tax_clauses = array();
if ( $bh_cat && 'all' !== $bh_cat ) {
	$bh_tax_clauses[] = array(
		'taxonomy' => 'category',
		'field'    => 'slug',
		'terms'    => $bh_cat,
	);
}
if ( $bh_tag && 'all' !== $bh_tag ) {
	$bh_tax_clauses[] = array(
		'taxonomy' => 'post_tag',
		'field'    => 'slug',
		'terms'    => $bh_tag,
	);
}
if ( ! empty( $bh_tax_clauses ) ) {
	$bh_news_args['tax_query'] = array_merge(
		array( 'relation' => 'AND' ),
		$bh_tax_clauses
	);
}

$bh_news_query = new WP_Query( $bh_news_args );
$bh_posts      = $bh_news_query->posts;

$bh_featured = null;
$bh_rest     = array();
if ( ! empty( $bh_posts ) ) {
	$bh_featured = $bh_posts[0];
	$bh_rest     = array_slice( $bh_posts, 1 );
}

$bh_archive_base = get_permalink( $bh_news_page_id );

$bh_categories = get_categories(
	array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true,
	)
);
$bh_tags = get_tags(
	array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true,
	)
);

$bh_recent_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 5,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'no_found_rows'       => true,
	)
);

?>

<main id="main-content" class="bh-page content-page news-page">
	<?php
	while ( have_posts() ) :
		the_post();
		$has_banner = has_post_thumbnail();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php get_template_part( 'template-parts/page', 'header' ); ?>
				<div class="content-page__body content-page__body--full">
					<p class="news-page__intro">
						<?php esc_html_e( 'Latest news, updates, and stories from the fortress.', 'brimstone-hill' ); ?>
					</p>

					<div class="news-filters">
						<div class="sidebar-card">
							<h2 class="sidebar-card__title"><?php esc_html_e( 'Browse', 'brimstone-hill' ); ?></h2>
							<div class="sidebar-group">
								<h3 class="sidebar-group__title"><?php esc_html_e( 'Categories', 'brimstone-hill' ); ?></h3>
								<ul class="sidebar-list sidebar-list--inline">
									<li>
										<a class="sidebar-filter<?php echo ! $bh_cat || 'all' === $bh_cat ? ' sidebar-filter--active' : ''; ?>" href="<?php echo esc_url( $bh_news_filter_url( $bh_archive_base, '', $bh_tag ) ); ?>"><?php esc_html_e( 'All', 'brimstone-hill' ); ?></a>
									</li>
									<?php foreach ( $bh_categories as $bh_c ) : ?>
										<li>
											<a class="sidebar-filter<?php echo $bh_cat === $bh_c->slug ? ' sidebar-filter--active' : ''; ?>" href="<?php echo esc_url( $bh_news_filter_url( $bh_archive_base, $bh_c->slug, $bh_tag ) ); ?>"><?php echo esc_html( $bh_c->name ); ?></a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="sidebar-group">
								<h3 class="sidebar-group__title"><?php esc_html_e( 'Tags', 'brimstone-hill' ); ?></h3>
								<div class="sidebar-tags">
									<a class="tag-chip<?php echo ! $bh_tag || 'all' === $bh_tag ? ' tag-chip--active' : ''; ?>" href="<?php echo esc_url( $bh_news_filter_url( $bh_archive_base, $bh_cat, '' ) ); ?>"><?php esc_html_e( 'All', 'brimstone-hill' ); ?></a>
									<?php foreach ( $bh_tags as $bh_t ) : ?>
										<a class="tag-chip<?php echo $bh_tag === $bh_t->slug ? ' tag-chip--active' : ''; ?>" href="<?php echo esc_url( $bh_news_filter_url( $bh_archive_base, $bh_cat, $bh_t->slug ) ); ?>"><?php echo esc_html( $bh_t->name ); ?></a>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>

					<div class="news-layout news-layout--single">
						<div class="news-main">
							<?php if ( $bh_featured ) : ?>
								<?php
								$bh_f_link = get_permalink( $bh_featured );
								$bh_f_img  = get_the_post_thumbnail_url( $bh_featured, 'large' );
								$bh_f_cats = get_the_category( $bh_featured->ID );
								$bh_f_cat  = ! empty( $bh_f_cats ) ? $bh_f_cats[0]->name : '';
								?>
								<article class="news-feature">
									<?php if ( $bh_f_img ) : ?>
										<a href="<?php echo esc_url( $bh_f_link ); ?>" class="news-feature__media">
											<img src="<?php echo esc_url( $bh_f_img ); ?>" alt="" loading="lazy" />
										</a>
									<?php endif; ?>
									<div class="news-feature__body">
										<div class="news-meta">
											<span class="news-meta__date"><?php echo esc_html( get_the_date( get_option( 'date_format' ), $bh_featured ) ); ?></span>
											<span class="news-meta__dot" aria-hidden="true">•</span>
											<span class="news-meta__category"><?php echo esc_html( $bh_f_cat ? $bh_f_cat : __( 'News', 'brimstone-hill' ) ); ?></span>
										</div>
										<h2 class="news-feature__title">
											<a href="<?php echo esc_url( $bh_f_link ); ?>"><?php echo esc_html( get_the_title( $bh_featured ) ); ?></a>
										</h2>
										<p class="news-feature__excerpt"><?php echo esc_html( get_the_excerpt( $bh_featured ) ); ?></p>
										<p class="news-feature__cta">
											<a class="btn btn--secondary btn--sm" href="<?php echo esc_url( $bh_f_link ); ?>"><?php esc_html_e( 'Read article', 'brimstone-hill' ); ?></a>
										</p>
									</div>
								</article>
							<?php else : ?>
								<p class="news-empty"><?php esc_html_e( 'No posts match your filters yet.', 'brimstone-hill' ); ?></p>
							<?php endif; ?>

							<div class="news-grid" role="list">
								<?php foreach ( $bh_rest as $bh_post ) : ?>
									<?php
									$bh_p_link = get_permalink( $bh_post );
									$bh_p_img  = get_the_post_thumbnail_url( $bh_post, 'medium_large' );
									$bh_p_cats = get_the_category( $bh_post->ID );
									$bh_p_cat  = ! empty( $bh_p_cats ) ? $bh_p_cats[0]->name : '';
									?>
									<article class="news-card" role="listitem">
										<?php if ( $bh_p_img ) : ?>
											<a href="<?php echo esc_url( $bh_p_link ); ?>" class="news-card__media">
												<img src="<?php echo esc_url( $bh_p_img ); ?>" alt="" loading="lazy" />
											</a>
										<?php endif; ?>
										<div class="news-card__body">
											<div class="news-meta">
												<span class="news-meta__date"><?php echo esc_html( get_the_date( get_option( 'date_format' ), $bh_post ) ); ?></span>
												<span class="news-meta__dot" aria-hidden="true">•</span>
												<span class="news-meta__category"><?php echo esc_html( $bh_p_cat ? $bh_p_cat : __( 'News', 'brimstone-hill' ) ); ?></span>
											</div>
											<h3 class="news-card__title">
												<a href="<?php echo esc_url( $bh_p_link ); ?>"><?php echo esc_html( get_the_title( $bh_post ) ); ?></a>
											</h3>
											<p class="news-card__excerpt"><?php echo esc_html( get_the_excerpt( $bh_post ) ); ?></p>
										</div>
									</article>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();
