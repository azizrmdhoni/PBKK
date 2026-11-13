<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_krs extends MY_Model
{
    protected $table = 'krs';
    protected $pk = 'id_krs';

    // Bobot nilai huruf
    public static $bobot = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];

    public function get_all()
    {
        return $this->db->select('krs.*, mahasiswa.nama AS nama_mhs, matakuliah.nama_mk, matakuliah.sks')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('matakuliah', 'matakuliah.kode_mk = krs.kode_mk')
            ->order_by('krs.tahun_ajaran DESC, krs.nim')
            ->get('krs')->result();
    }

    public function by_nim($nim)
    {
        return $this->db->select('krs.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.semester')
            ->join('matakuliah', 'matakuliah.kode_mk = krs.kode_mk')
            ->where('krs.nim', $nim)
            ->order_by('krs.tahun_ajaran, matakuliah.kode_mk')
            ->get('krs')->result();
    }

    public function sudah_ada($nim, $kode_mk, $tahun)
    {
        return $this->db->where(['nim' => $nim, 'kode_mk' => $kode_mk, 'tahun_ajaran' => $tahun])
            ->count_all_results('krs') > 0;
    }

    // Hitung IPK dari daftar KRS yang sudah bernilai
    public function hitung_ipk($rows)
    {
        $sks = 0; $mutu = 0;
        foreach ($rows as $r) {
            if ($r->nilai && isset(self::$bobot[$r->nilai])) {
                $sks  += $r->sks;
                $mutu += $r->sks * self::$bobot[$r->nilai];
            }
        }
        return $sks > 0 ? round($mutu / $sks, 2) : 0;
    }
}
