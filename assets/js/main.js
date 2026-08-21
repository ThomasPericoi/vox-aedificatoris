document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    const body = document.body;
    const header = document.getElementById('header');
    const main = document.getElementById('main');
    const footer = document.querySelector('footer');
    const adminBar = body.classList.contains('admin-bar') ? document.getElementById('wpadminbar') : null;
    const nav = document.querySelector('.nav-wrapper');
    const menuToggle = document.getElementById('menu-toggle');
    const desktopQuery = window.matchMedia('(min-width: 1200px)');
    const reduceMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

    // Toggle inert and aria-hidden together for accessible hidden states.
    const setElementState = (element, enabled) => {
        if (!element) {
            return;
        }

        element.toggleAttribute('inert', !enabled);
        element.setAttribute('aria-hidden', enabled ? 'false' : 'true');
    };

    // Open or close the main navigation and protect the rest of the page.
    const setMenuState = (opened) => {
        body.classList.toggle('js-menuOpened', opened);

        if (menuToggle) {
            menuToggle.setAttribute('aria-expanded', opened ? 'true' : 'false');
            menuToggle.querySelector('.screen-reader-text').textContent = opened ? menuToggle.dataset.labelClose : menuToggle.dataset.labelOpen;
        }

        if (desktopQuery.matches) {
            nav?.removeAttribute('inert');
            setElementState(main, true);
            setElementState(footer, true);
            return;
        }

        nav?.toggleAttribute('inert', !opened);
        setElementState(main, !opened);
        setElementState(footer, !opened);
    };

    const closeMenu = () => setMenuState(false);

    // Keep viewport, scrollbar, admin bar, and header values in CSS variables.
    const updateLayoutVariables = () => {
        root.style.setProperty('--viewport-height', `${window.innerHeight}px`);
        root.style.setProperty('--scrollbar-width', `${window.innerWidth - root.clientWidth}px`);
        root.style.setProperty('--admin-bar-visible-height', '0px');

        if (adminBar) {
            const adminBarRect = adminBar.getBoundingClientRect();
            const adminBarVisibleHeight = Math.max(0, Math.min(adminBarRect.bottom, adminBarRect.height));

            root.style.setProperty('--admin-bar-visible-height', `${adminBarVisibleHeight}px`);
        }

        if (header) {
            root.style.setProperty('--header-height', `${header.offsetHeight}px`);
        }
    };

    // Batch layout variable updates into the next animation frame.
    let layoutTicking = false;
    const requestLayoutVariablesUpdate = () => {
        if (layoutTicking) {
            return;
        }

        layoutTicking = true;
        window.requestAnimationFrame(() => {
            updateLayoutVariables();
            layoutTicking = false;
        });
    };

    // Reconcile menu and layout state when the viewport changes.
    const onViewportChange = () => {
        updateLayoutVariables();

        if (desktopQuery.matches) {
            closeMenu();
            nav?.removeAttribute('inert');
            return;
        }

        setMenuState(body.classList.contains('js-menuOpened'));
    };

    // Bind all layout observers and viewport listeners.
    const initLayoutVariables = () => {
        updateLayoutVariables();
        window.addEventListener('resize', onViewportChange, { passive: true });
        window.addEventListener('scroll', requestLayoutVariablesUpdate, { passive: true });
        window.visualViewport?.addEventListener('resize', updateLayoutVariables, { passive: true });
        window.visualViewport?.addEventListener('scroll', requestLayoutVariablesUpdate, { passive: true });

        if ('ResizeObserver' in window && header) {
            new ResizeObserver(updateLayoutVariables).observe(header);
        }

        if ('ResizeObserver' in window && adminBar) {
            new ResizeObserver(updateLayoutVariables).observe(adminBar);
        }

        if (typeof desktopQuery.addEventListener === 'function') {
            desktopQuery.addEventListener('change', onViewportChange);
        }
    };

    // Print the theme signature in the console.
    const initSignature = () => {
        console.info('This theme was made by Thomas Pericoi - https://thomaspericoi.com/');

        if (window.AsciiPrinter && typeof window.AsciiPrinter.printRandom === 'function') {
            window.AsciiPrinter.printRandom();
        }
    };

    // Reveal main sections progressively while keeping fallbacks for old browsers.
    const initRevealOnScroll = () => {
        if (!main) {
            return;
        }

        const sections = Array.from(main.children).filter((element) => element.tagName === 'SECTION');
        const revealSection = (section) => section.classList.add('js-inView');

        if (!sections.length || reduceMotionQuery.matches || !('IntersectionObserver' in window)) {
            sections.forEach(revealSection);
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                revealSection(entry.target);
                observer.unobserve(entry.target);
            });
        }, {
            rootMargin: '0px 0px -15% 0px',
            threshold: 0.1,
        });

        window.requestAnimationFrame(() => {
            window.requestAnimationFrame(() => {
                sections.forEach((section) => observer.observe(section));
            });
        });
    };

    // Preserve custom ordered-list starts inside formatted content.
    const initOrderedLists = () => {
        document.querySelectorAll('.formatted ol[start]').forEach((list) => {
            const start = Number.parseInt(list.getAttribute('start'), 10);

            if (!Number.isNaN(start)) {
                list.style.counterReset = `item ${start - 1}`;
            }
        });
    };

    // Stop decorative hero videos when reduced motion is requested.
    const initHeroVideos = () => {
        if (!reduceMotionQuery.matches) {
            return;
        }

        document.querySelectorAll('.front-page-hero video[autoplay]').forEach((video) => {
            video.removeAttribute('autoplay');
            video.pause();
        });
    };

    // Wire the responsive menu behaviour.
    const initMenu = () => {
        if (!nav || !menuToggle) {
            return;
        }

        setMenuState(false);

        menuToggle.addEventListener('click', () => {
            setMenuState(!body.classList.contains('js-menuOpened'));
        });

        nav.addEventListener('click', (event) => {
            if (!desktopQuery.matches && event.target.closest('a')) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && body.classList.contains('js-menuOpened')) {
                closeMenu();
                menuToggle.focus();
            }
        });
    };

    // Initialize the clients sliders.
    const initClientsSliders = () => {
        if (typeof window.Swiper !== 'function') {
            return;
        }

        document.querySelectorAll('.front-page-clients-slider').forEach((slider) => {
            const slides = slider.querySelectorAll('.swiper-slide');

            new window.Swiper(slider, {
                slidesPerView: 2,
                spaceBetween: 16,
                centeredSlides: true,
                loop: slides.length > 2,
                grabCursor: true,
                centerInsufficientSlides: true,
                watchOverflow: true,
                keyboard: {
                    enabled: true,
                    onlyInViewport: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3.5,
                        spaceBetween: 32,
                        centeredSlides: false,
                    },
                    992: {
                        slidesPerView: 5,
                        spaceBetween: 90,
                        centeredSlides: false,
                    },
                },
            });
        });
    };

    // Initialize the testimonials slider.
    const initTestimonialsSliders = () => {
        if (typeof window.Swiper !== 'function') {
            return;
        }

        document.querySelectorAll('.front-page-testimonials-slider').forEach((slider) => {
            const slides = slider.querySelectorAll('.swiper-slide');
            const slidesCount = slides.length;

            if (!slidesCount) {
                return;
            }

            new window.Swiper(slider, {
                slidesPerView: slidesCount > 1 ? 1.1 : 1,
                spaceBetween: 16,
                grabCursor: slidesCount > 1,
                watchOverflow: true,
                keyboard: {
                    enabled: true,
                    onlyInViewport: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: slidesCount > 1 ? 1.5 : 1,
                    },
                    992: {
                        slidesPerView: slidesCount > 2 ? 2.05 : slidesCount,
                    },
                },
            });
        });
    };

    // Toggle each mission offer from either of its controls.
    const initMissionOffers = () => {
        document.querySelectorAll('.front-page-mission').forEach((mission) => {
            const toggles = mission.querySelectorAll('.front-page-mission-icon-toggle, .front-page-mission-offer-toggle');
            const panelId = toggles[0]?.getAttribute('aria-controls');
            const panel = panelId ? document.getElementById(panelId) : null;

            if (!toggles.length || !panel) {
                return;
            }

            const setOfferState = (opened) => {
                panel.hidden = !opened;
                toggles.forEach((toggle) => toggle.setAttribute('aria-expanded', opened ? 'true' : 'false'));
            };

            toggles.forEach((toggle) => {
                toggle.addEventListener('click', () => {
                    setOfferState(toggle.getAttribute('aria-expanded') !== 'true');
                });
            });
        });
    };

    initLayoutVariables();
    initSignature();
    initRevealOnScroll();
    initOrderedLists();
    initHeroVideos();
    initMenu();
    initClientsSliders();
    initTestimonialsSliders();
    initMissionOffers();
});
