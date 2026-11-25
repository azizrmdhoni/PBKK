/* ShopEase | Product Management: konfirmasi hapus dan preview gambar sebelum upload. */
(function () {
    'use strict';

    // Konfirmasi untuk form bertanda data-confirm="pesan"
    document.addEventListener('submit', function (e) {
        var form = e.target;
        var message = form && form.getAttribute ? form.getAttribute('data-confirm') : null;
        if (message && !window.confirm(message)) {
            e.preventDefault();
        }
    });

    // Preview gambar sebelum diunggah
    var input = document.querySelector('[data-image-input]');
    if (!input) { return; }

    var box = document.getElementById(input.getAttribute('data-preview-target'));
    var note = document.getElementById(input.getAttribute('data-note-target'));
    var maxFiles = parseInt(input.getAttribute('data-max-files'), 10) || 0;
    var maxBytes = (parseFloat(input.getAttribute('data-max-mb')) || 2) * 1024 * 1024;
    var allowed = ['image/jpeg', 'image/png', 'image/webp'];
    var defaultNote = note ? note.textContent : '';
    var urls = [];

    function clearPreview() {
        urls.forEach(function (u) { URL.revokeObjectURL(u); });
        urls = [];
        if (box) { box.textContent = ''; }
    }

    function formatSize(bytes) {
        return bytes >= 1048576 ? (bytes / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(bytes / 1024)) + ' KB';
    }

    function addThumb(file, index) {
        var url = URL.createObjectURL(file);
        urls.push(url);

        var fig = document.createElement('figure');
        fig.className = 'gal-item';

        var img = document.createElement('img');
        img.src = url;
        img.alt = 'Pratinjau ' + file.name;
        fig.appendChild(img);

        var cap = document.createElement('span');
        cap.className = 'gal-cap';
        cap.textContent = file.name + ' (' + formatSize(file.size) + ')';
        fig.appendChild(cap);

        box.appendChild(fig);
    }

    input.addEventListener('change', function () {
        clearPreview();

        var files = Array.prototype.slice.call(input.files || []);
        var valid = [];
        var problems = [];

        files.forEach(function (file) {
            if (allowed.indexOf(file.type) === -1) {
                problems.push(file.name + ': format harus JPG, PNG, atau WEBP.');
            } else if (file.size > maxBytes) {
                problems.push(file.name + ': ukuran melebihi 2 MB.');
            } else if (valid.length >= maxFiles) {
                problems.push(file.name + ': melebihi sisa kuota ' + maxFiles + ' gambar.');
            } else {
                valid.push(file);
            }
        });

        // Buang file yang ditolak dari input (bila browser mendukung DataTransfer).
        if (problems.length && window.DataTransfer) {
            var dt = new DataTransfer();
            valid.forEach(function (f) { dt.items.add(f); });
            input.files = dt.files;
        }

        if (box) { valid.forEach(addThumb); }

        if (note) {
            note.textContent = problems.length
                ? 'Tidak dipilih: ' + problems.join(' ')
                : (valid.length ? valid.length + ' gambar siap diunggah. ' : '') + defaultNote;
            note.style.color = problems.length ? 'var(--danger)' : '';
        }
    });
})();
