<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_dosen');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->render('admin/dosen/index', [
            'title' => 'Data Dosen',
            'rows'  => $this->M_dosen->get_all(),
        ]);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nidn', 'NIDN', 'required|trim|is_unique[dosen.nidn]');
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/dosen/form', ['title' => 'Tambah Dosen', 'row' => null]);
        }
        $data = $this->_input();
        $data['nidn'] = $this->input->post('nidn', TRUE);
        $this->M_dosen->insert($data);
        $this->session->set_flashdata('success', 'Dosen berhasil ditambahkan.');
        redirect('admin/dosen');
    }

    public function edit($nidn)
    {
        $row = $this->M_dosen->get($nidn);
        if (!$row) show_404();

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/dosen/form', ['title' => 'Edit Dosen', 'row' => $row]);
        }
        $this->M_dosen->update($nidn, $this->_input());
        $this->session->set_flashdata('success', 'Data dosen diperbarui.');
        redirect('admin/dosen');
    }

    public function hapus($nidn)
    {
        $this->M_dosen->delete($nidn);
        $this->session->set_flashdata('success', 'Dosen dihapus.');
        redirect('admin/dosen');
    }

    private function _rules()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
    }

    private function _input()
    {
        return [
            'nama'    => $this->input->post('nama', TRUE),
            'email'   => $this->input->post('email', TRUE),
            'telepon' => $this->input->post('telepon', TRUE),
        ];
    }
}
