<a href="<?= site_url('admin/krs/tambah') ?>" class="btn btn-primary mb-3">+ Tambah KRS</a>
<table class="table table-bordered table-sm bg-white">
  <thead class="thead-light"><tr><th>Tahun Ajaran</th><th>NIM</th><th>Mahasiswa</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th><th width="160">Aksi</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= $r->tahun_ajaran ?></td>
      <td><?= $r->nim ?></td>
      <td><?= html_escape($r->nama_mhs) ?></td>
      <td><?= html_escape($r->nama_mk) ?></td>
      <td><?= $r->sks ?></td>
      <td><?= $r->nilai ?: '-' ?></td>
      <td>
        <a href="<?= site_url('admin/krs/nilai/'.$r->id_krs) ?>" class="btn btn-sm btn-success">Nilai</a>
        <a href="<?= site_url('admin/krs/hapus/'.$r->id_krs) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus KRS ini?')">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
