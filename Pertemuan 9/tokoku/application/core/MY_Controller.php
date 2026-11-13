<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    // Halaman toko (publik)
    protected function render($view, $data = []) {
        $this->load->view('layout/header', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/footer');
    }

    // Halaman admin (sidebar)
    protected function render_admin($view, $data = []) {
        $data['n_verif'] = $this->db->where('status', 'menunggu verifikasi')->count_all_results('pesanan');
        $this->load->view('layout/admin_header', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/admin_footer');
    }

    // Halaman login/daftar (layar penuh, tanpa menu)
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
}
