<?php
$namaHari = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];
$bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$hariIni = $namaHari[(int)date('N')];
$tgl = $hariIni . ', ' . date('j') . ' ' . $bulan[(int)date('n')] . ' ' . date('Y');
$sub = ['admin' => 'Pantau data akademik dan kelola data master kampus dari satu tempat.',
        'dosen' => 'Berikut jadwal mengajar dan kelas yang Anda ampu semester ini.',
        'mahasiswa' => 'Ringkasan studi dan jadwal kuliah Anda semester ini.'][$role];
$icons = ['Mahasiswa' => ['bi-people-fill', 'ic-blue'], 'Dosen' => ['bi-person-badge-fill', 'ic-violet'], 'Mata Kuliah' => ['bi-journal-bookmark-fill', 'ic-amber'],
  'Kelas' => ['bi-calendar-week-fill', 'ic-green'], 'Kelas Diampu' => ['bi-easel2-fill', 'ic-blue'], 'Total Peserta' => ['bi-people-fill', 'ic-green'],
  'IPK' => ['bi-award-fill', 'ic-amber'], 'SKS Lulus' => ['bi-check2-circle', 'ic-green'], 'SKS Berjalan' => ['bi-hourglass-split', 'ic-blue']];
?>
<div class="hero-a">
  <div>
    <span class="chip-ta"><i class="bi bi-calendar2-check"></i> Tahun Akademik 2026/2027</span>
    <h3>Selamat datang, <?= html_escape(explode(' ', $this->session->userdata('nama'))[0]); ?> 👋</h3>
    <p><?= $sub; ?></p>
  </div>
  <div class="hero-meta"><b>Hari ini</b><span><?= $tgl; ?></span></div>
</div>

<div class="row">
  <?php foreach ($stat as $label => $n): $ic = isset($icons[$label]) ? $icons[$label] : ['bi-bar-chart-fill', 'ic-blue']; ?>
    <div class="col-sm-6 col-xl-3 mb-4"><div class="card-lite stat"><span class="ico <?= $ic[1]; ?>"><i class="bi <?= $ic[0]; ?>"></i></span>
      <div><small><?= $label; ?></small><h3><?= $n; ?></h3></div></div></div>
  <?php endforeach; ?>
</div>

<?php if ($role == 'admin'): ?>
<div class="row">
  <div class="col-lg-7 mb-4"><div class="card-lite h-100">
    <div class="card-head">Mahasiswa per Program Studi</div>
    <div class="card-pad"><?php if ($per_prodi): ?><canvas id="chartProdi" height="150"></canvas><?php else: ?><div class="empty"><i class="bi bi-bar-chart"></i>Belum ada data</div><?php endif; ?></div>
  </div></div>
  <div class="col-lg-5 mb-4"><div class="card-lite h-100">
    <div class="card-head">Aksi Cepat</div>
    <div class="quick-grid">
      <a class="quick" href="<?= site_url('mahasiswa/tambah'); ?>"><span class="ico ic-blue"><i class="bi bi-person-plus-fill"></i></span>Tambah Mahasiswa</a>
      <a class="quick" href="<?= site_url('dosen/tambah'); ?>"><span class="ico ic-violet"><i class="bi bi-person-badge-fill"></i></span>Tambah Dosen</a>
      <a class="quick" href="<?= site_url('matakuliah/tambah'); ?>"><span class="ico ic-amber"><i class="bi bi-journal-plus"></i></span>Tambah Mata Kuliah</a>
      <a class="quick" href="<?= site_url('kelas/tambah'); ?>"><span class="ico ic-green"><i class="bi bi-calendar-plus"></i></span>Buat Kelas Baru</a>
    </div>
  </div></div>
