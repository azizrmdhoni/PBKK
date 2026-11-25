(function () {
    'use strict';
    var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

    // Bayangan header saat scroll
    var header = document.getElementById('siteHeader');
    if (header) {
        var onScroll = function () { header.classList.toggle('scrolled', (window.scrollY || 0) > 8); };
        window.addEventListener('scroll', onScroll, { passive: true }); onScroll();
    }

    // Tandai menu aktif
    var path = location.pathname.replace(/\/+$/, '');
    $$('.nav-in a').forEach(function (a) {
        if (!a.hash && a.pathname.replace(/\/+$/, '') === path) { a.classList.add('active'); }
    });

    // Dropdown akun
    $$('[data-dropdown]').forEach(function (box) {
        var btn = box.querySelector('[data-dropdown-btn]');
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = box.classList.toggle('open');
            btn.setAttribute('aria-expanded', String(open));
        });
    });
    document.addEventListener('click', function () {
        $$('[data-dropdown].open').forEach(function (b) { b.classList.remove('open'); b.querySelector('[data-dropdown-btn]').setAttribute('aria-expanded', 'false'); });
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { document.body.click(); var app = document.querySelector('.app'); if (app) { app.classList.remove('nav-open'); } } });

    // Sidebar mobile (panel)
    var app = document.querySelector('.app');
    $$('[data-nav-toggle]').forEach(function (b) { b.addEventListener('click', function (e) { e.stopPropagation(); app.classList.toggle('nav-open'); }); });
    if (app) { document.addEventListener('click', function (e) { if (app.classList.contains('nav-open') && !e.target.closest('.sidebar')) { app.classList.remove('nav-open'); } }); }

    // Tampilkan / sembunyikan password
    var eye = '<svg class="i" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
    var ICON_EYE = eye + '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>';
    var ICON_OFF = eye + '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><path d="m2 2 20 20"/></svg>';
    $$('[data-toggle-password]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.togglePassword);
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.innerHTML = show ? ICON_OFF : ICON_EYE;
            btn.setAttribute('aria-pressed', String(show));
            btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        });
    });

    // Checklist syarat password (bantuan visual; validasi sebenarnya di server)
    $$('[data-rules-for]').forEach(function (input) {
        var list = document.getElementById(input.dataset.rulesFor);
        var yes = eye + '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>'.replace('width="20" height="20"', '');
        var no = eye + '<circle cx="12" cy="12" r="10"/></svg>';
        function check() {
            var v = input.value, s = { len: v.length >= 8, alpha: /[A-Za-z]/.test(v), digit: /\d/.test(v) };
            $$('[data-rule]', list).forEach(function (li) {
                var ok = s[li.dataset.rule];
                li.classList.toggle('ok', ok);
                li.querySelector('svg').outerHTML = (ok ? yes : no).replace('width="20" height="20"', 'width="16" height="16"');
            });
        }
        input.addEventListener('input', check); check();
    });

    // Isi otomatis akun uji (hanya dirender di mode development)
    $$('[data-fill-email]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var e = document.getElementById('email'), p = document.getElementById('password');
            if (e) { e.value = btn.dataset.fillEmail; }
            if (p) { p.value = btn.dataset.fillPw; p.focus(); }
        });
    });

    // Cegah submit ganda
    $$('form[data-once]').forEach(function (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('button[type="submit"]');
            if (!btn || btn.disabled) { return; }
            btn.dataset.label = btn.textContent;
            btn.textContent = btn.dataset.loadingText || 'Memproses...';
            setTimeout(function () { btn.disabled = true; }, 0);
        });
    });
    window.addEventListener('pageshow', function (e) {
        if (!e.persisted) { return; }
        $$('form[data-once] button[type="submit"]').forEach(function (b) { b.disabled = false; if (b.dataset.label) { b.textContent = b.dataset.label; } });
    });
})();
