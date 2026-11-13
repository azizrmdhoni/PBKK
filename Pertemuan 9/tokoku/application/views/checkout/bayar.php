<div class="steps">
  <div class="step done"><span class="n"><i class="bi bi-check"></i></span> Keranjang</div><span class="step-sep"></span>
  <div class="step done"><span class="n"><i class="bi bi-check"></i></span> Pengiriman</div><span class="step-sep"></span>
  <div class="step on"><span class="n">3</span> Pembayaran</div>
</div>
<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
  <div><h4 class="mb-0" style="font-weight:800">Pesanan <?= $p['kode']; ?></h4><small class="text-muted"><?= $p['tanggal']; ?></small></div>
  <?= badge_status($p['status']); ?>
</div>
<div class="row">
  <div class="col-lg-7 mb-4">
    <div class="card-lite mb-4">
      <div class="card-head">Rincian Pesanan</div>
      <div class="card-pad">
        <?php foreach ($items as $i): ?>
          <div class="d-flex justify-content-between py-2 border-bottom"><span><?= html_escape($i['nama']); ?> <span class="text-muted">× <?= $i['qty']; ?></span></span><b><?= rupiah($i['harga'] * $i['qty']); ?></b></div>
        <?php endforeach; ?>
        <div class="sum-row total"><span>Total pembayaran</span><span><?= rupiah($p['total']); ?></span></div>
      </div>
    </div>
    <div class="card-lite">
      <div class="card-head">Dikirim ke</div>
      <div class="card-pad"><b><?= html_escape($p['nama_penerima']); ?></b> &middot; <?= html_escape($p['telepon']); ?><br><span class="text-muted"><?= nl2br(html_escape($p['alamat'])); ?></span></div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="bank-card mb-4">
      <small>Transfer ke rekening</small>
      <div class="no">1234 5678 90</div>
      <div>Bank BCA &middot; a.n. TokoKu Indonesia</div>
      <hr style="border-color:rgba(255,255,255,.15)">
      <small>Jumlah yang harus dibayar</small><div style="font-size:1.4rem;font-weight:800;color:#fdba74"><?= rupiah($p['total']); ?></div>
    </div>
    <div class="card-lite card-pad">
      <h6 class="mb-3">Bukti Pembayaran</h6>
      <?php if ($err): ?><div class="alert alert-danger py-2"><?= html_escape($err); ?></div><?php endif; ?>
      <?php if ($p['bukti']): ?>
        <div class="alert alert-success py-2"><i class="bi bi-check-circle mr-1"></i> Bukti sudah terkirim. <a target="_blank" href="<?= base_url('uploads/bukti/' . $p['bukti']); ?>">Lihat file</a></div>
      <?php endif; ?>
      <?php if (in_array($p['status'], ['menunggu pembayaran', 'menunggu verifikasi'])): ?>
        <?= form_open_multipart('checkout/bayar/' . $p['kode']); ?>
          <div class="form-group"><label>Unggah bukti transfer (jpg, png, pdf — maks 2MB)</label>
            <input type="file" name="bukti" class="form-control-file" required></div>
          <button class="btn btn-primary btn-block"><i class="bi bi-cloud-upload mr-1"></i> Kirim Bukti</button>
        <?= form_close(); ?>
      <?php else: ?><p class="text-muted mb-0">Pesanan Anda sedang diproses.</p><?php endif; ?>
    </div>
  </div>
</div>
