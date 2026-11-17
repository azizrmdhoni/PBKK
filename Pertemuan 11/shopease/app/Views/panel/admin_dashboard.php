<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<?php
$firstName = explode(' ', trim((string) session()->get('name')))[0];
$statuses  = [
    ['pending_payment', 'Menunggu pembayaran', 'warn'],
    ['waiting_verification', 'Menunggu verifikasi', 'info'],
    ['processing', 'Diproses', 'prog'],
    ['shipped', 'Dikirim', 'prog'],
    ['completed', 'Selesai', 'ok'],
    ['cancelled', 'Dibatalkan', ''],
];
$milestones = [
    ['M1', 'Fondasi', 'Setup CI4, database, routing, layout', 'done', 'Selesai'],
    ['M2', 'Katalog/Admin', 'Autentikasi selesai. CRUD kategori dan produk berikutnya', 'now', 'Sedang dikerjakan'],
    ['M3', 'Customer Store', 'Katalog, detail, pencarian, keranjang', 'next', 'Menunggu'],
    ['M4', 'Transaksi', 'Checkout, order, pembayaran, verifikasi', 'next', 'Menunggu'],
    ['M5', 'Fulfillment', 'Status pesanan, pengiriman, dashboard dan laporan', 'next', 'Menunggu'],
    ['M6', 'Quality & Release', 'Testing, dokumentasi, demo', 'next', 'Menunggu'],
];
$cards = [
    ['Produk', '-', 'Aktif setelah M2', 'package', 'tone-green'],
    ['Pelanggan aktif', (string) $customers, $newCustomers > 0 ? '+' . $newCustomers . ' dalam 7 hari terakhir' : 'Belum ada yang baru minggu ini', 'users', 'tone-terra'],
    ['Pesanan', '-', 'Aktif setelah M4', 'receipt', 'tone-sand'],
    ['Penjualan', 'Rp -', 'Aktif setelah M4', 'banknote', 'tone-sage'],
];
?>

<p class="hello">Halo, <strong><?= esc($firstName) ?></strong>. Berikut kondisi toko hari ini.</p>

<div class="stats">
    <?php foreach ($cards as [$label, $value, $note, $ico, $tone]): ?>
        <div class="stat">
            <div class="stat-top"><span><?= esc($label) ?></span><span class="stat-ico <?= esc($tone) ?>"><?= icon($ico, 20) ?></span></div>
            <div class="stat-val"><?= esc($value) ?></div>
            <div class="stat-note"><?= esc($note) ?></div>
        </div>
    <?php endforeach; ?>
</div>

<div class="panel-grid">
    <section class="card">
        <div class="card-head">
            <h2>Pelanggan terbaru</h2>
            <span class="muted small"><?= esc($staff) ?> akun staf aktif</span>
        </div>
        <?php if (empty($latest)): ?>
            <div class="empty">
                <div class="ico"><?= icon('user-plus', 28) ?></div>
                <strong>Belum ada pelanggan</strong>
                <span>Akun yang mendaftar akan muncul di sini.</span>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="table">
                    <thead><tr><th>Nama</th><th>Email</th><th>Bergabung</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php foreach ($latest as $u): ?>
                        <tr>
                            <td><div class="cell-user"><span class="avatar avatar-sm" aria-hidden="true"><?= esc(strtoupper(mb_substr($u['name'], 0, 1))) ?></span><?= esc($u['name']) ?></div></td>
                            <td class="muted"><?= esc($u['email']) ?></td>
                            <td class="muted"><?= esc(date('d/m/Y', strtotime($u['created_at']))) ?></td>
                            <td><?= (int) $u['is_active'] === 1 ? '<span class="badge badge-ok">Aktif</span>' : '<span class="badge">Nonaktif</span>' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <section class="card">
        <div class="card-head"><h2>Ringkasan pesanan</h2></div>
        <ul class="list">
            <?php foreach ($statuses as [$code, $label, $tone]): ?>
                <li><span class="sdot <?= esc($tone) ?>"></span><div class="grow"><?= esc($label) ?><small><?= esc($code) ?></small></div><strong class="muted">-</strong></li>
            <?php endforeach; ?>
        </ul>
        <div class="card-foot"><?= icon('info', 14) ?> Terisi setelah modul Checkout (M4) aktif.</div>
    </section>
</div>

<section class="card">
    <div class="card-head"><h2>Progres pengembangan</h2><span class="muted small">Milestone PRD bagian 17</span></div>
    <ul class="list">
        <?php foreach ($milestones as [$code, $name, $desc, $state, $stateLabel]): ?>
            <li class="is-<?= esc($state) ?>">
                <span class="mile"><?= $state === 'done' ? icon('check', 16) : esc($code) ?></span>
                <div class="grow"><strong><?= esc($code) ?> &middot; <?= esc($name) ?></strong><small><?= esc($desc) ?></small></div>
                <span class="badge <?= $state === 'done' ? 'badge-ok' : ($state === 'now' ? 'badge-terra' : '') ?>"><?= esc($stateLabel) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?= $this->endSection() ?>
