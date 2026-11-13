<?php $this->load->view('layout/head', ['title' => $title, 'datatables' => !empty($datatables)]); ?>
<body>
<?php $c = $this->router->class; $role = $this->session->userdata('role'); $nama = $this->session->userdata('nama');
if (!function_exists('_mi')) { function _mi($ctrl, $cur, $icon, $label) { return '<a class="item ' . ($cur == $ctrl ? 'active' : '') . '" href="' . site_url($ctrl) . '"><i class="bi ' . $icon . '"></i> ' . $label . '</a>'; } } ?>
<aside class="sidebar" id="sidebar">
  <div class="brand"><span class="logo"><i class="bi bi-mortarboard-fill"></i></span><div>SIAKAD<small>PORTAL AKADEMIK</small></div></div>
  <div class="nav-label">Menu Utama</div>
  <?= _mi('dashboard', $c, 'bi-grid-1x2-fill', 'Dashboard'); ?>
  <?php if ($role == 'admin'): ?>
    <div class="nav-label">Data Master</div>
    <?= _mi('mahasiswa', $c, 'bi-people-fill', 'Mahasiswa'); ?>
    <?= _mi('dosen', $c, 'bi-person-badge-fill', 'Dosen'); ?>
    <?= _mi('matakuliah', $c, 'bi-journal-bookmark-fill', 'Mata Kuliah'); ?>
    <?= _mi('kelas', $c, 'bi-calendar-week-fill', 'Kelas & Jadwal'); ?>
  <?php elseif ($role == 'dosen'): ?>
    <div class="nav-label">Perkuliahan</div>
    <?= _mi('nilai', $c, 'bi-pencil-square', 'Input Nilai'); ?>
  <?php else: ?>
    <div class="nav-label">Akademik</div>
    <?= _mi('krs', $c, 'bi-card-checklist', 'Kartu Rencana Studi'); ?>
    <?= _mi('khs', $c, 'bi-award-fill', 'Kartu Hasil Studi'); ?>
    <div class="nav-label">Akun</div>
    <?= _mi('profil', $c, 'bi-person-circle', 'Profil Saya'); ?>
  <?php endif; ?>
  <div class="nav-label">Sistem</div>
  <a class="item" href="<?= site_url('auth/logout'); ?>"><i class="bi bi-box-arrow-left"></i> Keluar</a>
  <div class="user"><span class="avatar" style="background:linear-gradient(135deg,#5b86ff,#2f5bea)"><?= inisial($nama); ?></span>
    <div style="line-height:1.25;min-width:0"><b class="d-block text-truncate" style="max-width:150px"><?= html_escape($nama); ?></b><small style="text-transform:capitalize;color:#8d9bd0"><?= $role; ?></small></div></div>
</aside>
<div class="sidebar-backdrop" id="backdrop"></div>
<div class="main">
  <div class="topbar-app">
    <div class="d-flex align-items-center" style="gap:.9rem">
      <button class="btn btn-light-soft btn-sm d-lg-none" id="toggle"><i class="bi bi-list"></i></button>
      <div class="crumbs-t"><i class="bi bi-house-door"></i> Beranda <i class="bi bi-chevron-right" style="font-size:.7rem"></i> <b><?= html_escape($title); ?></b></div>
    </div>
    <div class="d-flex align-items-center" style="gap:.8rem">
      <span class="tb-chip d-none d-md-flex"><i class="bi bi-calendar3"></i> <?= date('d M Y'); ?></span>
      <button class="tb-icon d-none d-md-grid" title="Notifikasi"><i class="bi bi-bell"></i><span class="dot"></span></button>
      <div class="dropdown">
        <button class="user-btn" data-toggle="dropdown">
          <span class="avatar" style="background:linear-gradient(135deg,#5b86ff,#2f5bea)"><?= inisial($nama); ?></span>
          <span class="d-none d-md-block"><span class="nm d-block"><?= html_escape(explode(' ', $nama)[0]); ?></span><small><?= $role; ?></small></span>
          <i class="bi bi-chevron-down d-none d-md-block" style="font-size:.7rem;color:#94a3b8"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right border-0 shadow" style="border-radius:14px;min-width:200px;padding:.5rem">
          <?php if ($role == 'mahasiswa'): ?><a class="dropdown-item rounded" href="<?= site_url('profil'); ?>"><i class="bi bi-person-circle mr-2"></i>Profil Saya</a><div class="dropdown-divider"></div><?php endif; ?>
          <a class="dropdown-item rounded text-danger" href="<?= site_url('auth/logout'); ?>"><i class="bi bi-box-arrow-right mr-2"></i>Keluar</a>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
