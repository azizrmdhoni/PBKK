<?php $this->load->view('layout/head', ['title' => $title]); ?>
<body>
<?php $role = $this->session->userdata('role'); $login = $this->session->userdata('login'); ?>
<div class="promo-bar">🚚 Gratis ongkir untuk pembelian di atas <b>Rp 500.000</b> &nbsp;·&nbsp; Garansi 7 hari &nbsp;·&nbsp; Pembayaran aman</div>
<nav class="store-nav sticky-top">
  <div class="container d-flex align-items-center flex-wrap">
    <a class="brand" href="<?= site_url('toko'); ?>"><span class="logo"><i class="bi bi-bag-heart-fill"></i></span><span>Toko<em>Ku</em></span></a>
    <form class="store-search" method="get" action="<?= site_url('toko'); ?>">
      <i class="bi bi-search"></i>
      <input type="text" name="cari" class="form-control" placeholder="Cari produk, misalnya headphone…" value="<?= html_escape($this->input->get('cari', true)); ?>">
    </form>
    <div class="d-flex align-items-center ml-auto" style="gap:.4rem">
      <a class="nav-link-s d-none d-md-inline" href="<?= site_url('toko'); ?>">Katalog</a>
      <?php if ($login && $role == 'pelanggan'): ?>
        <a class="nav-link-s d-none d-md-inline" href="<?= site_url('checkout/riwayat'); ?>">Pesanan Saya</a>
      <?php endif; ?>
      <?php if ($role != 'admin'): ?>
        <a class="cart-btn" href="<?= site_url('belanja'); ?>" title="Keranjang"><i class="bi bi-cart3"></i>
          <?php if ($this->keranjang->jumlah() > 0): ?><span class="cnt"><?= $this->keranjang->jumlah(); ?></span><?php endif; ?></a>
      <?php endif; ?>
      <?php if ($login): ?>
        <div class="dropdown ml-2">
          <a href="#" class="d-flex align-items-center" data-toggle="dropdown" style="gap:.5rem;color:inherit">
            <span class="avatar"><?= inisial($this->session->userdata('nama')); ?></span>
            <span class="d-none d-md-inline font-weight-bold"><?= html_escape(explode(' ', $this->session->userdata('nama'))[0]); ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow border-0" style="border-radius:12px">
            <?php if ($role == 'admin'): ?><a class="dropdown-item" href="<?= site_url('dashboard'); ?>"><i class="bi bi-speedometer2 mr-2"></i>Dashboard Admin</a>
            <?php else: ?><a class="dropdown-item" href="<?= site_url('checkout/riwayat'); ?>"><i class="bi bi-receipt mr-2"></i>Pesanan Saya</a><?php endif; ?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="<?= site_url('auth/logout'); ?>"><i class="bi bi-box-arrow-right mr-2"></i>Keluar</a>
          </div>
        </div>
      <?php else: ?>
        <a class="btn btn-light-soft btn-sm ml-2" href="<?= site_url('auth'); ?>">Masuk</a>
        <a class="btn btn-primary btn-sm" href="<?= site_url('auth/register'); ?>">Daftar</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main class="container py-4">
