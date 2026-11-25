# ShopEase | Modul Product Management (M2)

CRUD kategori dan produk, upload dan galeri gambar, pencarian/filter/pagination, manajemen stok,
serta proteksi akses Administrator dan Operator. Dibangun di atas fondasi ShopEase (CodeIgniter 4.7).

## 1. Cara menjalankan

```bash
# 1. Buat tabel + data awal (aman dijalankan ulang)
mysql -u root -p < database/shopease_product_management.sql

# 2. Pastikan akun uji ada (tabel users dari modul Authentication)
php spark db:seed UserSeeder

# 3. Jalankan aplikasi
php spark serve
```

Atur koneksi database di `.env` (`database.default.*`). Login dengan:

| Role          | Email                   | Password      |
|---------------|-------------------------|---------------|
| Administrator | admin@shopease.test     | Shopease123   |
| Operator      | operator@shopease.test  | Shopease123   |
| Customer      | customer@shopease.test  | Shopease123   |

## 2. URL

| Halaman           | URL                          |
|-------------------|------------------------------|
| Daftar produk     | `/admin/products`            |
| Tambah produk     | `/admin/products/create`     |
| Edit produk       | `/admin/products/edit/1`     |
| Daftar kategori   | `/admin/categories`          |
| Tambah kategori   | `/admin/categories/create`   |
| Edit kategori     | `/admin/categories/edit/1`   |

Filter daftar produk: `/admin/products?q=sepatu&category=1&status=tersedia&stock=low&page=2`

## 3. File yang ditambah atau diubah

```
database/shopease_product_management.sql     tabel, FK, data awal + data contoh
app/Models/{Category,Product,ProductImage}Model.php
app/Models/Concerns/GeneratesSlug.php        slug unik (nama, nama-2, nama-3 ...)
app/Libraries/ProductImageUploader.php       validasi + simpan + hapus file gambar
app/Controllers/Admin/{Category,Product}Controller.php
app/Config/Routes.php                        grup admin: auth:admin,operator
app/Config/Pager.php                         template pagination 'shopease_full'
app/Views/admin/products/{index,create,edit,_form}.php
app/Views/admin/categories/{index,create,edit,_form}.php
app/Views/Pager/shopease_full.php
app/Views/panel/_inventory_alert.php         kartu peringatan stok (dashboard)
app/Views/layouts/panel.php                  menu Katalog aktif, section scripts
app/Views/layouts/flash_panel.php            alert peringatan upload
app/Views/panel/{admin,operator}_dashboard.php, Controllers/{Admin,Operator}/DashboardController.php
app/Common.php                               ikon baru + helper rupiah(), product_image_url()
public/assets/css/shopease.css               gaya form, tabel produk, galeri, pagination
public/assets/js/product.js                  konfirmasi hapus + preview gambar
public/uploads/products/                     folder upload (+ .htaccess anti-eksekusi script)
```

## 4. Pemetaan ke modul praktikum

| Bagian modul            | Status | Catatan |
|-------------------------|--------|---------|
| F. Database MySQL       | Selesai | Skema sama dengan modul; ditambah index, `utf8mb4`, dan `IF NOT EXISTS`. |
| G. Model                | Selesai | Ditambah `listing()`, `summary()`, `lowStock()`, `outOfStock()`, `withProductCount()`, `makePrimary()`. |
| H. Controller           | Selesai | Ditambah `updateStock`, `setPrimaryImage`, `deleteImage`. |
| I. Routes               | Selesai | Grup `admin` dengan `auth:admin,operator`; semua aksi ubah data memakai POST + CSRF. |
| J/K. View               | Selesai | Memakai layout panel dan gaya bawaan ShopEase (bukan Bootstrap CDN) agar seragam dengan dashboard. |
| Tugas 1 Product Search  | Selesai | Cari nama, filter kategori/status/stok, pagination 10 per halaman. |
| Tugas 2 Image Gallery   | Selesai | Banyak gambar, gambar utama, hapus per gambar (file fisik ikut terhapus), preview sebelum upload. |
| Tugas 3 Inventory       | Selesai | Update stok langsung dari tabel, filter stok menipis (1-5) dan habis (0), kartu peringatan di dashboard. |
| Tugas 4 Dashboard       | Selesai | Total produk, kategori, tersedia/tidak tersedia, menipis, habis. |

