<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    /**
     * Landing page ShopEase.
     * Controller hanya menyiapkan data; presentasi ditangani View.
     * Saat M3 selesai, $featured dapat diganti dengan ProductModel (produk aktif).
     */
    public function index(): string
    {
        $data = [
            'title'      => 'ShopEase – Toko Online Modern, Cepat, dan Terpercaya',
            'metaDesc'   => 'ShopEase membantu Anda berbelanja dengan mudah: jelajahi katalog, checkout aman, unggah bukti bayar, dan pantau pesanan hingga sampai.',
            'stats'      => $this->stats(),
            'categories' => $this->categories(),
            'featured'   => $this->featuredProducts(),
            'features'   => $this->features(),
            'steps'      => $this->steps(),
            'roles'      => $this->roles(),
            'faqs'       => $this->faqs(),
        ];

        return view('frontend/home', $data);
    }

    private function stats(): array
    {
        return [
            ['value' => '3',    'label' => 'Peran pengguna (Customer, Admin, Operator)'],
            ['value' => '10',   'label' => 'Tabel database terelasi'],
            ['value' => '100%', 'label' => 'Total dihitung ulang di server'],
            ['value' => '6',    'label' => 'Tahap status pesanan terlacak'],
        ];
    }

    private function categories(): array
    {
        return [
            ['name' => 'Elektronik',      'icon' => 'bi-headphones', 'count' => 48, 'slug' => 'elektronik'],
            ['name' => 'Fashion',         'icon' => 'bi-handbag',    'count' => 120, 'slug' => 'fashion'],
            ['name' => 'Rumah & Dapur',   'icon' => 'bi-house-heart', 'count' => 76, 'slug' => 'rumah-dapur'],
            ['name' => 'Kecantikan',      'icon' => 'bi-stars',      'count' => 64, 'slug' => 'kecantikan'],
            ['name' => 'Olahraga',        'icon' => 'bi-bicycle',    'count' => 39, 'slug' => 'olahraga'],
            ['name' => 'Buku & Alat Tulis', 'icon' => 'bi-book',     'count' => 82, 'slug' => 'buku-alat-tulis'],
        ];
    }

    /** Data contoh (seed demonstrasi) – bukan data pribadi nyata. */
    private function featuredProducts(): array
    {
        return [
            ['name' => 'Headphone Nirkabel Aura X',  'category' => 'Elektronik', 'price' => 749000,  'old' => 899000, 'stock' => 24, 'icon' => 'bi-headphones', 'tone' => 'indigo', 'badge' => 'Terlaris', 'slug' => 'headphone-aura-x'],
            ['name' => 'Jaket Bomber Urban Classic', 'category' => 'Fashion',    'price' => 389000,  'old' => null,   'stock' => 15, 'icon' => 'bi-handbag',    'tone' => 'rose',   'badge' => 'Baru',     'slug' => 'jaket-bomber-urban'],
            ['name' => 'Rice Cooker Digital 1.8L',   'category' => 'Rumah & Dapur', 'price' => 529000, 'old' => 599000, 'stock' => 8, 'icon' => 'bi-house-heart', 'tone' => 'amber', 'badge' => 'Stok Terbatas', 'slug' => 'rice-cooker-digital'],
            ['name' => 'Serum Vitamin C Brightening', 'category' => 'Kecantikan', 'price' => 149000, 'old' => null,   'stock' => 60, 'icon' => 'bi-stars',       'tone' => 'teal',   'badge' => null,       'slug' => 'serum-vitamin-c'],
        ];
    }

    private function features(): array
    {
        return [
            ['icon' => 'bi-grid-1x2',        'title' => 'Katalog Terpusat',          'text' => 'Produk, harga, dan stok tersaji dalam satu katalog dengan pencarian, filter kategori, sorting, dan pagination.'],
            ['icon' => 'bi-cart-check',      'title' => 'Keranjang & Checkout',      'text' => 'Kelola keranjang, pilih alamat, dan checkout. Stok divalidasi dan total dihitung ulang oleh server.'],
            ['icon' => 'bi-receipt-cutoff',  'title' => 'Pembayaran Manual Terverifikasi', 'text' => 'Unggah bukti pembayaran, lalu admin menyetujui atau menolaknya dengan status yang tercatat.'],
            ['icon' => 'bi-truck',           'title' => 'Pelacakan Pengiriman',      'text' => 'Pantau status pesanan dan nomor resi dari pending hingga selesai, langsung dari akun Anda.'],
            ['icon' => 'bi-shield-lock',     'title' => 'Keamanan Berlapis',         'text' => 'Password di-hash, CSRF aktif, validasi server-side, serta akses dibatasi per peran (RBAC).'],
            ['icon' => 'bi-bar-chart-line',  'title' => 'Dashboard & Laporan',       'text' => 'Ringkasan produk, pelanggan, pesanan, dan penjualan, lengkap dengan rekap berdasarkan periode.'],
        ];
    }

    private function steps(): array
    {
        return [
            ['title' => 'Jelajahi Produk',    'text' => 'Cari atau pilih kategori, lalu periksa harga dan stok.'],
            ['title' => 'Tambah ke Keranjang', 'text' => 'Atur kuantitas sesuai stok yang tersedia.'],
            ['title' => 'Checkout Aman',       'text' => 'Pilih alamat; sistem membuat pesanan dalam satu transaksi database.'],
            ['title' => 'Unggah Bukti Bayar',  'text' => 'Admin memverifikasi pembayaran Anda.'],
            ['title' => 'Pantau Pesanan',      'text' => 'Dari diproses, dikirim, hingga selesai.'],
        ];
    }

    private function roles(): array
    {
        return [
            ['icon' => 'bi-person-heart', 'name' => 'Customer',      'items' => ['Belanja & checkout', 'Unggah bukti pembayaran', 'Riwayat & status pesanan']],
            ['icon' => 'bi-person-gear',  'name' => 'Administrator', 'items' => ['CRUD kategori & produk', 'Verifikasi pembayaran', 'Dashboard & laporan']],
            ['icon' => 'bi-box-seam',     'name' => 'Operator Toko', 'items' => ['Menyiapkan pesanan', 'Update status proses', 'Input kurir & nomor resi']],
        ];
    }

    private function faqs(): array
    {
        return [
            ['q' => 'Bagaimana cara membayar pesanan?',               'a' => 'Pembayaran dilakukan manual melalui transfer, lalu unggah bukti pembayaran pada halaman detail pesanan. Admin akan memverifikasinya.'],
            ['q' => 'Apakah saya harus login untuk berbelanja?',      'a' => 'Anda dapat menjelajahi katalog tanpa akun. Login atau registrasi diperlukan saat menambah keranjang dan checkout.'],
            ['q' => 'Bagaimana saya melacak pesanan?',                'a' => 'Buka Riwayat Pesanan untuk melihat status pesanan, status pembayaran, kurir, dan nomor resi.'],
            ['q' => 'Apakah harga bisa berubah setelah saya memesan?', 'a' => 'Tidak. Nama dan harga produk disimpan sebagai snapshot pada saat transaksi sehingga riwayat pesanan tetap akurat.'],
            ['q' => 'Seberapa aman data akun saya?',                  'a' => 'Password disimpan dengan hashing, formulir dilindungi CSRF, dan setiap halaman privat dijaga filter otorisasi.'],
        ];
    }
}
