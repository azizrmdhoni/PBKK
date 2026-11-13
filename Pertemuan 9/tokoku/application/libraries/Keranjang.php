<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Keranjang belanja berbasis session.
 * Yang disimpan hanya [id_produk => qty]; harga selalu diambil dari database.
 */
class Keranjang {
    protected $CI;

    public function __construct() { $this->CI =& get_instance(); }

    private function baca()    { return $this->CI->session->userdata('keranjang') ?: []; }
    private function tulis($k) { $this->CI->session->set_userdata('keranjang', $k); }

    public function qty($id)        { $k = $this->baca(); return isset($k[$id]) ? $k[$id] : 0; }
    public function tambah($id, $q) { $k = $this->baca(); $k[$id] = $this->qty($id) + $q; $this->tulis($k); }
    public function ubah($id, $q) {
        $k = $this->baca();
        if ($q <= 0) unset($k[$id]); else $k[$id] = $q;
        $this->tulis($k);
    }
    public function hapus($id)  { $this->ubah($id, 0); }
    public function kosongkan() { $this->CI->session->unset_userdata('keranjang'); }
    public function jumlah()    { return array_sum($this->baca()); }

    public function item() {
        $k = $this->baca();
        if (!$k) return [];
        $rows = $this->CI->db->where_in('id', array_keys($k))->get('produk')->result_array();
        foreach ($rows as &$r) {
            $r['qty']      = $k[$r['id']];
            $r['subtotal'] = $r['harga'] * $r['qty'];
        }
        return $rows;
    }
    public function total() {
        $t = 0;
        foreach ($this->item() as $i) $t += $i['subtotal'];
        return $t;
    }
}
