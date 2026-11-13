<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->wajib_login(['admin']);
        $this->load->model('Produk_model', 'produk');
    }

    public function index() {
        $this->render_admin('produk/index', ['title' => 'Kelola Produk', 'datatables' => true, 'produk' => $this->produk->getAll()]);
    }
    public function tambah()  { $this->form(null); }
    public function ubah($id) { $this->form($id); }

    private function form($id) {
        $row = [];
        if ($id) { $row = $this->produk->getById($id); if (!$row) show_404(); }

        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|integer');
        $this->form_validation->set_rules('stok', 'Stok', 'required|integer');

        $err = '';
        if ($this->form_validation->run()) {
            $gambar = isset($row['gambar']) ? $row['gambar'] : null;

            if (!empty($_FILES['gambar']['name'])) {
                $this->load->library('upload', [
                    'upload_path' => './uploads/produk/', 'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 2048, 'encrypt_name' => TRUE,
                ]);
                if ($this->upload->do_upload('gambar')) {
                    if ($gambar && is_file('./uploads/produk/' . $gambar)) unlink('./uploads/produk/' . $gambar);
                    $gambar = $this->upload->data('file_name');
                } else {
                    $err = $this->upload->display_errors('', '');
                }
            }
            if (!$err) {
                $this->produk->simpan([
                    'kategori_id' => $this->input->post('kategori_id'),
                    'nama'        => $this->input->post('nama', true),
                    'deskripsi'   => $this->input->post('deskripsi', true),
                    'harga'       => $this->input->post('harga'),
                    'stok'        => $this->input->post('stok'),
                    'gambar'      => $gambar,
                ], $id);
                $this->session->set_flashdata('pesan', 'Produk berhasil disimpan.');
                redirect('produk');
            }
        }
        $this->render_admin('produk/form', [
            'title' => $id ? 'Ubah Produk' : 'Tambah Produk', 'row' => $row, 'err' => $err,
            'kategori' => $this->db->get('kategori')->result_array(),
        ]);
    }

    public function hapus($id) {
        $p = $this->produk->getById($id);
        if ($p) {
            if ($p['gambar'] && is_file('./uploads/produk/' . $p['gambar'])) unlink('./uploads/produk/' . $p['gambar']);
            $this->produk->hapus($id);
            $this->session->set_flashdata('pesan', 'Produk dihapus.');
        }
        redirect('produk');
    }
}
