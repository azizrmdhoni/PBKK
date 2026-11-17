<?php
$flashOk  = session()->getFlashdata('success');
$flashErr = session()->getFlashdata('error');
?>
<?php if ($flashOk || $flashErr): ?>
    <div class="container flash-wrap">
        <?php if ($flashOk): ?>
            <div class="alert alert-success" role="status"><?= icon('check-circle', 18) ?><span><?= esc($flashOk) ?></span></div>
        <?php endif; ?>
        <?php if ($flashErr): ?>
            <div class="alert alert-error" role="alert"><?= icon('alert', 18) ?><span><?= esc($flashErr) ?></span></div>
        <?php endif; ?>
    </div>
<?php endif; ?>
