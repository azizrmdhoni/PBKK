<div class="page-head"><div><h4>Input Nilai</h4><div class="crumb">Pilih kelas yang Anda ampu</div></div></div>
<div class="card-lite">
  <div class="table-responsive"><table class="table-modern table">
    <thead><tr><th>Kode</th><th>Mata Kuliah</th><th>Jadwal</th><th>Semester</th><th>Peserta</th><th></th></tr></thead>
    <tbody><?php foreach ($kelas as $k): ?>
      <tr><td><span class="badge-soft bs-secondary"><?= $k['kode']; ?></span></td><td><b><?= html_escape($k['matkul']); ?></b></td>
        <td><span class="day-pill"><?= $k['hari']; ?></span> <small class="text-muted"><?= $k['jam']; ?></small></td><td><?= $k['semester']; ?></td>
        <td><span class="badge-soft bs-primary"><?= $k['peserta']; ?> mahasiswa</span></td>
        <td class="text-right"><a class="btn btn-primary btn-sm" href="<?= site_url('nilai/peserta/' . $k['id']); ?>"><i class="bi bi-pencil-square"></i> Input Nilai</a></td></tr>
    <?php endforeach; ?></tbody></table></div>
  <?php if (!$kelas): ?><div class="empty"><i class="bi bi-easel2"></i>Anda belum mengampu kelas.</div><?php endif; ?>
</div>
