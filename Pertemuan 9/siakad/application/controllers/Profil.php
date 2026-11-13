<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller {
    public function __construct() { parent::__construct(); $this->wajib_login(['mahasiswa']); }

    public function index() {
        $m = $this->data_mahasiswa();
        $err = '';

        if ($this->input->method() == 'post') {
            $this->load->library('upload', [
                'upload_path' => './uploads/foto/', 'allowed_types' => 'jpg|jpeg|png',
                'max_size' => 2048, 'encrypt_name' => TRUE,
            ]);
            if ($this->upload->do_upload('foto')) {
                if ($m['foto'] && is_file('./uploads/foto/' . $m['foto'])) unlink('./uploads/foto/' . $m['foto']);
                $this->db->where('id', $m['id'])->update('mahasiswa', ['foto' => $this->upload->data('file_name')]);
                $this->session->set_flashdata('pesan', 'Foto berhasil diperbarui.');
                redirect('profil');
            }
            $err = $this->upload->display_errors('', '');
        }
        $this->render('profil/index', ['title' => 'Profil', 'm' => $m, 'err' => $err]);
    }
}
