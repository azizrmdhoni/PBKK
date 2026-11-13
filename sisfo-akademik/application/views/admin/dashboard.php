<div class="row">
<?php
$kartu = [
  ['Mahasiswa', $jml_mhs, 'primary'],
  ['Dosen', $jml_dosen, 'success'],
  ['Mata Kuliah', $jml_mk, 'warning'],
  ['Jurusan', $jml_jurusan, 'info'],
];
foreach ($kartu as $k): ?>
  <div class="col-md-3 mb-3">
    <div class="card border-left-<?= $k[2] ?> shadow-sm">
      <div class="card-body">
        <div class="text-muted small"><?= $k[0] ?></div>
        <div class="h2 mb-0 text-<?= $k[2] ?>"><?= $k[1] ?></div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<p class="text-muted">Selamat datang, <?= html_escape($this->session->userdata('nama')) ?>.</p>
