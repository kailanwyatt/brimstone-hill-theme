(function () {
  var root = document.querySelector('.donate-page');
  if (!root) return;

  var form = root.querySelector('#bh-donate-form');
  if (!form) return;

  var cfg =
    typeof bhDonate === 'object' && bhDonate !== null
      ? bhDonate
      : { min: 1, max: 999999.99, decimals: 2, currencySymbol: '$' };

  var amountHidden = root.querySelector('#bh-donation-amount');
  var presetBtns = root.querySelectorAll('.donate-amount__btn[data-amount]');
  var otherBtn = root.querySelector('.donate-amount__btn--other');
  var otherWrap = root.querySelector('#bh-donate-other-wrap');
  var otherInput = root.querySelector('#donate-other');
  var submitBtn = root.querySelector('#bh-donate-submit');
  var summary = root.querySelector('#bh-donate-summary');

  var selectedPreset = null;
  var otherMode = false;

  function decimals() {
    var d = parseInt(cfg.decimals, 10);
    return Number.isFinite(d) && d >= 0 ? d : 2;
  }

  function clampAmount(n) {
    var min = parseFloat(cfg.min);
    var max = parseFloat(cfg.max);
    if (!Number.isFinite(min)) min = 1;
    if (!Number.isFinite(max)) max = 999999.99;
    if (n < min) return min;
    if (n > max) return max;
    return n;
  }

  function parseAmount() {
    if (otherMode && otherInput) {
      var raw = String(otherInput.value || '').replace(',', '.');
      var n = parseFloat(raw);
      return Number.isFinite(n) ? n : 0;
    }
    if (selectedPreset != null) return selectedPreset;
    return 0;
  }

  function formatMoney(n) {
    return n.toFixed(decimals());
  }

  function syncHidden() {
    if (!amountHidden) return;
    var amt = parseAmount();
    if (amt > 0) {
      var rounded = clampAmount(amt);
      amountHidden.value = formatMoney(rounded);
    } else {
      amountHidden.value = '';
    }
  }

  function syncState() {
    syncHidden();
    var amt = parseAmount();
    var okAmount = amt > 0;
    submitBtn.disabled = !okAmount;

    if (okAmount) {
      summary.hidden = false;
      summary.textContent =
        'Amount: ' +
        (cfg.currencySymbol || '$') +
        formatMoney(clampAmount(amt));
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

  form.addEventListener('submit', function (e) {
    syncHidden();
    var amt = clampAmount(parseAmount());
    var min = parseFloat(cfg.min);
    var max = parseFloat(cfg.max);
    if (!Number.isFinite(min)) min = 1;
    if (!Number.isFinite(max)) max = 999999.99;

    if (!(amt > 0) || amt < min || amt > max) {
      e.preventDefault();
      syncState();
      return;
    }

    if (amountHidden) {
      amountHidden.value = formatMoney(amt);
    }
  });
})();
