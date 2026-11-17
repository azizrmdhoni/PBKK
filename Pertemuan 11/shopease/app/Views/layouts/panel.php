<?php
$role      = (string) session()->get('role');
$isAdmin   = $role === 'admin';
$userName  = (string) session()->get('name');
$userEmail = (string) session()->get('email');
$initial   = strtoupper(mb_substr($userName !== '' ? $userName : 'U', 0, 1));
$roleLabel = $isAdmin ? 'Administrator' : 'Operator Toko';
$roleBadge = $isAdmin ? 'badge-green' : 'badge-terra';

// [label, ikon, path, sudah aktif?]
$menu = $isAdmin ? [
    'Ringkasan' => [['Dashboard', 'dashboard', 'admin', true]],
    'Katalog'   => [['Kategori', 'tag', 'admin/kategori', false], ['Produk', 'package', 'admin/produk', false]],
    'Penjualan' => [['Pesanan', 'receipt', 'admin/pesanan', false], ['Laporan', 'chart', 'admin/laporan', false]],
    'Sistem'    => [['Pengguna', 'users', 'admin/pengguna', false]],
] : [
    'Ringkasan'   => [['Dashboard', 'dashboard', 'operator', true]],
    'Fulfillment' => [['Pesanan Masuk', 'inbox', 'operator/pesanan', false], ['Pengiriman', 'truck', 'operator/pengiriman', false]],
];
$current = trim(uri_string(), '/');
$homeUrl = $isAdmin ? 'admin' : 'operator';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Dashboard') ?> | ShopEase</title>
    <meta name="robots" content="noindex">
    <meta name="theme-color" content="#1b3a31">
    <link href="<?= base_url('assets/css/shopease.css') ?>" rel="stylesheet">
</head>
<body>
<a class="skip-link" href="#main">Lewati ke konten utama</a>

<div class="app">
    <aside class="sidebar" id="sidebar" aria-label="Menu <?= esc($roleLabel) ?>">
        <div class="sidebar-head">
            <a class="brand brand-light" href="<?= base_url($homeUrl) ?>">
                <span class="brand-mark"><?= icon('bag', 20) ?></span><span>Shop<em>Ease</em></span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <?php foreach ($menu as $group => $items): ?>
                <div class="nav-group"><?= esc($group) ?></div>
                <?php foreach ($items as [$label, $ico, $path, $live]): ?>
                    <?php $active = $path === $homeUrl ? $current === $path : ($current === $path || str_starts_with($current, $path . '/')); ?>
                    <a class="nav-link<?= $active ? ' active' : '' ?>" href="<?= base_url($path) ?>"<?= $active ? ' aria-current="page"' : '' ?>>
                        <?= icon($ico, 19) ?><span><?= esc($label) ?></span>
                        <?php if (! $live): ?><em class="tag" style="font-style: normal">Segera</em><?php endif; ?>
                    </a>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <div class="nav-group">Toko</div>
            <a class="nav-link" href="<?= base_url('/') ?>"><?= icon('home', 19) ?><span>Lihat toko</span></a>
        </nav>

        <div class="sidebar-foot">
            <span class="avatar" aria-hidden="true"><?= esc($initial) ?></span>
            <div class="who"><strong><?= esc($userName) ?></strong><small><?= esc($roleLabel) ?></small></div>
            <form action="<?= site_url('logout') ?>" method="post" class="m-0">
                <?= csrf_field() ?>
                <button type="submit" aria-label="Keluar" title="Keluar"><?= icon('logout', 18) ?></button>
            </form>
        </div>
    </aside>

    <div class="app-main">
        <header class="topbar">
            <button class="burger" type="button" data-nav-toggle aria-label="Buka menu" aria-controls="sidebar"><?= icon('menu', 22) ?></button>
            <div class="page-title">
                <?php if (! empty($crumb)): ?>
                    <nav class="crumb" aria-label="Breadcrumb">
                        <a href="<?= base_url($homeUrl) ?>">Dashboard</a><?= icon('chevron-right', 13) ?><span><?= esc($crumb) ?></span>
                    </nav>
                <?php else: ?>
                    <p class="crumb"><?= esc($roleLabel) ?> &middot; <?= date('d/m/Y') ?></p>
                <?php endif; ?>
                <h1><?= esc($heading ?? 'Dashboard') ?></h1>
            </div>
            <div class="topbar-right">
                <span class="badge <?= esc($roleBadge) ?>"><?= esc($roleLabel) ?></span>
                <span class="who-mini"><?= esc($userEmail) ?></span>
            </div>
        </header>

        <main class="page" id="main">
            <?= $this->include('layouts/flash_panel') ?>
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script src="<?= base_url('assets/js/shopease.js') ?>"></script>
</body>
</html>
