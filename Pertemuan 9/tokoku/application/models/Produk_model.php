<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {
    public function getAll($kategori = null, $cari = null, $urut = null) {
        $this->db->select('produk.*, kategori.nama AS kategori')
                 ->from('produk')
                 ->join('kategori', 'kategori.id = produk.kategori_id', 'left');
        if ($kategori) $this->db->where('produk.kategori_id', $kategori);
        if ($cari)     $this->db->like('produk.nama', $cari);
        if ($urut == 'murah')      $this->db->order_by('produk.harga', 'ASC');
        elseif ($urut == 'mahal')  $this->db->order_by('produk.harga', 'DESC');
        elseif ($urut == 'nama')   $this->db->order_by('produk.nama', 'ASC');
        else                       $this->db->order_by('produk.id', 'DESC');
        return $this->db->get()->result_array();
    }
    public function getById($id) {
        return $this->db->select('produk.*, kategori.nama AS kategori')->from('produk')
                        ->join('kategori', 'kategori.id = produk.kategori_id', 'left')
                        ->where('produk.id', $id)->get()->row_array();
    }
    public function simpan($data, $id = null) {
        if ($id) return $this->db->where('id', $id)->update('produk', $data);
        return $this->db->insert('produk', $data);
    }
    public function hapus($id) { return $this->db->delete('produk', ['id' => $id]); }
}