</div>
<div class="card-lite mb-4">
  <div class="card-head">Kelas Terbaru <a class="btn btn-light-soft btn-sm" href="<?= site_url('kelas'); ?>">Lihat semua</a></div>
  <div class="table-responsive"><table class="table-modern table">
    <thead><tr><th>Mata Kuliah</th><th>Dosen Pengampu</th><th>Jadwal</th><th>Semester</th></tr></thead>
    <tbody><?php foreach ($kelas_baru as $k): ?>
      <tr><td><b><?= html_escape($k['matkul']); ?></b></td><td><?= html_escape($k['dosen']); ?></td>
        <td><span class="day-pill"><?= $k['hari']; ?></span> <small class="text-muted ml-1"><?= $k['jam']; ?></small></td><td><span class="badge-soft bs-secondary"><?= $k['semester']; ?></span></td></tr>
    <?php endforeach; ?></tbody></table></div>
  <?php if (!$kelas_baru): ?><div class="empty"><i class="bi bi-calendar-x"></i>Belum ada kelas</div><?php endif; ?>
</div>
<?php if ($per_prodi): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>
<script>
new Chart(document.getElementById('chartProdi'), {type:'bar',
  data:{labels:<?= json_encode(array_column($per_prodi, 'prodi')); ?>,
        datasets:[{label:'Mahasiswa',data:<?= json_encode(array_map('intval', array_column($per_prodi, 'n'))); ?>,backgroundColor:'#2f5bea',borderRadius:10,maxBarThickness:54}]},
  options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0},grid:{color:'#eef1f8'}},x:{grid:{display:false}}}}});
</script>
<?php endif; ?>

<?php else: ?>
<div class="row">
  <?php if ($role == 'mahasiswa'): $persen = min(100, round($stat['SKS Lulus'] / 144 * 100)); ?>
  <div class="col-lg-4 mb-4"><div class="card-lite h-100">
    <div class="card-head">Progres Studi</div>
    <div class="card-pad text-center">
      <div class="ring" style="--p:<?= $persen; ?>"><div><span><b><?= $persen; ?>%</b><small>tuntas</small></span></div></div>
      <p class="mt-3 mb-1"><b><?= $stat['SKS Lulus']; ?></b> dari <b>144</b> SKS</p>
      <small class="text-muted">Program Studi <?= html_escape($mhs['prodi']); ?><br>NIM <?= $mhs['nim']; ?> &middot; Angkatan <?= $mhs['angkatan']; ?></small>
    </div>
  </div></div>
  <?php endif; ?>
  <div class="<?= $role == 'mahasiswa' ? 'col-lg-8' : 'col-12'; ?> mb-4"><div class="card-lite h-100">
    <div class="card-head"><?= $role == 'dosen' ? 'Jadwal Mengajar' : 'Jadwal Kuliah'; ?>
      <?php if ($role == 'mahasiswa'): ?><a href="<?= site_url('krs'); ?>" class="btn btn-light-soft btn-sm"><i class="bi bi-card-checklist"></i> Kelola KRS</a><?php elseif ($role == 'dosen'): ?><a href="<?= site_url('nilai'); ?>" class="btn btn-light-soft btn-sm"><i class="bi bi-pencil-square"></i> Input Nilai</a><?php endif; ?></div>
    <?php if ($jadwal): ?>
    <div class="sched-grid">
      <?php foreach ($jadwal as $j): $today = $j['hari'] == $hariIni; ?>
        <div class="sched <?= $today ? 'today' : ''; ?>">
          <div class="d"><span class="day-pill"><?= $j['hari']; ?></span><?= $today ? '<span class="today-tag">HARI INI</span>' : ''; ?></div>
          <div class="t"><?= html_escape($j['matkul']); ?></div>
          <div class="m"><span><i class="bi bi-clock"></i><?= $j['jam']; ?></span><span><i class="bi bi-geo-alt"></i><?= html_escape($j['ruang']); ?></span></div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?><div class="empty"><i class="bi bi-calendar-x"></i>Belum ada jadwal<?= $role == 'mahasiswa' ? '. Silakan isi KRS terlebih dahulu.' : '.'; ?></div><?php endif; ?>
  </div></div>
</div>
<?php endif; ?>
