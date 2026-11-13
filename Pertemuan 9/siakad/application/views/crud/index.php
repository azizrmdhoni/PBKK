<div class="page-head"><div><h4>Data <?= $judul; ?></h4><div class="crumb">Kelola data master <?= strtolower($judul); ?></div></div>
  <a href="<?= site_url($ctrl . '/tambah'); ?>" class="btn btn-primary"><i class="bi bi-plus-lg mr-1"></i> Tambah <?= $judul; ?></a></div>
<div class="card-lite">
  <div class="table-responsive"><table class="table-modern table" id="tbl">
    <thead><tr><th width="50">No</th><?php foreach ($kolom as $label): ?><th><?= $label; ?></th><?php endforeach; ?><th class="text-right" width="150">Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $n => $r): ?>
      <tr>
        <td><?= $n + 1; ?></td>
        <?php foreach ($kolom as $k => $label): ?><td><?= html_escape($r[$k]); ?></td><?php endforeach; ?>
        <td class="text-right" style="white-space:nowrap">
          <a href="<?= site_url($ctrl . '/ubah/' . $r['id']); ?>" class="btn btn-light-soft btn-sm"><i class="bi bi-pencil-square"></i> Ubah</a>
          <a href="<?= site_url($ctrl . '/hapus/' . $r['id']); ?>" data-confirm="Data ini akan dihapus permanen beserta data terkaitnya." class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table></div>
</div>
<script>
window.addEventListener('load', function () {
  $('#tbl').DataTable({language: {search: 'Cari:', lengthMenu: 'Tampilkan _MENU_', info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
    paginate: {previous: '‹', next: '›'}, emptyTable: 'Belum ada data', zeroRecords: 'Tidak ditemukan', infoEmpty: ''},
    order: [], columnDefs: [{orderable: false, targets: [0, -1]}]});
});
</script>
