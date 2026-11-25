<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<div class="page-head">
    <p>Lengkapi data produk. Gambar boleh ditambahkan sekarang atau nanti.</p>
    <a href="<?= site_url('admin/products') ?>" class="btn btn-ghost"><?= icon('arrow-left', 16) ?> Kembali</a>
</div>

<?= $this->include('admin/products/_form') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/product.js') ?>"></script>
<?= $this->endSection() ?>
