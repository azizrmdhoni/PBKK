<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Sistem Informasi Akademik</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container" style="max-width:420px;margin-top:10vh">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h4 class="text-center mb-1">Sistem Informasi Akademik</h4>
      <p class="text-center text-muted mb-4">Silakan login</p>

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
      <?php endif; ?>

      <?= form_open('auth') ?>
        <div class="form-group">
          <label>Username / NIM</label>
          <input type="text" name="username" class="form-control" value="<?= set_value('username') ?>" autofocus>
          <small class="text-danger"><?= form_error('username') ?></small>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control">
          <small class="text-danger"><?= form_error('password') ?></small>
        </div>
        <button class="btn btn-primary btn-block">Masuk</button>
      <?= form_close() ?>
      <hr>
      <small class="text-muted">Demo: admin / admin123 &nbsp;|&nbsp; 2021001 / mhs123</small>
    </div>
  </div>
</div>
</body>
</html>
