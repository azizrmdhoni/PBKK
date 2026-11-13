<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Model dasar dengan operasi CRUD umum
class MY_Model extends CI_Model
{
    protected $table;
    protected $pk;

    public function get_all()
    {
        return $this->db->order_by($this->pk, 'ASC')->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->get_where($this->table, [$this->pk => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where($this->pk, $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, [$this->pk => $id]);
    }

    public function count()
    {
        return $this->db->count_all($this->table);
    }
}
