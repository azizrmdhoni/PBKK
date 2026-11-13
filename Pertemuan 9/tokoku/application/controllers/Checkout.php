<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->wajib_login(['pelanggan']);
        $this->load->model('Pesanan_model', 'pesanan');
    }

    public function index() {
        $items = $this->keranjang->item();
        if (!$items) redirect('belanja');

        $this->form_validation->set_rules('nama_penerima', 'Nama penerima', 'required');
        $this->form_validation->set_rules('telepon', 'Telepon', 'required|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->render('checkout/index', [
                'title' => 'Checkout', 'items' => $items, 'total' => $this->keranjang->total(),
            ]);
        }

        foreach ($items as $i) {            // cek stok terakhir
            if ($i['qty'] > $i['stok']) {
                $this->session->set_flashdata('error', 'Stok ' . $i['nama'] . ' tidak cukup.');
                redirect('belanja');
            }
        }
        $kode = $this->pesanan->buat(
            $this->session->userdata('uid'), $this->input->post(NULL, true),
            $items, $this->keranjang->total()
        );
        if (!$kode) show_error('Gagal membuat pesanan.');

        $this->keranjang->kosongkan();
        redirect('checkout/bayar/' . $kode);
    }

    // halaman pembayaran + upload bukti transfer
    public function bayar($kode) {
        $p = $this->pesanan->getByKode($kode);
        if (!$p || $p['user_id'] != $this->session->userdata('uid')) show_404();

        $err = '';
        if ($this->input->method() == 'post') {
            $this->load->library('upload', [
                'upload_path' => './uploads/bukti/', 'allowed_types' => 'jpg|jpeg|png|pdf',
                'max_size' => 2048, 'encrypt_name' => TRUE,
            ]);
            if ($this->upload->do_upload('bukti')) {
                $this->db->where('id', $p['id'])->update('pesanan', [
                    'bukti' => $this->upload->data('file_name'), 'status' => 'menunggu verifikasi',
                ]);
                $this->session->set_flashdata('pesan', 'Bukti pembayaran terkirim.');
                redirect('checkout/bayar/' . $kode);
            }
            $err = $this->upload->display_errors('', '');
        }
        $this->render('checkout/bayar', [
            'title' => 'Pembayaran', 'p' => $p, 'items' => $this->pesanan->getItems($p['id']), 'err' => $err,
        ]);
    }

    public function riwayat() {
        $rows = $this->db->order_by('id', 'DESC')
                         ->get_where('pesanan', ['user_id' => $this->session->userdata('uid')])->result_array();
        $this->render('checkout/riwayat', ['title' => 'Pesanan Saya', 'pesanan' => $rows]);
    }
}
