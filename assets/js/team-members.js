(function () {
  'use strict';

  var roots = document.querySelectorAll('[data-bhfp-team-members]');
  if (!roots.length) return;

  roots.forEach(function (root) {
    var modalId = root.getAttribute('data-modal-id');
    var modal = modalId ? document.getElementById(modalId) : null;
    if (!modal) return;

    var img = modal.querySelector('.bhfp-team-modal__img');
    var fallback = modal.querySelector('.bhfp-team-modal__avatar-fallback');
    var roleEl = modal.querySelector('.bhfp-team-modal__role');
    var nameEl = modal.querySelector('.bhfp-team-modal__name');
    var bioEl = modal.querySelector('.bhfp-team-modal__bio');
    var lastFocus = null;

    function closeModal() {
      modal.hidden = true;
      document.body.style.overflow = '';
      if (lastFocus && typeof lastFocus.focus === 'function') {
        lastFocus.focus();
      }
      lastFocus = null;
    }

    function openModal(data) {
      if (!data) return;
      lastFocus = document.activeElement;
      nameEl.textContent = data.name || '';
      roleEl.textContent = data.title || '';
      roleEl.hidden = !data.title;
      bioEl.textContent = data.bio || '';

      if (data.imageUrl) {
        img.hidden = false;
        img.src = data.imageUrl;
        img.alt = data.name || '';
        if (fallback) {
          fallback.hidden = true;
          fallback.textContent = '';
        }
      } else {
        img.hidden = true;
        img.removeAttribute('src');
        if (fallback) {
          fallback.hidden = false;
          fallback.textContent = (data.name || '?').charAt(0);
        }
      }

      modal.hidden = false;
      document.body.style.overflow = 'hidden';
      var closeBtn = modal.querySelector('.bhfp-team-modal__close');
      if (closeBtn) closeBtn.focus();
    }

    root.querySelectorAll('[data-team-open]').forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        try {
          openModal(JSON.parse(trigger.getAttribute('data-team-member') || '{}'));
        } catch (e) {
          // Ignore bad JSON.
        }
      });
    });

    modal.querySelectorAll('[data-team-modal-close]').forEach(function (el) {
      el.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (e) {
      if (modal.hidden) return;
      if (e.key === 'Escape') {
        closeModal();
      }
    });
  });
})();
