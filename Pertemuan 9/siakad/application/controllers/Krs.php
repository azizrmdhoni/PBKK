<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs extends MY_Controller {
    const MAX_SKS = 24;
    private $mhs;

    public function __construct() {
        parent::__construct();
        $this->wajib_login(['mahasiswa']);
        $this->mhs = $this->data_mahasiswa();
    }

    public function index() {
        $mid = $this->mhs['id'];

        $diambil = $this->db->query(
            "SELECT krs.id AS krs_id, krs.nilai_huruf, k.hari, k.jam, k.ruang, k.semester,
                    mk.kode, mk.nama AS matkul, mk.sks, d.nama AS dosen
             FROM krs JOIN kelas k ON k.id = krs.kelas_id
             JOIN matakuliah mk ON mk.id = k.matakuliah_id JOIN dosen d ON d.id = k.dosen_id
             WHERE krs.mahasiswa_id = ? ORDER BY k.semester DESC, mk.kode", [$mid])->result_array();

        $tersedia = $this->db->query(
            "SELECT k.*, mk.kode, mk.nama AS matkul, mk.sks, d.nama AS dosen,
                    (SELECT COUNT(*) FROM krs WHERE kelas_id = k.id) AS terisi
             FROM kelas k JOIN matakuliah mk ON mk.id = k.matakuliah_id JOIN dosen d ON d.id = k.dosen_id
             WHERE k.id NOT IN (SELECT kelas_id FROM krs WHERE mahasiswa_id = ?)
             ORDER BY mk.kode", [$mid])->result_array();

        $this->render('krs/index', [
            'title' => 'KRS', 'diambil' => $diambil, 'tersedia' => $tersedia,
            'sks_aktif' => $this->sks_aktif(), 'max' => self::MAX_SKS,
        ]);
    }

    private function sks_aktif() {
        return (int)$this->db->query(
            "SELECT COALESCE(SUM(mk.sks), 0) AS t FROM krs
             JOIN kelas k ON k.id = krs.kelas_id JOIN matakuliah mk ON mk.id = k.matakuliah_id
             WHERE krs.mahasiswa_id = ? AND krs.nilai_huruf IS NULL", [$this->mhs['id']])->row()->t;
    }

    public function ambil($kelas_id) {
        $k = $this->db->query(
            "SELECT k.*, mk.sks, (SELECT COUNT(*) FROM krs WHERE kelas_id = k.id) AS terisi
             FROM kelas k JOIN matakuliah mk ON mk.id = k.matakuliah_id WHERE k.id = ?", [$kelas_id])->row_array();
        if (!$k) show_404();

        $sudah = $this->db->get_where('krs', ['mahasiswa_id' => $this->mhs['id'], 'kelas_id' => $kelas_id])->num_rows();

        if ($sudah)                                             $err = 'Kelas sudah diambil.';
        elseif ($k['terisi'] >= $k['kuota'])                    $err = 'Kuota kelas penuh.';
        elseif ($this->sks_aktif() + $k['sks'] > self::MAX_SKS) $err = 'Melebihi batas ' . self::MAX_SKS . ' SKS.';
        else                                                    $err = '';

        if ($err) {
            $this->session->set_flashdata('error', $err);
        } else {
            $this->db->insert('krs', ['mahasiswa_id' => $this->mhs['id'], 'kelas_id' => $kelas_id]);
            $this->session->set_flashdata('pesan', 'Kelas berhasil diambil.');
        }
        redirect('krs');
    }

    public function batal($krs_id) {
        // hanya boleh batal jika nilai belum diinput
        $this->db->where(['id' => $krs_id, 'mahasiswa_id' => $this->mhs['id']])
                 ->where('nilai_angka IS NULL', null, false)->delete('krs');
        $this->session->set_flashdata('pesan', 'KRS dibatalkan.');
        redirect('krs');
    }
}
