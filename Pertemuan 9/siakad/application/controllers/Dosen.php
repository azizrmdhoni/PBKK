<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends Crud_Controller {
    protected $tabel = 'dosen';
    protected $judul = 'Dosen';
    protected $fields = [
        'nidn' => ['label' => 'NIDN', 'type' => 'text', 'rules' => 'required|is_unique[dosen.nidn]'],
        'nama' => ['label' => 'Nama', 'type' => 'text', 'rules' => 'required'],
    ];
    protected $kolom = ['nidn' => 'NIDN', 'nama' => 'Nama'];

    protected function sebelum_simpan($data, $id) {
        if (!$id) {
            $this->db->insert('user', [
                'username' => $data['nidn'],
                'password' => password_hash($data['nidn'], PASSWORD_DEFAULT),
                'nama' => $data['nama'], 'role' => 'dosen',
            ]);
            $data['user_id'] = $this->db->insert_id();
        } else {
            $d = $this->db->get_where('dosen', ['id' => $id])->row_array();
            $this->db->where('id', $d['user_id'])->update('user', ['nama' => $data['nama'], 'username' => $data['nidn']]);
        }
        return $data;
    }
    protected function sesudah_hapus($row) { $this->db->delete('user', ['id' => $row['user_id']]); }
}
