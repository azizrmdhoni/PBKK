<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<div class="soon">
    <span class="ico-lg"><?= icon($module['icon'], 30) ?></span>
    <span class="badge badge-terra"><?= icon('wrench', 13) ?> Dalam pengembangan: <?= esc($module['milestone']) ?></span>
    <h2 class="title"><?= esc($module['title']) ?></h2>
    <p class="muted"><?= esc($module['summary']) ?></p>

    <h3 class="sub">Isi halaman ini nanti</h3>
    <ul class="soon-list">
        <?php foreach ($module['items'] as $item): ?>
            <li><?= icon('check-circle', 18) ?> <?= esc($item) ?></li>
        <?php endforeach; ?>
    </ul>

    <div class="soon-foot">
        <span><?= icon('lock', 16) ?> Akses: <?= esc($module['access']) ?></span>
        <a href="<?= base_url(session()->get('role') === 'admin' ? 'admin' : 'operator') ?>" class="btn btn-primary">Kembali ke dashboard</a>
    </div>
</div>
<?= $this->endSection() ?>
