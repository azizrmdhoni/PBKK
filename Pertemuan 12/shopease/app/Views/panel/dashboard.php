<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<section class="se-card">
    <h1 class="se-title"><?= esc($headline ?? 'Dashboard') ?></h1>
    <p class="se-sub"><?= esc($note ?? '') ?></p>
    <dl class="se-meta">
        <div><dt>Nama</dt><dd><?= esc(session()->get('name')) ?></dd></div>
        <div><dt>Email</dt><dd><?= esc(session()->get('email')) ?></dd></div>
        <div><dt>Role</dt><dd><?= esc(session()->get('role')) ?></dd></div>
    </dl>
</section>
<?= $this->endSection() ?>
