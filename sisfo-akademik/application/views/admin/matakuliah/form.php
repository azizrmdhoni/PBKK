<div class="card" style="max-width:640px"><div class="card-body">
<?= form_open() ?>
  <div class="form-group">
    <label>Kode MK</label>
    <input type="text" name="kode_mk" class="form-control" value="<?= set_value('kode_mk', $row->kode_mk ?? '') ?>" <?= $row ? 'readonly' : '' ?>>
    <small class="text-danger"><?= form_error('kode_mk') ?></small>
  </div>
  <div class="form-group">
    <label>Nama Mata Kuliah</label>
    <input type="text" name="nama_mk" class="form-control" value="<?= set_value('nama_mk', $row->nama_mk ?? '') ?>">
    <small class="text-danger"><?= form_error('nama_mk') ?></small>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>SKS</label>
      <input type="number" name="sks" class="form-control" value="<?= set_value('sks', $row->sks ?? '') ?>">
      <small class="text-danger"><?= form_error('sks') ?></small>
    </div>
    <div class="form-group col-md-6">
      <label>Semester</label>
      <input type="number" name="semester" class="form-control" value="<?= set_value('semester', $row->semester ?? '') ?>">
      <small class="text-danger"><?= form_error('semester') ?></small>
    </div>
  </div>
  <div class="form-group">
    <label>Jurusan</label>
    <select name="id_jurusan" class="form-control">
      <option value="">-- Pilih --</option>
      <?php foreach ($jurusan as $j): ?>
        <option value="<?= $j->id_jurusan ?>" <?= set_select('id_jurusan', $j->id_jurusan, $row && $row->id_jurusan == $j->id_jurusan) ?>><?= html_escape($j->nama_jurusan) ?></option>
      <?php endforeach; ?>
    </select>
    <small class="text-danger"><?= form_error('id_jurusan') ?></small>
  </div>
  <div class="form-group">
    <label>Dosen Pengampu</label>
    <select name="nidn" class="form-control">
      <option value="">-- Belum ditentukan --</option>
      <?php foreach ($dosen as $d): ?>
        <option value="<?= $d->nidn ?>" <?= set_select('nidn', $d->nidn, $row && $row->nidn == $d->nidn) ?>><?= html_escape($d->nama) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/matakuliah') ?>" class="btn btn-secondary">Batal</a>
<?= form_close() ?>
</div></div>
