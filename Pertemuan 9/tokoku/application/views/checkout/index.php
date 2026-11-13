<div class="steps">
  <div class="step done"><span class="n"><i class="bi bi-check"></i></span> Keranjang</div><span class="step-sep"></span>
  <div class="step on"><span class="n">2</span> Pengiriman</div><span class="step-sep"></span>
  <div class="step"><span class="n">3</span> Pembayaran</div>
</div>
<div class="row">
  <div class="col-lg-7 mb-4">
    <div class="card-lite card-pad">
      <h5 class="mb-3" style="font-weight:800">Data Pengiriman</h5>
      <?= form_open('checkout'); ?>
        <div class="form-group"><label>Nama penerima</label>
          <input name="nama_penerima" class="form-control" value="<?= set_value('nama_penerima', $this->session->userdata('nama')); ?>">
          <?= form_error('nama_penerima', '<span class="invalid-msg">', '</span>'); ?></div>
        <div class="form-group"><label>Nomor telepon</label>
          <input name="telepon" class="form-control" placeholder="08xxxxxxxxxx" value="<?= set_value('telepon'); ?>">
          <?= form_error('telepon', '<span class="invalid-msg">', '</span>'); ?></div>
        <div class="form-group"><label>Alamat lengkap</label>
          <textarea name="alamat" rows="3" class="form-control" placeholder="Jalan, nomor, kecamatan, kota, kode pos"><?= set_value('alamat'); ?></textarea>
          <?= form_error('alamat', '<span class="invalid-msg">', '</span>'); ?></div>
        <button class="btn btn-primary px-4">Buat Pesanan <i class="bi bi-arrow-right ml-1"></i></button>
        <a href="<?= site_url('belanja'); ?>" class="btn btn-light-soft ml-2">Kembali</a>
      <?= form_close(); ?>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card-lite card-pad">
      <h6 class="mb-3">Pesanan Anda</h6>
      <?php foreach ($items as $i): ?>
        <div class="d-flex align-items-center mb-3" style="gap:.8rem">
          <img class="thumb" src="<?= gambar_produk($i); ?>" alt="">
          <div class="flex-fill"><div class="font-weight-bold" style="line-height:1.25"><?= html_escape($i['nama']); ?></div><small class="text-muted"><?= $i['qty']; ?> × <?= rupiah($i['harga']); ?></small></div>
          <b><?= rupiah($i['subtotal']); ?></b>
        </div>
      <?php endforeach; ?>
      <div class="sum-row"><span>Ongkos kirim</span><span class="text-success">Gratis</span></div>
      <div class="sum-row total"><span>Total</span><span><?= rupiah($total); ?></span></div>
    </div>
  </div>
</div>
