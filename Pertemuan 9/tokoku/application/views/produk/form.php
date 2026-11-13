<div class="page-head"><div><h4><?= $title; ?></h4><div class="crumb"><a href="<?= site_url('produk'); ?>">Produk</a> / <?= $title; ?></div></div></div>
<?php if ($err): ?><div class="alert alert-danger"><?= html_escape($err); ?></div><?php endif; ?>
<?= form_open_multipart(current_url()); ?>
<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card-lite card-pad">
      <div class="form-group"><label>Nama produk</label>
        <input name="nama" class="form-control" value="<?= set_value('nama', isset($row['nama']) ? $row['nama'] : ''); ?>">
        <?= form_error('nama', '<span class="invalid-msg">', '</span>'); ?></div>
      <div class="form-group"><label>Kategori</label>
        <select name="kategori_id" class="custom-select">
          <option value="">— pilih kategori —</option>
          <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id']; ?>" <?= set_value('kategori_id', isset($row['kategori_id']) ? $row['kategori_id'] : '') == $k['id'] ? 'selected' : ''; ?>><?= html_escape($k['nama']); ?></option>
          <?php endforeach; ?>
        </select><?= form_error('kategori_id', '<span class="invalid-msg">', '</span>'); ?></div>
      <div class="form-group"><label>Deskripsi</label>
        <textarea name="deskripsi" rows="5" class="form-control"><?= set_value('deskripsi', isset($row['deskripsi']) ? $row['deskripsi'] : ''); ?></textarea></div>
      <div class="form-row">
        <div class="form-group col-md-6"><label>Harga (Rp)</label>
          <input name="harga" class="form-control" value="<?= set_value('harga', isset($row['harga']) ? $row['harga'] : ''); ?>">
          <?= form_error('harga', '<span class="invalid-msg">', '</span>'); ?></div>
        <div class="form-group col-md-6"><label>Stok</label>
          <input name="stok" class="form-control" value="<?= set_value('stok', isset($row['stok']) ? $row['stok'] : ''); ?>">
          <?= form_error('stok', '<span class="invalid-msg">', '</span>'); ?></div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 mb-4">
    <div class="card-lite card-pad">
      <label>Gambar produk</label>
      <img id="pv" class="preview mb-3" src="<?= !empty($row) ? gambar_produk($row) : base_url('assets/img/kategori/0.svg'); ?>" alt="">
      <input type="file" name="gambar" id="gambar" class="form-control-file" accept="image/*">
      <small class="text-muted d-block mt-2">JPG / PNG, maks 2MB.<?= !empty($row['gambar']) ? ' Kosongkan jika tidak ingin mengganti.' : ' Jika kosong, ilustrasi kategori dipakai.'; ?></small>
    </div>
    <div class="mt-3 d-flex" style="gap:.6rem">
      <button class="btn btn-primary flex-fill"><i class="bi bi-check2-circle mr-1"></i> Simpan</button>
      <a href="<?= site_url('produk'); ?>" class="btn btn-light-soft">Batal</a>
    </div>
  </div>
</div>
<?= form_close(); ?>
<script>
document.getElementById('gambar').addEventListener('change', function () {
  if (this.files[0]) document.getElementById('pv').src = URL.createObjectURL(this.files[0]);
});
</script>
