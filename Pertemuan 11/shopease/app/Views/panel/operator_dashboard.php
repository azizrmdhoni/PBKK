<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<?php
$firstName = explode(' ', trim((string) session()->get('name')))[0];
$queues = [
    ['Perlu disiapkan', 'Pembayaran terverifikasi, barang menunggu disiapkan.', 'package', 'tone-green'],
    ['Menunggu resi', 'Sudah disiapkan, kurir dan nomor resi belum diisi.', 'inbox', 'tone-terra'],
    ['Sudah dikirim', 'Dalam perjalanan ke pelanggan.', 'truck', 'tone-sage'],
];
$can = [
    [true,  'Melihat daftar pesanan'],
    [true,  'Memperbarui status pemrosesan'],
    [true,  'Mengisi kurir, nomor resi, dan status pengiriman'],
    [false, 'Memverifikasi pembayaran (hanya admin, BR-007)'],
    [false, 'Mengelola produk, kategori, dan pengguna'],
];
?>

<p class="hello">Halo, <strong><?= esc($firstName) ?></strong>. Berikut antrian pesanan yang perlu Anda tangani.</p>

<div class="stats">
    <?php foreach ($queues as [$label, $desc, $ico, $tone]): ?>
        <div class="stat">
            <div class="stat-top"><span><?= esc($label) ?></span><span class="stat-ico <?= esc($tone) ?>"><?= icon($ico, 20) ?></span></div>
            <div class="stat-val">-</div>
            <div class="stat-note"><?= esc($desc) ?></div>
        </div>
    <?php endforeach; ?>
</div>

<div class="panel-grid">
    <section class="card">
        <div class="card-head"><h2>Pesanan yang perlu diproses</h2></div>
        <div class="empty">
            <div class="ico"><?= icon('inbox', 28) ?></div>
            <strong>Belum ada pesanan</strong>
            <span>Daftar muncul setelah pelanggan bisa checkout (M4) dan pesanan diproses (M5).</span>
        </div>
    </section>

    <section class="card">
        <div class="card-head"><h2>Wewenang operator</h2></div>
        <div class="card-body">
            <ul class="can">
                <?php foreach ($can as [$ok, $text]): ?>
                    <li class="<?= $ok ? 'ok' : 'no' ?>"><?= icon($ok ? 'check-circle' : 'x-circle', 19) ?><span><?= esc($text) ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
