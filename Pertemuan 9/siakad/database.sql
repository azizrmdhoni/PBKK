-- SIAKAD Kampus - database db_siakad
-- Import file ini di phpMyAdmin (buat database db_siakad dulu, pilih database, tab Import)
SET NAMES utf8mb4;

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  role ENUM('admin','dosen','mahasiswa') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE mahasiswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  nim VARCHAR(20) NOT NULL UNIQUE,
  nama VARCHAR(100) NOT NULL,
  prodi VARCHAR(80) NOT NULL,
  angkatan INT NOT NULL,
  foto VARCHAR(255) NULL
) ENGINE=InnoDB;

CREATE TABLE dosen (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  nidn VARCHAR(20) NOT NULL UNIQUE,
  nama VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE matakuliah (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode VARCHAR(15) NOT NULL UNIQUE,
  nama VARCHAR(100) NOT NULL,
  sks TINYINT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE kelas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  matakuliah_id INT NOT NULL,
  dosen_id INT NOT NULL,
  hari VARCHAR(10) NOT NULL,
  jam VARCHAR(15) NOT NULL,
  ruang VARCHAR(20) NOT NULL,
  semester VARCHAR(10) NOT NULL,
  kuota INT NOT NULL DEFAULT 40,
  FOREIGN KEY (matakuliah_id) REFERENCES matakuliah(id) ON DELETE CASCADE,
  FOREIGN KEY (dosen_id) REFERENCES dosen(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE krs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mahasiswa_id INT NOT NULL,
  kelas_id INT NOT NULL,
  nilai_angka DECIMAL(5,2) NULL,
  nilai_huruf CHAR(2) NULL,
  bobot DECIMAL(3,2) NULL,
  UNIQUE KEY uq_krs (mahasiswa_id, kelas_id),
  FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===== DATA CONTOH =====
-- admin / admin123 | dosen: NIDN sebagai username & password | mahasiswa: NIM sebagai username & password
INSERT INTO user (id, username, password, nama, role) VALUES
(1, 'admin',      '$2y$10$mGmQrxKrGSTxM65LXPryh.SYrlKKIIbHfro2vIbgzIRSJ.DXDljQG',  'Administrator', 'admin'),
(2, '0011223301', '$2y$10$uwFEHLFDw6Is4UDQlMvFceYt0lS1bD8lY/Y1jXvv6VF2ifAL14isW', 'Dr. Siti Rahma', 'dosen'),
(3, '0011223302', '$2y$10$IqoaM6XizbnNJXNpuaWaiOeK16eX.su5Bj1XAfECTmKnyabgdCFvC', 'Ir. Agus Prasetyo', 'dosen'),
(4, '2026001',    '$2y$10$7zgi7dinxF8c9IUl49SYBO9NPeopA3.Ms2KsFs9q4p6PURhQaybJC',    'Andi Saputra', 'mahasiswa'),
(5, '2026002',    '$2y$10$0AQTAR8WtSTbY0aoRfr4BumjqVGT6wk4d4EJDBoVAG.Z8yDY3sGdy',    'Dewi Lestari', 'mahasiswa');

INSERT INTO dosen (user_id, nidn, nama) VALUES
(2, '0011223301', 'Dr. Siti Rahma'),
(3, '0011223302', 'Ir. Agus Prasetyo');

INSERT INTO mahasiswa (user_id, nim, nama, prodi, angkatan) VALUES
(4, '2026001', 'Andi Saputra', 'Teknik Informatika', 2026),
(5, '2026002', 'Dewi Lestari', 'Sistem Informasi', 2026);

INSERT INTO matakuliah (kode, nama, sks) VALUES
('IF101', 'Pemrograman Web', 3),
('IF102', 'Basis Data', 3),
('IF103', 'Pemrograman Berorientasi Objek', 3),
('IF104', 'Rekayasa Perangkat Lunak', 2);

INSERT INTO kelas (matakuliah_id, dosen_id, hari, jam, ruang, semester, kuota) VALUES
(1, 1, 'Senin',  '08:00-10:30', 'Lab 1',  '2026/1', 40),
(2, 2, 'Selasa', '10:00-12:30', 'R. 201', '2026/1', 40),
(3, 1, 'Rabu',   '13:00-15:30', 'R. 202', '2026/1', 35),
(4, 2, 'Kamis',  '08:00-09:40', 'R. 203', '2026/1', 35);
