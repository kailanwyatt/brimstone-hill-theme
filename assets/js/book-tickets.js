document.addEventListener('DOMContentLoaded', function () {
	const form = document.getElementById('bhfp-book-tickets-form');
	if (!form) {
		return;
	}

	const config = typeof bhBookTickets !== 'undefined' ? bhBookTickets : {};
	const tiersByEvent = config.tiersByEvent || { 0: [] };
	const i18n = config.i18n || {};
	const currencySymbol = config.currencySymbol || '$';
	const decimals = typeof config.decimals === 'number' ? config.decimals : 2;
	const decimalSep = config.decimalSeparator || '.';
	const thousandSep = config.thousandSeparator || ',';

	const eventSelect = document.getElementById('booking_event');
	const tiersContainer = document.getElementById('booking-ticket-tiers');
	const totalPriceEl = document.getElementById('booking-total-price');
	const submitBtn = document.getElementById('btn-submit-booking');

	if (!tiersContainer || !totalPriceEl || !submitBtn) {
		return;
	}

	const submitLabel = submitBtn.textContent;

	function formatMoney(amount) {
		const n = Number(amount) || 0;
		const fixed = n.toFixed(decimals);
		const parts = fixed.split('.');
		parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandSep);
		const formatted = parts.join(decimalSep);
		return currencySymbol + formatted;
	}

	function formatTierPrice(price) {
		const p = parseFloat(price) || 0;
		return p > 0 ? formatMoney(p) : i18n.free || 'Free';
	}

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	function buildTierRow(tier) {
		const id = tier.id || '';
		const label = tier.label || '';
		const price = parseFloat(tier.price) || 0;
		const desc = tier.desc || '';

		return (
			'<div class="ticket-type-row" data-price="' +
			price +
			'" data-key="' +
			escapeHtml(id) +
			'">' +
			'<div class="ticket-info">' +
			'<h3>' +
			escapeHtml(label) +
			'</h3>' +
			(desc ? '<p>' + escapeHtml(desc) + '</p>' : '') +
			'<div class="ticket-price" data-tier-price>' +
			formatTierPrice(price) +
			'</div>' +
			'</div>' +
			'<div class="ticket-controls">' +
			'<button type="button" class="btn-qty btn-minus" aria-label="' +
			escapeHtml(i18n.decrease || 'Decrease quantity') +
			'">-</button>' +
			'<input type="number" name="tickets[' +
			escapeHtml(id) +
			']" value="0" min="0" max="20" class="qty-input" readonly>' +
			'<button type="button" class="btn-qty btn-plus" aria-label="' +
			escapeHtml(i18n.increase || 'Increase quantity') +
			'">+</button>' +
			'</div>' +
			'</div>'
		);
	}

	function renderTiers(eventId) {
		const key = String(eventId || '0');
		const tiers = tiersByEvent[key] || tiersByEvent['0'] || [];

		if (!tiers.length) {
			tiersContainer.innerHTML =
				'<p class="description book-tickets-no-tiers">' +
				escapeHtml(i18n.noTiers || 'No ticket types are available.') +
				'</p>';
			updateTotals();
			return;
		}

		tiersContainer.innerHTML = tiers.map(buildTierRow).join('');
		updateTotals();
	}

	function updateTotals() {
		const rows = tiersContainer.querySelectorAll('.ticket-type-row');
		let totalAmount = 0;
		let totalTickets = 0;

		rows.forEach(function (row) {
			const price = parseFloat(row.getAttribute('data-price')) || 0;
			const input = row.querySelector('.qty-input');
			const qty = input ? parseInt(input.value, 10) || 0 : 0;
			totalAmount += price * qty;
			totalTickets += qty;
		});

		totalPriceEl.textContent = formatMoney(totalAmount);
		submitBtn.disabled = totalTickets === 0 || tiersContainer.querySelector('.book-tickets-no-tiers');
	}

	tiersContainer.addEventListener('click', function (e) {
		const minus = e.target.closest('.btn-minus');
		const plus = e.target.closest('.btn-plus');
		if (!minus && !plus) {
			return;
		}

		const row = e.target.closest('.ticket-type-row');
		if (!row) {
			return;
		}

		const input = row.querySelector('.qty-input');
		if (!input) {
			return;
		}

		let val = parseInt(input.value, 10) || 0;
		const max = parseInt(input.getAttribute('max'), 10) || 20;

		if (minus && val > 0) {
			input.value = val - 1;
			updateTotals();
		}
		if (plus && val < max) {
			input.value = val + 1;
			updateTotals();
		}
	});

	if (eventSelect) {
		eventSelect.addEventListener('change', function () {
			renderTiers(eventSelect.value);
		});

		const initialEventId = config.initialEventId
			? String(config.initialEventId)
			: '';
		if (initialEventId && initialEventId !== '0') {
			const hasOption = Array.from(eventSelect.options).some(function (opt) {
				return opt.value === initialEventId;
			});
			if (hasOption) {
				eventSelect.value = initialEventId;
				renderTiers(initialEventId);
			}
		}
	}

	const visitDateInput = document.getElementById('booking_date');
	if (visitDateInput && config.initialVisitDate) {
		visitDateInput.value = config.initialVisitDate;
	}

	form.addEventListener('submit', function (e) {
		const rows = tiersContainer.querySelectorAll('.ticket-type-row');
		let totalTickets = 0;
		rows.forEach(function (row) {
			const input = row.querySelector('.qty-input');
			totalTickets += input ? parseInt(input.value, 10) || 0 : 0;
		});

		if (totalTickets === 0 || tiersContainer.querySelector('.book-tickets-no-tiers')) {
			e.preventDefault();
			alert(i18n.selectOne || 'Please select at least one ticket.');
			return;
		}

		submitBtn.disabled = true;
		submitBtn.textContent = i18n.processing || 'Processing...';
	});

	updateTotals();
});
