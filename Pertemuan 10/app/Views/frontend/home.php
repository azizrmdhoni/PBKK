<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- ========== HERO ========== -->
<section class="hero" id="beranda">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="eyebrow"><i class="bi bi-lightning-charge-fill"></i> Belanja online lebih mudah</span>
                <h1 class="hero-title">Belanja cerdas, <span class="text-gradient">pesanan terlacak</span>, tanpa ribet.</h1>
                <p class="hero-lead">ShopEase menyatukan katalog, keranjang, pembayaran, dan pengiriman dalam satu alur yang rapi, transparan, dan aman untuk setiap pelanggan.</p>

                <form class="hero-search" action="<?= base_url('katalog') ?>" method="get" role="search">
                    <i class="bi bi-search"></i>
                    <label for="heroQ" class="visually-hidden">Cari produk</label>
                    <input id="heroQ" type="search" name="q" placeholder="Cari produk, misalnya &quot;headphone&quot;" autocomplete="off">
                    <button type="submit" class="btn btn-brand">Cari</button>
                </form>

                <div class="d-flex flex-wrap gap-2 mt-3 quick-tags">
                    <span class="text-muted small me-1">Populer:</span>
                    <a href="<?= base_url('katalog?q=headphone') ?>">Headphone</a>
                    <a href="<?= base_url('katalog?q=jaket') ?>">Jaket</a>
                    <a href="<?= base_url('katalog?q=serum') ?>">Serum</a>
                </div>

                <ul class="trust-row list-unstyled">
                    <li><i class="bi bi-shield-check"></i> Transaksi aman</li>
                    <li><i class="bi bi-receipt"></i> Harga tersimpan akurat</li>
                    <li><i class="bi bi-geo-alt"></i> Resi dapat dilacak</li>
                </ul>
            </div>

            <div class="col-lg-6">
                <div class="hero-visual">
                    <div class="order-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <div class="small text-muted">Nomor Pesanan</div>
                                <div class="fw-bold">SE-20261112-0042</div>
                            </div>
                            <span class="status-pill status-ok"><i class="bi bi-check-circle-fill"></i> Pembayaran Terverifikasi</span>
                        </div>
                        <ol class="timeline list-unstyled mb-3">
                            <li class="done"><span class="dot"></span><div><strong>Pesanan dibuat</strong><small>Menunggu pembayaran</small></div></li>
                            <li class="done"><span class="dot"></span><div><strong>Pembayaran diverifikasi</strong><small>Oleh administrator</small></div></li>
                            <li class="active"><span class="dot"></span><div><strong>Sedang diproses</strong><small>Operator menyiapkan barang</small></div></li>
                            <li><span class="dot"></span><div><strong>Dikirim</strong><small>Nomor resi akan muncul</small></div></li>
                        </ol>
                        <div class="order-total">
                            <span>Total Pembayaran</span>
                            <strong>Rp 749.000</strong>
                        </div>
                    </div>

                    <div class="float-chip chip-1"><i class="bi bi-box-seam"></i><div><strong>Stok tervalidasi</strong><small>Cegah overselling</small></div></div>
                    <div class="float-chip chip-2"><i class="bi bi-lock-fill"></i><div><strong>CSRF aktif</strong><small>Form terlindungi</small></div></div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-strip">
            <?php foreach ($stats as $s): ?>
                <div class="stat">
                    <div class="stat-value" data-count="<?= esc($s['value']) ?>"><?= esc($s['value']) ?></div>
                    <div class="stat-label"><?= esc($s['label']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== KATEGORI ========== -->
<section class="section" id="kategori">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow-sm">Kategori</span>
            <h2>Temukan apa yang Anda butuhkan</h2>
            <p>Jelajahi produk berdasarkan kategori favorit Anda.</p>
        </div>
        <div class="row g-3 g-lg-4">
            <?php foreach ($categories as $c): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a class="cat-card" href="<?= base_url('katalog?kategori=' . $c['slug']) ?>">
                        <span class="cat-icon"><i class="bi <?= esc($c['icon']) ?>"></i></span>
                        <span class="cat-name"><?= esc($c['name']) ?></span>
                        <span class="cat-count"><?= esc($c['count']) ?> produk</span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== PRODUK UNGGULAN ========== -->
<section class="section section-alt" id="produk">
    <div class="container">
        <div class="section-head d-flex flex-wrap justify-content-between align-items-end gap-3">
            <div>
                <span class="eyebrow-sm">Produk Unggulan</span>
                <h2 class="mb-1">Pilihan terbaik minggu ini</h2>
                <p class="mb-0">Contoh tampilan kartu produk pada katalog ShopEase.</p>
            </div>
            <a href="<?= base_url('katalog') ?>" class="btn btn-outline-brand">Lihat Semua <i class="bi bi-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-3 g-lg-4">
            <?php foreach ($featured as $p): ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card">
                        <div class="product-media tone-<?= esc($p['tone']) ?>">
                            <?php if ($p['badge']): ?><span class="product-badge"><?= esc($p['badge']) ?></span><?php endif; ?>
                            <i class="bi <?= esc($p['icon']) ?>"></i>
                        </div>
                        <div class="product-body">
                            <div class="product-cat"><?= esc($p['category']) ?></div>
                            <h3 class="product-name"><a href="<?= base_url('produk/' . $p['slug']) ?>"><?= esc($p['name']) ?></a></h3>
                            <div class="product-price">
                                <strong>Rp <?= number_format($p['price'], 0, ',', '.') ?></strong>
                                <?php if ($p['old']): ?><s>Rp <?= number_format($p['old'], 0, ',', '.') ?></s><?php endif; ?>
                            </div>
                            <div class="product-foot">
                                <span class="stock <?= $p['stock'] <= 10 ? 'low' : '' ?>"><i class="bi bi-box2"></i> Stok <?= esc($p['stock']) ?></span>
                                <a href="<?= base_url('produk/' . $p['slug']) ?>" class="btn btn-sm btn-brand">Detail</a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== FITUR ========== -->
<section class="section" id="fitur">
    <div class="container">
        <div class="section-head text-center mx-auto">
            <span class="eyebrow-sm">Fitur</span>
            <h2>Semua yang dibutuhkan toko online modern</h2>
            <p>Dirancang berdasarkan kebutuhan nyata pelanggan, administrator, dan operator.</p>
        </div>
        <div class="row g-3 g-lg-4">
            <?php foreach ($features as $f): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <span class="feature-icon"><i class="bi <?= esc($f['icon']) ?>"></i></span>
                        <h3><?= esc($f['title']) ?></h3>
                        <p><?= esc($f['text']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== CARA KERJA ========== -->
<section class="section section-dark" id="cara-kerja">
    <div class="container">
        <div class="section-head text-center mx-auto">
            <span class="eyebrow-sm light">Cara Kerja</span>
            <h2>Lima langkah dari pilih sampai terima</h2>
        </div>
        <ol class="steps list-unstyled">
            <?php foreach ($steps as $i => $s): ?>
                <li class="step">
                    <span class="step-num"><?= $i + 1 ?></span>
                    <h3><?= esc($s['title']) ?></h3>
                    <p><?= esc($s['text']) ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<!-- ========== PERAN ========== -->
<section class="section" id="peran">
    <div class="container">
        <div class="section-head text-center mx-auto">
            <span class="eyebrow-sm">Untuk Semua Peran</span>
            <h2>Satu platform, tiga pengalaman</h2>
            <p>Akses dibatasi sesuai peran sehingga data tetap aman dan alur kerja tetap fokus.</p>
        </div>
        <div class="row g-3 g-lg-4">
            <?php foreach ($roles as $r): ?>
                <div class="col-md-4">
                    <div class="role-card">
                        <span class="role-icon"><i class="bi <?= esc($r['icon']) ?>"></i></span>
                        <h3><?= esc($r['name']) ?></h3>
                        <ul class="list-unstyled">
                            <?php foreach ($r['items'] as $it): ?>
                                <li><i class="bi bi-check2-circle"></i> <?= esc($it) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== FAQ ========== -->
<section class="section section-alt" id="faq">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <span class="eyebrow-sm">FAQ</span>
                <h2>Pertanyaan yang sering diajukan</h2>
                <p class="text-muted">Tidak menemukan jawabannya? Daftar dan coba langsung alurnya.</p>
                <a href="<?= base_url('register') ?>" class="btn btn-brand">Buat Akun</a>
            </div>
            <div class="col-lg-8">
                <div class="accordion se-accordion" id="faqAccordion">
                    <?php foreach ($faqs as $i => $f): ?>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button <?= $i ? 'collapsed' : '' ?>" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq<?= $i ?>"
                                        aria-expanded="<?= $i ? 'false' : 'true' ?>" aria-controls="faq<?= $i ?>">
                                    <?= esc($f['q']) ?>
                                </button>
                            </h3>
                            <div id="faq<?= $i ?>" class="accordion-collapse collapse <?= $i ? '' : 'show' ?>" data-bs-parent="#faqAccordion">
                                <div class="accordion-body"><?= esc($f['a']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CTA ========== -->
<section class="cta">
    <div class="container">
        <div class="cta-box">
            <div>
                <h2>Siap mulai berbelanja dengan ShopEase?</h2>
                <p>Buat akun dalam hitungan detik dan nikmati alur belanja yang transparan.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg fw-semibold">Daftar Sekarang</a>
                <a href="<?= base_url('katalog') ?>" class="btn btn-outline-light btn-lg">Lihat Katalog</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
