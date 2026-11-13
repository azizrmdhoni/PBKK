<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Toko extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->wajib_login();            // seluruh toko wajib login
        $this->load->model('Produk_model', 'produk');
    }

    public function index() {
        $kat  = $this->input->get('kategori');
        $cari = $this->input->get('cari', true);
        $urut = $this->input->get('urut');
        $this->render('toko/index', [
            'title'    => 'Katalog',
            'produk'   => $this->produk->getAll($kat, $cari, $urut),
            'kategori' => $this->db->get('kategori')->result_array(),
            'kat' => $kat, 'cari' => $cari, 'urut' => $urut,
        ]);
    }

    public function detail($id) {
        $p = $this->produk->getById($id);
        if (!$p) show_404();
        $mirip = array_filter($this->produk->getAll($p['kategori_id']), function ($x) use ($id) { return $x['id'] != $id; });
        $this->render('toko/detail', ['title' => $p['nama'], 'p' => $p, 'mirip' => array_slice($mirip, 0, 4)]);
    }
}
