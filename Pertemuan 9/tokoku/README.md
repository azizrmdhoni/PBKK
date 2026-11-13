# TokoKu - Toko Online (CodeIgniter 3.1.13)

## Cara pasang (XAMPP)
1. Ekstrak folder `tokoku` ke `C:\xampp\htdocs\` (hasil: `C:\xampp\htdocs\tokoku\index.php`).
2. Jalankan **Apache** dan **MySQL** di XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin` -> **Baru** -> buat database `db_tokoku` (collation utf8mb4_general_ci).
4. Pilih database `db_tokoku` -> tab **Import** -> pilih file `database.sql` -> **Kirim**.
5. Buka `http://localhost/tokoku/`

Jika MySQL Anda memakai password untuk root, ubah di `application/config/database.php`.
Jika folder diganti namanya, ubah `base_url` di `application/config/config.php`.


## Lokasi folder
Folder boleh diletakkan di mana saja di `htdocs`, termasuk subfolder (contoh: `htdocs/PBKK/Pertemuan 9/tokoku/`, dibuka lewat
`http://localhost/PBKK/Pertemuan%209/tokoku/`). `base_url` dihitung otomatis dan `MY_URI.php` menangani nama folder berspasi,
jadi tidak perlu mengedit `config.php`.

## Alur akses
Membuka `http://localhost/tokoku/` langsung menampilkan **halaman login**. Seluruh halaman lain wajib login terlebih dahulu.

## Fitur
- **Toko:** hero & kategori, pencarian, urut harga, detail + produk serupa, keranjang, checkout 3 langkah, upload bukti transfer, riwayat pesanan.
- **Admin:** dashboard (statistik, grafik status, stok menipis), CRUD produk dengan preview gambar, kelola pesanan.
- **Gambar produk:** 12 ilustrasi 2D (SVG) ada di `uploads/produk/`. Produk tanpa gambar otomatis memakai ilustrasi kategori.
- Halaman login/daftar terpisah (layar penuh). Halaman admin hanya bisa dibuka setelah login sebagai admin.

## Port MySQL
Proyek ini sudah diset ke **port 4306** (sesuai XAMPP Anda) di `application/config/database.php`.
Jika MySQL Anda memakai port standar, ubah `'port' => 4306,` menjadi `'port' => 3306,`.

## Akun contoh
| Peran     | Email                | Password     |
|-----------|----------------------|--------------|
| Admin     | admin@tokoku.com     | admin123     |
| Pelanggan | pelanggan@tokoku.com | pelanggan123 |

## Alur uji
1. Login admin -> **Produk** -> tambah/ubah produk (coba upload gambar).
2. Logout -> login pelanggan -> Katalog -> Detail -> Masukkan Keranjang.
3. Keranjang -> Checkout -> isi alamat -> upload bukti transfer.
4. Login admin -> **Pesanan** -> Detail -> ubah status -> cek Dashboard (omzet).

## Struktur penting
- `application/controllers` : Auth, Toko, Belanja, Checkout, Dashboard, Produk, Pesanan
- `application/models`      : Produk_model, Pesanan_model
- `application/libraries`   : Keranjang (keranjang berbasis session)
- `application/core`        : MY_Controller (render + proteksi login/role)
- `application/views`       : tampilan (Bootstrap 4, Bootstrap Icons, DataTables, SweetAlert2, Chart.js via CDN, butuh internet)
- `uploads/`                : gambar produk & bukti bayar

## Masalah umum
- 404 selain halaman depan: aktifkan `mod_rewrite` Apache; pastikan `.htaccess` ikut ter-ekstrak (file tersembunyi).
- Tampilan polos tanpa gaya: komputer perlu internet (Bootstrap dari CDN).
- Error database: cek nama database & password di `application/config/database.php`.
