<div class="card" style="max-width:560px"><div class="card-body">
<?= form_open() ?>
  <div class="form-group">
    <label>Kode Jurusan</label>
    <input type="text" name="kode_jurusan" class="form-control" value="<?= set_value('kode_jurusan', $row->kode_jurusan ?? '') ?>">
    <small class="text-danger"><?= form_error('kode_jurusan') ?></small>
  </div>
  <div class="form-group">
    <label>Nama Jurusan</label>
    <input type="text" name="nama_jurusan" class="form-control" value="<?= set_value('nama_jurusan', $row->nama_jurusan ?? '') ?>">
    <small class="text-danger"><?= form_error('nama_jurusan') ?></small>
  </div>
  <button class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/jurusan') ?>" class="btn btn-secondary">Batal</a>
<?= form_close() ?>
</div></div>
