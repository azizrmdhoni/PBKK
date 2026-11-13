<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Belanja extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->wajib_login(['pelanggan']);
    }

    public function index() {
        $this->render('belanja/index', [
            'title' => 'Keranjang',
            'items' => $this->keranjang->item(),
            'total' => $this->keranjang->total(),
        ]);
    }

    public function tambah($id) {
        $p = $this->db->get_where('produk', ['id' => $id])->row_array();
        if (!$p) show_404();

        $qty = (int)$this->input->post('qty');
        if ($qty < 1) $qty = 1;

        if ($this->keranjang->qty($id) + $qty > $p['stok']) {
            $this->session->set_flashdata('error', 'Stok tidak mencukupi.');
            redirect('toko/detail/' . $id);
        }
        $this->keranjang->tambah($id, $qty);
        $this->session->set_flashdata('pesan', 'Produk ditambahkan ke keranjang.');
        redirect('belanja');
    }

    public function ubah() {
        $qty = $this->input->post('qty');
        if (is_array($qty)) {
            foreach ($qty as $id => $q) $this->keranjang->ubah((int)$id, (int)$q);
        }
        redirect('belanja');
    }

    public function hapus($id) {
        $this->keranjang->hapus((int)$id);
        redirect('belanja');
    }
}
