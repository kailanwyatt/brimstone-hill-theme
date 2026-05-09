(function () {
  var lightbox = document.getElementById('bh-gallery-lightbox');
  if (!lightbox) return;

  var img = document.getElementById('bh-gallery-lightbox-img');
  var caption = document.getElementById('bh-gallery-lightbox-caption');
  var closeBtn = document.getElementById('bh-gallery-lightbox-close');
  var prevBtn = document.getElementById('bh-gallery-lightbox-prev');
  var nextBtn = document.getElementById('bh-gallery-lightbox-next');
  var triggers = Array.prototype.slice.call(
    document.querySelectorAll('[data-gallery-open="1"]')
  );
  var activeIndex = -1;

  function setImageAt(index) {
    if (!triggers.length) return;
    if (index < 0) index = triggers.length - 1;
    if (index >= triggers.length) index = 0;

    activeIndex = index;
    var trigger = triggers[activeIndex];
    img.setAttribute('src', trigger.getAttribute('data-full') || '');
    img.setAttribute('alt', trigger.getAttribute('data-alt') || '');
    caption.textContent = trigger.getAttribute('data-caption') || '';
  }

  function closeLightbox() {
    lightbox.hidden = true;
    document.body.style.overflow = '';
    img.setAttribute('src', '');
    img.setAttribute('alt', '');
    caption.textContent = '';
    activeIndex = -1;
  }

  function openLightbox(index) {
    setImageAt(index);
    lightbox.hidden = false;
    document.body.style.overflow = 'hidden';
  }

  function showNext(step) {
    if (lightbox.hidden || activeIndex < 0) return;
    setImageAt(activeIndex + step);
  }

  triggers.forEach(function (trigger, index) {
    trigger.addEventListener('click', function () {
      openLightbox(index);
    });
  });

  if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
  if (prevBtn) prevBtn.addEventListener('click', function () { showNext(-1); });
  if (nextBtn) nextBtn.addEventListener('click', function () { showNext(1); });

  lightbox.addEventListener('click', function (e) {
    if (e.target === lightbox) closeLightbox();
  });

  document.addEventListener('keydown', function (e) {
    if (lightbox.hidden) return;
    if (e.key === 'Escape') {
      closeLightbox();
    } else if (e.key === 'ArrowLeft') {
      showNext(-1);
    } else if (e.key === 'ArrowRight') {
      showNext(1);
    }
  });
})();
