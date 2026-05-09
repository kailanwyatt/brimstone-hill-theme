<?php
/**
 * Home Newsletter section
 */
?>
<section class="newsletter">
	<div class="container">
		<h2 class="newsletter__title">Stay informed</h2>
		<p class="newsletter__subline">Hear about upcoming events and learn about our story and collections by signing up for our newsletter.</p>
		
		<form class="newsletter__form" action="#" method="POST" onSubmit="event.preventDefault(); alert('Signed up successfully!');">
			<div class="newsletter__field">
				<label for="newsletter-name" class="newsletter__label">Name <span aria-hidden="true">(required)</span></label>
				<input type="text" id="newsletter-name" name="name" class="newsletter__input" placeholder="Your name" required />
			</div>
			<div class="newsletter__field">
				<label for="newsletter-email" class="newsletter__label">Email <span aria-hidden="true">(required)</span></label>
				<input type="email" id="newsletter-email" name="email" class="newsletter__input" placeholder="your@email.com" required />
			</div>
			<button type="submit" class="btn btn--primary newsletter__submit">Sign up</button>
		</form>
	</div>
</section>
