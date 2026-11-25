<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<div class="page-head">
    <p>Ubah data <strong><?= esc($product['name']) ?></strong>, kelola galeri, atau tambahkan gambar baru.</p>
    <a href="<?= site_url('admin/products') ?>" class="btn btn-ghost"><?= icon('arrow-left', 16) ?> Kembali</a>
</div>

<?= $this->include('admin/products/_form') ?>

<section class="card gallery-card">
    <div class="card-head">
        <h2>Galeri gambar</h2>
        <span class="muted small"><?= count($images) ?> dari <?= (int) $maxImages ?> gambar</span>
    </div>

    <?php if (empty($images)): ?>
        <div class="empty">
            <div class="ico"><?= icon('image', 28) ?></div>
            <strong>Belum ada gambar</strong>
            <span>Unggah gambar lewat form di atas, lalu klik Update Produk.</span>
        </div>
    <?php else: ?>
        <div class="card-body">
            <div class="gallery">
                <?php foreach ($images as $image): ?>
                    <?php $isPrimary = (int) $image['is_primary'] === 1; ?>
                    <figure class="gal-item<?= $isPrimary ? ' primary' : '' ?>">
                        <?php if ($isPrimary): ?>
                            <span class="badge badge-terra gal-flag"><?= icon('star', 12) ?> Utama</span>
                        <?php endif; ?>
                        <img src="<?= esc(product_image_url($image['image'])) ?>" alt="Gambar <?= esc($product['name']) ?>" loading="lazy">
                        <figcaption class="gal-bar">
                            <?php if (! $isPrimary): ?>
                                <form method="post" action="<?= site_url('admin/products/image/primary/' . $image['id_image']) ?>" class="inline-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-ghost btn-sm"><?= icon('star', 14) ?> Jadikan utama</button>
                                </form>
                            <?php endif; ?>
                            <form method="post" action="<?= site_url('admin/products/image/delete/' . $image['id_image']) ?>" class="inline-form"
                                  data-confirm="Hapus gambar ini? File akan dihapus permanen.">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger-ghost btn-sm" aria-label="Hapus gambar"><?= icon('trash', 14) ?> Hapus</button>
                            </form>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/product.js') ?>"></script>
<?= $this->endSection() ?>
