<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Format rupiah
if (!function_exists('rupiah')) {
    function rupiah($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
}

// URL gambar produk (gambar upload, atau ilustrasi kategori bila kosong)
if (!function_exists('gambar_produk')) {
    function gambar_produk($p) {
        if (!empty($p['gambar']) && is_file(FCPATH . 'uploads/produk/' . $p['gambar'])) {
            return base_url('uploads/produk/' . $p['gambar']);
        }
        $k = isset($p['kategori_id']) ? (int)$p['kategori_id'] : 0;
        $f = is_file(FCPATH . 'assets/img/kategori/' . $k . '.svg') ? $k : 0;
        return base_url('assets/img/kategori/' . $f . '.svg');
    }
}

// Badge status pesanan berwarna
if (!function_exists('badge_status')) {
    function badge_status($s) {
        $map = [
            'menunggu pembayaran' => 'warning', 'menunggu verifikasi' => 'info',
            'dibayar' => 'primary', 'dikirim' => 'primary', 'selesai' => 'success', 'batal' => 'danger',
        ];
        $c = isset($map[$s]) ? $map[$s] : 'secondary';
        return '<span class="badge-soft bs-' . $c . '">' . html_escape($s) . '</span>';
    }
}

// Inisial nama untuk avatar
if (!function_exists('inisial')) {
    function inisial($nama) {
        $p = preg_split('/\s+/', trim($nama));
        $i = strtoupper(substr($p[0], 0, 1));
        if (isset($p[1])) $i .= strtoupper(substr($p[1], 0, 1));
        return $i;
    }
}
