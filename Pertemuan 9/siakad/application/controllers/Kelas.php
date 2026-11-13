<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends Crud_Controller {
    protected $tabel = 'kelas';
    protected $judul = 'Kelas';
    protected $fields = [
        'matakuliah_id' => ['label' => 'Mata Kuliah', 'type' => 'select', 'rules' => 'required'],
        'dosen_id'      => ['label' => 'Dosen',       'type' => 'select', 'rules' => 'required'],
        'hari'          => ['label' => 'Hari',        'type' => 'select', 'rules' => 'required'],
        'jam'           => ['label' => 'Jam (mis. 08:00-10:30)',  'type' => 'text',   'rules' => 'required'],
        'ruang'         => ['label' => 'Ruang',       'type' => 'text',   'rules' => 'required'],
        'semester'      => ['label' => 'Semester (mis. 2026/1)',  'type' => 'text',   'rules' => 'required'],
        'kuota'         => ['label' => 'Kuota',       'type' => 'number', 'rules' => 'required|integer|greater_than[0]'],
    ];
    protected $kolom = [
        'matkul' => 'Mata Kuliah', 'dosen' => 'Dosen', 'hari' => 'Hari',
        'jam' => 'Jam', 'ruang' => 'Ruang', 'semester' => 'Semester', 'kuota' => 'Kuota',
    ];

    protected function opsi($field) {
        if ($field == 'matakuliah_id') return array_column($this->db->get('matakuliah')->result_array(), 'nama', 'id');
        if ($field == 'dosen_id')      return array_column($this->db->get('dosen')->result_array(), 'nama', 'id');
        if ($field == 'hari') {
            $h = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            return array_combine($h, $h);
        }
        return [];
    }
    protected function daftar() {
        return $this->db->select('kelas.*, matakuliah.nama AS matkul, dosen.nama AS dosen')
            ->from('kelas')
            ->join('matakuliah', 'matakuliah.id = kelas.matakuliah_id')
            ->join('dosen', 'dosen.id = kelas.dosen_id')
            ->order_by('kelas.id', 'DESC')->get()->result_array();
    }
}
