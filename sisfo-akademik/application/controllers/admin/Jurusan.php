<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_jurusan');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->render('admin/jurusan/index', [
            'title' => 'Data Jurusan',
            'rows'  => $this->M_jurusan->get_all(),
        ]);
    }

    public function tambah()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/jurusan/form', ['title' => 'Tambah Jurusan', 'row' => null]);
        }
        $this->M_jurusan->insert($this->_input());
        $this->session->set_flashdata('success', 'Jurusan berhasil ditambahkan.');
        redirect('admin/jurusan');
    }

    public function edit($id)
    {
        $row = $this->M_jurusan->get($id);
        if (!$row) show_404();

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/jurusan/form', ['title' => 'Edit Jurusan', 'row' => $row]);
        }
        $this->M_jurusan->update($id, $this->_input());
        $this->session->set_flashdata('success', 'Jurusan berhasil diperbarui.');
        redirect('admin/jurusan');
    }

    public function hapus($id)
    {
        if (!$this->db->where('id_jurusan', $id)->count_all_results('mahasiswa')) {
            $this->M_jurusan->delete($id);
            $this->session->set_flashdata('success', 'Jurusan dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Jurusan masih dipakai data mahasiswa.');
        }
        redirect('admin/jurusan');
    }

    private function _rules()
    {
        $this->form_validation->set_rules('kode_jurusan', 'Kode Jurusan', 'required|trim|max_length[10]');
        $this->form_validation->set_rules('nama_jurusan', 'Nama Jurusan', 'required|trim');
    }

    private function _input()
    {
        return [
            'kode_jurusan' => $this->input->post('kode_jurusan', TRUE),
            'nama_jurusan' => $this->input->post('nama_jurusan', TRUE),
        ];
    }
}
