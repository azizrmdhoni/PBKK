<header class="se-header" id="siteHeader">
    <nav class="navbar navbar-expand-lg" aria-label="Navigasi utama">
        <div class="container">
            <a class="navbar-brand se-brand" href="<?= base_url('/') ?>">
                <span class="se-brand-mark"><i class="bi bi-bag-heart-fill"></i></span>
                Shop<span>Ease</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Buka menu">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-lg-auto gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="#kategori">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cara-kerja">Cara Kerja</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                </ul>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <a href="<?= base_url('login') ?>" class="btn btn-ghost">Masuk</a>
                    <a href="<?= base_url('register') ?>" class="btn btn-brand">Daftar Gratis</a>
                </div>
            </div>
        </div>
    </nav>
</header>
