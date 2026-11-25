<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<div class="page-head">
    <p>Kelompokkan produk agar mudah dicari pembeli. Kategori yang masih punya produk tidak bisa dihapus.</p>
    <a href="<?= site_url('admin/categories/create') ?>" class="btn btn-primary"><?= icon('plus', 17) ?> Tambah Kategori</a>
</div>

<section class="card">
    <?php if (empty($categories)): ?>
        <div class="empty">
            <div class="ico"><?= icon('tag', 28) ?></div>
            <strong>Belum ada kategori</strong>
            <span>Buat kategori pertama sebelum menambahkan produk.</span>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th><th>Kategori</th><th>Deskripsi</th>
                        <th>Produk</th><th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $i => $category): ?>
                    <?php $count = (int) $category['product_count']; ?>
                    <tr>
                        <td class="muted"><?= $i + 1 ?></td>
                        <td>
                            <div class="prod-cell">
                                <span class="stat-ico tone-green cat-ico"><?= icon('tag', 18) ?></span>
                                <div>
                                    <strong><?= esc($category['name']) ?></strong>
                                    <small><?= esc($category['slug']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="muted"><?= esc(mb_strimwidth((string) ($category['description'] ?? ''), 0, 90, '...')) ?: '-' ?></td>
                        <td>
                            <?php if ($count > 0): ?>
                                <a href="<?= site_url('admin/products?category=' . $category['id_category']) ?>" class="badge badge-green"><?= $count ?> produk</a>
                            <?php else: ?>
                                <span class="badge">Kosong</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="<?= site_url('admin/categories/edit/' . $category['id_category']) ?>" class="btn btn-ghost btn-sm"><?= icon('pencil', 15) ?> Edit</a>
                                <?php if ($count > 0): ?>
                                    <button type="button" class="btn btn-danger-ghost btn-sm" disabled
                                            title="Masih memiliki <?= $count ?> produk"><?= icon('trash', 15) ?> Hapus</button>
                                <?php else: ?>
                                    <form method="post" action="<?= site_url('admin/categories/delete/' . $category['id_category']) ?>" class="inline-form"
                                          data-confirm="<?= esc('Hapus kategori "' . $category['name'] . '"?') ?>">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger-ghost btn-sm" aria-label="Hapus <?= esc($category['name']) ?>"><?= icon('trash', 15) ?> Hapus</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="table-foot">
            <span class="muted small"><?= count($categories) ?> kategori</span>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/product.js') ?>"></script>
<?= $this->endSection() ?>
