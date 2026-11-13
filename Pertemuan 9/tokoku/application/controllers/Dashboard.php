<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct() { parent::__construct(); $this->wajib_login(['admin']); }

    public function index() {
        $omzet = $this->db->select_sum('total')->where_in('status', ['dibayar', 'dikirim', 'selesai'])
                          ->get('pesanan')->row()->total;
        $status = $this->db->select('status, COUNT(*) AS n')->group_by('status')->get('pesanan')->result_array();
        $this->render_admin('admin/dashboard', [
            'title'     => 'Dashboard',
            'n_produk'  => $this->db->count_all('produk'),
            'n_pesanan' => $this->db->count_all('pesanan'),
            'n_pelanggan' => $this->db->where('role', 'pelanggan')->count_all_results('user'),
            'omzet'     => (int)$omzet,
            'status'    => $status,
            'terbaru'   => $this->db->select('pesanan.*, user.nama AS pelanggan')->from('pesanan')
                                ->join('user', 'user.id = pesanan.user_id')->order_by('pesanan.id', 'DESC')->limit(6)->get()->result_array(),
            'menipis'   => $this->db->where('stok <=', 10)->order_by('stok', 'ASC')->limit(6)->get('produk')->result_array(),
        ]);
    }
}
