<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matakuliah extends Crud_Controller {
    protected $tabel = 'matakuliah';
    protected $judul = 'Mata Kuliah';
    protected $fields = [
        'kode' => ['label' => 'Kode', 'type' => 'text',   'rules' => 'required|is_unique[matakuliah.kode]'],
        'nama' => ['label' => 'Nama', 'type' => 'text',   'rules' => 'required'],
        'sks'  => ['label' => 'SKS',  'type' => 'number', 'rules' => 'required|integer|greater_than[0]|less_than[7]'],
    ];
    protected $kolom = ['kode' => 'Kode', 'nama' => 'Nama', 'sks' => 'SKS'];
}
