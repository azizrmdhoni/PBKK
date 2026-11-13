<div class="card mb-3"><div class="card-body">
  <table class="table table-borderless table-sm mb-0">
    <tr><th width="160">NIM</th><td><?= html_escape($mhs->nim) ?></td></tr>
    <tr><th>Nama</th><td><?= html_escape($mhs->nama) ?></td></tr>
    <tr><th>Jurusan</th><td><?= html_escape($mhs->nama_jurusan) ?></td></tr>
    <tr><th>Angkatan</th><td><?= html_escape($mhs->angkatan) ?></td></tr>
    <tr><th>Alamat</th><td><?= html_escape($mhs->alamat) ?></td></tr>
    <tr><th>Email</th><td><?= html_escape($mhs->email) ?></td></tr>
    <tr><th>Telepon</th><td><?= html_escape($mhs->telepon) ?></td></tr>
  </table>
</div></div>
<h5>Riwayat KRS</h5>
<table class="table table-bordered table-sm bg-white">
  <thead class="thead-light"><tr><th>Tahun Ajaran</th><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th></tr></thead>
  <tbody>
  <?php foreach ($krs as $k): ?>
    <tr><td><?= $k->tahun_ajaran ?></td><td><?= $k->kode_mk ?></td><td><?= html_escape($k->nama_mk) ?></td><td><?= $k->sks ?></td><td><?= $k->nilai ?: '-' ?></td></tr>
  <?php endforeach; ?>
  <?php if (!$krs): ?><tr><td colspan="5" class="text-center text-muted">Belum ada KRS</td></tr><?php endif; ?>
  </tbody>
</table>
<p><strong>IPK: <?= number_format($ipk, 2) ?></strong></p>
<a href="<?= site_url('admin/mahasiswa') ?>" class="btn btn-secondary">Kembali</a>
