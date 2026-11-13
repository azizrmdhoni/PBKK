<div class="page-head"><div><h4><?= $row ? 'Ubah' : 'Tambah'; ?> <?= $judul; ?></h4>
  <div class="crumb"><a href="<?= site_url($ctrl); ?>"><?= $judul; ?></a> / <?= $row ? 'Ubah' : 'Tambah'; ?></div></div></div>
<div class="row"><div class="col-lg-8">
<div class="card-lite card-pad">
  <?= form_open(current_url()); ?>
  <div class="form-row">
  <?php foreach ($fields as $f => $c): $val = set_value($f, isset($row[$f]) ? $row[$f] : ''); ?>
    <div class="form-group col-md-6">
      <label><?= $c['label']; ?></label>
      <?php if ($c['type'] == 'select'): ?>
        <select name="<?= $f; ?>" class="custom-select">
          <option value="">— pilih —</option>
          <?php foreach ($opsi[$f] as $k => $v): ?>
            <option value="<?= html_escape($k); ?>" <?= (string)$val === (string)$k ? 'selected' : ''; ?>><?= html_escape($v); ?></option>
          <?php endforeach; ?>
        </select>
      <?php else: ?>
        <input type="<?= $c['type']; ?>" name="<?= $f; ?>" value="<?= $val; ?>" class="form-control">
      <?php endif; ?>
      <?= form_error($f, '<span class="invalid-msg">', '</span>'); ?>
    </div>
  <?php endforeach; ?>
  </div>
  <?php if (in_array($ctrl, ['mahasiswa', 'dosen']) && !$row): ?>
    <div class="alert alert-info py-2"><i class="bi bi-info-circle mr-1"></i> Akun login dibuat otomatis. Username dan password awal = <?= $ctrl == 'mahasiswa' ? 'NIM' : 'NIDN'; ?>.</div>
  <?php endif; ?>
  <div class="mt-2"><button class="btn btn-primary px-4"><i class="bi bi-check2-circle mr-1"></i> Simpan</button>
    <a href="<?= site_url($ctrl); ?>" class="btn btn-light-soft ml-2">Batal</a></div>
  <?= form_close(); ?>
</div></div></div>
