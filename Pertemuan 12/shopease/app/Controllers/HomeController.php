<?php

namespace App\Controllers;

/**
 * Homepage (PRD bagian 10). Data kategori dan produk di sini adalah data contoh
 * sampai modul Product Management (M2) selesai; setelah itu ambil dari database.
 */
class HomeController extends BaseController
{
    public function index()
    {
        return view('frontend/home', [
            'title'    => 'Toko Online dengan Pesanan Terlacak',
            'metaDesc' => 'ShopEase: katalog produk, keranjang, pembayaran manual, dan pelacakan pesanan.',

            'benefits' => [
                ['icon' => 'shield', 'title' => 'Transaksi aman',      'text' => 'Total dihitung ulang di server'],
                ['icon' => 'receipt',      'title' => 'Harga tercatat',      'text' => 'Riwayat harga tidak berubah'],
                ['icon' => 'package',     'title' => 'Stok divalidasi',     'text' => 'Mencegah pesanan melebihi stok'],
                ['icon' => 'truck',        'title' => 'Resi dapat dilacak',  'text' => 'Status pengiriman terlihat'],
            ],

            'categories' => [
                ['name' => 'Elektronik',        'slug' => 'elektronik',   'icon' => 'headphones',       'count' => 24],
                ['name' => 'Fashion',           'slug' => 'fashion',      'icon' => 'shirt',          'count' => 38],
                ['name' => 'Kecantikan',        'slug' => 'kecantikan',   'icon' => 'sparkles',            'count' => 17],
                ['name' => 'Rumah Tangga',      'slug' => 'rumah-tangga', 'icon' => 'home',      'count' => 29],
                ['name' => 'Olahraga',          'slug' => 'olahraga',     'icon' => 'bike',          'count' => 14],
                ['name' => 'Buku & Alat Tulis', 'slug' => 'buku',         'icon' => 'book', 'count' => 21],
            ],

            'featured' => [
                ['name' => 'Headphone Nirkabel Noise Cancelling', 'slug' => 'headphone-nirkabel', 'category' => 'Elektronik', 'price' => 749000, 'old' => 899000, 'stock' => 18, 'tone' => 'green',  'icon' => 'headphones',   'badge' => 'Terlaris'],
                ['name' => 'Jaket Bomber Water Resistant',        'slug' => 'jaket-bomber',       'category' => 'Fashion',    'price' => 389000, 'old' => null,   'stock' => 9,  'tone' => 'terra',  'icon' => 'shirt',      'badge' => null],
                ['name' => 'Serum Vitamin C 30 ml',               'slug' => 'serum-vitamin-c',    'category' => 'Kecantikan', 'price' => 129000, 'old' => 159000, 'stock' => 42, 'tone' => 'sand',  'icon' => 'droplet', 'badge' => 'Diskon'],
                ['name' => 'Botol Minum Stainless 750 ml',        'slug' => 'botol-stainless',    'category' => 'Olahraga',   'price' => 99000,  'old' => null,   'stock' => 60, 'tone' => 'sage', 'icon' => 'cup',    'badge' => null],
            ],

            'steps' => [
                ['title' => 'Pilih produk',   'text' => 'Cari atau telusuri kategori, cek harga dan stok.'],
                ['title' => 'Checkout',       'text' => 'Masuk, periksa keranjang, pilih alamat.'],
                ['title' => 'Bayar',          'text' => 'Transfer lalu unggah bukti pembayaran.'],
                ['title' => 'Pantau pesanan', 'text' => 'Lihat verifikasi, pengiriman, dan nomor resi.'],
            ],
        ]);
    }
}
