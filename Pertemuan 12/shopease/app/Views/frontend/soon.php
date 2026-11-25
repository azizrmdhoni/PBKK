<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="soon-wrap">
    <div class="container">
        <nav class="crumb" aria-label="Breadcrumb">
            <a href="<?= base_url('/') ?>">Beranda</a><?= icon('chevron-right', 13) ?><span><?= esc($module['title']) ?></span>
        </nav>

        <div class="soon">
            <span class="ico-lg"><?= icon($module['icon'], 30) ?></span>
            <span class="badge badge-terra"><?= icon('wrench', 13) ?> Dalam pengembangan: <?= esc($module['milestone']) ?></span>
            <h1><?= esc($module['title']) ?></h1>
            <p class="muted"><?= esc($module['summary']) ?></p>

            <h2 class="sub">Isi halaman ini nanti</h2>
            <ul class="soon-list">
                <?php foreach ($module['items'] as $item): ?>
                    <li><?= icon('check-circle', 18) ?> <?= esc($item) ?></li>
                <?php endforeach; ?>
            </ul>

            <div class="soon-foot">
                <span><?= icon('lock', 16) ?> Akses: <?= esc($module['access']) ?></span>
                <a href="<?= base_url('/') ?>" class="btn btn-primary">Kembali ke beranda</a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
