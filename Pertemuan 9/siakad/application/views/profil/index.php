<div class="page-head"><div><h4>Profil Saya</h4><div class="crumb">Data pribadi dan foto mahasiswa</div></div></div>
<div class="row">
  <div class="col-lg-4 mb-4"><div class="card-lite card-pad text-center">
    <?php if ($m['foto']): ?><img id="pv" class="photo mb-3" src="<?= base_url('uploads/foto/' . $m['foto']); ?>" alt="">
    <?php else: ?><div id="pvbox" class="photo mb-3 mx-auto d-grid" style="display:grid;place-items:center;font-size:3.5rem;font-weight:800;color:#94a3b8"><?= inisial($m['nama']); ?></div><img id="pv" class="photo mb-3 d-none" alt=""><?php endif; ?>
    <h5 class="mb-0"><?= html_escape($m['nama']); ?></h5><span class="text-muted"><?= $m['nim']; ?></span>
  </div></div>
  <div class="col-lg-8 mb-4">
    <div class="card-lite card-pad mb-4">
      <h6 class="mb-3">Informasi Akademik</h6>
      <div class="kv"><span>NIM</span><b><?= $m['nim']; ?></b></div>
      <div class="kv"><span>Nama</span><b><?= html_escape($m['nama']); ?></b></div>
      <div class="kv"><span>Program Studi</span><b><?= html_escape($m['prodi']); ?></b></div>
      <div class="kv"><span>Angkatan</span><b><?= $m['angkatan']; ?></b></div>
    </div>
    <div class="card-lite card-pad">
      <h6 class="mb-3">Ganti Foto</h6>
      <?php if ($err): ?><div class="alert alert-danger py-2"><?= html_escape($err); ?></div><?php endif; ?>
      <?= form_open_multipart('profil'); ?>
        <div class="form-group"><input type="file" name="foto" id="foto" class="form-control-file" accept="image/*" required>
          <small class="text-muted">JPG / PNG, maksimal 2MB.</small></div>
        <button class="btn btn-primary"><i class="bi bi-cloud-upload mr-1"></i> Unggah Foto</button>
      <?= form_close(); ?>
    </div>
  </div>
</div>
<script>
document.getElementById('foto').addEventListener('change', function () {
  if (!this.files[0]) return;
  var pv = document.getElementById('pv'); pv.src = URL.createObjectURL(this.files[0]); pv.classList.remove('d-none');
  var b = document.getElementById('pvbox'); if (b) b.classList.add('d-none');
});
</script>
