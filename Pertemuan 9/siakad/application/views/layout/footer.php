    <div class="app-foot">&copy; <?= date('Y'); ?> SIAKAD Kampus &middot; Tahun Akademik 2026/2027 &middot; Latihan CodeIgniter 3</div>
  </div>
</div>
<?php $this->load->view('layout/scripts', ['datatables' => !empty($datatables)]); ?>
<script>$('#toggle,#backdrop').on('click', function(){ $('#sidebar,#backdrop').toggleClass('show'); });</script>
</body>
</html>
