<h4 class="mb-3" style="font-weight:800">Pesanan Saya</h4>
<div class="card-lite">
  <div class="table-responsive">
  <table class="table-modern table">
    <thead><tr><th>Kode</th><th>Tanggal</th><th>Total</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($pesanan as $p): ?>
      <tr><td class="font-weight-bold"><?= $p['kode']; ?></td><td><?= $p['tanggal']; ?></td><td><?= rupiah($p['total']); ?></td><td><?= badge_status($p['status']); ?></td>
        <td class="text-right"><a class="btn btn-outline-primary btn-sm" href="<?= site_url('checkout/bayar/' . $p['kode']); ?>">Detail</a></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php if (!$pesanan): ?><div class="empty"><i class="bi bi-receipt"></i>Belum ada pesanan.<br><a href="<?= site_url('toko'); ?>">Mulai belanja</a></div><?php endif; ?>
</div>
