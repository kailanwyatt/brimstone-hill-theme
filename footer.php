<?php
/**
 * The template for displaying the footer
 *
 * @package Brimstone_Hill
 */

?>

<footer class="site-footer">
	<div class="site-footer__inner container">
		<div class="site-footer__links">
			<a href="<?php echo esc_url( home_url( '/visit' ) ); ?>">Visit</a>
			<a href="<?php echo esc_url( home_url( '/visit/book-tickets' ) ); ?>">Book</a>
			<a href="<?php echo esc_url( home_url( '/get-involved/member' ) ); ?>">Member</a>
			<a href="<?php echo esc_url( home_url( '/get-involved/donate' ) ); ?>">Donate</a>
			<a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a>
			<a href="<?php echo esc_url( home_url( '/about/contact' ) ); ?>">Contact</a>
		</div>
		<p class="site-footer__copy">
			&copy; <?php echo date( 'Y' ); ?> Brimstone Hill Fortress National Park. All rights reserved. &middot; <a href="<?php echo esc_url( home_url( '/staff/login' ) ); ?>" class="site-footer__staff">Staff login</a>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
