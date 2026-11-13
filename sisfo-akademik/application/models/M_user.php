<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends MY_Model
{
    protected $table = 'user';
    protected $pk = 'id_user';

    public function by_username($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row();
    }
}
