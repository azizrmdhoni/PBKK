<div class="card" style="max-width:600px"><div class="card-body">
<?= form_open() ?>
  <div class="form-group">
    <label>Mahasiswa</label>
    <select name="nim" class="form-control">
      <option value="">-- Pilih --</option>
      <?php foreach ($mahasiswa as $m): ?>
        <option value="<?= $m->nim ?>" <?= set_select('nim', $m->nim) ?>><?= $m->nim ?> - <?= html_escape($m->nama) ?></option>
      <?php endforeach; ?>
    </select>
    <small class="text-danger"><?= form_error('nim') ?></small>
  </div>
  <div class="form-group">
    <label>Mata Kuliah</label>
    <select name="kode_mk" class="form-control">
      <option value="">-- Pilih --</option>
      <?php foreach ($matakuliah as $m): ?>
        <option value="<?= $m->kode_mk ?>" <?= set_select('kode_mk', $m->kode_mk) ?>><?= $m->kode_mk ?> - <?= html_escape($m->nama_mk) ?> (<?= $m->sks ?> SKS)</option>
      <?php endforeach; ?>
    </select>
    <small class="text-danger"><?= form_error('kode_mk') ?></small>
  </div>
  <div class="form-group">
    <label>Tahun Ajaran</label>
    <input type="text" name="tahun_ajaran" class="form-control" placeholder="2024/2025" value="<?= set_value('tahun_ajaran') ?>">
    <small class="text-danger"><?= form_error('tahun_ajaran') ?></small>
  </div>
  <button class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/krs') ?>" class="btn btn-secondary">Batal</a>
<?= form_close() ?>
</div></div>
