<?php

// application/models/User_Model.php
class User_Model extends CI_Model
{
    protected $_table = 'user';
    protected $primary = 'id';

    public function getAll()
    {
        return $this->db->where('is_active', 1)->get($this->_table)->result();
    }

    public function save(){
        $data = array(
            'nik' => htmlspecialchars($this->input->post('nik'), true),
            'username' => htmlspecialchars($this->input->post('username'), true),
            'password' => htmlspecialchars($this->input->post('password'), PASSWORD_DEFAULT),
            'email' => htmlspecialchars($this->input->post('email'), true),
            'full_name' => htmlspecialchars($this->input->post('full_name'), true),
            'phone' => htmlspecialchars($this->input->post('phone'), true),
            'alamat' => htmlspecialchars($this->input->post('alamat'), true),
            'role' => htmlspecialchars($this->input->post('role'), true),
            'is_active' => 1,
        );
        return $this->db->insert($this->_table,$data);
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }
}