<a href="<?= site_url('admin/mahasiswa/tambah') ?>" class="btn btn-primary mb-3">+ Tambah Mahasiswa</a>
<table class="table table-bordered table-sm bg-white">
  <thead class="thead-light"><tr><th width="50">No</th><th>NIM</th><th>Nama</th><th>Jurusan</th><th>Angkatan</th><th width="200">Aksi</th></tr></thead>
  <tbody>
  <?php $no=1; foreach ($rows as $r): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= html_escape($r->nim) ?></td>
      <td><?= html_escape($r->nama) ?></td>
      <td><?= html_escape($r->nama_jurusan) ?></td>
      <td><?= html_escape($r->angkatan) ?></td>
      <td>
        <a href="<?= site_url('admin/mahasiswa/detail/'.$r->nim) ?>" class="btn btn-sm btn-info">Detail</a>
        <a href="<?= site_url('admin/mahasiswa/edit/'.$r->nim) ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="<?= site_url('admin/mahasiswa/hapus/'.$r->nim) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus mahasiswa ini beserta akunnya?')">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
