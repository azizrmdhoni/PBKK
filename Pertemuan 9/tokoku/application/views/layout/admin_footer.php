  </div>
</div>
<?php $this->load->view('layout/scripts', ['datatables' => !empty($datatables)]); ?>
<script>
$('#toggle,#backdrop').on('click', function(){ $('#sidebar,#backdrop').toggleClass('show'); });
</script>
</body>
</html>
