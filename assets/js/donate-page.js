(function () {
  var root = document.querySelector('.donate-page');
  if (!root) return;

  var form = root.querySelector('#bh-donate-form');
  var thanks = root.querySelector('#bh-donate-thanks');
  var thanksEmail = root.querySelector('#bh-donate-thanks-email');
  var presetBtns = root.querySelectorAll('.donate-amount__btn[data-amount]');
  var otherBtn = root.querySelector('.donate-amount__btn--other');
  var otherWrap = root.querySelector('#bh-donate-other-wrap');
  var otherInput = root.querySelector('#donate-other');
  var recurring = root.querySelector('#bh-donate-recurring');
  var emailInput = root.querySelector('#donate-email');
  var submitBtn = root.querySelector('#bh-donate-submit');
  var summary = root.querySelector('#bh-donate-summary');

  var selectedPreset = null;
  var otherMode = false;

  function parseAmount() {
    if (otherMode) {
      var n = parseFloat(String(otherInput.value || '').replace(',', '.'));
      return Number.isFinite(n) ? n : 0;
    }
    if (selectedPreset != null) return selectedPreset;
    return 0;
  }

  function formatMoney(n) {
    return n.toFixed(2);
  }

  function syncState() {
    var amt = parseAmount();
    var okAmount = amt > 0;
    var okEmail = String(emailInput.value || '').trim().length > 0;
    submitBtn.disabled = !(okAmount && okEmail);

    if (okAmount) {
      summary.hidden = false;
      var line =
        'Amount: USD $' +
        formatMoney(amt) +
        (recurring.checked ? ' per month' : '');
      summary.textContent = line;
    } else {
      summary.hidden = true;
      summary.textContent = '';
    }
  }

  presetBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      otherMode = false;
      selectedPreset = parseFloat(btn.getAttribute('data-amount'));
      otherWrap.hidden = true;
      presetBtns.forEach(function (b) {
        b.classList.remove('donate-amount__btn--active');
      });
      if (otherBtn) otherBtn.classList.remove('donate-amount__btn--active');
      btn.classList.add('donate-amount__btn--active');
      syncState();
    });
  });

  if (otherBtn) {
    otherBtn.addEventListener('click', function () {
      otherMode = true;
      selectedPreset = null;
      presetBtns.forEach(function (b) {
        b.classList.remove('donate-amount__btn--active');
      });
      otherBtn.classList.add('donate-amount__btn--active');
      otherWrap.hidden = false;
      syncState();
    });
  }

  if (otherInput) {
    otherInput.addEventListener('input', syncState);
  }
  emailInput.addEventListener('input', syncState);
  if (recurring) {
    recurring.addEventListener('change', syncState);
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var amt = parseAmount();
    var email = String(emailInput.value || '').trim();
    if (!(amt > 0) || !email) {
      syncState();
      return;
    }
    form.hidden = true;
    thanks.hidden = false;
    thanksEmail.textContent = email;
    root.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
})();
