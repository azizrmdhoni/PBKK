<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matakuliah extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_matakuliah', 'M_jurusan', 'M_dosen']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->render('admin/matakuliah/index', [
            'title' => 'Data Mata Kuliah',
            'rows'  => $this->M_matakuliah->get_all(),
        ]);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('kode_mk', 'Kode MK', 'required|trim|is_unique[matakuliah.kode_mk]');
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/matakuliah/form', $this->_formdata('Tambah Mata Kuliah', null));
        }
        $data = $this->_input();
        $data['kode_mk'] = $this->input->post('kode_mk', TRUE);
        $this->M_matakuliah->insert($data);
        $this->session->set_flashdata('success', 'Mata kuliah ditambahkan.');
        redirect('admin/matakuliah');
    }

    public function edit($kode)
    {
        $row = $this->M_matakuliah->get($kode);
        if (!$row) show_404();

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/matakuliah/form', $this->_formdata('Edit Mata Kuliah', $row));
        }
        $this->M_matakuliah->update($kode, $this->_input());
        $this->session->set_flashdata('success', 'Mata kuliah diperbarui.');
        redirect('admin/matakuliah');
    }

    public function hapus($kode)
    {
        $this->M_matakuliah->delete($kode);
        $this->session->set_flashdata('success', 'Mata kuliah dihapus.');
        redirect('admin/matakuliah');
    }

    private function _formdata($title, $row)
    {
        return [
            'title' => $title, 'row' => $row,
            'jurusan' => $this->M_jurusan->get_all(),
            'dosen'   => $this->M_dosen->get_all(),
        ];
    }

    private function _rules()
    {
        $this->form_validation->set_rules('nama_mk', 'Nama MK', 'required|trim');
        $this->form_validation->set_rules('sks', 'SKS', 'required|integer|greater_than[0]|less_than[7]');
        $this->form_validation->set_rules('semester', 'Semester', 'required|integer|greater_than[0]|less_than[15]');
        $this->form_validation->set_rules('id_jurusan', 'Jurusan', 'required|integer');
    }

    private function _input()
    {
        return [
            'nama_mk'    => $this->input->post('nama_mk', TRUE),
            'sks'        => $this->input->post('sks', TRUE),
            'semester'   => $this->input->post('semester', TRUE),
            'id_jurusan' => $this->input->post('id_jurusan', TRUE),
            'nidn'       => $this->input->post('nidn', TRUE) ?: NULL,
        ];
    }
}
