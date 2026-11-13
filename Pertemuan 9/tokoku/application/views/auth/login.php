<?php $this->load->view('layout/head', ['title' => $title]); ?>
<body>
<div class="auth-wrap">
  <div class="auth-side">
    <div class="brand"><span class="logo"><i class="bi bi-bag-heart-fill"></i></span> TokoKu</div>
    <div>
      <h1>Belanja lebih mudah,<br>hidup lebih praktis.</h1>
      <p style="opacity:.9;max-width:420px">Temukan produk elektronik, fashion, makanan, dan buku pilihan dengan harga terbaik.</p>
      <ul>
        <li><i class="bi bi-truck"></i> Pengiriman cepat ke seluruh Indonesia</li>
        <li><i class="bi bi-shield-check"></i> Pembayaran aman dan terverifikasi</li>
        <li><i class="bi bi-arrow-repeat"></i> Garansi pengembalian 7 hari</li>
      </ul>
    </div>
    <small style="opacity:.75">&copy; <?= date('Y'); ?> TokoKu</small>
  </div>
  <div class="auth-form">
    <div class="auth-box">
      <h3 class="mt-3">Selamat datang kembali</h3>
      <p class="text-muted mb-4">Masuk ke akun Anda untuk melanjutkan.</p>
      <?php if ($e = $this->session->flashdata('error')): ?><div class="alert alert-danger py-2"><i class="bi bi-exclamation-circle mr-1"></i><?= html_escape($e); ?></div><?php endif; ?>
      <?= form_open('auth'); ?>
        <div class="form-group">
          <label>Email</label>
          <div class="input-icon"><i class="bi bi-envelope"></i>
            <input type="text" name="username" class="form-control" placeholder="nama@email.com" value="<?= set_value('username'); ?>" autofocus></div>
          <?= form_error('username', '<span class="invalid-msg">', '</span>'); ?>
        </div>
        <div class="form-group">
          <label>Password</label>
          <div class="input-icon"><i class="bi bi-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password">
            <i class="bi bi-eye toggle-pass"></i></div>
          <?= form_error('password', '<span class="invalid-msg">', '</span>'); ?>
        </div>
        <button class="btn btn-primary btn-block py-2 mt-4">Masuk</button>
      <?= form_close(); ?>
      <p class="text-center text-muted mt-4 mb-0">Belum punya akun? <a href="<?= site_url('auth/register'); ?>" class="font-weight-bold">Daftar sekarang</a></p>
      <div class="demo-box"><b>Akun demo</b><br>Admin: admin@tokoku.com / admin123<br>Pelanggan: pelanggan@tokoku.com / pelanggan123</div>
    </div>
  </div>
</div>
<?php $this->load->view('layout/scripts', ['no_error_toast' => true]); ?>
</body></html>
