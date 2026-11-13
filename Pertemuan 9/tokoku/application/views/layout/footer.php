</main>
<footer class="store-footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-3">
        <h6 class="d-flex align-items-center" style="gap:.5rem"><i class="bi bi-bag-heart-fill" style="color:#f97316"></i> TokoKu</h6>
        <p class="mb-0">Belanja online mudah, aman, dan terpercaya. Produk pilihan untuk gaya hidup digital Anda.</p>
      </div>
      <div class="col-6 col-md-2 offset-md-2 mb-3"><h6>Belanja</h6>
        <a href="<?= site_url('toko'); ?>">Semua Produk</a><a href="<?= site_url('toko?kategori=1'); ?>">Elektronik</a><a href="<?= site_url('toko?kategori=2'); ?>">Fashion</a></div>
      <div class="col-6 col-md-2 mb-3"><h6>Akun</h6>
        <a href="<?= site_url('checkout/riwayat'); ?>">Pesanan Saya</a><a href="<?= site_url('belanja'); ?>">Keranjang</a><a href="<?= site_url('auth/logout'); ?>">Keluar</a></div>
      <div class="col-md-2 mb-3"><h6>Bantuan</h6><a href="#">Cara Pembayaran</a><a href="#">Pengiriman</a><a href="#">Hubungi Kami</a></div>
    </div>
    <div class="copy">&copy; <?= date('Y'); ?> TokoKu. Dibuat untuk latihan CodeIgniter 3.</div>
  </div>
</footer>
<?php $this->load->view('layout/scripts'); ?>
</body>
</html>
