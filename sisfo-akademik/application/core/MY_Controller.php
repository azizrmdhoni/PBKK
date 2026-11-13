<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Controller dasar: halaman khusus admin
class Admin_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Silakan login sebagai admin.');
            redirect('auth');
        }
    }

    protected function render($view, $data = [])
    {
        $this->load->view('admin/layout/header', $data);
        $this->load->view($view, $data);
        $this->load->view('admin/layout/footer');
    }
}

// Controller dasar: halaman khusus mahasiswa
class Mhs_Controller extends CI_Controller
{
    protected $nim;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') !== 'mahasiswa') {
            $this->session->set_flashdata('error', 'Silakan login sebagai mahasiswa.');
            redirect('auth');
        }
        $this->nim = $this->session->userdata('nim');
    }

    protected function render($view, $data = [])
    {
        $this->load->view('mahasiswa/layout/header', $data);
        $this->load->view($view, $data);
        $this->load->view('mahasiswa/layout/footer');
    }
}
