<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'ShopEase') ?></title>
    <meta name="description" content="<?= esc($metaDesc ?? '') ?>">
    <meta name="theme-color" content="#4f46e5">
    <meta property="og:title" content="<?= esc($title ?? 'ShopEase') ?>">
    <meta property="og:description" content="<?= esc($metaDesc ?? '') ?>">
    <meta property="og:type" content="website">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/shopease.css') ?>" rel="stylesheet">
    <?= $this->renderSection('head') ?>
</head>
<body>
    <a class="visually-hidden-focusable skip-link" href="#main">Lewati ke konten utama</a>

    <?= $this->include('layouts/navbar') ?>

    <main id="main">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('layouts/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/shopease.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
