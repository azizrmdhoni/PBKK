<?php
$isLoggedIn = (bool) session()->get('isLoggedIn');
$role       = (string) session()->get('role');
$userName   = (string) session()->get('name');
$userEmail  = (string) session()->get('email');
$initial    = strtoupper(mb_substr($userName !== '' ? $userName : 'U', 0, 1));
$firstName  = explode(' ', trim($userName))[0] ?? '';
$isStaff    = in_array($role, ['admin', 'operator'], true);
$roleLabel  = ['admin' => 'Administrator', 'operator' => 'Operator Toko', 'customer' => 'Customer'][$role] ?? $role;
$roleBadge  = ['admin' => 'badge-green', 'operator' => 'badge-terra', 'customer' => 'badge-ok'][$role] ?? '';
?>
<div class="topstrip">
    <div class="container">
        <span><?= icon('shield', 15) ?>Transaksi aman &middot; Pembayaran manual via transfer &middot; Pesanan dapat dilacak</span>
        <?php if (! $isLoggedIn): ?>
            <span><a href="<?= base_url('login') ?>">Masuk</a> &nbsp;|&nbsp; <a href="<?= base_url('register') ?>">Daftar</a></span>
        <?php else: ?>
            <span>Masuk sebagai <?= esc($roleLabel) ?></span>
        <?php endif; ?>
    </div>
</div>

<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="header-row">
            <a class="brand" href="<?= base_url('/') ?>" aria-label="ShopEase, ke beranda">
                <span class="brand-mark"><?= icon('bag', 20) ?></span><span>Shop<em>Ease</em></span>
            </a>

            <form class="search" action="<?= base_url('katalog') ?>" method="get" role="search">
                <label for="q" class="sr-only">Cari produk</label>
                <input id="q" type="search" name="q" placeholder="Cari produk, misalnya headphone" autocomplete="off">
                <button type="submit"><?= icon('search', 18) ?> Cari</button>
            </form>

            <div class="header-actions">
            <?php if (! $isLoggedIn): ?>
                <a href="<?= base_url('login') ?>" class="btn btn-outline">Masuk</a>
                <a href="<?= base_url('register') ?>" class="btn btn-primary">Daftar</a>
            <?php else: ?>
                <?php if ($role === 'customer'): ?>
                    <a href="<?= base_url('keranjang') ?>" class="btn btn-ghost btn-icon" aria-label="Keranjang"><?= icon('cart') ?></a>
                <?php else: ?>
                    <a href="<?= base_url($role) ?>" class="btn btn-primary"><?= icon('dashboard', 18) ?> Dashboard</a>
                <?php endif; ?>

                <div class="dropdown" data-dropdown>
                    <button class="user-btn" type="button" data-dropdown-btn aria-expanded="false" aria-haspopup="true">
                        <span class="avatar avatar-sm" aria-hidden="true"><?= esc($initial) ?></span>
                        <span><?= esc($firstName) ?></span><?= icon('chevron-down', 16) ?>
                    </button>
                    <div class="menu">
                        <div class="menu-head">
                            <strong><?= esc($userName) ?></strong>
                            <small><?= esc($userEmail) ?></small>
                            <span class="badge <?= esc($roleBadge) ?>"><?= esc($roleLabel) ?></span>
                        </div>
                        <?php if ($role === 'customer'): ?>
                            <a href="<?= base_url('pesanan') ?>"><?= icon('history', 18) ?> Riwayat Pesanan</a>
                            <a href="<?= base_url('keranjang') ?>"><?= icon('cart', 18) ?> Keranjang</a>
                        <?php elseif ($isStaff): ?>
                            <a href="<?= base_url($role) ?>"><?= icon('dashboard', 18) ?> Dashboard</a>
                        <?php endif; ?>
                        <form action="<?= site_url('logout') ?>" method="post" class="m-0">
                            <?= csrf_field() ?>
                            <button type="submit" class="danger"><?= icon('logout', 18) ?> Keluar</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <nav class="site-nav" aria-label="Navigasi utama">
        <div class="container nav-in">
            <a href="<?= base_url('/') ?>">Beranda</a>
            <a href="<?= base_url('katalog') ?>">Katalog</a>
            <a href="<?= base_url('/#kategori') ?>">Kategori</a>
            <a href="<?= base_url('/#produk') ?>">Produk Unggulan</a>
            <a href="<?= base_url('/#cara-belanja') ?>">Cara Belanja</a>
        </div>
    </nav>
</header>
