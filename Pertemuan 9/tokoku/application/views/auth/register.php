<?php $this->load->view('layout/head', ['title' => $title]); ?>
<body>
<div class="auth-wrap">
  <div class="auth-side">
    <div class="brand"><span class="logo"><i class="bi bi-bag-heart-fill"></i></span> TokoKu</div>
    <div>
      <h1>Bergabung dan nikmati<br>belanja tanpa ribet.</h1>
      <ul>
        <li><i class="bi bi-cart-check"></i> Checkout cepat dalam beberapa langkah</li>
        <li><i class="bi bi-receipt"></i> Lacak seluruh pesanan Anda</li>
        <li><i class="bi bi-tag"></i> Harga terbaik setiap hari</li>
      </ul>
    </div>
    <small style="opacity:.75">&copy; <?= date('Y'); ?> TokoKu</small>
  </div>
  <div class="auth-form">
    <div class="auth-box">
      <h3 class="mt-3">Buat akun baru</h3>
      <p class="text-muted mb-4">Daftar gratis, hanya butuh satu menit.</p>
      <?= form_open('auth/register'); ?>
        <div class="form-group"><label>Nama lengkap</label>
          <div class="input-icon"><i class="bi bi-person"></i><input name="nama" class="form-control" value="<?= set_value('nama'); ?>" placeholder="Nama Anda"></div>
          <?= form_error('nama', '<span class="invalid-msg">', '</span>'); ?></div>
        <div class="form-group"><label>Email</label>
          <div class="input-icon"><i class="bi bi-envelope"></i><input name="username" type="email" class="form-control" value="<?= set_value('username'); ?>" placeholder="nama@email.com"></div>
          <?= form_error('username', '<span class="invalid-msg">', '</span>'); ?></div>
        <div class="form-group"><label>Password</label>
          <div class="input-icon"><i class="bi bi-lock"></i><input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter"><i class="bi bi-eye toggle-pass"></i></div>
          <?= form_error('password', '<span class="invalid-msg">', '</span>'); ?></div>
        <div class="form-group"><label>Ulangi password</label>
          <div class="input-icon"><i class="bi bi-lock-fill"></i><input type="password" name="konfirmasi" class="form-control" placeholder="Ketik ulang password"></div>
          <?= form_error('konfirmasi', '<span class="invalid-msg">', '</span>'); ?></div>
        <button class="btn btn-primary btn-block py-2 mt-4">Daftar</button>
      <?= form_close(); ?>
      <p class="text-center text-muted mt-4 mb-0">Sudah punya akun? <a href="<?= site_url('auth'); ?>" class="font-weight-bold">Masuk</a></p>
    </div>
  </div>
</div>
<?php $this->load->view('layout/scripts', ['no_error_toast' => true]); ?>
</body></html>
