<?php
/**
 * Home Plan Your Visit Teaser
 */
$title = get_option('bh_home_plan_title', 'Plan your visit');
?>
<section class="plan-teaser">
	<div class="container">
		<h2 class="section-title"><?php echo esc_html($title); ?></h2>
		<p class="plan-teaser__text">Find opening hours, admission prices, directions, and everything you need for a great day at the fortress.</p>
		<a href="<?php echo esc_url( home_url( '/visit/plan-your-visit' ) ); ?>" class="btn btn--primary">Plan your visit</a>
	</div>
</section>
