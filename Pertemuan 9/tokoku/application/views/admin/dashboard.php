<div class="page-head"><div><h4>Dashboard</h4><div class="crumb">Ringkasan performa toko Anda</div></div>
  <a href="<?= site_url('produk/tambah'); ?>" class="btn btn-primary"><i class="bi bi-plus-lg mr-1"></i> Tambah Produk</a></div>
<div class="row">
  <?php foreach ([['Total Produk', $n_produk, 'bi-box-seam-fill', 'ic-blue'], ['Total Pesanan', $n_pesanan, 'bi-receipt-cutoff', 'ic-violet'],
                  ['Pelanggan', $n_pelanggan, 'bi-people-fill', 'ic-amber'], ['Omzet', rupiah($omzet), 'bi-cash-stack', 'ic-green']] as $k): ?>
  <div class="col-sm-6 col-xl-3 mb-4"><div class="card-lite stat"><span class="ico <?= $k[3]; ?>"><i class="bi <?= $k[2]; ?>"></i></span>
    <div><small><?= $k[0]; ?></small><h3><?= $k[1]; ?></h3></div></div></div>
  <?php endforeach; ?>
</div>
<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card-lite">
      <div class="card-head">Pesanan Terbaru <a class="btn btn-light-soft btn-sm" href="<?= site_url('pesanan'); ?>">Lihat semua</a></div>
      <div class="table-responsive"><table class="table-modern table">
        <thead><tr><th>Kode</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr></thead>
        <tbody><?php foreach ($terbaru as $p): ?>
          <tr><td><a class="font-weight-bold" href="<?= site_url('pesanan/detail/' . $p['id']); ?>"><?= $p['kode']; ?></a></td>
            <td><?= html_escape($p['pelanggan']); ?></td><td><?= rupiah($p['total']); ?></td><td><?= badge_status($p['status']); ?></td></tr>
        <?php endforeach; ?></tbody></table></div>
      <?php if (!$terbaru): ?><div class="empty"><i class="bi bi-inbox"></i>Belum ada pesanan</div><?php endif; ?>
    </div>
  </div>
  <div class="col-lg-4 mb-4">
    <div class="card-lite mb-4">
      <div class="card-head">Status Pesanan</div>
      <div class="card-pad"><?php if ($status): ?><div style="max-width:230px;margin:0 auto"><canvas id="chartStatus"></canvas></div><?php else: ?><div class="empty"><i class="bi bi-pie-chart"></i>Belum ada data</div><?php endif; ?></div>
    </div>
    <div class="card-lite">
      <div class="card-head">Stok Menipis</div>
      <div class="card-pad pt-2">
        <?php foreach ($menipis as $m): ?>
          <div class="d-flex align-items-center py-2" style="gap:.7rem"><img class="dt-img" src="<?= gambar_produk($m); ?>" alt="">
            <div class="flex-fill" style="line-height:1.2"><b><?= html_escape($m['nama']); ?></b></div>
            <span class="badge-soft <?= $m['stok'] <= 5 ? 'bs-danger' : 'bs-warning'; ?>"><?= $m['stok']; ?> pcs</span></div>
        <?php endforeach; ?>
        <?php if (!$menipis): ?><p class="text-muted mb-0">Semua stok aman 👍</p><?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php if ($status): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>
<script>
new Chart(document.getElementById('chartStatus'), {type:'doughnut',
  data:{labels:<?= json_encode(array_column($status, 'status')); ?>,
        datasets:[{data:<?= json_encode(array_map('intval', array_column($status, 'n'))); ?>,
        backgroundColor:['#f59e0b','#3b82f6','#8b5cf6','#06b6d4','#22c55e','#ef4444'],borderWidth:0}]},
  options:{cutout:'66%',plugins:{legend:{position:'bottom',labels:{boxWidth:10,usePointStyle:true}}}}});
</script>
<?php endif; ?>
