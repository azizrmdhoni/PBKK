<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan_model extends CI_Model {

    // buat pesanan + detail + kurangi stok dalam satu transaksi
    public function buat($user_id, $post, $items, $total) {
        $kode = 'INV' . date('ymdHis') . rand(10, 99);

        $this->db->trans_start();
        $this->db->insert('pesanan', [
            'kode' => $kode, 'user_id' => $user_id,
            'nama_penerima' => $post['nama_penerima'],
            'telepon' => $post['telepon'], 'alamat' => $post['alamat'],
            'total' => $total,
        ]);
        $pid = $this->db->insert_id();

        foreach ($items as $i) {
            $this->db->insert('detail_pesanan', [
                'pesanan_id' => $pid, 'produk_id' => $i['id'],
                'nama' => $i['nama'], 'harga' => $i['harga'], 'qty' => $i['qty'],
            ]);
            $this->db->set('stok', 'stok - ' . (int)$i['qty'], FALSE)
                     ->where('id', $i['id'])->update('produk');
        }
        $this->db->trans_complete();

        return $this->db->trans_status() ? $kode : false;
    }

    public function getByKode($kode) { return $this->db->get_where('pesanan', ['kode' => $kode])->row_array(); }
    public function getById($id)     { return $this->db->get_where('pesanan', ['id' => $id])->row_array(); }
    public function getItems($pid)   { return $this->db->get_where('detail_pesanan', ['pesanan_id' => $pid])->result_array(); }
}
