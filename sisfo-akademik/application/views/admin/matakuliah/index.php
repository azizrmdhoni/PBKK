<a href="<?= site_url('admin/matakuliah/tambah') ?>" class="btn btn-primary mb-3">+ Tambah Mata Kuliah</a>
<table class="table table-bordered table-sm bg-white">
  <thead class="thead-light"><tr><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Smt</th><th>Jurusan</th><th>Dosen</th><th width="140">Aksi</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= html_escape($r->kode_mk) ?></td>
      <td><?= html_escape($r->nama_mk) ?></td>
      <td><?= $r->sks ?></td>
      <td><?= $r->semester ?></td>
      <td><?= html_escape($r->nama_jurusan) ?></td>
      <td><?= html_escape($r->nama_dosen ?: '-') ?></td>
      <td>
        <a href="<?= site_url('admin/matakuliah/edit/'.$r->kode_mk) ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="<?= site_url('admin/matakuliah/hapus/'.$r->kode_mk) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
