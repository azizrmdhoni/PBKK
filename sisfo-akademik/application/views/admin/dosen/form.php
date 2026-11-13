<div class="card" style="max-width:560px"><div class="card-body">
<?= form_open() ?>
  <div class="form-group">
    <label>NIDN</label>
    <input type="text" name="nidn" class="form-control" value="<?= set_value('nidn', $row->nidn ?? '') ?>" <?= $row ? 'readonly' : '' ?>>
    <small class="text-danger"><?= form_error('nidn') ?></small>
  </div>
  <div class="form-group">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" value="<?= set_value('nama', $row->nama ?? '') ?>">
    <small class="text-danger"><?= form_error('nama') ?></small>
  </div>
  <div class="form-group">
    <label>Email</label>
    <input type="text" name="email" class="form-control" value="<?= set_value('email', $row->email ?? '') ?>">
    <small class="text-danger"><?= form_error('email') ?></small>
  </div>
  <div class="form-group">
    <label>Telepon</label>
    <input type="text" name="telepon" class="form-control" value="<?= set_value('telepon', $row->telepon ?? '') ?>">
  </div>
  <button class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/dosen') ?>" class="btn btn-secondary">Batal</a>
<?= form_close() ?>
</div></div>
