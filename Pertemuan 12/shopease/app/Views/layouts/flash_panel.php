<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="status"><?= icon('check-circle', 18) ?><span><?= esc(session()->getFlashdata('success')) ?></span></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error" role="alert"><?= icon('alert', 18) ?><span><?= esc(session()->getFlashdata('error')) ?></span></div>
<?php endif; ?>
<?php
$flashWarning = session()->getFlashdata('warning');
if ($flashWarning):
    $flashWarning = (array) $flashWarning;
?>
    <div class="alert alert-info" role="status">
        <?= icon('alert', 18) ?>
        <div>
            <strong>Sebagian file tidak diunggah:</strong>
            <ul class="flash-list">
                <?php foreach ($flashWarning as $warning): ?>
                    <li><?= esc($warning) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
