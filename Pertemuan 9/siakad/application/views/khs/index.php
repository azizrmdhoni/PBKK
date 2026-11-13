<div class="page-head"><div><h4>Kartu Hasil Studi</h4><div class="crumb">Rekap nilai dan indeks prestasi</div></div>
  <button class="btn btn-primary no-print" onclick="window.print()"><i class="bi bi-printer mr-1"></i> Cetak KHS</button></div>
<div class="card-lite card-pad mb-4 d-flex align-items-center flex-wrap" style="gap:1.2rem">
  <span class="avatar" style="width:60px;height:60px;font-size:1.3rem"><?= inisial($m['nama']); ?></span>
  <div class="flex-fill"><h5 class="mb-0"><?= html_escape($m['nama']); ?></h5><span class="text-muted"><?= $m['nim']; ?> · <?= html_escape($m['prodi']); ?> · Angkatan <?= $m['angkatan']; ?></span></div>
  <div class="text-center px-3"><small class="text-muted d-block">IPK</small><span style="font-size:2rem;font-weight:800;color:var(--primary)"><?= number_format($ipk, 2); ?></span></div>
  <div class="text-center px-3"><small class="text-muted d-block">Total SKS</small><span style="font-size:2rem;font-weight:800"><?= $tot_sks; ?></span></div>
</div>
<?php foreach ($per as $semester => $d): ?>
<div class="card-lite mb-4">
  <div class="card-head">Semester <?= $semester; ?><span class="badge-soft bs-primary">IPS <?= $d['sks'] ? number_format($d['mutu'] / $d['sks'], 2) : '0.00'; ?> · <?= $d['sks']; ?> SKS</span></div>
  <div class="table-responsive"><table class="table-modern table">
    <thead><tr><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th><th>Huruf</th></tr></thead>
    <tbody><?php foreach ($d['mk'] as $r): ?>
      <tr><td><span class="badge-soft bs-secondary"><?= $r['kode']; ?></span></td><td><b><?= html_escape($r['nama']); ?></b></td><td><?= $r['sks']; ?></td>
        <td><?= $r['nilai_angka'] !== null ? $r['nilai_angka'] : '—'; ?></td>
        <td><?= $r['nilai_huruf'] ? '<span class="grade ' . grade_class($r['nilai_huruf']) . '">' . $r['nilai_huruf'] . '</span>' : '<span class="text-muted">—</span>'; ?></td></tr>
    <?php endforeach; ?></tbody></table></div>
</div>
<?php endforeach; ?>
<?php if (!$per): ?><div class="card-lite empty py-5"><i class="bi bi-award"></i>Belum ada data KRS. Ambil kelas di menu KRS.</div><?php endif; ?>
