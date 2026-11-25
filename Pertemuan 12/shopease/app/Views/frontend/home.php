<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="hero" id="beranda">
    <div class="container">
        <div class="hero-grid">
            <div class="banner">
                <span class="kicker"><?= icon('leaf', 16) ?> Toko online ShopEase</span>
                <h1>Belanja lebih mudah, pesanan selalu terlacak.</h1>
                <p>Pilih produk, bayar lewat transfer, lalu pantau status pesanan sampai tiba di alamat Anda.</p>
                <div class="actions">
                    <a href="<?= base_url('katalog') ?>" class="btn btn-accent btn-lg">Belanja Sekarang <?= icon('arrow-right', 18) ?></a>
                    <?php if (! session()->get('isLoggedIn')): ?>
                        <a href="<?= base_url('register') ?>" class="btn btn-line-light btn-lg">Buat Akun</a>
                    <?php endif; ?>
                </div>
            </div>

            <aside class="track">
                <h2>Contoh pelacakan pesanan</h2>
                <span class="code">SE-20261112-0042</span>
                <ol class="steps">
                    <li class="done"><span class="dot"><?= icon('check', 13) ?></span><div><strong>Pesanan dibuat</strong><small>Menunggu pembayaran</small></div></li>
                    <li class="done"><span class="dot"><?= icon('check', 13) ?></span><div><strong>Pembayaran diverifikasi</strong><small>Oleh administrator</small></div></li>
                    <li class="now"><span class="dot"></span><div><strong>Sedang diproses</strong><small>Operator menyiapkan barang</small></div></li>
                    <li><span class="dot"></span><div><strong>Dikirim</strong><small>Nomor resi akan muncul</small></div></li>
                </ol>
            </aside>
        </div>

        <div class="benefits">
            <?php foreach ($benefits as $b): ?>
                <div class="benefit">
                    <span class="ico"><?= icon($b['icon'], 22) ?></span>
                    <div><strong><?= esc($b['title']) ?></strong><span><?= esc($b['text']) ?></span></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="kategori">
    <div class="container">
        <div class="section-head">
            <div><h2>Belanja per kategori</h2><p>Temukan produk sesuai kebutuhan Anda.</p></div>
            <a href="<?= base_url('katalog') ?>" class="btn btn-ghost btn-sm">Semua produk</a>
        </div>
        <div class="grid cols-6">
            <?php foreach ($categories as $c): ?>
                <a class="cat" href="<?= base_url('katalog?kategori=' . $c['slug']) ?>">
                    <span class="ico"><?= icon($c['icon'], 26) ?></span>
                    <strong><?= esc($c['name']) ?></strong>
                    <small><?= esc($c['count']) ?> produk</small>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="produk">
    <div class="container">
        <div class="section-head">
            <div><h2>Produk unggulan</h2><p>Contoh kartu produk yang akan tampil di katalog.</p></div>
            <a href="<?= base_url('katalog') ?>" class="btn btn-ghost btn-sm">Lihat semua</a>
        </div>
        <div class="grid cols-4">
            <?php foreach ($featured as $p): ?>
                <article class="product">
                    <div class="product-media tone-<?= esc($p['tone']) ?>">
                        <?php if ($p['badge']): ?><span class="product-badge"><?= esc($p['badge']) ?></span><?php endif; ?>
                        <span class="disc"><?= icon($p['icon'], 46) ?></span>
                    </div>
                    <div class="product-body">
                        <span class="product-cat"><?= esc($p['category']) ?></span>
                        <h3 class="product-name"><a href="<?= base_url('produk/' . $p['slug']) ?>"><?= esc($p['name']) ?></a></h3>
                        <div class="price">
                            <strong>Rp <?= number_format($p['price'], 0, ',', '.') ?></strong>
                            <?php if ($p['old']): ?><s>Rp <?= number_format($p['old'], 0, ',', '.') ?></s><?php endif; ?>
                        </div>
                        <div class="product-foot">
                            <span class="stock<?= $p['stock'] <= 10 ? ' low' : '' ?>">Stok <?= esc($p['stock']) ?></span>
                            <a href="<?= base_url('produk/' . $p['slug']) ?>" class="btn btn-sm btn-primary">Detail</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="cara-belanja">
    <div class="container">
        <div class="section-head"><div><h2>Cara belanja</h2><p>Empat langkah dari memilih sampai menerima pesanan.</p></div></div>
        <div class="how">
            <div class="grid cols-4">
                <?php foreach ($steps as $i => $s): ?>
                    <div class="how-item">
                        <span class="how-n"><?= $i + 1 ?></span>
                        <div><strong><?= esc($s['title']) ?></strong><span><?= esc($s['text']) ?></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
