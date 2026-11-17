<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<?php
$errors = session('errors') ?? [];
$err    = static fn (string $f) => $errors[$f] ?? null;
?>

<h1>Masuk ke akun Anda</h1>
<p class="auth-sub">Belum punya akun? <a href="<?= site_url('register') ?>">Daftar gratis</a></p>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="status"><?= icon('check-circle', 18) ?><span><?= esc(session()->getFlashdata('success')) ?></span></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error" role="alert"><?= icon('alert', 18) ?><span><?= esc(session()->getFlashdata('error')) ?></span></div>
<?php endif; ?>

<form action="<?= site_url('login') ?>" method="post" novalidate data-once>
    <?= csrf_field() ?>

    <div class="field">
        <label class="label" for="email">Email</label>
        <div class="input<?= $err('email') ? ' invalid' : '' ?>">
            <?= icon('mail', 18) ?>
            <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" placeholder="nama@email.com"
                   autocomplete="email" autofocus required <?= $err('email') ? 'aria-invalid="true" aria-describedby="email-err"' : '' ?>>
        </div>
        <?php if ($err('email')): ?><p class="field-error" id="email-err"><?= esc($err('email')) ?></p><?php endif; ?>
    </div>

    <div class="field">
        <label class="label" for="password">Password</label>
        <div class="input<?= $err('password') ? ' invalid' : '' ?>">
            <?= icon('lock', 18) ?>
            <input type="password" id="password" name="password" placeholder="Masukkan password"
                   autocomplete="current-password" required <?= $err('password') ? 'aria-invalid="true" aria-describedby="password-err"' : '' ?>>
            <button type="button" class="toggle" data-toggle-password="password" aria-label="Tampilkan password" aria-pressed="false"><?= icon('eye', 20) ?></button>
        </div>
        <?php if ($err('password')): ?><p class="field-error" id="password-err"><?= esc($err('password')) ?></p><?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary btn-lg btn-block" data-loading-text="Memeriksa...">Masuk</button>
</form>

<?php if (ENVIRONMENT === 'development'): ?>
    <?php
    $demoPw = \App\Database\Seeds\UserSeeder::DEFAULT_PASSWORD;
    $badge  = ['admin' => 'badge-green', 'operator' => 'badge-terra', 'customer' => 'badge-gold'];
    ?>
    <div class="demo">
        <div class="demo-head">Akun uji <span>(hanya tampil di mode development)</span></div>
        <?php foreach (\App\Database\Seeds\UserSeeder::ACCOUNTS as $acc): ?>
            <div class="demo-row">
                <span class="badge <?= esc($badge[$acc['role']] ?? '') ?>"><?= esc($acc['role']) ?></span>
                <code><?= esc($acc['email']) ?></code>
                <button type="button" class="btn btn-sm btn-ghost" data-fill-email="<?= esc($acc['email']) ?>" data-fill-pw="<?= esc($demoPw) ?>">Isi</button>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
