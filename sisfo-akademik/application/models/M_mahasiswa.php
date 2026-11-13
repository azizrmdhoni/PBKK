<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mahasiswa extends MY_Model
{
    protected $table = 'mahasiswa';
    protected $pk = 'nim';

    public function get_all()
    {
        return $this->db->select('mahasiswa.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan')
            ->order_by('mahasiswa.nim')->get('mahasiswa')->result();
    }

    public function get_detail($nim)
    {
        return $this->db->select('mahasiswa.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan')
            ->where('mahasiswa.nim', $nim)->get('mahasiswa')->row();
    }
}
