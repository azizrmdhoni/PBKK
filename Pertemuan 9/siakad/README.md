# SIAKAD Kampus - Sistem Informasi Akademik (CodeIgniter 3.1.13)

## Cara pasang (XAMPP)
1. Ekstrak folder `siakad` ke `C:\xampp\htdocs\` (hasil: `C:\xampp\htdocs\siakad\index.php`).
2. Jalankan **Apache** dan **MySQL** di XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin` -> buat database `db_siakad`.
4. Pilih database `db_siakad` -> tab **Import** -> pilih `database.sql` -> **Kirim**.
5. Buka `http://localhost/siakad/`


## Lokasi folder
Folder boleh diletakkan di mana saja di `htdocs`, termasuk subfolder (contoh: `htdocs/PBKK/Pertemuan 9/siakad/`, dibuka lewat
`http://localhost/PBKK/Pertemuan%209/siakad/`). `base_url` dihitung otomatis dan `MY_URI.php` menangani nama folder berspasi,
jadi tidak perlu mengedit `config.php`.

## Alur akses
Membuka `http://localhost/siakad/` langsung menampilkan **halaman login**. Seluruh halaman lain wajib login terlebih dahulu.

## Fitur
- Login layar penuh; semua halaman lain wajib login dan dibatasi per peran (admin / dosen / mahasiswa).
- **Admin:** dashboard + grafik, CRUD Mahasiswa, Dosen, Mata Kuliah, Kelas (tabel dengan pencarian & paginasi).
- **Mahasiswa:** KRS (validasi kuota/dobel/24 SKS), KHS (IPS & IPK), profil + foto.
- **Dosen:** jadwal mengajar dan input nilai per kelas.

## Port MySQL
Proyek ini sudah diset ke **port 4306** (sesuai XAMPP Anda) di `application/config/database.php`.
Jika MySQL Anda memakai port standar, ubah `'port' => 4306,` menjadi `'port' => 3306,`.

## Akun contoh
| Peran     | Username    | Password   |
|-----------|-------------|------------|
| Admin     | admin       | admin123   |
| Dosen     | 0011223301  | 0011223301 |
| Dosen     | 0011223302  | 0011223302 |
| Mahasiswa | 2026001     | 2026001    |
| Mahasiswa | 2026002     | 2026002    |

Akun dosen/mahasiswa yang dibuat admin otomatis memakai NIDN/NIM sebagai username dan password awal.

## Alur uji
1. Admin: kelola Mata Kuliah -> Dosen -> Mahasiswa -> Kelas (urutan ini penting).
2. Mahasiswa: menu **KRS** -> Ambil kelas (ada validasi kuota, dobel, maksimal 24 SKS).
3. Dosen: menu **Input Nilai** -> pilih kelas -> isi nilai 0-100.
4. Mahasiswa: menu **KHS** (IPS & IPK) dan **Profil** (upload foto).

Skala nilai: >=85 A(4.0), >=75 B+(3.5), >=65 B(3.0), >=55 C+(2.5), >=45 C(2.0), >=35 D(1.0), selain itu E(0).

## Struktur penting
- `application/core/MY_Controller.php` : render, proteksi role, dan `Crud_Controller` (CRUD generik)
- `application/controllers` : Auth, Dashboard, Mahasiswa, Dosen, Matakuliah, Kelas, Krs, Nilai, Khs, Profil
- `application/views`       : tampilan (Bootstrap 4, Bootstrap Icons, DataTables, SweetAlert2, Chart.js via CDN, butuh internet)

## Masalah umum
- 404 selain halaman depan: aktifkan `mod_rewrite` Apache; pastikan `.htaccess` ikut ter-ekstrak.
- Error database: cek nama database & password di `application/config/database.php`.
