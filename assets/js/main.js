document.addEventListener('DOMContentLoaded', () => {
    
    // --- Accordions ---
    const accordions = document.querySelectorAll('.accordion');
    
    accordions.forEach(accordion => {
        const allowMultiple = accordion.dataset.allowMultiple === 'true';
        const items = accordion.querySelectorAll('.accordion__item');
        
        items.forEach(item => {
            const trigger = item.querySelector('.accordion__trigger');
            const panel = item.querySelector('.accordion__panel');
            
            if (!trigger || !panel) return;
            
            trigger.addEventListener('click', () => {
                const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
                
                if (!allowMultiple && !isExpanded) {
                    // Close all other panels
                    items.forEach(otherItem => {
                        const otherTrigger = otherItem.querySelector('.accordion__trigger');
                        const otherPanel = otherItem.querySelector('.accordion__panel');
                        if (otherTrigger && otherPanel) {
                            otherTrigger.setAttribute('aria-expanded', 'false');
                            otherPanel.hidden = true;
                            otherPanel.classList.remove('accordion__panel--open');
                        }
                    });
                }
                
                // Toggle current
                trigger.setAttribute('aria-expanded', !isExpanded);
                panel.hidden = isExpanded;
                if (!isExpanded) {
                    panel.classList.add('accordion__panel--open');
                } else {
                    panel.classList.remove('accordion__panel--open');
                }
            });
        });
    });

    // --- Mobile Menu Toggle ---
    const menuBtn = document.querySelector('.site-header__menu-btn');
    const mobileNav = document.getElementById('mobile-nav');
    const mobileBackdrop = document.getElementById('mobile-nav-backdrop');

    const setMobileNavOpen = (open) => {
        if (!menuBtn || !mobileNav) {
            return;
        }
        menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        mobileNav.hidden = !open;
        if (mobileBackdrop) {
            mobileBackdrop.hidden = !open;
            mobileBackdrop.setAttribute('aria-hidden', open ? 'false' : 'true');
        }
        document.body.classList.toggle('mobile-nav-open', open);
    };

    if (menuBtn && mobileNav) {
        menuBtn.addEventListener('click', () => {
            const isExpanded = menuBtn.getAttribute('aria-expanded') === 'true';
            setMobileNavOpen(!isExpanded);
        });

        if (mobileBackdrop) {
            mobileBackdrop.addEventListener('click', () => setMobileNavOpen(false));
        }

        mobileNav.querySelectorAll('.mobile-nav__trigger').forEach((toggle) => {
            toggle.addEventListener('click', () => {
                const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                const sublist = toggle.nextElementSibling;

                if (sublist && sublist.classList.contains('mobile-nav__sublist')) {
                    toggle.setAttribute('aria-expanded', !isExpanded);
                    sublist.hidden = isExpanded;
                    if (!isExpanded) {
                        sublist.classList.add('mobile-nav__sublist--open');
                    } else {
                        sublist.classList.remove('mobile-nav__sublist--open');
                    }
                }
            });
        });
    }

});
