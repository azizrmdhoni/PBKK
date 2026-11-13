CREATE DATABASE IF NOT EXISTS db_akademik CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_akademik;

DROP TABLE IF EXISTS krs;
DROP TABLE IF EXISTS matakuliah;
DROP TABLE IF EXISTS dosen;
DROP TABLE IF EXISTS mahasiswa;
DROP TABLE IF EXISTS jurusan;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  role ENUM('admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB;

CREATE TABLE jurusan (
  id_jurusan INT AUTO_INCREMENT PRIMARY KEY,
  kode_jurusan VARCHAR(10) NOT NULL UNIQUE,
  nama_jurusan VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE mahasiswa (
  nim VARCHAR(15) PRIMARY KEY,
  id_user INT NULL,
  nama VARCHAR(100) NOT NULL,
  alamat TEXT,
  email VARCHAR(100),
  telepon VARCHAR(20),
  id_jurusan INT NOT NULL,
  angkatan YEAR NOT NULL,
  FOREIGN KEY (id_jurusan) REFERENCES jurusan(id_jurusan),
  FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE dosen (
  nidn VARCHAR(15) PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  telepon VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE matakuliah (
  kode_mk VARCHAR(10) PRIMARY KEY,
  nama_mk VARCHAR(100) NOT NULL,
  sks TINYINT NOT NULL,
  semester TINYINT NOT NULL,
  id_jurusan INT NOT NULL,
  nidn VARCHAR(15) NULL,
  FOREIGN KEY (id_jurusan) REFERENCES jurusan(id_jurusan),
  FOREIGN KEY (nidn) REFERENCES dosen(nidn) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE krs (
  id_krs INT AUTO_INCREMENT PRIMARY KEY,
  nim VARCHAR(15) NOT NULL,
  kode_mk VARCHAR(10) NOT NULL,
  tahun_ajaran VARCHAR(9) NOT NULL,
  nilai CHAR(2) NULL,
  UNIQUE KEY uq_krs (nim, kode_mk, tahun_ajaran),
  FOREIGN KEY (nim) REFERENCES mahasiswa(nim) ON DELETE CASCADE,
  FOREIGN KEY (kode_mk) REFERENCES matakuliah(kode_mk) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Password: admin / admin123 dan mahasiswa / mhs123 (di-hash dengan password_hash)
INSERT INTO user (username, password, nama, role) VALUES
('admin', '$2y$10$G4sTG92qghsJQlt8zUtL4u6loNEpWzytvPbh3/9gScxR9O7IavC3a', 'Administrator', 'admin'),
('2021001', '$2y$10$ywU46Tyt7FrlGdPyrXE/UOF6hILCAggqkAnevk0doK02AvES4D//K', 'Budi Santoso', 'mahasiswa');

INSERT INTO jurusan (kode_jurusan, nama_jurusan) VALUES
('TI','Teknik Informatika'),('SI','Sistem Informasi'),('MN','Manajemen');

INSERT INTO dosen VALUES
('0701018501','Dr. Ahmad Fauzi, M.Kom','ahmad@kampus.ac.id','081200000001'),
('0702028502','Siti Rahma, M.T.','siti@kampus.ac.id','081200000002');

INSERT INTO mahasiswa (nim, id_user, nama, alamat, email, telepon, id_jurusan, angkatan) VALUES
('2021001', 2, 'Budi Santoso', 'Surabaya', 'budi@mail.com', '081300000001', 1, 2021),
('2021002', NULL, 'Ani Lestari', 'Sidoarjo', 'ani@mail.com', '081300000002', 2, 2021);

INSERT INTO matakuliah VALUES
('TI101','Pemrograman Web',3,3,1,'0701018501'),
('TI102','Basis Data',3,3,1,'0702028502'),
('SI201','Analisis Sistem',2,3,2,'0702028502');

INSERT INTO krs (nim, kode_mk, tahun_ajaran, nilai) VALUES
('2021001','TI101','2023/2024','A'),
('2021001','TI102','2023/2024','B');
