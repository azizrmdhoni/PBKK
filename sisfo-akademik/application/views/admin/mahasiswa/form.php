<div class="card" style="max-width:640px"><div class="card-body">
<?= form_open() ?>
  <div class="form-group">
    <label>NIM</label>
    <input type="text" name="nim" class="form-control" value="<?= set_value('nim', $row->nim ?? '') ?>" <?= $row ? 'readonly' : '' ?>>
    <small class="text-danger"><?= form_error('nim') ?></small>
  </div>
  <div class="form-group">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" value="<?= set_value('nama', $row->nama ?? '') ?>">
    <small class="text-danger"><?= form_error('nama') ?></small>
  </div>
  <div class="form-row">
    <div class="form-group col-md-8">
      <label>Jurusan</label>
      <select name="id_jurusan" class="form-control">
        <option value="">-- Pilih --</option>
        <?php foreach ($jurusan as $j): ?>
          <option value="<?= $j->id_jurusan ?>" <?= set_select('id_jurusan', $j->id_jurusan, isset($row) && $row && $row->id_jurusan == $j->id_jurusan) ?>><?= html_escape($j->nama_jurusan) ?></option>
        <?php endforeach; ?>
      </select>
      <small class="text-danger"><?= form_error('id_jurusan') ?></small>
    </div>
    <div class="form-group col-md-4">
      <label>Angkatan</label>
      <input type="text" name="angkatan" class="form-control" maxlength="4" value="<?= set_value('angkatan', $row->angkatan ?? date('Y')) ?>">
      <small class="text-danger"><?= form_error('angkatan') ?></small>
    </div>
  </div>
  <div class="form-group">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control" rows="2"><?= set_value('alamat', $row->alamat ?? '') ?></textarea>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>Email</label>
      <input type="text" name="email" class="form-control" value="<?= set_value('email', $row->email ?? '') ?>">
      <small class="text-danger"><?= form_error('email') ?></small>
    </div>
    <div class="form-group col-md-6">
      <label>Telepon</label>
      <input type="text" name="telepon" class="form-control" value="<?= set_value('telepon', $row->telepon ?? '') ?>">
    </div>
  </div>
  <button class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/mahasiswa') ?>" class="btn btn-secondary">Batal</a>
<?= form_close() ?>
</div></div>
