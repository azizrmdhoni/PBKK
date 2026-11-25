<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<?php
$errors = session('errors') ?? [];
$bad    = static fn (string $f) => isset($errors[$f]) ? ' invalid' : '';
$aria   = static fn (string $f) => isset($errors[$f]) ? 'aria-invalid="true" aria-describedby="' . $f . '-err"' : '';
$fb     = static fn (string $f) => isset($errors[$f]) ? '<p class="field-error" id="' . $f . '-err">' . esc($errors[$f]) . '</p>' : '';
?>

<h1>Buat akun ShopEase</h1>
<p class="auth-sub">Sudah punya akun? <a href="<?= site_url('login') ?>">Masuk</a></p>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error" role="alert"><?= icon('alert', 18) ?><span><?= esc(session()->getFlashdata('error')) ?></span></div>
<?php endif; ?>

<form action="<?= site_url('register') ?>" method="post" novalidate data-once>
    <?= csrf_field() ?>

    <div class="field">
        <label class="label" for="name">Nama lengkap</label>
        <div class="input<?= $bad('name') ?>">
            <?= icon('user', 18) ?>
            <input type="text" id="name" name="name" value="<?= esc(old('name')) ?>" placeholder="Nama sesuai identitas"
                   autocomplete="name" autofocus required <?= $aria('name') ?>>
        </div>
        <?= $fb('name') ?>
    </div>

    <div class="field">
        <label class="label" for="email">Email</label>
        <div class="input<?= $bad('email') ?>">
            <?= icon('mail', 18) ?>
            <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" placeholder="nama@email.com"
                   autocomplete="email" required <?= $aria('email') ?>>
        </div>
        <?= $fb('email') ?>
    </div>

    <div class="field">
        <label class="label" for="phone">Nomor telepon <span class="opt">(opsional)</span></label>
        <div class="input<?= $bad('phone') ?>">
            <?= icon('phone', 18) ?>
            <input type="tel" id="phone" name="phone" value="<?= esc(old('phone')) ?>" placeholder="081234567890"
                   inputmode="tel" autocomplete="tel" <?= $aria('phone') ?>>
        </div>
        <?= $fb('phone') ?>
    </div>

    <div class="field">
        <label class="label" for="password">Password</label>
        <div class="input<?= $bad('password') ?>">
            <?= icon('lock', 18) ?>
            <input type="password" id="password" name="password" placeholder="Buat password" autocomplete="new-password"
                   required data-rules-for="pw-rules" <?= $aria('password') ?>>
            <button type="button" class="toggle" data-toggle-password="password" aria-label="Tampilkan password" aria-pressed="false"><?= icon('eye', 20) ?></button>
        </div>
        <?= $fb('password') ?>
        <ul class="checklist" id="pw-rules" aria-label="Syarat password">
            <li data-rule="len"><?= icon('circle', 16) ?> Minimal 8 karakter</li>
            <li data-rule="alpha"><?= icon('circle', 16) ?> Ada huruf</li>
            <li data-rule="digit"><?= icon('circle', 16) ?> Ada angka</li>
        </ul>
    </div>

    <div class="field">
        <label class="label" for="password_confirm">Ulangi password</label>
        <div class="input<?= $bad('password_confirm') ?>">
            <?= icon('shield', 18) ?>
            <input type="password" id="password_confirm" name="password_confirm" placeholder="Ketik ulang password"
                   autocomplete="new-password" required <?= $aria('password_confirm') ?>>
            <button type="button" class="toggle" data-toggle-password="password_confirm" aria-label="Tampilkan password" aria-pressed="false"><?= icon('eye', 20) ?></button>
        </div>
        <?= $fb('password_confirm') ?>
    </div>

    <button type="submit" class="btn btn-primary btn-lg btn-block" data-loading-text="Membuat akun...">Buat akun</button>
</form>
<?= $this->endSection() ?>
