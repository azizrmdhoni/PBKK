<?php
/**
 * Form produk, dipakai bersama oleh create.php dan edit.php.
 *
 * @var array|null $product    null saat tambah produk
 * @var array      $categories
 * @var int        $maxImages
 * @var int|null   $slotsLeft  sisa kuota gambar (hanya saat edit)
 */


$product   = $product ?? null;
$isEdit    = $product !== null;
$slotsLeft = $slotsLeft ?? $maxImages;
$errors    = session()->getFlashdata('errors') ?? [];

// old() mengembalikan nilai input sebelumnya; $default (data produk) di-escape di sini.
$val     = static fn (string $key, $default = ''): string => esc((string) (old($key, null, false) ?? $default));
$invalid = static fn (string $key): string => isset($errors[$key]) ? ' invalid' : '';
$fieldError = static fn (string $key): string => isset($errors[$key])
    ? '<p class="field-error" id="err-' . esc($key, 'attr') . '">' . esc($errors[$key]) . '</p>'
    : '';

$action       = $isEdit ? site_url('admin/products/update/' . $product['id_product']) : site_url('admin/products/store');
$categoryNow  = $val('id_category', $product['id_category'] ?? '');
$statusNow    = $val('status', $product['status'] ?? 'tersedia');
$priceDefault = isset($product['price']) ? (string) (float) $product['price'] : '';
$stockDefault = $product['stock'] ?? 0;
?>

<?php if (! empty($errors)): ?>
    <div class="alert alert-error" role="alert">
        <?= icon('alert', 18) ?>
        <div>
            <strong>Periksa kembali isian Anda:</strong>
            <ul class="flash-list">
                <?php foreach ($errors as $message): ?>
                    <li><?= esc($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data" data-once>
    <?= csrf_field() ?>

    <div class="form-layout">
        <section class="card">
            <div class="card-head"><h2>Informasi produk</h2></div>
            <div class="card-body">
                <div class="field">
                    <label class="label" for="name">Nama produk</label>
                    <input type="text" id="name" name="name" class="control<?= $invalid('name') ?>" value="<?= $val('name', $product['name'] ?? '') ?>"
                           minlength="3" maxlength="150" required placeholder="Contoh: Sepatu Sneakers">
                    <?= $fieldError('name') ?>
                </div>

                <div class="form-grid">
                    <div class="field">
                        <label class="label" for="id_category">Kategori</label>
                        <select id="id_category" name="id_category" class="control<?= $invalid('id_category') ?>" required>
                            <option value="">Pilih kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= esc($category['id_category']) ?>" <?= $categoryNow === (string) $category['id_category'] ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= $fieldError('id_category') ?>
                        <?php if (empty($categories)): ?>
                            <p class="hint">Belum ada kategori. <a href="<?= site_url('admin/categories/create') ?>">Buat kategori dulu</a>.</p>
                        <?php endif; ?>
                    </div>
                    <div class="field">
                        <label class="label" for="status">Status produk</label>
                        <select id="status" name="status" class="control<?= $invalid('status') ?>" required>
                            <?php foreach (\App\Models\ProductModel::STATUSES as $code => $label): ?>
                                <option value="<?= esc($code) ?>" <?= $statusNow === $code ? 'selected' : '' ?>><?= esc($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= $fieldError('status') ?>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="description">Deskripsi <span class="opt">(opsional)</span></label>
                    <textarea id="description" name="description" class="control<?= $invalid('description') ?>" rows="5" maxlength="5000"
                              placeholder="Jelaskan bahan, ukuran, atau keunggulan produk"><?= $val('description', $product['description'] ?? '') ?></textarea>
                    <?= $fieldError('description') ?>
                </div>

                <div class="form-grid">
                    <div class="field">
                        <label class="label" for="price">Harga</label>
                        <div class="input-group<?= $invalid('price') ?>">
                            <span class="addon">Rp</span>
                            <input type="number" id="price" name="price" min="0" step="0.01" inputmode="decimal" required
                                   value="<?= $val('price', $priceDefault) ?>" placeholder="0">
                        </div>
                        <?= $fieldError('price') ?>
                    </div>
                    <div class="field">
                        <label class="label" for="stock">Stok</label>
                        <input type="number" id="stock" name="stock" class="control<?= $invalid('stock') ?>" min="0" step="1" inputmode="numeric" required
                               value="<?= $val('stock', $stockDefault) ?>">
                        <?= $fieldError('stock') ?>
                        <p class="hint">Isi 0 bila stok kosong. Stok 1&ndash;<?= \App\Models\ProductModel::LOW_STOCK_THRESHOLD ?> ditandai menipis.</p>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" data-loading-text="Menyimpan..."><?= icon('save', 17) ?> <?= $isEdit ? 'Update Produk' : 'Simpan Produk' ?></button>
                <a href="<?= site_url('admin/products') ?>" class="btn btn-ghost">Batal</a>
            </div>
        </section>

        <section class="card">
            <div class="card-head"><h2><?= $isEdit ? 'Tambah gambar baru' : 'Gambar produk' ?></h2></div>
            <div class="card-body">
                <div class="field">
                    <label class="label" for="images">Pilih gambar <span class="opt">(opsional)</span></label>
                    <input type="file" id="images" name="images[]" class="control control-file" multiple
                           accept="image/jpeg,image/png,image/webp"
                           data-image-input data-preview-target="image-preview" data-note-target="image-note"
                           data-max-files="<?= (int) $slotsLeft ?>" data-max-mb="2"
                           <?= $slotsLeft < 1 ? 'disabled' : '' ?>>
                    <p class="hint" id="image-note">
                        <?php if ($slotsLeft < 1): ?>
                            Batas <?= (int) $maxImages ?> gambar tercapai. Hapus gambar lama untuk menambah yang baru.
                        <?php else: ?>
                            JPG, PNG, atau WEBP &middot; maks. 2 MB per gambar &middot; sisa kuota <?= (int) $slotsLeft ?> gambar.
                        <?php endif; ?>
                    </p>
                </div>
                <div id="image-preview" class="gallery gallery-sm" aria-live="polite"></div>
                <?php if (! $isEdit): ?>
                    <p class="hint">Gambar pertama otomatis menjadi gambar utama. Anda bisa mengubahnya nanti saat edit produk.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</form>
