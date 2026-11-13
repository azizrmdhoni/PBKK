<footer class="se-footer">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4">
                <a class="se-brand text-white mb-3 d-inline-flex" href="<?= base_url('/') ?>">
                    <span class="se-brand-mark"><i class="bi bi-bag-heart-fill"></i></span>
                    Shop<span>Ease</span>
                </a>
                <p class="footer-text">Platform toko online berbasis CodeIgniter 4 untuk mengelola katalog, pesanan, pembayaran, dan pengiriman dalam satu tempat.</p>
            </div>
            <div class="col-6 col-lg-2 offset-lg-1">
                <h6>Belanja</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#kategori">Kategori</a></li>
                    <li><a href="#produk">Produk Unggulan</a></li>
                    <li><a href="#cara-kerja">Cara Belanja</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6>Akun</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= base_url('login') ?>">Masuk</a></li>
                    <li><a href="<?= base_url('register') ?>">Daftar</a></li>
                    <li><a href="#faq">Bantuan</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6>Teknologi</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="tech-chip">CodeIgniter 4</span>
                    <span class="tech-chip">PHP</span>
                    <span class="tech-chip">MySQL</span>
                    <span class="tech-chip">Bootstrap 5</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
            <span>&copy; <?= date('Y') ?> ShopEase. Proyek pembelajaran Web Framework.</span>
            <span>Data produk pada halaman ini adalah data contoh.</span>
        </div>
    </div>
</footer>

<button class="back-to-top" id="backToTop" type="button" aria-label="Kembali ke atas">
    <i class="bi bi-arrow-up"></i>
</button>
