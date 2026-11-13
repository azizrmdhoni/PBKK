<div class="page-head"><div><h4>Kelola Produk</h4><div class="crumb">Tambah, ubah, dan hapus produk toko</div></div>
  <a href="<?= site_url('produk/tambah'); ?>" class="btn btn-primary"><i class="bi bi-plus-lg mr-1"></i> Tambah Produk</a></div>
<div class="card-lite">
  <div class="table-responsive"><table class="table-modern table" id="tbl">
    <thead><tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th class="text-right">Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($produk as $p): ?>
      <tr>
        <td><div class="d-flex align-items-center" style="gap:.8rem"><img class="dt-img" src="<?= gambar_produk($p); ?>" alt=""><b><?= html_escape($p['nama']); ?></b></div></td>
        <td><span class="badge-soft bs-secondary"><?= html_escape($p['kategori']); ?></span></td>
        <td data-order="<?= $p['harga']; ?>"><?= rupiah($p['harga']); ?></td>
        <td data-order="<?= $p['stok']; ?>"><span class="badge-soft <?= $p['stok'] <= 5 ? 'bs-danger' : ($p['stok'] <= 10 ? 'bs-warning' : 'bs-success'); ?>"><?= $p['stok']; ?></span></td>
        <td class="text-right" style="white-space:nowrap">
          <a href="<?= site_url('produk/ubah/' . $p['id']); ?>" class="btn btn-light-soft btn-sm"><i class="bi bi-pencil-square"></i> Ubah</a>
          <a href="<?= site_url('produk/hapus/' . $p['id']); ?>" data-confirm="Produk “<?= html_escape($p['nama']); ?>” akan dihapus permanen." class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table></div>
</div>
<script>
window.addEventListener('load', function () {
  $('#tbl').DataTable({order: [], language: {search: 'Cari:', lengthMenu: 'Tampilkan _MENU_', info: 'Menampilkan _START_–_END_ dari _TOTAL_ produk',
    paginate: {previous: '‹', next: '›'}, emptyTable: 'Belum ada produk', zeroRecords: 'Tidak ditemukan', infoEmpty: ''}, columnDefs: [{orderable: false, targets: 4}]});
});
</script>
