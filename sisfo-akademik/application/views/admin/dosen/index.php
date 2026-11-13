<a href="<?= site_url('admin/dosen/tambah') ?>" class="btn btn-primary mb-3">+ Tambah Dosen</a>
<table class="table table-bordered table-sm bg-white">
  <thead class="thead-light"><tr><th width="50">No</th><th>NIDN</th><th>Nama</th><th>Email</th><th>Telepon</th><th width="140">Aksi</th></tr></thead>
  <tbody>
  <?php $no=1; foreach ($rows as $r): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= html_escape($r->nidn) ?></td>
      <td><?= html_escape($r->nama) ?></td>
      <td><?= html_escape($r->email) ?></td>
      <td><?= html_escape($r->telepon) ?></td>
      <td>
        <a href="<?= site_url('admin/dosen/edit/'.$r->nidn) ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="<?= site_url('admin/dosen/hapus/'.$r->nidn) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
