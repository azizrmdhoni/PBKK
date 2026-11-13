<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function index() {
        if ($this->session->userdata('login')) redirect('dashboard');

        $this->form_validation->set_rules('username', 'Username', 'required', ['required' => 'Username wajib diisi.']);
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
            redirect('dashboard');
        }
        $this->session->set_flashdata('error', 'Username atau password salah.');
        redirect('auth');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
