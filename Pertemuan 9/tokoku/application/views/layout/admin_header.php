<?php $this->load->view('layout/head', ['title' => $title, 'datatables' => !empty($datatables)]); ?>
<body>
<?php $c = $this->router->class; ?>
<aside class="sidebar" id="sidebar">
  <div class="brand"><span class="logo"><i class="bi bi-bag-heart-fill"></i></span><div>TokoKu<small>PANEL ADMIN</small></div></div>
  <div class="nav-label">Menu Utama</div>
  <a class="item <?= $c == 'dashboard' ? 'active' : ''; ?>" href="<?= site_url('dashboard'); ?>"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
  <a class="item <?= $c == 'produk' ? 'active' : ''; ?>" href="<?= site_url('produk'); ?>"><i class="bi bi-box-seam-fill"></i> Produk</a>
  <a class="item <?= $c == 'pesanan' ? 'active' : ''; ?>" href="<?= site_url('pesanan'); ?>"><i class="bi bi-receipt-cutoff"></i> Pesanan
    <?php if ($n_verif > 0): ?><span class="badge badge-warning ml-auto"><?= $n_verif; ?></span><?php endif; ?></a>
  <div class="nav-label">Lainnya</div>
  <a class="item" href="<?= site_url('toko'); ?>" target="_blank"><i class="bi bi-shop"></i> Lihat Toko</a>
  <a class="item" href="<?= site_url('auth/logout'); ?>"><i class="bi bi-box-arrow-left"></i> Keluar</a>
  <div class="user">
    <span class="avatar"><?= inisial($this->session->userdata('nama')); ?></span>
    <div><b><?= html_escape($this->session->userdata('nama')); ?></b><small>Administrator</small></div>
  </div>
</aside>
<div class="sidebar-backdrop" id="backdrop"></div>
<div class="main">
  <div class="topbar-app">
    <div class="d-flex align-items-center" style="gap:.75rem">
      <button class="btn btn-light-soft btn-sm d-lg-none" id="toggle"><i class="bi bi-list"></i></button>
      <b><?= html_escape($title); ?></b>
    </div>
    <div class="text-muted small d-none d-md-block"><i class="bi bi-calendar3 mr-1"></i><?= date('d M Y'); ?></div>
  </div>
  <div class="content">
