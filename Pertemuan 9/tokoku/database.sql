-- TokoKu - database db_tokoku
-- Import file ini di phpMyAdmin (buat database db_tokoku dulu, pilih database, tab Import)
SET NAMES utf8mb4;

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  role ENUM('admin','pelanggan') NOT NULL DEFAULT 'pelanggan'
) ENGINE=InnoDB;

CREATE TABLE kategori (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kategori_id INT NOT NULL,
  nama VARCHAR(150) NOT NULL,
  deskripsi TEXT,
  harga INT NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  gambar VARCHAR(255) NULL,
  FOREIGN KEY (kategori_id) REFERENCES kategori(id)
) ENGINE=InnoDB;

CREATE TABLE pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode VARCHAR(30) NOT NULL UNIQUE,
  user_id INT NOT NULL,
  nama_penerima VARCHAR(100) NOT NULL,
  telepon VARCHAR(20) NOT NULL,
  alamat TEXT NOT NULL,
  total INT NOT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'menunggu pembayaran',
  bukti VARCHAR(255) NULL,
  tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES user(id)
) ENGINE=InnoDB;

CREATE TABLE detail_pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pesanan_id INT NOT NULL,
  produk_id INT NOT NULL,
  nama VARCHAR(150) NOT NULL,
  harga INT NOT NULL,
  qty INT NOT NULL,
  FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===== DATA CONTOH =====
-- admin@tokoku.com / admin123  |  pelanggan@tokoku.com / pelanggan123
INSERT INTO user (username, password, nama, role) VALUES
('admin@tokoku.com', '$2y$10$nb1a9P/vJfYv95XapAIQNOKc0I.jhB3BzWFzEPLiHaWKRk3zpfiuW', 'Administrator', 'admin'),
('pelanggan@tokoku.com', '$2y$10$hU2OzVyJWn4xP8NQaQTD1uHgLtmv7rG8XAgM0KE5qDuqNNnGkL.Im', 'Budi Pelanggan', 'pelanggan');

INSERT INTO kategori (nama) VALUES ('Elektronik'),('Fashion'),('Makanan'),('Buku');

INSERT INTO produk (kategori_id, nama, deskripsi, harga, stok, gambar) VALUES
(1, 'Headphone Bluetooth X1', 'Headphone nirkabel dengan suara jernih dan baterai tahan hingga 20 jam. Nyaman dipakai seharian.', 350000, 25, 'headphone.svg'),
(1, 'Power Bank 10000 mAh', 'Power bank ringkas dengan dua port USB dan indikator baterai. Cocok dibawa bepergian.', 185000, 40, 'powerbank.svg'),
(1, 'Smartwatch Fit Pro', 'Jam pintar dengan pemantau detak jantung, notifikasi, dan tahan percikan air.', 499000, 18, 'smartwatch.svg'),
(1, 'Speaker Mini Pro', 'Speaker kompak dengan bass kuat untuk musik di rumah maupun kantor.', 275000, 8, 'speaker.svg'),
(2, 'Kaos Polos Premium', 'Kaos katun combed 30s yang lembut, adem, dan tidak mudah melar.', 75000, 100, 'kaos.svg'),
(2, 'Jaket Hoodie Unisex', 'Hoodie fleece tebal dan hangat dengan kantong depan yang lega.', 220000, 30, 'hoodie.svg'),
(2, 'Sneakers Urban Run', 'Sepatu sneakers ringan dengan sol empuk untuk aktivitas harian.', 325000, 22, 'sneakers.svg'),
(2, 'Ransel Daily Pack', 'Tas ransel water-resistant dengan ruang laptop 15 inci dan banyak kompartemen.', 260000, 5, 'ransel.svg'),
(3, 'Keripik Tempe Original', 'Keripik tempe renyah dengan bumbu gurih, kemasan 250 gram.', 18000, 200, 'keripik.svg'),
(3, 'Kopi Arabika Gayo 250g', 'Biji kopi arabika Gayo sangrai medium, aroma harum dan rasa seimbang.', 85000, 60, 'kopi.svg'),
(4, 'Belajar CodeIgniter 3', 'Buku panduan membangun aplikasi web dengan CodeIgniter 3 langkah demi langkah.', 95000, 15, 'buku.svg'),
(4, 'Notebook Spiral A5', 'Buku catatan spiral A5 dengan 100 lembar kertas tebal bergaris.', 28000, 80, 'notes.svg');
