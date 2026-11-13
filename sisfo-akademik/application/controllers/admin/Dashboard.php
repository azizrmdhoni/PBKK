<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    public function index()
    {
        $this->load->model(['M_mahasiswa', 'M_dosen', 'M_matakuliah', 'M_jurusan']);
        $data = [
            'title'      => 'Dashboard',
            'jml_mhs'    => $this->M_mahasiswa->count(),
            'jml_dosen'  => $this->M_dosen->count(),
            'jml_mk'     => $this->M_matakuliah->count(),
            'jml_jurusan'=> $this->M_jurusan->count(),
        ];
        $this->render('admin/dashboard', $data);
    }
}
