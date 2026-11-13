<div class="page-head"><div><h4><?= html_escape($k['matkul']); ?></h4><div class="crumb"><a href="<?= site_url('nilai'); ?>">Input Nilai</a> / Semester <?= $k['semester']; ?></div></div></div>
<?= form_open('nilai/simpan/' . $k['id']); ?>
<div class="card-lite">
  <div class="table-responsive"><table class="table-modern table">
    <thead><tr><th>NIM</th><th>Nama Mahasiswa</th><th width="170">Nilai (0–100)</th><th>Huruf</th></tr></thead>
    <tbody><?php foreach ($peserta as $p): ?>
      <tr><td><span class="badge-soft bs-secondary"><?= $p['nim']; ?></span></td><td><b><?= html_escape($p['nama']); ?></b></td>
        <td><input type="number" step="0.01" min="0" max="100" name="nilai[<?= $p['krs_id']; ?>]" value="<?= $p['nilai_angka']; ?>" class="form-control form-control-sm" placeholder="0 – 100"></td>
        <td><?= $p['nilai_huruf'] ? '<span class="grade ' . grade_class($p['nilai_huruf']) . '">' . $p['nilai_huruf'] . '</span>' : '<span class="text-muted">—</span>'; ?></td></tr>
    <?php endforeach; ?></tbody></table></div>
  <?php if (!$peserta): ?><div class="empty"><i class="bi bi-people"></i>Belum ada peserta di kelas ini.</div><?php endif; ?>
  <?php if ($peserta): ?><div class="card-pad d-flex justify-content-between align-items-center">
    <small class="text-muted">A ≥ 85 · B+ ≥ 75 · B ≥ 65 · C+ ≥ 55 · C ≥ 45 · D ≥ 35 · E &lt; 35</small>
    <div><a href="<?= site_url('nilai'); ?>" class="btn btn-light-soft mr-2">Kembali</a><button class="btn btn-primary"><i class="bi bi-check2-circle mr-1"></i> Simpan Nilai</button></div></div><?php endif; ?>
</div>
<?= form_close(); ?>
