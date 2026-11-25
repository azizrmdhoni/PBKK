<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<?php $logged = (bool) session()->get('isLoggedIn'); ?>
<section class="se-card">
    <h1 class="se-title">
        <?= $logged ? 'Halo, ' . esc(session()->get('name')) : 'Selamat datang di ShopEase' ?>
    </h1>
    <p class="se-sub">
        <?= $logged
            ? 'Anda sudah masuk sebagai ' . esc(session()->get('role')) . '. Katalog produk akan tampil di halaman ini setelah modul Product Management selesai.'
            : 'Masuk atau buat akun untuk mulai berbelanja. Katalog produk akan tampil di halaman ini setelah modul Product Management selesai.' ?>
    </p>
</section>
<?= $this->endSection() ?>
