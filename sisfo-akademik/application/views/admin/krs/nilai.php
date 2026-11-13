<div class="card" style="max-width:520px"><div class="card-body">
  <p class="mb-1"><strong><?= $mhs->nim ?> - <?= html_escape($mhs->nama) ?></strong></p>
  <p class="text-muted"><?= html_escape($mk->nama_mk) ?> (<?= $row->tahun_ajaran ?>)</p>
  <?= form_open() ?>
    <div class="form-group">
      <label>Nilai Huruf</label>
      <select name="nilai" class="form-control">
        <option value="">-- Pilih --</option>
        <?php foreach (['A','B','C','D','E'] as $n): ?>
          <option value="<?= $n ?>" <?= set_select('nilai', $n, $row->nilai == $n) ?>><?= $n ?></option>
        <?php endforeach; ?>
      </select>
      <small class="text-danger"><?= form_error('nilai') ?></small>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="<?= site_url('admin/krs') ?>" class="btn btn-secondary">Batal</a>
  <?= form_close() ?>
</div></div>
