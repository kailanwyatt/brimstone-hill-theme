<?php
/**
 * Home Welcome section
 */
$title = get_option( 'bh_home_welcome_title', 'Welcome!' );
$text  = get_option( 'bh_home_welcome_text', 'Brimstone Hill Fortress National Park is a UNESCO World Heritage Site...' );
?>
<section class="welcome-section">
	<div class="container">
		<h2 class="welcome-section__title"><?php echo esc_html( $title ); ?></h2>
		<div class="welcome-section__intro"><?php echo wp_kses_post( $text ); ?></div>
		<div class="welcome-section__actions">
			<a href="<?php echo esc_url( home_url( '/visit/plan-your-visit' ) ); ?>" class="btn btn--primary">Plan your visit</a>
			<a href="<?php echo esc_url( home_url( '/discover' ) ); ?>" class="btn btn--secondary">Experience it</a>
			<a href="<?php echo esc_url( home_url( '/get-involved/member' ) ); ?>" class="btn btn--secondary">Become a member</a>
		</div>
	</div>
</section>
