<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Khs extends MY_Controller {
    public function __construct() { parent::__construct(); $this->wajib_login(['mahasiswa']); }

    public function index() {
        $m = $this->data_mahasiswa();
        $rows = $this->db->query(
            "SELECT k.semester, mk.kode, mk.nama, mk.sks, krs.nilai_angka, krs.nilai_huruf, krs.bobot
             FROM krs JOIN kelas k ON k.id = krs.kelas_id JOIN matakuliah mk ON mk.id = k.matakuliah_id
             WHERE krs.mahasiswa_id = ? ORDER BY k.semester, mk.kode", [$m['id']])->result_array();

        $per = []; $tot_sks = 0; $tot_mutu = 0;
        foreach ($rows as $r) {
            $s = $r['semester'];
            if (!isset($per[$s])) $per[$s] = ['mk' => [], 'sks' => 0, 'mutu' => 0];
            $per[$s]['mk'][] = $r;
            if ($r['nilai_huruf'] !== null) {           // hanya matkul yang sudah bernilai
                $per[$s]['sks']  += $r['sks'];
                $per[$s]['mutu'] += $r['sks'] * $r['bobot'];
                $tot_sks  += $r['sks'];
                $tot_mutu += $r['sks'] * $r['bobot'];
            }
        }
        $this->render('khs/index', [
            'title' => 'KHS', 'm' => $m, 'per' => $per,
            'ipk' => $tot_sks ? round($tot_mutu / $tot_sks, 2) : 0, 'tot_sks' => $tot_sks,
        ]);
    }
}
