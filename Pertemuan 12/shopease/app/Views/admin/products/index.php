<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<?php


$lowMax    = \App\Models\ProductModel::LOW_STOCK_THRESHOLD;
$hasFilter = $filters['q'] !== '' || $filters['category'] > 0 || $filters['status'] !== '' || $filters['stock'] !== '';
$first     = ($pager->getCurrentPage() - 1) * $pager->getPerPage();
$total     = $pager->getTotal();

$cards = [
    ['Total produk',   $summary['total'],        $summary['available'] . ' tersedia',             'package',  'tone-green'],
    ['Tidak tersedia', $summary['unavailable'],  'Disembunyikan dari pembeli',                    'lock',     'tone-sand'],
    ['Stok menipis',   $summary['low_stock'],    'Sisa 1 sampai ' . $lowMax . ' unit',            'alert',    'tone-terra'],
    ['Stok habis',     $summary['out_of_stock'], 'Perlu diisi ulang',                             'inbox',    'tone-sage'],
];
?>

<div class="page-head">
    <p>Kelola katalog produk ShopEase: harga, stok, status, dan gambar.</p>
    <a href="<?= site_url('admin/products/create') ?>" class="btn btn-primary"><?= icon('plus', 17) ?> Tambah Produk</a>
</div>

<div class="stats">
    <?php foreach ($cards as [$label, $value, $note, $ico, $tone]): ?>
        <div class="stat">
            <div class="stat-top"><span><?= esc($label) ?></span><span class="stat-ico <?= esc($tone) ?>"><?= icon($ico, 20) ?></span></div>
            <div class="stat-val"><?= esc($value) ?></div>
            <div class="stat-note"><?= esc($note) ?></div>
        </div>
    <?php endforeach; ?>
</div>

<section class="card">
    <form method="get" action="<?= site_url('admin/products') ?>" class="toolbar" role="search">
        <div class="field grow">
            <label class="label" for="q">Cari produk</label>
            <div class="input">
                <?= icon('search', 18) ?>
                <input type="search" id="q" name="q" value="<?= esc($filters['q']) ?>" placeholder="Ketik nama produk" maxlength="150">
            </div>
        </div>
        <div class="field">
            <label class="label" for="category">Kategori</label>
            <select id="category" name="category" class="control">
                <option value="">Semua kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= esc($category['id_category']) ?>" <?= $filters['category'] === (int) $category['id_category'] ? 'selected' : '' ?>>
                        <?= esc($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label class="label" for="status">Status</label>
            <select id="status" name="status" class="control">
                <option value="">Semua status</option>
                <?php foreach (\App\Models\ProductModel::STATUSES as $code => $label): ?>
                    <option value="<?= esc($code) ?>" <?= $filters['status'] === $code ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label class="label" for="stock">Stok</label>
            <select id="stock" name="stock" class="control">
                <option value="">Semua stok</option>
                <option value="low" <?= $filters['stock'] === 'low' ? 'selected' : '' ?>>Menipis (1-<?= $lowMax ?>)</option>
                <option value="out" <?= $filters['stock'] === 'out' ? 'selected' : '' ?>>Habis (0)</option>
            </select>
        </div>
        <div class="toolbar-actions">
            <button type="submit" class="btn btn-primary"><?= icon('filter', 16) ?> Terapkan</button>
            <?php if ($hasFilter): ?>
                <a href="<?= site_url('admin/products') ?>" class="btn btn-ghost"><?= icon('x', 16) ?> Reset</a>
            <?php endif; ?>
        </div>
    </form>

    <?php if (empty($products)): ?>
        <div class="empty">
            <div class="ico"><?= icon($hasFilter ? 'search' : 'package', 28) ?></div>
            <?php if ($hasFilter): ?>
                <strong>Produk tidak ditemukan</strong>
                <span>Coba ubah kata kunci atau longgarkan filter.</span>
            <?php else: ?>
                <strong>Belum ada data produk</strong>
                <span>Mulai dengan menambahkan produk pertama Anda.</span>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th><th>Produk</th><th>Kategori</th><th>Harga</th>
                        <th>Stok</th><th>Status</th><th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $i => $product): ?>
                    <?php
                    $thumb = product_image_url($product['thumbnail'] ?? null);
                    $stock = (int) $product['stock'];
                    $name  = $product['name'];
                    ?>
                    <tr>
                        <td class="muted"><?= $first + $i + 1 ?></td>
                        <td>
                            <div class="prod-cell">
                                <?php if ($thumb): ?>
                                    <img class="thumb" src="<?= esc($thumb) ?>" alt="" loading="lazy" width="48" height="48">
                                <?php else: ?>
                                    <span class="thumb thumb-ph"><?= icon('image', 20) ?></span>
                                <?php endif; ?>
                                <div>
                                    <strong><?= esc($name) ?></strong>
                                    <small><?= (int) $product['image_count'] ?> gambar</small>
                                </div>
                            </div>
                        </td>
                        <td><?= esc($product['category_name']) ?></td>
                        <td class="nowrap"><strong><?= esc(rupiah($product['price'])) ?></strong></td>
                        <td>
                            <form method="post" action="<?= site_url('admin/products/stock/' . $product['id_product']) ?>" class="stock-form">
                                <?= csrf_field() ?>
                                <input type="number" name="stock" class="control control-sm" min="0" max="2147483646" value="<?= $stock ?>"
                                       aria-label="Stok <?= esc($name) ?>" required>
                                <button type="submit" class="btn btn-ghost btn-sm btn-icon" title="Simpan stok" aria-label="Simpan stok <?= esc($name) ?>"><?= icon('save', 16) ?></button>
                            </form>
                            <?php if ($stock === 0): ?>
                                <span class="badge badge-danger stock-badge">Habis</span>
                            <?php elseif ($stock <= $lowMax): ?>
                                <span class="badge badge-gold stock-badge">Menipis</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($product['status'] === 'tersedia'): ?>
                                <span class="badge badge-ok">Tersedia</span>
                            <?php else: ?>
                                <span class="badge">Tidak Tersedia</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="<?= site_url('admin/products/edit/' . $product['id_product']) ?>" class="btn btn-ghost btn-sm"><?= icon('pencil', 15) ?> Edit</a>
                                <form method="post" action="<?= site_url('admin/products/delete/' . $product['id_product']) ?>" class="inline-form"
                                      data-confirm="<?= esc('Hapus produk "' . $name . '"? Semua gambarnya ikut terhapus dan tindakan ini tidak bisa dibatalkan.') ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger-ghost btn-sm" aria-label="Hapus <?= esc($name) ?>"><?= icon('trash', 15) ?> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-foot">
            <span class="muted small">Menampilkan <?= $first + 1 ?>&ndash;<?= $first + count($products) ?> dari <?= esc($total) ?> produk</span>
            <?php if ($pager->getPageCount() > 1): ?>
                <?= $pager->links('default', 'shopease_full') ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/product.js') ?>"></script>
<?= $this->endSection() ?>
