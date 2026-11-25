<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<div class="page-head">
    <p>Ubah nama atau deskripsi kategori <strong><?= esc($category['name']) ?></strong>.</p>
    <a href="<?= site_url('admin/categories') ?>" class="btn btn-ghost"><?= icon('arrow-left', 16) ?> Kembali</a>
</div>

<?= $this->include('admin/categories/_form') ?>
<?= $this->endSection() ?>
