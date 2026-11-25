<?php
/**
 * Form kategori, dipakai bersama oleh create.php dan edit.php.
 *
 * @var array|null $category null saat tambah kategori
 */
$category = $category ?? null;
$isEdit   = $category !== null;
$errors   = session()->getFlashdata('errors') ?? [];

$val        = static fn (string $key, $default = ''): string => esc((string) (old($key, null, false) ?? $default));
$invalid    = static fn (string $key): string => isset($errors[$key]) ? ' invalid' : '';
$fieldError = static fn (string $key): string => isset($errors[$key])
    ? '<p class="field-error">' . esc($errors[$key]) . '</p>'
    : '';

$action = $isEdit
    ? site_url('admin/categories/update/' . $category['id_category'])
    : site_url('admin/categories/store');
?>
<form action="<?= $action ?>" method="post" data-once>
    <?= csrf_field() ?>
    <section class="card card-narrow">
        <div class="card-head"><h2><?= $isEdit ? 'Ubah kategori' : 'Kategori baru' ?></h2></div>
        <div class="card-body">
            <div class="field">
                <label class="label" for="name">Nama kategori</label>
                <input type="text" id="name" name="name" class="control<?= $invalid('name') ?>" required minlength="3" maxlength="100"
                       value="<?= $val('name', $category['name'] ?? '') ?>" placeholder="Contoh: Elektronik">
                <?= $fieldError('name') ?>
            </div>
            <div class="field">
                <label class="label" for="description">Deskripsi <span class="opt">(opsional)</span></label>
                <textarea id="description" name="description" class="control<?= $invalid('description') ?>" rows="4" maxlength="1000"
                          placeholder="Ringkasan jenis produk dalam kategori ini"><?= $val('description', $category['description'] ?? '') ?></textarea>
                <?= $fieldError('description') ?>
            </div>
            <?php if ($isEdit): ?>
                <p class="hint">Slug saat ini: <code><?= esc($category['slug']) ?></code>. Slug berubah otomatis bila nama diganti.</p>
            <?php endif; ?>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary" data-loading-text="Menyimpan..."><?= icon('save', 17) ?> <?= $isEdit ? 'Update Kategori' : 'Simpan Kategori' ?></button>
            <a href="<?= site_url('admin/categories') ?>" class="btn btn-ghost">Batal</a>
        </div>
    </section>
</form>
