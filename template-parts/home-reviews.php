<?php
/**
 * Home Featured Reviews section
 */

$reviews = array(
	array(
		'name' => 'TripAdvisor visitor',
		'location' => 'St. Kitts & Nevis',
		'rating' => 5,
		'title' => 'A must-see on St. Kitts',
		'quote' => 'Breathtaking views, impressive history, and so much to explore. Give yourself time to walk the grounds and take it all in.',
	),
	array(
		'name' => 'TripAdvisor visitor',
		'location' => 'United States',
		'rating' => 5,
		'title' => 'Incredible fortress and museum',
		'quote' => 'Well preserved, informative, and beautiful. The museum adds great context and the views from the top are unforgettable.',
	),
	array(
		'name' => 'TripAdvisor visitor',
		'location' => 'United Kingdom',
		'rating' => 5,
		'title' => 'History with panoramic views',
		'quote' => 'An outstanding heritage site. The scale of the fortifications is remarkable and the scenery is stunning from every angle.',
	),
	array(
		'name' => 'TripAdvisor visitor',
		'location' => 'Canada',
		'rating' => 5,
		'title' => 'Worth the climb',
		'quote' => 'Wear good shoes and bring water. The climb is rewarded with spectacular views and fascinating details throughout the site.',
	),
);
?>
<section class="featured-reviews" aria-label="Featured reviews">
	<div class="container">
		<div class="featured-reviews__head">
			<h2 class="section-title">What visitors are saying</h2>
			<p class="featured-reviews__sub">Featured 5‑star reviews from TripAdvisor.</p>
		</div>

		<div class="featured-reviews__grid" role="list">
			<?php foreach ( $reviews as $review ) : ?>
				<article class="review-card" role="listitem">
					<div class="review-card__top">
						<span class="review-stars" aria-label="<?php echo esc_attr( $review['rating'] ); ?> out of 5 stars">★★★★★</span>
						<div class="review-card__meta">
							<span class="review-card__name"><?php echo esc_html( $review['name'] ); ?></span>
							<?php if ( ! empty( $review['location'] ) ) : ?>
								<span class="review-card__location"><?php echo esc_html( $review['location'] ); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<h3 class="review-card__title"><?php echo esc_html( $review['title'] ); ?></h3>
					<p class="review-card__quote">"<?php echo esc_html( $review['quote'] ); ?>"</p>
				</article>
			<?php endforeach; ?>
		</div>

		<p class="featured-reviews__cta">
			<a class="link--more" href="https://www.tripadvisor.com" target="_blank" rel="noopener noreferrer">Read more reviews on TripAdvisor</a>
		</p>
	</div>
</section>