## 5. Penyempurnaan dari kode contoh modul (sesuai Catatan Teknis)

- `id_category` divalidasi benar-benar ada (`is_not_unique[categories.id_category]`).
- Produk + gambar disimpan dalam satu **transaksi**; bila gagal, file yang sudah dipindah dihapus kembali.
- Upload diperiksa di server: error PHP, ukuran 2 MB, MIME + ekstensi, isi file (`getimagesize`), dan maksimal 8 gambar per produk. Atribut `accept` hanya bantuan UI.
- File diberi nama acak; folder upload memiliki `.htaccess` yang menolak eksekusi script.
- Slug unik dan stabil (tidak berubah bila nama tidak diganti), tidak lagi bergantung `time()`.
- Hapus produk: baris dihapus dulu, file fisik dihapus setelah transaksi sukses.
- Hapus kategori ditolak bila masih punya produk (cek aplikasi + FK `RESTRICT`).
- Gambar utama otomatis ditetapkan/dipromosikan saat gambar pertama diunggah atau gambar utama dihapus.
- Pesan validasi berbahasa Indonesia, error ditampilkan per kolom, input lama dipertahankan.
- Otorisasi: Admin dan Operator punya hak sama pada modul ini (sesuai modul). Bila nanti berbeda,
  pecah grup route per aksi, misalnya `delete` hanya `auth:admin`.

## 6. Panduan pengujian manual

Login dulu sebagai Administrator atau Operator, lalu isi kolom Hasil.

| No | Skenario | Langkah singkat | Hasil yang diharapkan | Hasil |
|----|----------|-----------------|-----------------------|-------|
| 1  | Tambah kategori | Kategori > Tambah, isi "Buku", simpan | Muncul di daftar, pesan sukses | ☐ |
| 2  | Tambah produk | Produk > Tambah, isi data lengkap | Produk muncul di daftar | ☐ |
| 3  | Produk tanpa kategori | Kosongkan kategori (hapus atribut `required` lewat DevTools), simpan | Ditolak, pesan "Kategori wajib dipilih." | ☐ |
| 4  | Edit produk | Ubah harga atau nama, update | Data berubah | ☐ |
| 5  | Hapus produk | Klik Hapus, konfirmasi | Baris dan file gambar hilang | ☐ |
| 6  | Upload gambar | Pilih 2 gambar JPG/PNG, simpan | File ada di `public/uploads/products/`, thumbnail tampil | ☐ |
| 7  | Stok 0 | Tambah produk dengan stok 0 | Tersimpan, lencana "Habis" | ☐ |
| 8  | Hapus kategori terpakai | Hapus "Fashion" | Tombol nonaktif; via POST langsung ditolak dengan pesan error | ☐ |
| 9  | Customer buka halaman admin | Login customer, buka `/admin/products` | Dialihkan ke beranda, "Anda tidak punya akses" | ☐ |
| 10 | Operator buka produk | Login operator, buka `/admin/products` | Halaman tampil normal | ☐ |
| 11 | Upload tidak valid | Unggah `.txt`/`.php` atau gambar > 2 MB | Ditolak, ada peringatan, produk tetap tersimpan | ☐ |
| 12 | Cari dan filter | `?q=sepatu`, kategori Elektronik, stok menipis | Hanya hasil yang sesuai; filter terbawa saat pindah halaman | ☐ |
| 13 | Gambar utama | Edit produk, "Jadikan utama" pada gambar kedua | Lencana Utama pindah, thumbnail daftar ikut berubah | ☐ |
| 14 | Hapus gambar utama | Hapus gambar utama | Gambar lain otomatis jadi utama | ☐ |

## 7. Langkah berikutnya

Halaman publik (`HomeController`, katalog, detail produk) masih memakai data contoh. Pada milestone
M3 (Customer Store), ambil data dari `ProductModel::listing()` dan `product_image_url()`.
