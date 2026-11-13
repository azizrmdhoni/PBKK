<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends Crud_Controller {
    protected $tabel = 'mahasiswa';
    protected $judul = 'Mahasiswa';
    protected $fields = [
        'nim'      => ['label' => 'NIM',      'type' => 'text',   'rules' => 'required|is_unique[mahasiswa.nim]'],
        'nama'     => ['label' => 'Nama',     'type' => 'text',   'rules' => 'required'],
        'prodi'    => ['label' => 'Prodi',    'type' => 'text',   'rules' => 'required'],
        'angkatan' => ['label' => 'Angkatan', 'type' => 'number', 'rules' => 'required|exact_length[4]|integer'],
    ];
    protected $kolom = ['nim' => 'NIM', 'nama' => 'Nama', 'prodi' => 'Prodi', 'angkatan' => 'Angkatan'];

    protected function sebelum_simpan($data, $id) {
        if (!$id) {   // baru: buat akun login (password awal = NIM)
            $this->db->insert('user', [
                'username' => $data['nim'],
                'password' => password_hash($data['nim'], PASSWORD_DEFAULT),
                'nama' => $data['nama'], 'role' => 'mahasiswa',
            ]);
            $data['user_id'] = $this->db->insert_id();
        } else {      // ubah: sinkronkan nama & username
            $m = $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
            $this->db->where('id', $m['user_id'])->update('user', ['nama' => $data['nama'], 'username' => $data['nim']]);
        }
        return $data;
    }
    protected function sesudah_hapus($row) { $this->db->delete('user', ['id' => $row['user_id']]); }
}
