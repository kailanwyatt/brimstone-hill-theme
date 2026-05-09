document.addEventListener('DOMContentLoaded', function() {
	// Custom Quantity Selector Logic
	const quantityWrappers = document.querySelectorAll('.bh-quantity-wrapper');
	
	quantityWrappers.forEach(function(wrapper) {
		const minusBtn = wrapper.querySelector('.bh-quantity-minus');
		const plusBtn = wrapper.querySelector('.bh-quantity-plus');
		const display = wrapper.querySelector('.bh-quantity-display');
		
		// Find the hidden original wooCommerce input
		const originalInput = document.querySelector('form.cart input.qty');
		
		if (!minusBtn || !plusBtn || !display || !originalInput) return;
		
		// Sync initial value
		display.textContent = originalInput.value || 1;
		
		minusBtn.addEventListener('click', function() {
			let currentVal = parseInt(originalInput.value) || 1;
			if (currentVal > 1) {
				currentVal--;
				originalInput.value = currentVal;
				display.textContent = currentVal;
			}
		});
		
		plusBtn.addEventListener('click', function() {
			let currentVal = parseInt(originalInput.value) || 1;
			let max = parseInt(originalInput.getAttribute('max')) || 999;
			if (currentVal < max) {
				currentVal++;
				originalInput.value = currentVal;
				display.textContent = currentVal;
			}
		});
	});
});
