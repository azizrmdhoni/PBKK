(function () {
    'use strict';

    // Tampilkan / sembunyikan password
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.togglePassword);
            var icon = btn.querySelector('i');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            btn.setAttribute('aria-pressed', String(show));
            btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        });
    });

    // Checklist syarat password (bantuan visual; validasi sebenarnya di server)
    document.querySelectorAll('[data-rules-for]').forEach(function (input) {
        var list = document.getElementById(input.dataset.rulesFor);
        function check() {
            var v = input.value;
            var state = { len: v.length >= 8, alpha: /[A-Za-z]/.test(v), digit: /\d/.test(v) };
            list.querySelectorAll('[data-rule]').forEach(function (li) {
                var ok = state[li.dataset.rule];
                li.classList.toggle('ok', ok);
                li.querySelector('i').className = ok ? 'bi bi-check-circle-fill' : 'bi bi-circle';
            });
        }
        input.addEventListener('input', check);
        check();
    });

    // Isi otomatis akun uji (tombol hanya dirender di mode development)
    document.querySelectorAll('[data-fill-email]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var email = document.getElementById('email');
            var pw = document.getElementById('password');
            if (email) { email.value = btn.dataset.fillEmail; }
            if (pw) { pw.value = btn.dataset.fillPw; pw.focus(); }
        });
    });

    // Cegah submit ganda
    document.querySelectorAll('form[data-once]').forEach(function (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('button[type="submit"]');
            if (!btn || btn.disabled) { return; }
            btn.dataset.label = btn.textContent;
            btn.textContent = btn.dataset.loadingText || 'Memproses...';
            setTimeout(function () { btn.disabled = true; }, 0);
        });
    });

    // Pulihkan tombol saat kembali lewat bfcache
    window.addEventListener('pageshow', function (e) {
        if (!e.persisted) { return; }
        document.querySelectorAll('form[data-once] button[type="submit"]').forEach(function (btn) {
            btn.disabled = false;
            if (btn.dataset.label) { btn.textContent = btn.dataset.label; }
        });
    });
})();
