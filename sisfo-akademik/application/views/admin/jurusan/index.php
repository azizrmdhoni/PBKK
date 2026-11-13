<a href="<?= site_url('admin/jurusan/tambah') ?>" class="btn btn-primary mb-3">+ Tambah Jurusan</a>
<table class="table table-bordered table-sm bg-white">
  <thead class="thead-light"><tr><th width="50">No</th><th>Kode</th><th>Nama Jurusan</th><th width="140">Aksi</th></tr></thead>
  <tbody>
  <?php $no=1; foreach ($rows as $r): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= html_escape($r->kode_jurusan) ?></td>
      <td><?= html_escape($r->nama_jurusan) ?></td>
      <td>
        <a href="<?= site_url('admin/jurusan/edit/'.$r->id_jurusan) ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="<?= site_url('admin/jurusan/hapus/'.$r->id_jurusan) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
