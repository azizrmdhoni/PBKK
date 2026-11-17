<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="status"><?= icon('check-circle', 18) ?><span><?= esc(session()->getFlashdata('success')) ?></span></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error" role="alert"><?= icon('alert', 18) ?><span><?= esc(session()->getFlashdata('error')) ?></span></div>
<?php endif; ?>
