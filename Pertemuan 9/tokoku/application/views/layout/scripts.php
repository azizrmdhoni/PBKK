<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (!empty($datatables)): ?>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.8/js/dataTables.bootstrap4.min.js"></script>
<?php endif; ?>
<script>
var Toast = Swal.mixin({toast:true, position:'top-end', showConfirmButton:false, timer:3200, timerProgressBar:true});
<?php $J = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT; ?>
<?php if ($m = $this->session->flashdata('pesan')): ?>Toast.fire({icon:'success', title:<?= json_encode($m, $J); ?>});<?php endif; ?>
<?php if (empty($no_error_toast) && ($m = $this->session->flashdata('error'))): ?>Toast.fire({icon:'error', title:<?= json_encode($m, $J); ?>, timer:4500});<?php endif; ?>
$(document).on('click', '[data-confirm]', function (e) {
  e.preventDefault(); var href = this.href;
  Swal.fire({title:'Konfirmasi', text:$(this).data('confirm'), icon:'warning', showCancelButton:true,
    confirmButtonText:'Ya, lanjutkan', cancelButtonText:'Batal', confirmButtonColor:'#ea580c', reverseButtons:true})
    .then(function (r) { if (r.isConfirmed) location.href = href; });
});
$(document).on('click', '.qty-stepper [data-step]', function () {
  var i = $(this).siblings('input'), v = parseInt(i.val() || 1) + parseInt($(this).data('step')),
      min = parseInt(i.attr('min') || 0), max = parseInt(i.attr('max') || 9999);
  i.val(Math.max(min, Math.min(max, v)));
});
$(document).on('click', '.toggle-pass', function () {
  var i = $(this).siblings('input'); i.attr('type', i.attr('type') == 'password' ? 'text' : 'password');
  $(this).toggleClass('bi-eye bi-eye-slash');
});
</script>
