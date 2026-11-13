<?php $filter = $cari || $kat; ?>
<?php if (!$filter): ?>
<section class="hero">
  <div class="art"><img src="<?= base_url('assets/img/kategori/1.svg'); ?>" alt=""><img src="<?= base_url('assets/img/kategori/2.svg'); ?>" alt=""></div>
  <span class="badge-soft bs-primary mb-3"><i class="bi bi-stars"></i> Koleksi Terbaru</span>
  <h1>Temukan produk <em>favoritmu</em><br>dengan harga terbaik.</h1>
  <p>Elektronik, fashion, makanan, dan buku pilihan. Belanja aman, pengiriman cepat, garansi 7 hari.</p>
  <a href="#produk" class="btn btn-primary mt-2 px-4">Mulai Belanja <i class="bi bi-arrow-right ml-1"></i></a>
</section>
<div class="perks">
  <div class="perk"><i class="bi bi-truck"></i><div><b>Pengiriman Cepat</b><small>Ke seluruh Indonesia</small></div></div>
  <div class="perk"><i class="bi bi-shield-check"></i><div><b>Pembayaran Aman</b><small>Transfer terverifikasi</small></div></div>
  <div class="perk"><i class="bi bi-arrow-repeat"></i><div><b>Garansi 7 Hari</b><small>Pengembalian mudah</small></div></div>
</div>
<?php endif; ?>

<div id="produk" class="chips">
  <a class="chip <?= !$kat ? 'on' : ''; ?>" href="<?= site_url('toko'); ?>">Semua</a>
  <?php foreach ($kategori as $k): ?>
    <a class="chip <?= $kat == $k['id'] ? 'on' : ''; ?>" href="<?= site_url('toko?kategori=' . $k['id']); ?>"><?= html_escape($k['nama']); ?></a>
  <?php endforeach; ?>
</div>

<div class="sec-title">
  <h5><?= $cari ? 'Hasil untuk “' . html_escape($cari) . '”' : 'Semua Produk'; ?> <small class="text-muted font-weight-normal">(<?= count($produk); ?> produk)</small></h5>
  <form method="get" action="<?= site_url('toko'); ?>" class="form-inline">
    <input type="hidden" name="kategori" value="<?= html_escape($kat); ?>"><input type="hidden" name="cari" value="<?= html_escape($cari); ?>">
    <select name="urut" class="custom-select custom-select-sm" onchange="this.form.submit()" style="border-radius:10px">
      <option value="">Terbaru</option>
      <option value="murah" <?= $urut == 'murah' ? 'selected' : ''; ?>>Harga terendah</option>
      <option value="mahal" <?= $urut == 'mahal' ? 'selected' : ''; ?>>Harga tertinggi</option>
      <option value="nama" <?= $urut == 'nama' ? 'selected' : ''; ?>>Nama A–Z</option>
    </select>
  </form>
</div>

<div class="row">
  <?php foreach ($produk as $p) $this->load->view('toko/_card', ['p' => $p]); ?>
  <?php if (!$produk): ?>
    <div class="col-12"><div class="card-lite empty"><i class="bi bi-search"></i>Produk tidak ditemukan.<br><a href="<?= site_url('toko'); ?>">Lihat semua produk</a></div></div>
  <?php endif; ?>
</div>
