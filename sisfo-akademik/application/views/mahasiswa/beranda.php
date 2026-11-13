<div class="card mb-3"><div class="card-body">
  <h5><?= html_escape($mhs->nama) ?></h5>
  <p class="mb-0 text-muted">NIM <?= $mhs->nim ?> &middot; <?= html_escape($mhs->nama_jurusan) ?> &middot; Angkatan <?= $mhs->angkatan ?></p>
</div></div>
<div class="row">
  <div class="col-md-4"><div class="card"><div class="card-body">
    <div class="text-muted small">IPK</div><div class="h2 mb-0"><?= number_format($ipk, 2) ?></div>
  </div></div></div>
  <div class="col-md-4"><div class="card"><div class="card-body">
    <div class="text-muted small">Mata kuliah diambil</div><div class="h2 mb-0"><?= count($krs) ?></div>
  </div></div></div>
</div>
