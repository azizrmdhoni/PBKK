<div class="page-head"><div><h4>Pesanan</h4><div class="crumb">Kelola seluruh pesanan pelanggan</div></div></div>
<div class="card-lite">
  <div class="table-responsive"><table class="table-modern table" id="tbl">
    <thead><tr><th>Kode</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($pesanan as $p): ?>
      <tr><td class="font-weight-bold"><?= $p['kode']; ?></td><td><?= html_escape($p['pelanggan']); ?></td><td><?= $p['tanggal']; ?></td>
        <td data-order="<?= $p['total']; ?>"><?= rupiah($p['total']); ?></td><td><?= badge_status($p['status']); ?></td>
        <td class="text-right"><a class="btn btn-light-soft btn-sm" href="<?= site_url('pesanan/detail/' . $p['id']); ?>"><i class="bi bi-eye"></i> Detail</a></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table></div>
</div>
<script>
window.addEventListener('load', function () {
  $('#tbl').DataTable({order: [], language: {search: 'Cari:', lengthMenu: 'Tampilkan _MENU_', info: 'Menampilkan _START_–_END_ dari _TOTAL_ pesanan',
    paginate: {previous: '‹', next: '›'}, emptyTable: 'Belum ada pesanan', zeroRecords: 'Tidak ditemukan', infoEmpty: ''}, columnDefs: [{orderable: false, targets: 5}]});
});
</script>
