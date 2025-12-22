<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    public function register() {
        if ($this->session->userdata('logged_in_mitra')) {
            redirect('admin/dashboard');
        }

        $nama = $this->input->post('nama');
        $mitra = $this->input->post('mitra');
        $alamat = $this->input->post('alamat');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($this->Admin_model->cek_email($email)) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar.');
            redirect('admin_index/daftar');
            return;
        }

        $data = [
            'username' => $nama,
            'nama_mitra' => $mitra,
            'alamat' => $alamat,
            'email_mitra' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $this->Admin_model->insert($data);
        
        $admin = $this->Admin_model->cek_email($email);
        $this->session->set_userdata([
            'mitra_id' => $admin['id_mitra'],
            'mitra_nama' => $admin['nama_mitra'],
            'mitra_email' => $admin['email_mitra'],
            'logged_in_mitra' => true
        ]);
        redirect('admin/dashboard');
    }
    
    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        $admin = $this->Admin_model->cek_email($email);

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                $this->session->set_userdata([
                    'mitra_id' => $admin['id_mitra'],
                    'mitra_nama' => $admin['nama_mitra'],
                    'mitra_email' => $admin['email_mitra'],
                    'logged_in_mitra' => true
                ]);
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah.');
                redirect('admin_index/masuk');
            }
        } else {
            $this->session->set_flashdata('error', 'Email tidak terdaftar.');
            redirect('admin_index/masuk');
        }
    }
    public function lupa_pass(){
        $email = $this->input->post('email');
        $cek = $this->Admin_model->cek_email($email);
        if (!$cek){
            $this->session->set_flashdata('error', 'Email tidak terdaftar.');
            redirect('admin_index/lupa_password');
        } else {
            $this->session->set_flashdata('email', $email);
            redirect('admin_index/verifikasi');
        }
    }

    public function verif() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $repass = $this->input->post('repass');
        $admin = $this->Admin_model->cek_email($email);
        
        if ($password !== $repass) {
            $this->session->set_flashdata('error', 'Konfirmasi password tidak sesuai.');
            redirect('admin_index/verifikasi');
            return;
        }else {
            $update = [
                'password' => password_hash($password, PASSWORD_DEFAULT)];
            $this->Admin_model->update($email, $update);
            $this->session->set_userdata([
                'mitra_id' => $admin['id_mitra'],
                'mitra_nama' => $admin['nama_mitra'],
                'mitra_email' => $admin['email_mitra'],
                'logged_in_mitra' => true
            ]);
            redirect('admin_index/done');
        }

    }

    public function logout_mitra() {
        $this->session->unset_userdata([
            'mitra_id',
            'mitra_nama',
            'logged_in_mitra'
        ]);
    
        redirect('admin_index');
    }
    
}