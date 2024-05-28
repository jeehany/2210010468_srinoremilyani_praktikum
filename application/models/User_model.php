<?php

// application/models/User_model.php
class User_model extends CI_Model
{
    protected $_table = 'user';
    protected $primary = 'id';

    public function getAll() {
        return $this->db->where('is_active', 1)->get($this->_table)->result();
    }

    public function save(){
        $data = array(
            'nik' => htmlspecialchars($this->input->post('nik'), ENT_QUOTES),
            'username' => htmlspecialchars($this->input->post('username'), ENT_QUOTES),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES),
            'full_name' => htmlspecialchars($this->input->post('full_name'), ENT_QUOTES),
            'phone' => htmlspecialchars($this->input->post('phone'), ENT_QUOTES),
            'alamat' => htmlspecialchars($this->input->post('alamat'), ENT_QUOTES),
            'role' => htmlspecialchars($this->input->post('role'), ENT_QUOTES),
            'is_active' => 1,
        );
        return $this->db->insert($this->_table, $data);
    }

    public function getById($id) {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    public function editData() {
        $id = $this->input->post('id');
        $data = array(
            'username' => htmlspecialchars($this->input->post('username'), ENT_QUOTES),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES),
            'full_name' => htmlspecialchars($this->input->post('full_name'), ENT_QUOTES),
            'phone' => htmlspecialchars($this->input->post('phone'), ENT_QUOTES),
            'role' => htmlspecialchars($this->input->post('role'), ENT_QUOTES),
            'is_active' => 1,
        );
        return $this->db->set($data)->where($this->primary, $id)->update($this->_table);
    }

    public function delete($id)
    {
        return $this->db->where($this->primary, $id)->delete($this->_table);
    }
}
?>
