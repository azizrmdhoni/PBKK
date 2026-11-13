<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    private function tujuan($role) { return $role == 'admin' ? 'dashboard' : 'toko'; }

    public function index() {
        if ($this->session->userdata('login')) redirect($this->tujuan($this->session->userdata('role')));

        $this->form_validation->set_rules('username', 'Email', 'required|valid_email', ['valid_email' => 'Format email tidak valid.', 'required' => 'Email wajib diisi.']);
        $this->form_validation->set_rules('password', 'Password', 'required', ['required' => 'Password wajib diisi.']);

        if ($this->form_validation->run() == FALSE) {
            return $this->render_auth('auth/login', ['title' => 'Masuk']);
        }

        $u = $this->db->get_where('user', ['username' => $this->input->post('username', true)])->row_array();

        if ($u && password_verify($this->input->post('password'), $u['password'])) {
            $this->session->set_userdata([
                'login' => TRUE, 'uid' => $u['id'],
                'nama'  => $u['nama'], 'role' => $u['role'],
            ]);
            $this->session->set_flashdata('pesan', 'Selamat datang, ' . $u['nama'] . '!');
            redirect($this->tujuan($u['role']));
        }
        $this->session->set_flashdata('error', 'Email atau password salah.');
        redirect('auth');
    }

    public function register() {
        if ($this->session->userdata('login')) redirect($this->tujuan($this->session->userdata('role')));

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Email', 'required|valid_email|is_unique[user.username]', ['is_unique' => 'Email ini sudah terdaftar.']);
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi', 'Konfirmasi', 'required|matches[password]', ['matches' => 'Konfirmasi password tidak sama.']);

        if ($this->form_validation->run() == FALSE) {
            return $this->render_auth('auth/register', ['title' => 'Daftar']);
        }
        $this->db->insert('user', [
            'username' => $this->input->post('username', true),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama'     => $this->input->post('nama', true),
            'role'     => 'pelanggan',
        ]);
        $this->session->set_flashdata('pesan', 'Registrasi berhasil, silakan masuk.');
        redirect('auth');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
