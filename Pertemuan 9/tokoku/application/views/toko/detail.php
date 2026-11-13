<div class="crumbs"><a href="<?= site_url(); ?>">Beranda</a> / <a href="<?= site_url('toko?kategori=' . $p['kategori_id']); ?>"><?= html_escape($p['kategori']); ?></a> / <?= html_escape($p['nama']); ?></div>
<div class="card-lite card-pad">
  <div class="row">
    <div class="col-md-5 mb-4"><div class="detail-img"><img src="<?= gambar_produk($p); ?>" alt="<?= html_escape($p['nama']); ?>"></div></div>
    <div class="col-md-7">
      <span class="badge-soft bs-primary"><?= html_escape($p['kategori']); ?></span>
      <h2 class="mt-2 mb-1" style="font-weight:800"><?= html_escape($p['nama']); ?></h2>
      <div class="price" style="font-size:1.9rem"><?= rupiah($p['harga']); ?></div>
      <div class="my-3">
        <?php if ($p['stok'] > 10): ?><span class="badge-soft bs-success"><i class="bi bi-check-circle"></i> Stok tersedia (<?= $p['stok']; ?>)</span>
        <?php elseif ($p['stok'] > 0): ?><span class="badge-soft bs-warning"><i class="bi bi-exclamation-triangle"></i> Stok terbatas, sisa <?= $p['stok']; ?></span>
        <?php else: ?><span class="badge-soft bs-danger">Stok habis</span><?php endif; ?>
      </div>
      <p class="text-muted" style="line-height:1.7"><?= nl2br(html_escape($p['deskripsi'])); ?></p>
      <?php if ($p['stok'] > 0): ?>
        <?= form_open('belanja/tambah/' . $p['id'], ['class' => 'd-flex flex-wrap align-items-center', 'style' => 'gap:.8rem']); ?>
          <div class="qty-stepper">
            <button type="button" data-step="-1">−</button>
            <input type="number" name="qty" value="1" min="1" max="<?= $p['stok']; ?>">
            <button type="button" data-step="1">+</button>
          </div>
          <button class="btn btn-primary px-4" style="height:46px"><i class="bi bi-cart-plus mr-1"></i> Masukkan Keranjang</button>
        <?= form_close(); ?>
      <?php endif; ?>
      <hr class="my-4">
      <div class="row text-muted small">
        <div class="col-6 mb-2"><i class="bi bi-truck text-warning mr-1"></i> Pengiriman cepat</div>
        <div class="col-6 mb-2"><i class="bi bi-shield-check text-warning mr-1"></i> Pembayaran aman</div>
        <div class="col-6"><i class="bi bi-arrow-repeat text-warning mr-1"></i> Garansi 7 hari</div>
        <div class="col-6"><i class="bi bi-patch-check text-warning mr-1"></i> Produk original</div>
      </div>
    </div>
  </div>
</div>
<?php if ($mirip): ?>
<div class="sec-title mt-5"><h5>Produk Serupa</h5></div>
<div class="row"><?php foreach ($mirip as $m) $this->load->view('toko/_card', ['p' => $m]); ?></div>
<?php endif; ?>
