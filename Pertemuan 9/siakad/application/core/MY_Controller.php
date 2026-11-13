<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    // Halaman dengan sidebar
    protected function render($view, $data = []) {
        $this->load->view('layout/header', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/footer');
    }

    // Halaman login (layar penuh, tanpa menu)
    protected function render_auth($view, $data = []) {
        $this->load->view($view, $data);
    }

    // wajib login, dan (opsional) hanya role tertentu
    protected function wajib_login($roles = []) {
        if (!$this->session->userdata('login')) {
            redirect('auth');
        }
        if ($roles && !in_array($this->session->userdata('role'), $roles)) {
            show_error('Anda tidak punya akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    // data mahasiswa / dosen milik user yang sedang login
    protected function data_mahasiswa() {
        $m = $this->db->get_where('mahasiswa', ['user_id' => $this->session->userdata('uid')])->row_array();
        if (!$m) show_error('Data mahasiswa tidak ditemukan.');
        return $m;
    }
    protected function data_dosen() {
        $d = $this->db->get_where('dosen', ['user_id' => $this->session->userdata('uid')])->row_array();
        if (!$d) show_error('Data dosen tidak ditemukan.');
        return $d;
    }
}

/**
 * Controller CRUD generik (admin). Dipakai oleh Mahasiswa, Dosen, Matakuliah, Kelas.
 * Controller turunan cukup mengisi $tabel, $judul, $fields, $kolom.
 */
abstract class Crud_Controller extends MY_Controller {
    protected $tabel;
    protected $judul;
    protected $fields = [];   // 'kolom' => ['label'=>, 'type'=>text|number|select, 'rules'=>]
    protected $kolom  = [];   // kolom yang tampil di daftar: 'kolom' => 'Label'

    public function __construct() {
        parent::__construct();
        $this->wajib_login(['admin']);
    }

    // ---- bisa di-override oleh controller turunan ----
    protected function daftar()                    { return $this->db->order_by('id', 'DESC')->get($this->tabel)->result_array(); }
    protected function opsi($field)                { return []; }
    protected function sebelum_simpan($data, $id)  { return $data; }
    protected function sesudah_hapus($row)         { }

    public function index() {
        $this->render('crud/index', [
            'title' => $this->judul, 'judul' => $this->judul, 'datatables' => true,
            'rows'  => $this->daftar(), 'kolom' => $this->kolom,
            'ctrl'  => strtolower($this->router->class),
        ]);
    }
    public function tambah()  { $this->form(null); }
    public function ubah($id) { $this->form($id); }

    protected function form($id) {
        $row = [];
        if ($id) {
            $row = $this->db->get_where($this->tabel, ['id' => $id])->row_array();
            if (!$row) show_404();
        }
        foreach ($this->fields as $f => $c) {
            $rules = isset($c['rules']) ? $c['rules'] : '';
            if ($id) $rules = preg_replace('/\|?is_unique\[[^\]]+\]/', '', $rules); // cek unik hanya saat tambah
            $this->form_validation->set_rules($f, $c['label'], $rules);
        }

        if ($this->form_validation->run() == FALSE) {
            $opsi = [];
            foreach ($this->fields as $f => $c) if ($c['type'] == 'select') $opsi[$f] = $this->opsi($f);
            return $this->render('crud/form', [
                'title' => $this->judul, 'judul' => $this->judul, 'row' => $row,
                'fields' => $this->fields, 'opsi' => $opsi, 'ctrl' => strtolower($this->router->class),
            ]);
        }

        $data = [];
        foreach ($this->fields as $f => $c) $data[$f] = $this->input->post($f, true);
        $data = $this->sebelum_simpan($data, $id);

        if ($id) $this->db->where('id', $id)->update($this->tabel, $data);
        else     $this->db->insert($this->tabel, $data);

        $this->session->set_flashdata('pesan', 'Data berhasil disimpan.');
        redirect(strtolower($this->router->class));
    }

    public function hapus($id) {
        $row = $this->db->get_where($this->tabel, ['id' => $id])->row_array();
        if ($row) {
            $this->db->delete($this->tabel, ['id' => $id]);
            $this->sesudah_hapus($row);
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect(strtolower($this->router->class));
    }
}
