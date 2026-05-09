document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bhfp-book-tickets-form');
    if (!form) return;

    const ticketRows = document.querySelectorAll('.ticket-type-row');
    const totalPriceEl = document.getElementById('booking-total-price');
    const submitBtn = document.getElementById('btn-submit-booking');

    let totalAmount = 0;
    let totalTickets = 0;

    function updateTotals() {
        totalAmount = 0;
        totalTickets = 0;

        ticketRows.forEach(row => {
            const price = parseFloat(row.getAttribute('data-price')) || 0;
            const input = row.querySelector('.qty-input');
            const qty = parseInt(input.value) || 0;

            totalAmount += price * qty;
            totalTickets += qty;
        });

        totalPriceEl.textContent = '$' + totalAmount.toFixed(2);
        submitBtn.disabled = totalTickets === 0;
    }

    ticketRows.forEach(row => {
        const btnMinus = row.querySelector('.btn-minus');
        const btnPlus = row.querySelector('.btn-plus');
        const input = row.querySelector('.qty-input');

        btnMinus.addEventListener('click', () => {
            let val = parseInt(input.value) || 0;
            if (val > 0) {
                input.value = val - 1;
                updateTotals();
            }
        });

        btnPlus.addEventListener('click', () => {
            let val = parseInt(input.value) || 0;
            if (val < parseInt(input.getAttribute('max') || 20)) {
                input.value = val + 1;
                updateTotals();
            }
        });
    });

    // Form submission processing
    form.addEventListener('submit', function(e) {
        if (totalTickets === 0) {
            e.preventDefault();
            alert('Please select at least one ticket.');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        // Allow the standard form POST submission to proceed
    });
});
