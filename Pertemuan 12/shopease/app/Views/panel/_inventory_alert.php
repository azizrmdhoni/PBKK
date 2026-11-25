<?php
/**
 * Kartu peringatan stok untuk dashboard admin dan operator.
 *
 * @var array $lowStock
 * @var array $outStock
 * @var int   $lowThreshold
 */
$groups = [
    ['Stok habis',   $outStock, 'badge-danger', 'Habis'],
    ['Stok menipis', $lowStock, 'badge-gold',   null],
];
?>
<section class="card">
    <div class="card-head">
        <h2>Peringatan stok</h2>
        <a href="<?= site_url('admin/products?stock=low') ?>" class="small">Lihat semua</a>
    </div>

    <?php if (empty($lowStock) && empty($outStock)): ?>
        <div class="empty">
            <div class="ico"><?= icon('check-circle', 28) ?></div>
            <strong>Stok aman</strong>
            <span>Tidak ada produk yang stoknya menipis atau habis.</span>
        </div>
    <?php else: ?>
        <?php foreach ($groups as [$title, $rows, $badge, $fixedLabel]): ?>
            <?php if (! empty($rows)): ?>
                <p class="list-title"><?= esc($title) ?></p>
                <ul class="list">
                    <?php foreach ($rows as $row): ?>
                        <li>
                            <div class="grow">
                                <a href="<?= site_url('admin/products/edit/' . $row['id_product']) ?>"><strong><?= esc($row['name']) ?></strong></a>
                            </div>
                            <span class="badge <?= esc($badge) ?>"><?= $fixedLabel ?? ((int) $row['stock'] . ' unit') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="card-foot"><?= icon('info', 14) ?> Menipis berarti sisa 1&ndash;<?= (int) $lowThreshold ?> unit.</div>
    <?php endif; ?>
</section>
