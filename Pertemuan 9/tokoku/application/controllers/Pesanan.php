<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends MY_Controller {
    private $daftar_status = ['menunggu pembayaran', 'menunggu verifikasi', 'dibayar', 'dikirim', 'selesai', 'batal'];

    public function __construct() {
        parent::__construct();
        $this->wajib_login(['admin']);
        $this->load->model('Pesanan_model', 'pesanan');
    }

    public function index() {
        $rows = $this->db->select('pesanan.*, user.nama AS pelanggan')->from('pesanan')
                    ->join('user', 'user.id = pesanan.user_id')->order_by('pesanan.id', 'DESC')
                    ->get()->result_array();
        $this->render_admin('pesanan/index', ['title' => 'Pesanan', 'datatables' => true, 'pesanan' => $rows]);
    }

    public function detail($id) {
        $p = $this->pesanan->getById($id);
        if (!$p) show_404();
        $this->render_admin('pesanan/detail', [
            'title' => 'Detail Pesanan', 'p' => $p,
            'items' => $this->pesanan->getItems($id), 'status' => $this->daftar_status,
        ]);
    }

    public function status($id) {
        $s = $this->input->post('status');
        if (in_array($s, $this->daftar_status)) {
            $this->db->where('id', $id)->update('pesanan', ['status' => $s]);
            $this->session->set_flashdata('pesan', 'Status diperbarui.');
        }
        redirect('pesanan/detail/' . $id);
    }
}
