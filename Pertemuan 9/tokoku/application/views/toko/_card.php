<div class="col-6 col-md-4 col-lg-3 mb-4">
  <div class="pcard">
    <a class="img" href="<?= site_url('toko/detail/' . $p['id']); ?>">
      <img src="<?= gambar_produk($p); ?>" alt="<?= html_escape($p['nama']); ?>" loading="lazy">
      <?php if ($p['stok'] <= 0): ?><span class="tag out">Habis</span>
      <?php elseif ($p['stok'] <= 10): ?><span class="tag low">Sisa <?= $p['stok']; ?></span><?php endif; ?>
    </a>
    <div class="body">
      <div class="cat"><?= html_escape(isset($p['kategori']) ? $p['kategori'] : ''); ?></div>
      <a class="name" href="<?= site_url('toko/detail/' . $p['id']); ?>"><?= html_escape($p['nama']); ?></a>
      <div class="price"><?= rupiah($p['harga']); ?></div>
    </div>
    <div class="foot">
      <?= form_open('belanja/tambah/' . $p['id']); ?>
        <input type="hidden" name="qty" value="1">
        <button class="btn btn-primary btn-block btn-sm py-2" <?= $p['stok'] <= 0 ? 'disabled' : ''; ?>><i class="bi bi-cart-plus mr-1"></i> Tambah</button>
      <?= form_close(); ?>
    </div>
  </div>
</div>
