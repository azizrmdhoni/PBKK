<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai extends MY_Controller {
    private $dsn;

    public function __construct() {
        parent::__construct();
        $this->wajib_login(['dosen']);
        $this->dsn = $this->data_dosen();
    }

    // daftar kelas yang diampu
    public function index() {
        $rows = $this->db->query(
            "SELECT k.id, k.hari, k.jam, k.semester, mk.kode, mk.nama AS matkul,
                    (SELECT COUNT(*) FROM krs WHERE kelas_id = k.id) AS peserta
             FROM kelas k JOIN matakuliah mk ON mk.id = k.matakuliah_id
             WHERE k.dosen_id = ?", [$this->dsn['id']])->result_array();
        $this->render('nilai/index', ['title' => 'Input Nilai', 'kelas' => $rows]);
    }

    private function kelas_milik($kelas_id) {
        $k = $this->db->query(
            "SELECT k.*, mk.nama AS matkul FROM kelas k JOIN matakuliah mk ON mk.id = k.matakuliah_id
             WHERE k.id = ? AND k.dosen_id = ?", [$kelas_id, $this->dsn['id']])->row_array();
        if (!$k) show_error('Kelas bukan milik Anda.', 403);
        return $k;
    }

    // daftar peserta + form nilai
    public function peserta($kelas_id) {
        $k = $this->kelas_milik($kelas_id);
        $peserta = $this->db->query(
            "SELECT krs.id AS krs_id, krs.nilai_angka, krs.nilai_huruf, m.nim, m.nama
             FROM krs JOIN mahasiswa m ON m.id = krs.mahasiswa_id
             WHERE krs.kelas_id = ? ORDER BY m.nim", [$kelas_id])->result_array();
        $this->render('nilai/peserta', ['title' => 'Peserta Kelas', 'k' => $k, 'peserta' => $peserta]);
    }

    public function simpan($kelas_id) {
        $this->kelas_milik($kelas_id);
        $nilai = $this->input->post('nilai');
        if (is_array($nilai)) {
            foreach ($nilai as $krs_id => $angka) {
                if ($angka === '' || !is_numeric($angka) || $angka < 0 || $angka > 100) continue;
                list($huruf, $bobot) = $this->konversi((float)$angka);
                $this->db->where(['id' => (int)$krs_id, 'kelas_id' => $kelas_id])
                         ->update('krs', ['nilai_angka' => $angka, 'nilai_huruf' => $huruf, 'bobot' => $bobot]);
            }
        }
        $this->session->set_flashdata('pesan', 'Nilai tersimpan.');
        redirect('nilai/peserta/' . $kelas_id);
    }

    // skala nilai
    private function konversi($n) {
        if ($n >= 85) return ['A', 4.0];
        if ($n >= 75) return ['B+', 3.5];
        if ($n >= 65) return ['B', 3.0];
        if ($n >= 55) return ['C+', 2.5];
        if ($n >= 45) return ['C', 2.0];
        if ($n >= 35) return ['D', 1.0];
        return ['E', 0.0];
    }
}
