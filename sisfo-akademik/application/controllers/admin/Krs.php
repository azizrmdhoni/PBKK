<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// KRS + input nilai oleh admin
class Krs extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_krs', 'M_mahasiswa', 'M_matakuliah']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->render('admin/krs/index', [
            'title' => 'KRS & Nilai',
            'rows'  => $this->M_krs->get_all(),
        ]);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nim', 'Mahasiswa', 'required');
        $this->form_validation->set_rules('kode_mk', 'Mata Kuliah', 'required');
        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required|regex_match[/^\d{4}\/\d{4}$/]');

        if ($this->form_validation->run() == FALSE) {
            return $this->render('admin/krs/form', [
                'title' => 'Tambah KRS',
                'mahasiswa'  => $this->M_mahasiswa->get_all(),
                'matakuliah' => $this->M_matakuliah->get_all(),
            ]);
        }

        $nim = $this->input->post('nim', TRUE);
        $mk  = $this->input->post('kode_mk', TRUE);
        $ta  = $this->input->post('tahun_ajaran', TRUE);

        if ($this->M_krs->sudah_ada($nim, $mk, $ta)) {
            $this->session->set_flashdata('error', 'Mahasiswa sudah mengambil mata kuliah ini pada tahun ajaran tersebut.');
            redirect('admin/krs/tambah');
        }

        $this->M_krs->insert(['nim' => $nim, 'kode_mk' => $mk, 'tahun_ajaran' => $ta]);
        $this->session->set_flashdata('success', 'KRS ditambahkan.');
        redirect('admin/krs');
    }

    public function nilai($id)
    {
        $row = $this->M_krs->get($id);
        if (!$row) show_404();

        $this->form_validation->set_rules('nilai', 'Nilai', 'required|in_list[A,B,C,D,E]');
        if ($this->form_validation->run() == FALSE) {
            $mk = $this->M_matakuliah->get($row->kode_mk);
            return $this->render('admin/krs/nilai', [
                'title' => 'Input Nilai', 'row' => $row,
                'mhs' => $this->M_mahasiswa->get($row->nim), 'mk' => $mk,
            ]);
        }
        $this->M_krs->update($id, ['nilai' => $this->input->post('nilai')]);
        $this->session->set_flashdata('success', 'Nilai disimpan.');
        redirect('admin/krs');
    }

    public function hapus($id)
    {
        $this->M_krs->delete($id);
        $this->session->set_flashdata('success', 'KRS dihapus.');
        redirect('admin/krs');
    }
}
