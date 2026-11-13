<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('role')) {
            $this->_arahkan($this->session->userdata('role'));
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
            return;
        }

        $user = $this->M_user->by_username($this->input->post('username', TRUE));

        if ($user && password_verify($this->input->post('password'), $user->password)) {
            $this->session->set_userdata([
                'id_user'  => $user->id_user,
                'nama'     => $user->nama,
                'role'     => $user->role,
                'nim'      => $user->role === 'mahasiswa' ? $user->username : null,
            ]);
            $this->_arahkan($user->role);
        }

        $this->session->set_flashdata('error', 'Username atau password salah.');
        redirect('auth');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    private function _arahkan($role)
    {
        redirect($role === 'admin' ? 'admin/dashboard' : 'portal');
    }
}
