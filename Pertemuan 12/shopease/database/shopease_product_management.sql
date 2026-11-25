-- =====================================================================
-- ShopEase | Product Management (M2)
-- Tabel: categories, products, product_images
-- Cara pakai:  mysql -u root -p < database/shopease_product_management.sql
-- Skrip ini aman dijalankan ulang (IF NOT EXISTS / INSERT IGNORE).
-- =====================================================================

CREATE DATABASE IF NOT EXISTS db_shopease
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_shopease;

-- 1. Kategori ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(120) NOT NULL UNIQUE,
    description TEXT,
    created_at  DATETIME NULL,
    updated_at  DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Produk -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS products (
    id_product  INT AUTO_INCREMENT PRIMARY KEY,
    id_category INT NOT NULL,
    name        VARCHAR(150) NOT NULL,
    slug        VARCHAR(180) NOT NULL UNIQUE,
    description TEXT,
    price       DECIMAL(12,2) NOT NULL DEFAULT 0,
    stock       INT NOT NULL DEFAULT 0,
    status      ENUM('tersedia','tidak_tersedia')
                NOT NULL DEFAULT 'tersedia',
    created_at  DATETIME NULL,
    updated_at  DATETIME NULL,
    INDEX idx_products_category (id_category),
    INDEX idx_products_status_stock (status, stock),
    CONSTRAINT fk_product_category
        FOREIGN KEY (id_category)
        REFERENCES categories(id_category)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Gambar produk ----------------------------------------------------
CREATE TABLE IF NOT EXISTS product_images (
    id_image   INT AUTO_INCREMENT PRIMARY KEY,
    id_product INT NOT NULL,
    image      VARCHAR(255) NOT NULL,
    is_primary TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NULL,
    INDEX idx_images_product (id_product, is_primary),
    CONSTRAINT fk_image_product
        FOREIGN KEY (id_product)
        REFERENCES products(id_product)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Data awal (sesuai modul) ----------------------------------------
INSERT IGNORE INTO categories (name, slug, description, created_at, updated_at) VALUES
('Fashion',    'fashion',    'Produk fashion',        NOW(), NOW()),
('Elektronik', 'elektronik', 'Produk elektronik',     NOW(), NOW()),
('Olahraga',   'olahraga',   'Perlengkapan olahraga', NOW(), NOW());

INSERT IGNORE INTO products
    (id_category, name, slug, description, price, stock, status, created_at, updated_at)
VALUES
((SELECT id_category FROM categories WHERE slug = 'fashion'),
 'Sepatu Sneakers', 'sepatu-sneakers', 'Sepatu casual', 299000, 15, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'elektronik'),
 'Headphone Bluetooth', 'headphone-bluetooth', 'Headphone wireless', 350000, 10, 'tersedia', NOW(), NOW());

-- 5. Data contoh tambahan (agar pagination, filter, dan peringatan stok bisa diuji)
INSERT IGNORE INTO products
    (id_category, name, slug, description, price, stock, status, created_at, updated_at)
VALUES
((SELECT id_category FROM categories WHERE slug = 'fashion'),
 'Kaos Polos Katun', 'kaos-polos-katun', 'Kaos katun combed 30s, nyaman dipakai harian.', 89000, 40, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'fashion'),
 'Jaket Bomber Water Resistant', 'jaket-bomber-water-resistant', 'Jaket bomber ringan dengan lapisan tahan percikan air.', 389000, 9, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'fashion'),
 'Tas Ransel Kanvas', 'tas-ransel-kanvas', 'Ransel kanvas dengan kompartemen laptop 14 inci.', 225000, 4, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'fashion'),
 'Topi Baseball', 'topi-baseball', 'Topi baseball adjustable.', 65000, 0, 'tidak_tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'elektronik'),
 'Power Bank 10000 mAh', 'power-bank-10000-mah', 'Power bank fast charging dengan dua port USB.', 185000, 25, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'elektronik'),
 'Mouse Wireless', 'mouse-wireless', 'Mouse nirkabel 2.4 GHz, senyap saat diklik.', 129000, 3, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'elektronik'),
 'Smartwatch Fitness', 'smartwatch-fitness', 'Pelacak aktivitas, detak jantung, dan kualitas tidur.', 549000, 12, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'elektronik'),
 'Speaker Bluetooth Mini', 'speaker-bluetooth-mini', 'Speaker portabel tahan cipratan.', 275000, 0, 'tidak_tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'olahraga'),
 'Botol Minum Stainless 750 ml', 'botol-minum-stainless-750-ml', 'Botol minum stainless, menjaga suhu hingga 12 jam.', 99000, 60, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'olahraga'),
 'Matras Yoga 6 mm', 'matras-yoga-6-mm', 'Matras yoga anti slip.', 145000, 18, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'olahraga'),
 'Raket Badminton Carbon', 'raket-badminton-carbon', 'Raket ringan berbahan carbon.', 320000, 5, 'tersedia', NOW(), NOW()),
((SELECT id_category FROM categories WHERE slug = 'olahraga'),
 'Dumbbell Set 10 kg', 'dumbbell-set-10-kg', 'Sepasang dumbbell dengan lapisan karet.', 260000, 8, 'tersedia', NOW(), NOW());
