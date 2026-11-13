<?php $this->load->view('layout/head', ['title' => $title]); ?>
<body>
<div class="auth-wrap">
  <div class="auth-side">
    <div class="brand"><span class="logo"><i class="bi bi-mortarboard-fill"></i></span> SIAKAD Kampus</div>
    <div>
      <svg class="campus-art" viewBox="0 0 520 330" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <circle cx="260" cy="175" r="150" fill="rgba(255,255,255,.09)"/><circle cx="260" cy="175" r="108" fill="rgba(255,255,255,.07)"/>
        <path d="M260 40 V78" stroke="#fff" stroke-width="3"/><path d="M260 40 L292 50 L260 60Z" fill="#f5b83d"/>
        <polygon points="150,128 260,78 370,128" fill="#fff"/><polygon points="176,124 260,88 344,124" fill="#e3eaff"/>
        <circle cx="260" cy="112" r="13" fill="#2f5bea"/><path d="M260 112 V104 M260 112 L266 115" stroke="#fff" stroke-width="2.4" stroke-linecap="round"/>
        <rect x="146" y="128" width="228" height="16" rx="2" fill="#dbe4ff"/>
        <?php foreach ([0,1,2,3,4] as $i): $x = 168 + $i * 44; ?>
          <rect x="<?= $x; ?>" y="144" width="24" height="104" rx="3" fill="#fff"/><rect x="<?= $x - 3; ?>" y="144" width="30" height="8" rx="2" fill="#e3eaff"/><rect x="<?= $x - 3; ?>" y="240" width="30" height="8" rx="2" fill="#e3eaff"/>
          <rect x="<?= $x + 7; ?>" y="156" width="3" height="80" fill="#e8eeff"/>
        <?php endforeach; ?>
        <rect x="236" y="190" width="48" height="58" rx="4" fill="#2448c9" opacity=".35"/>
        <rect x="136" y="248" width="248" height="12" rx="2" fill="#cbd8ff"/><rect x="120" y="260" width="280" height="12" rx="2" fill="#b4c6ff"/><rect x="104" y="272" width="312" height="12" rx="2" fill="#9db4ff"/>
        <g transform="translate(56 66)"><polygon points="0,26 44,8 88,26 44,44" fill="#f5b83d"/><path d="M18 36 V54 Q44 68 70 54 V36 L44 48Z" fill="#d99a1e"/><path d="M82 29 V58" stroke="#f5b83d" stroke-width="3"/><circle cx="82" cy="62" r="4" fill="#f5b83d"/></g>
        <g transform="translate(398 236)"><rect x="0" y="34" width="86" height="16" rx="3" fill="#fff"/><rect x="8" y="16" width="74" height="16" rx="3" fill="#7fa0ff"/><rect x="2" y="0" width="70" height="14" rx="3" fill="#f5b83d"/></g>
        <circle cx="448" cy="92" r="5" fill="#fff" opacity=".7"/><circle cx="80" cy="218" r="4" fill="#fff" opacity=".6"/><circle cx="468" cy="150" r="3" fill="#f5b83d"/>
      </svg>
      <h1 class="mt-4">Kelola kegiatan akademik<br>dalam satu platform.</h1>
      <p style="opacity:.88;max-width:440px;margin-bottom:.9rem">Untuk mahasiswa, dosen, dan administrator kampus.</p>
      <span class="pill-feat"><i class="bi bi-card-checklist"></i> KRS Online</span>
      <span class="pill-feat"><i class="bi bi-pencil-square"></i> Input Nilai</span>
      <span class="pill-feat"><i class="bi bi-award"></i> KHS &amp; IPK Otomatis</span>
    </div>
    <small style="opacity:.75">&copy; <?= date('Y'); ?> SIAKAD Kampus &middot; Tahun Akademik 2026/2027</small>
  </div>
  <div class="auth-form">
    <div class="auth-box">
      <div class="d-flex align-items-center mb-3" style="gap:.65rem"><span class="avatar" style="border-radius:13px;width:46px;height:46px;font-size:1.3rem;background:linear-gradient(135deg,#5b86ff,#2f5bea)"><i class="bi bi-mortarboard-fill"></i></span>
        <div style="line-height:1.15"><b style="font-size:1.1rem">SIAKAD Kampus</b><br><small class="text-muted">Portal Akademik Terpadu</small></div></div>
      <h3 class="mt-4 mb-1">Selamat datang 👋</h3>
      <p class="text-muted mb-3">Masuk untuk mengakses portal akademik Anda.</p>
      <div class="role-tabs">
        <div class="role-tab" data-u="2026001"><i class="bi bi-mortarboard"></i>Mahasiswa</div>
        <div class="role-tab" data-u="0011223301"><i class="bi bi-person-workspace"></i>Dosen</div>
        <div class="role-tab" data-u="admin" data-p="admin123"><i class="bi bi-shield-lock"></i>Admin</div>
      </div>
      <?php if ($e = $this->session->flashdata('error')): ?><div class="alert alert-danger py-2"><i class="bi bi-exclamation-circle mr-1"></i><?= html_escape($e); ?></div><?php endif; ?>
      <?= form_open('auth'); ?>
        <div class="form-group"><label>Username</label>
          <div class="input-icon"><i class="bi bi-person"></i>
            <input type="text" name="username" id="u" class="form-control" placeholder="NIM / NIDN / admin" value="<?= set_value('username'); ?>" autofocus></div>
          <?= form_error('username', '<span class="invalid-msg">', '</span>'); ?></div>
        <div class="form-group"><label>Password</label>
          <div class="input-icon"><i class="bi bi-lock"></i>
            <input type="password" name="password" id="p" class="form-control" placeholder="Masukkan password"><i class="bi bi-eye toggle-pass"></i></div>
          <?= form_error('password', '<span class="invalid-msg">', '</span>'); ?></div>
        <button class="btn btn-primary btn-block py-2 mt-4" style="font-size:1rem">Masuk <i class="bi bi-arrow-right ml-1"></i></button>
      <?= form_close(); ?>
      <div class="demo-box"><i class="bi bi-info-circle mr-1"></i> Klik peran di atas untuk mengisi akun demo otomatis. Password awal Mahasiswa/Dosen = NIM/NIDN.</div>
    </div>
  </div>
</div>
<?php $this->load->view('layout/scripts', ['no_error_toast' => true]); ?>
<script>
$('.role-tab').on('click', function () {
  $('.role-tab').removeClass('on'); $(this).addClass('on');
  var u = $(this).data('u'); $('#u').val(u); $('#p').val($(this).data('p') || u);
});
</script>
</body></html>
