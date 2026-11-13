<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct() { parent::__construct(); $this->wajib_login(); }

    public function index() {
        $role = $this->session->userdata('role');
        $data = ['title' => 'Dashboard', 'role' => $role, 'jadwal' => [], 'stat' => []];

        if ($role == 'admin') {
            $data['stat'] = [
                'Mahasiswa'   => $this->db->count_all('mahasiswa'),
                'Dosen'       => $this->db->count_all('dosen'),
                'Mata Kuliah' => $this->db->count_all('matakuliah'),
                'Kelas'       => $this->db->count_all('kelas'),
            ];
            $data['per_prodi'] = $this->db->select('prodi, COUNT(*) AS n')->group_by('prodi')->get('mahasiswa')->result_array();
            $data['kelas_baru'] = $this->db->query(
                "SELECT k.hari, k.jam, k.semester, mk.nama AS matkul, d.nama AS dosen
                 FROM kelas k JOIN matakuliah mk ON mk.id = k.matakuliah_id JOIN dosen d ON d.id = k.dosen_id
                 ORDER BY k.id DESC LIMIT 5")->result_array();
        } elseif ($role == 'dosen') {
            $d = $this->data_dosen();
            $data['jadwal'] = $this->db->query(
                "SELECT k.hari, k.jam, k.ruang, m.nama AS matkul
                 FROM kelas k JOIN matakuliah m ON m.id = k.matakuliah_id
                 WHERE k.dosen_id = ? ORDER BY FIELD(k.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), k.jam", [$d['id']])->result_array();
            $data['stat'] = [
                'Kelas Diampu' => count($data['jadwal']),
                'Total Peserta' => (int)$this->db->query("SELECT COUNT(*) AS n FROM krs JOIN kelas k ON k.id = krs.kelas_id WHERE k.dosen_id = ?", [$d['id']])->row()->n,
            ];
        } else {
            $m = $this->data_mahasiswa();
            $data['jadwal'] = $this->db->query(
                "SELECT k.hari, k.jam, k.ruang, mk.nama AS matkul
                 FROM krs JOIN kelas k ON k.id = krs.kelas_id JOIN matakuliah mk ON mk.id = k.matakuliah_id
                 WHERE krs.mahasiswa_id = ? AND krs.nilai_huruf IS NULL ORDER BY FIELD(k.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), k.jam", [$m['id']])->result_array();
            $r = $this->db->query(
                "SELECT COALESCE(SUM(mk.sks),0) AS sks, COALESCE(SUM(mk.sks * krs.bobot),0) AS mutu
                 FROM krs JOIN kelas k ON k.id = krs.kelas_id JOIN matakuliah mk ON mk.id = k.matakuliah_id
                 WHERE krs.mahasiswa_id = ? AND krs.nilai_huruf IS NOT NULL", [$m['id']])->row();
            $aktif = $this->db->query(
                "SELECT COALESCE(SUM(mk.sks),0) AS s FROM krs JOIN kelas k ON k.id = krs.kelas_id JOIN matakuliah mk ON mk.id = k.matakuliah_id
                 WHERE krs.mahasiswa_id = ? AND krs.nilai_huruf IS NULL", [$m['id']])->row()->s;
            $data['stat'] = [
                'IPK' => $r->sks > 0 ? number_format($r->mutu / $r->sks, 2) : '0.00',
                'SKS Lulus' => (int)$r->sks, 'SKS Berjalan' => (int)$aktif, 'Mata Kuliah' => count($data['jadwal']),
            ];
            $data['mhs'] = $m;
        }
        $this->render('dashboard/index', $data);
    }
}
