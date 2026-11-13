<div class="card"><div class="card-body">
  <p class="mb-1"><strong><?= html_escape($mhs->nama) ?></strong> (<?= $mhs->nim ?>)</p>
  <p class="text-muted"><?= html_escape($mhs->nama_jurusan) ?></p>
  <table class="table table-bordered table-sm">
    <thead class="thead-light"><tr><th>Tahun Ajaran</th><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th></tr></thead>
    <tbody>
    <?php foreach ($krs as $k): ?>
      <tr><td><?= $k->tahun_ajaran ?></td><td><?= $k->kode_mk ?></td><td><?= html_escape($k->nama_mk) ?></td><td><?= $k->sks ?></td><td><?= $k->nilai ?: '-' ?></td></tr>
    <?php endforeach; ?>
    <?php if (!$krs): ?><tr><td colspan="5" class="text-center text-muted">Belum ada data</td></tr><?php endif; ?>
    </tbody>
  </table>
  <p><strong>IPK: <?= number_format($ipk, 2) ?></strong></p>
  <button onclick="window.print()" class="btn btn-secondary no-print">Cetak</button>
</div></div>
