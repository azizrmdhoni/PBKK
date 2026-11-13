<div class="card" style="max-width:480px"><div class="card-body">
<?= form_open('portal/password') ?>
  <div class="form-group"><label>Password lama</label>
    <input type="password" name="lama" class="form-control"><small class="text-danger"><?= form_error('lama') ?></small></div>
  <div class="form-group"><label>Password baru</label>
    <input type="password" name="baru" class="form-control"><small class="text-danger"><?= form_error('baru') ?></small></div>
  <div class="form-group"><label>Konfirmasi password baru</label>
    <input type="password" name="konfirmasi" class="form-control"><small class="text-danger"><?= form_error('konfirmasi') ?></small></div>
  <button class="btn btn-primary">Simpan</button>
<?= form_close() ?>
</div></div>
