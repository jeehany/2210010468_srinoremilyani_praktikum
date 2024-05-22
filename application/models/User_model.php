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
}