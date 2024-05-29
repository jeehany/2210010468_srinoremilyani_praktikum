<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email','email','required|trim');
        $this->form_validation->set_rules('password','password','required|trim');

        $this->load->view('login/index');
    }
    public function dologin()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('user', ['email' => $email])->row_array(); // cari user berdasarkan email
        
        // jika user terdaftar
        if ($user) {
            // periksa password-nya
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                ];
                $this->session->set_userdata($data);
                
                // periksa role-nya
                if ($user['role'] == 'PEMILIK') {
                    $this->_updateLastLogin($user['id']);
                    redirect('menu');
                } elseif ($user['role'] == 'ADMIN') {
                    $this->_updateLastLogin($user['id']);
                    redirect('user');
                } elseif ($user['role'] == 'KASIR') {
                    $this->_updateLastLogin($user['id']);
                    redirect('kasir');
                } else{
                    redirect('login');
                }
        }else {
            // jika password salah
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <b> Password Salah. </b> </div>');
            redirect('login');
        }
    } else {
        // jika user tidak terdaftar
        echo "User tidak terdaftar";
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <b>Error: </b> User Tidak Terdaftar. </div>');
        redirect('login');
    }}
    private function _updateLastLogin($userid)
    {
        $sql = "UPDATE user SET last_login=now() WHERE id=$userid";
        $this->db->query($sql);
    }
    public function logout()
    {
        //hsncurkan semua sesi
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }
    public function block()
    {
        $data = array(
            'user' => infoLogin(),
            'title' => 'Access Denied'
        );
        $this->load->view('login/error404', $data);
    }
}