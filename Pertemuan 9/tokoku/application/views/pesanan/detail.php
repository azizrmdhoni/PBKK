<div class="page-head"><div><h4>Pesanan <?= $p['kode']; ?></h4><div class="crumb"><a href="<?= site_url('pesanan'); ?>">Pesanan</a> / <?= $p['kode']; ?> &middot; <?= $p['tanggal']; ?></div></div><?= badge_status($p['status']); ?></div>
<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card-lite mb-4">
      <div class="card-head">Item Pesanan</div>
      <div class="table-responsive"><table class="table-modern table">
        <thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th class="text-right">Subtotal</th></tr></thead>
        <tbody><?php foreach ($items as $i): ?>
          <tr><td><b><?= html_escape($i['nama']); ?></b></td><td><?= rupiah($i['harga']); ?></td><td><?= $i['qty']; ?></td><td class="text-right"><?= rupiah($i['harga'] * $i['qty']); ?></td></tr>
        <?php endforeach; ?>
          <tr><td colspan="3" class="text-right font-weight-bold">Total</td><td class="text-right font-weight-bold" style="color:var(--primary-600)"><?= rupiah($p['total']); ?></td></tr>
        </tbody></table></div>
    </div>
    <div class="card-lite">
      <div class="card-head">Pengiriman</div>
      <div class="card-pad"><b><?= html_escape($p['nama_penerima']); ?></b> &middot; <?= html_escape($p['telepon']); ?><br><span class="text-muted"><?= nl2br(html_escape($p['alamat'])); ?></span></div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card-lite card-pad mb-4">
      <h6>Ubah Status</h6>
      <?= form_open('pesanan/status/' . $p['id']); ?>
        <select name="status" class="custom-select mb-3">
          <?php foreach ($status as $s): ?><option <?= $p['status'] == $s ? 'selected' : ''; ?>><?= $s; ?></option><?php endforeach; ?>
        </select>
        <button class="btn btn-primary btn-block">Simpan Status</button>
      <?= form_close(); ?>
    </div>
    <div class="card-lite card-pad">
      <h6>Bukti Pembayaran</h6>
      <?php if ($p['bukti']): ?>
        <a target="_blank" href="<?= base_url('uploads/bukti/' . $p['bukti']); ?>" class="btn btn-outline-primary btn-block"><i class="bi bi-file-earmark-image mr-1"></i> Lihat Bukti</a>
      <?php else: ?><p class="text-muted mb-0">Belum ada bukti pembayaran.</p><?php endif; ?>
    </div>
  </div>
</div>
