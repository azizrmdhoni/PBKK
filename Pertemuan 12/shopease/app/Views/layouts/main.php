<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'ShopEase') ?> | ShopEase</title>
    <meta name="description" content="<?= esc($metaDesc ?? 'ShopEase - toko online dengan pesanan terlacak.') ?>">
    <meta name="theme-color" content="#1b3a31">
    <link href="<?= base_url('assets/css/shopease.css') ?>" rel="stylesheet">
    <?= $this->renderSection('head') ?>
</head>
<body>
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <?= $this->include('layouts/navbar') ?>
    <?= $this->include('layouts/flash') ?>

    <main id="main">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('layouts/footer') ?>

    <script src="<?= base_url('assets/js/shopease.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
