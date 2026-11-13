<div class="steps">
  <div class="step on"><span class="n">1</span> Keranjang</div><span class="step-sep"></span>
  <div class="step"><span class="n">2</span> Pengiriman</div><span class="step-sep"></span>
  <div class="step"><span class="n">3</span> Pembayaran</div>
</div>
<h4 class="mb-3" style="font-weight:800">Keranjang Belanja</h4>
<?php if (!$items): ?>
  <div class="card-lite empty py-5"><i class="bi bi-cart-x"></i><h5>Keranjang masih kosong</h5>
    <p>Yuk temukan produk favoritmu.</p><a href="<?= site_url('toko'); ?>" class="btn btn-primary">Mulai Belanja</a></div>
<?php else: ?>
<div class="row">
  <div class="col-lg-8 mb-4">
    <?= form_open('belanja/ubah'); ?>
    <div class="card-lite">
      <div class="table-responsive">
      <table class="table-modern table">
        <thead><tr><th>Produk</th><th>Harga</th><th width="120">Jumlah</th><th>Subtotal</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $i): ?>
          <tr>
            <td><div class="d-flex align-items-center" style="gap:.8rem"><img class="thumb" src="<?= gambar_produk($i); ?>" alt="">
              <a class="font-weight-bold" style="color:var(--text)" href="<?= site_url('toko/detail/' . $i['id']); ?>"><?= html_escape($i['nama']); ?></a></div></td>
            <td><?= rupiah($i['harga']); ?></td>
            <td><input type="number" name="qty[<?= $i['id']; ?>]" value="<?= $i['qty']; ?>" min="0" max="<?= $i['stok']; ?>" class="form-control form-control-sm" style="width:80px"></td>
            <td class="font-weight-bold"><?= rupiah($i['subtotal']); ?></td>
            <td><a href="<?= site_url('belanja/hapus/' . $i['id']); ?>" class="text-danger" title="Hapus"><i class="bi bi-trash3"></i></a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
      <div class="card-pad d-flex justify-content-between">
        <a href="<?= site_url('toko'); ?>" class="btn btn-light-soft btn-sm"><i class="bi bi-arrow-left"></i> Lanjut belanja</a>
        <button class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-clockwise"></i> Perbarui keranjang</button>
      </div>
    </div>
    <?= form_close(); ?>
  </div>
  <div class="col-lg-4">
    <div class="card-lite card-pad">
      <h6 class="mb-3">Ringkasan Belanja</h6>
      <div class="sum-row"><span>Subtotal (<?= $this->keranjang->jumlah(); ?> barang)</span><span><?= rupiah($total); ?></span></div>
      <div class="sum-row"><span>Ongkos kirim</span><span class="text-success">Gratis</span></div>
      <div class="sum-row total"><span>Total</span><span><?= rupiah($total); ?></span></div>
      <a href="<?= site_url('checkout'); ?>" class="btn btn-primary btn-block py-2 mt-3">Lanjut ke Pengiriman <i class="bi bi-arrow-right ml-1"></i></a>
    </div>
  </div>
</div>
<?php endif; ?>
