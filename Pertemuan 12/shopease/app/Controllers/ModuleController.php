<?php

namespace App\Controllers;

/**
 * Halaman-halaman PRD bagian 10 yang modulnya belum dibangun. Rute, hak akses,
 * dan navigasinya sudah final; hanya isinya yang menunggu milestone terkait.
 * Saat sebuah modul selesai, pindahkan method-nya ke controller sendiri
 * (mis. ProductController) dan ubah rute di Routes.php.
 */
class ModuleController extends BaseController
{
    private const MODULES = [
        'catalog' => [
            'area' => 'front', 'title' => 'Katalog Produk', 'icon' => 'grid', 'milestone' => 'M3 - Customer Store', 'access' => 'Publik',
            'summary' => 'Jelajahi seluruh produk aktif dengan pencarian dan filter.',
            'items'   => ['Pencarian nama produk', 'Filter kategori', 'Urutkan berdasarkan harga', 'Kartu produk', 'Pagination'],
        ],
        'product' => [
            'area' => 'front', 'title' => 'Detail Produk', 'icon' => 'package', 'milestone' => 'M3 - Customer Store', 'access' => 'Publik. Menambah ke keranjang memerlukan login.',
            'summary' => 'Informasi lengkap satu produk sebelum dimasukkan ke keranjang.',
            'items'   => ['Foto, nama, dan deskripsi', 'Harga dan stok', 'Pilihan kuantitas', 'Tombol tambah ke keranjang'],
        ],
        'cart' => [
            'area' => 'front', 'title' => 'Keranjang', 'icon' => 'cart', 'milestone' => 'M3 - Customer Store', 'access' => 'Customer',
            'summary' => 'Kelola produk yang akan dibeli sebelum checkout.',
            'items'   => ['Daftar item dan kuantitas', 'Harga dan subtotal', 'Hapus item', 'Total keranjang'],
        ],
        'checkout' => [
            'area' => 'front', 'title' => 'Checkout', 'icon' => 'bag-check', 'milestone' => 'M4 - Transaksi', 'access' => 'Customer',
            'summary' => 'Ubah keranjang menjadi pesanan. Stok dan total dihitung ulang di server.',
            'items'   => ['Pilihan alamat', 'Ringkasan produk', 'Ongkos kirim (jika digunakan)', 'Total dan konfirmasi'],
        ],
        'orders' => [
            'area' => 'front', 'title' => 'Riwayat Pesanan', 'icon' => 'history', 'milestone' => 'M4 - Transaksi', 'access' => 'Customer (hanya pesanan miliknya)',
            'summary' => 'Daftar semua pesanan Anda beserta statusnya.',
            'items'   => ['Nomor order dan tanggal', 'Total pesanan', 'Status pesanan', 'Tautan ke detail'],
        ],
        'orderDetail' => [
            'area' => 'front', 'title' => 'Detail Pesanan', 'icon' => 'receipt', 'milestone' => 'M4 - Transaksi', 'access' => 'Pemilik pesanan atau admin',
            'summary' => 'Rincian satu pesanan, pembayaran, dan pengiriman.',
            'items'   => ['Item dan harga snapshot', 'Total pesanan', 'Status pembayaran', 'Status pengiriman dan nomor resi'],
        ],
        'adminOrders' => [
            'area' => 'staff', 'title' => 'Pesanan', 'icon' => 'receipt', 'milestone' => 'M4 - Transaksi dan M5 - Fulfillment', 'access' => 'Administrator',
            'summary' => 'Pantau pesanan dan verifikasi pembayaran (FR-015).',
            'items'   => ['Daftar order dan detail', 'Setujui atau tolak bukti pembayaran', 'Pembaruan status pesanan', 'Catatan waktu dan pengguna perubah status'],
        ],
        'adminReports' => [
            'area' => 'staff', 'title' => 'Laporan', 'icon' => 'chart', 'milestone' => 'M5 - Fulfillment', 'access' => 'Administrator',
            'summary' => 'Rekap penjualan dasar (FR-019).',
            'items'   => ['Rekap berdasarkan periode', 'Rekap berdasarkan status pesanan'],
        ],
        'adminUsers' => [
            'area' => 'staff', 'title' => 'Pengguna', 'icon' => 'users', 'milestone' => 'M5 - Fulfillment', 'access' => 'Administrator',
            'summary' => 'Lihat pelanggan dan kelola akun staf.',
            'items'   => ['Daftar pelanggan', 'Aktifkan atau nonaktifkan akun', 'Penetapan role admin dan operator lewat proses administrasi'],
        ],
        'operatorOrders' => [
            'area' => 'staff', 'title' => 'Pesanan Masuk', 'icon' => 'inbox', 'milestone' => 'M5 - Fulfillment', 'access' => 'Operator',
            'summary' => 'Pesanan yang perlu disiapkan (FR-016).',
            'items'   => ['Daftar pesanan sesuai status', 'Perbarui status pemrosesan', 'Verifikasi pembayaran tetap hanya untuk admin (BR-007)'],
        ],
        'operatorShipments' => [
            'area' => 'staff', 'title' => 'Pengiriman', 'icon' => 'truck', 'milestone' => 'M5 - Fulfillment', 'access' => 'Operator',
            'summary' => 'Catat pengiriman pesanan (FR-016).',
            'items'   => ['Pilih kurir', 'Isi nomor resi', 'Perbarui status pengiriman'],
        ],
    ];

    private function page(string $key)
    {
        $module = self::MODULES[$key];
        $view   = $module['area'] === 'staff' ? 'panel/soon' : 'frontend/soon';

        return view($view, [
            'title'   => $module['title'],
            'heading' => $module['title'],
            'crumb'   => $module['title'],
            'module'  => $module,
        ]);
    }

    // Publik & customer
    public function catalog()                     { return $this->page('catalog'); }
    public function product(string $slug = '')    { return $this->page('product'); }
    public function cart()                        { return $this->page('cart'); }
    public function checkout()                    { return $this->page('checkout'); }
    public function orders()                      { return $this->page('orders'); }
    public function orderDetail(string $id = '')  { return $this->page('orderDetail'); }

    // Admin
    public function adminOrders()                 { return $this->page('adminOrders'); }
    public function adminReports()                { return $this->page('adminReports'); }
    public function adminUsers()                  { return $this->page('adminUsers'); }

    // Operator
    public function operatorOrders()              { return $this->page('operatorOrders'); }
    public function operatorShipments()           { return $this->page('operatorShipments'); }
}
