<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Akun') ?> | ShopEase</title>
    <meta name="theme-color" content="#234a3f">
    <link href="<?= base_url('assets/css/shopease.css') ?>" rel="stylesheet">
</head>
<body>
<a class="skip-link" href="#main">Lewati ke formulir</a>

<div class="auth">
    <aside class="auth-side" aria-label="Tentang ShopEase">
        <a class="brand brand-light" href="<?= base_url('/') ?>">
            <span class="brand-mark"><?= icon('bag', 20) ?></span><span>Shop<em>Ease</em></span>
        </a>

        <div>
            <h2>Belanja aman, pesanan selalu terlacak.</h2>
            <p class="lead">Satu akun untuk memilih produk, membayar, dan memantau pesanan sampai tiba.</p>
            <ul class="points">
                <li><span class="ico"><?= icon('lock', 20) ?></span><div><strong>Password terlindungi</strong><span>Disimpan dalam bentuk hash, bukan teks biasa.</span></div></li>
                <li><span class="ico"><?= icon('receipt', 20) ?></span><div><strong>Harga tersimpan akurat</strong><span>Harga saat transaksi dicatat pada pesanan.</span></div></li>
                <li><span class="ico"><?= icon('truck', 20) ?></span><div><strong>Status dan resi terlihat</strong><span>Dari menunggu pembayaran sampai dikirim.</span></div></li>
            </ul>
        </div>

        <small>&copy; <?= date('Y') ?> ShopEase. Proyek pembelajaran Web Framework.</small>
    </aside>

    <main class="auth-main" id="main">
        <div class="auth-wrap">
            <div class="auth-mobile-brand">
                <a class="brand" href="<?= base_url('/') ?>"><span class="brand-mark"><?= icon('bag', 20) ?></span><span>Shop<em>Ease</em></span></a>
            </div>

            <div class="auth-card">
                <?= $this->renderSection('content') ?>
            </div>

            <p class="auth-back"><a href="<?= base_url('/') ?>"><?= icon('arrow-left', 16) ?> Kembali ke beranda</a></p>
        </div>
    </main>
</div>

<script src="<?= base_url('assets/js/shopease.js') ?>"></script>
</body>
</html>
