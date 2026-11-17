<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <a class="brand brand-light" href="<?= base_url('/') ?>">
                    <span class="brand-mark"><?= icon('bag', 20) ?></span><span>Shop<em>Ease</em></span>
                </a>
                <p style="max-width: 38ch; margin-top: 1rem">Toko online dengan katalog terpusat, pembayaran manual yang diverifikasi, dan status pesanan yang dapat dipantau.</p>
            </div>
            <div>
                <h3>Belanja</h3>
                <ul>
                    <li><a href="<?= base_url('katalog') ?>">Katalog</a></li>
                    <li><a href="<?= base_url('/#kategori') ?>">Kategori</a></li>
                    <li><a href="<?= base_url('/#produk') ?>">Produk Unggulan</a></li>
                </ul>
            </div>
            <div>
                <h3>Akun</h3>
                <ul>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <li><a href="<?= base_url('pesanan') ?>">Riwayat Pesanan</a></li>
                        <li><a href="<?= base_url('keranjang') ?>">Keranjang</a></li>
                    <?php else: ?>
                        <li><a href="<?= base_url('login') ?>">Masuk</a></li>
                        <li><a href="<?= base_url('register') ?>">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div>
                <h3>Informasi</h3>
                <ul>
                    <li>Pembayaran manual</li>
                    <li>Pelacakan pesanan</li>
                    <li>Mata uang Rupiah (IDR)</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; <?= date('Y') ?> ShopEase. Proyek pembelajaran Web Framework.</span>
            <span>Data produk pada halaman ini adalah data contoh.</span>
        </div>
    </div>
</footer>
