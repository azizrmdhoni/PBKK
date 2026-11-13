(function () {
    'use strict';

    // Header: bayangan saat scroll
    var header = document.getElementById('siteHeader');
    var toTop = document.getElementById('backToTop');
    function onScroll() {
        var y = window.scrollY || document.documentElement.scrollTop;
        if (header) header.classList.toggle('scrolled', y > 8);
        if (toTop) toTop.classList.toggle('show', y > 600);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    if (toTop) {
        toTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Tutup menu mobile setelah klik link anchor
    document.querySelectorAll('#mainNav a.nav-link').forEach(function (a) {
        a.addEventListener('click', function () {
            var el = document.getElementById('mainNav');
            if (el && el.classList.contains('show') && window.bootstrap) {
                window.bootstrap.Collapse.getOrCreateInstance(el).hide();
            }
        });
    });

    // Reveal on scroll
    var targets = document.querySelectorAll(
        '.section-head, .cat-card, .product-card, .feature-card, .step, .role-card, .se-accordion .accordion-item, .cta-box'
    );
    targets.forEach(function (el) { el.classList.add('reveal'); });

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
            });
        }, { threshold: 0.12 });
        targets.forEach(function (el) { io.observe(el); });
    } else {
        targets.forEach(function (el) { el.classList.add('in'); });
    }

    // Scroll-spy sederhana untuk navigasi
    var links = Array.prototype.slice.call(document.querySelectorAll('#mainNav a.nav-link'));
    var map = links.map(function (l) { return { l: l, s: document.querySelector(l.getAttribute('href')) }; })
                   .filter(function (x) { return x.s; });
    if ('IntersectionObserver' in window && map.length) {
        var spy = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    map.forEach(function (m) { m.l.classList.toggle('active', m.s === e.target); });
                }
            });
        }, { rootMargin: '-45% 0px -50% 0px' });
        map.forEach(function (m) { spy.observe(m.s); });
    }
})();
