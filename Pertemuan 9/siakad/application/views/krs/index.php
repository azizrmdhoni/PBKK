<?php $persen = min(100, round($sks_aktif / $max * 100)); ?>
<div class="page-head"><div><h4>Kartu Rencana Studi</h4><div class="crumb">Pilih kelas yang ingin Anda ambil semester ini</div></div></div>
<div class="card-lite card-pad mb-4">
  <div class="d-flex justify-content-between mb-2"><b>Beban SKS semester berjalan</b><span><b><?= $sks_aktif; ?></b> / <?= $max; ?> SKS</span></div>
  <div class="progress-thin"><div style="width:<?= $persen; ?>%"></div></div>
</div>

<div class="card-lite mb-4">
  <div class="card-head">KRS Saya</div>
  <div class="table-responsive"><table class="table-modern table">
    <thead><tr><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Dosen</th><th>Jadwal</th><th>Semester</th><th>Nilai</th><th></th></tr></thead>
    <tbody><?php foreach ($diambil as $r): ?>
      <tr><td><span class="badge-soft bs-secondary"><?= $r['kode']; ?></span></td><td><b><?= html_escape($r['matkul']); ?></b></td><td><?= $r['sks']; ?></td>
        <td><?= html_escape($r['dosen']); ?></td><td><span class="day-pill"><?= $r['hari']; ?></span> <small class="text-muted"><?= $r['jam'] . ' · ' . html_escape($r['ruang']); ?></small></td>
        <td><?= $r['semester']; ?></td>
        <td><?= $r['nilai_huruf'] ? '<span class="grade ' . grade_class($r['nilai_huruf']) . '">' . $r['nilai_huruf'] . '</span>' : '<span class="text-muted">—</span>'; ?></td>
        <td class="text-right"><?php if (!$r['nilai_huruf']): ?><a href="<?= site_url('krs/batal/' . $r['krs_id']); ?>" data-confirm="Batalkan mata kuliah ini dari KRS?" class="btn btn-sm btn-outline-danger">Batal</a><?php endif; ?></td></tr>
    <?php endforeach; ?></tbody></table></div>
  <?php if (!$diambil): ?><div class="empty"><i class="bi bi-card-checklist"></i>Belum ada mata kuliah yang diambil.</div><?php endif; ?>
</div>

<div class="card-lite">
  <div class="card-head">Kelas Tersedia</div>
  <div class="table-responsive"><table class="table-modern table">
    <thead><tr><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Dosen</th><th>Jadwal</th><th>Semester</th><th>Kuota</th><th></th></tr></thead>
    <tbody><?php foreach ($tersedia as $r): $penuh = $r['terisi'] >= $r['kuota']; ?>
      <tr><td><span class="badge-soft bs-secondary"><?= $r['kode']; ?></span></td><td><b><?= html_escape($r['matkul']); ?></b></td><td><?= $r['sks']; ?></td>
        <td><?= html_escape($r['dosen']); ?></td><td><span class="day-pill"><?= $r['hari']; ?></span> <small class="text-muted"><?= $r['jam'] . ' · ' . html_escape($r['ruang']); ?></small></td>
        <td><?= $r['semester']; ?></td>
        <td><span class="badge-soft <?= $penuh ? 'bs-danger' : 'bs-success'; ?>"><?= $r['terisi'] . '/' . $r['kuota']; ?></span></td>
        <td class="text-right"><?php if ($penuh): ?><span class="text-muted small">Penuh</span><?php else: ?><a href="<?= site_url('krs/ambil/' . $r['id']); ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Ambil</a><?php endif; ?></td></tr>
    <?php endforeach; ?></tbody></table></div>
  <?php if (!$tersedia): ?><div class="empty"><i class="bi bi-inbox"></i>Tidak ada kelas tersedia.</div><?php endif; ?>
</div>
