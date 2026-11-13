<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Halaman untuk mahasiswa yang login
class Portal extends Mhs_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_mahasiswa', 'M_krs', 'M_user']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $krs = $this->M_krs->by_nim($this->nim);
        $this->render('mahasiswa/beranda', [
            'title' => 'Beranda',
            'mhs'   => $this->M_mahasiswa->get_detail($this->nim),
            'krs'   => $krs,
            'ipk'   => $this->M_krs->hitung_ipk($krs),
        ]);
    }

    public function khs()
    {
        $krs = $this->M_krs->by_nim($this->nim);
        $this->render('mahasiswa/khs', [
            'title' => 'Kartu Hasil Studi',
            'mhs'   => $this->M_mahasiswa->get_detail($this->nim),
            'krs'   => $krs,
            'ipk'   => $this->M_krs->hitung_ipk($krs),
        ]);
    }

    public function password()
    {
        $this->form_validation->set_rules('lama', 'Password lama', 'required');
        $this->form_validation->set_rules('baru', 'Password baru', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi', 'Konfirmasi', 'required|matches[baru]');

        if ($this->form_validation->run() == FALSE) {
            return $this->render('mahasiswa/password', ['title' => 'Ganti Password']);
        }

        $user = $this->M_user->get($this->session->userdata('id_user'));
        if (!password_verify($this->input->post('lama'), $user->password)) {
            $this->session->set_flashdata('error', 'Password lama salah.');
            redirect('portal/password');
        }
        $this->M_user->update($user->id_user, [
            'password' => password_hash($this->input->post('baru'), PASSWORD_DEFAULT),
        ]);
        $this->session->set_flashdata('success', 'Password berhasil diganti.');
        redirect('portal');
    }
}
