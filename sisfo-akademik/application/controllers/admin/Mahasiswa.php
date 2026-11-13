<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_mahasiswa', 'M_jurusan', 'M_user', 'M_krs']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->render('admin/mahasiswa/index', [
            'title' => 'Data Mahasiswa',
            'rows'  => $this->M_mahasiswa->get_all(),
        ]);
    }

    public function detail($nim)
    {
        $mhs = $this->M_mahasiswa->get_detail($nim);
        if (!$mhs) show_404();
        $krs = $this->M_krs->by_nim($nim);
        $this->render('admin/mahasiswa/detail', [
            'title' => 'Detail Mahasiswa',
            'mhs'   => $mhs,
            'krs'   => $krs,
            'ipk'   => $this->M_krs->hitung_ipk($krs),
        ]);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nim', 'NIM', 'required|trim|is_unique[mahasiswa.nim]|is_unique[user.username]');
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/mahasiswa/form', [
                'title' => 'Tambah Mahasiswa', 'row' => null,
                'jurusan' => $this->M_jurusan->get_all(),
            ]);
        }

        $nim = $this->input->post('nim', TRUE);

        // Buat akun login otomatis: username = NIM, password awal = NIM
        $this->M_user->insert([
            'username' => $nim,
            'password' => password_hash($nim, PASSWORD_DEFAULT),
            'nama'     => $this->input->post('nama', TRUE),
            'role'     => 'mahasiswa',
        ]);
        $data = $this->_input();
        $data['nim'] = $nim;
        $data['id_user'] = $this->db->insert_id();
        $this->M_mahasiswa->insert($data);

        $this->session->set_flashdata('success', 'Mahasiswa ditambahkan. Password awal = NIM.');
        redirect('admin/mahasiswa');
    }

    public function edit($nim)
    {
        $row = $this->M_mahasiswa->get($nim);
        if (!$row) show_404();

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/mahasiswa/form', [
                'title' => 'Edit Mahasiswa', 'row' => $row,
                'jurusan' => $this->M_jurusan->get_all(),
            ]);
        }
        $this->M_mahasiswa->update($nim, $this->_input());
        if ($row->id_user) {
            $this->M_user->update($row->id_user, ['nama' => $this->input->post('nama', TRUE)]);
        }
        $this->session->set_flashdata('success', 'Data mahasiswa diperbarui.');
        redirect('admin/mahasiswa');
    }

    public function hapus($nim)
    {
        $row = $this->M_mahasiswa->get($nim);
        if ($row) {
            $this->M_mahasiswa->delete($nim);
            if ($row->id_user) $this->M_user->delete($row->id_user);
            $this->session->set_flashdata('success', 'Mahasiswa dihapus.');
        }
        redirect('admin/mahasiswa');
    }

    private function _rules()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('id_jurusan', 'Jurusan', 'required|integer');
        $this->form_validation->set_rules('angkatan', 'Angkatan', 'required|exact_length[4]|integer');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
    }

    private function _input()
    {
        return [
            'nama'       => $this->input->post('nama', TRUE),
            'alamat'     => $this->input->post('alamat', TRUE),
            'email'      => $this->input->post('email', TRUE),
            'telepon'    => $this->input->post('telepon', TRUE),
            'id_jurusan' => $this->input->post('id_jurusan', TRUE),
            'angkatan'   => $this->input->post('angkatan', TRUE),
        ];
    }
}
