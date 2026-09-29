(function () {
  'use strict';

  var STORAGE_KEY = 'bhMembershipCardView';
  var root = document.querySelector('[data-membership-cards]');
  var grid = document.querySelector('[data-membership-grid]');
  var toggleBtns = document.querySelectorAll('[data-membership-view]');
  var cards = document.querySelectorAll('[data-membership-card]');
  var cta = document.querySelector('[data-membership-cta]');
  var ctaOpen = document.querySelector('[data-membership-cta-open]');
  var ctaClose = document.querySelector('[data-membership-cta-close]');
  var ctaFront = cta ? cta.querySelector('.membership-cta-banner__face--front') : null;
  var ctaBack = cta ? cta.querySelector('.membership-cta-banner__face--back') : null;
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function setView(mode) {
    if (!grid || !root) return;
    var isFlat = mode === 'flat';
    grid.classList.toggle('membership-grid--flat', isFlat);
    grid.classList.toggle('membership-grid--flip', !isFlat);
    root.setAttribute('data-view', isFlat ? 'flat' : 'flip');

    toggleBtns.forEach(function (btn) {
      var active = btn.getAttribute('data-membership-view') === mode;
      btn.classList.toggle('is-active', active);
      btn.setAttribute('aria-pressed', active ? 'true' : 'false');
    });

    cards.forEach(function (card) {
      card.classList.remove('membership-card--flipped');
      card.setAttribute('aria-pressed', 'false');
      if (isFlat) {
        card.removeAttribute('tabindex');
        card.removeAttribute('role');
      } else {
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'button');
      }
    });

    try {
      sessionStorage.setItem(STORAGE_KEY, mode);
    } catch (e) {
      // Ignore storage failures.
    }
  }

  function flipCard(card) {
    if (!grid || grid.classList.contains('membership-grid--flat')) return;
    var flipped = card.classList.toggle('membership-card--flipped');
    card.setAttribute('aria-pressed', flipped ? 'true' : 'false');
  }

  if (root && grid) {
    var saved = 'flip';
    try {
      saved = sessionStorage.getItem(STORAGE_KEY) || 'flip';
    } catch (e) {
      saved = 'flip';
    }
    setView(saved === 'flat' ? 'flat' : 'flip');

    toggleBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        setView(btn.getAttribute('data-membership-view') || 'flip');
      });
    });

    cards.forEach(function (card) {
      card.addEventListener('click', function () {
        flipCard(card);
      });
      card.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          flipCard(card);
        }
      });
    });
  }

  function openCtaForm() {
    if (!cta || !ctaFront || !ctaBack) return;
    cta.classList.add('membership-cta-banner--open');
    if (reduceMotion) {
      ctaFront.hidden = true;
      ctaBack.hidden = false;
    } else {
      ctaFront.setAttribute('aria-hidden', 'true');
      ctaBack.hidden = false;
      window.setTimeout(function () {
        ctaFront.hidden = true;
      }, 350);
    }
    var firstField = ctaBack.querySelector('input, select, textarea, button');
    if (firstField) {
      window.setTimeout(function () {
        firstField.focus();
      }, reduceMotion ? 0 : 360);
    }
  }

  function closeCtaForm() {
    if (!cta || !ctaFront || !ctaBack) return;
    cta.classList.remove('membership-cta-banner--open');
    ctaFront.hidden = false;
    ctaFront.removeAttribute('aria-hidden');
    if (reduceMotion) {
      ctaBack.hidden = true;
    } else {
      window.setTimeout(function () {
        ctaBack.hidden = true;
      }, 350);
    }
    if (ctaOpen) {
      ctaOpen.focus();
    }
  }

  if (ctaOpen) {
    ctaOpen.addEventListener('click', openCtaForm);
  }
  if (ctaClose) {
    ctaClose.addEventListener('click', closeCtaForm);
  }
})();
