<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_matakuliah extends MY_Model
{
    protected $table = 'matakuliah';
    protected $pk = 'kode_mk';

    public function get_all()
    {
        return $this->db->select('matakuliah.*, jurusan.nama_jurusan, dosen.nama AS nama_dosen')
            ->join('jurusan', 'jurusan.id_jurusan = matakuliah.id_jurusan')
            ->join('dosen', 'dosen.nidn = matakuliah.nidn', 'left')
            ->order_by('matakuliah.semester, matakuliah.kode_mk')
            ->get('matakuliah')->result();
    }
}
